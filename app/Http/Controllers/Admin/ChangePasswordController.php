<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    /**
     * عرض صفحة تغيير كلمة المرور
     */
    public function show()
    {
        return view('auth.passwords.change');
    }

    /**
     * معالجة طلب تغيير كلمة المرور
     */
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'], // قاعدة current_password تتحقق تلقائياً أن الكلمة الحالية صحيحة
            'new_password' => ['required', 'string', 'min:8', 'confirmed'], // confirmed تتأكد من تطابق حقل التأكيد
        ]);



        Auth::user()->update([
            'password' => Hash::make($request->new_password)
        ]);



        return back()->with('status', 'تم تغيير كلمة المرور بنجاح!');
    }
}
