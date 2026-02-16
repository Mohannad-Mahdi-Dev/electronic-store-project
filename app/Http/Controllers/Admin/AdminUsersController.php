<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller
{
    // =========================
    // Super Admin (role_id = 1)
    // =========================

    public function indexSuper()
    {
        $users = User::where('role_id', 1)->latest()->paginate(10);
        $title = 'Super Admins';
        $role  = 1;

        return view('dsadmin.admin_users.index', compact('users', 'title', 'role'));
    }

    public function createSuper()
    {
        $title = 'إضافة أدمن';
        $role  = 1;
        return view('dsadmin.admin_users.create', compact('title', 'role'));
    }


    public function storeSuper(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = new \App\Models\User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
        $user->role_id = 1; //  Super Admin
        $user->save();

        return redirect()->to('/super-admins')->with('success', 'تمت إضافة الأدمن بنجاح');
    }



    public function editSuper(User $user)
    {
        abort_if((int)$user->role_id !== 1, 404);

        $title = 'تعديل أدمن';
        $role  = 1;

        return view('dsadmin.admin_users.edit', compact('user', 'title', 'role'));
    }

    public function updateSuper(Request $request, User $user)
    {
        abort_if((int)$user->role_id !== 1, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('super-admins.index')->with('success', 'تم تحديث الأدمن بنجاح');
    }

    public function destroySuper(User $user)
    {
        abort_if((int)$user->role_id !== 1, 404);

        // لا تحذف نفسك
        if (auth()->id() === $user->id) {
            return back()->with('error', 'لا يمكنك حذف حسابك الحالي');
        }

        // لا تحذف آخر سوبر أدمن
        $count = User::where('role_id', 1)->count();
        if ($count <= 1) {
            return back()->with('error', 'لا يمكن حذف آخر أدمن في النظام');
        }

        $user->delete();
        return back()->with('success', 'تم حذف الأدمن بنجاح');
    }


    // =========================
    // Sub Admin (role_id = 2)
    // =========================

    public function indexSub()
    {
        $users = User::where('role_id', 2)->latest()->paginate(10);
        $title = 'Sub Admins Management';
        $role  = 2;

        return view('dsadmin.admin_users.index', compact('users', 'title', 'role'));
    }

    public function createSub()
    {
        $title = 'إضافة سَب أدمن';
        $role  = 2;
        return view('dsadmin.admin_users.create', compact('title', 'role'));
    }


    public function storeSub(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = new \App\Models\User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
        $user->role_id = 2; //  Sub Admin
        $user->save();

        return redirect()->to('/admin/sub-admins')->with('success', 'تمت إضافة السَب أدمن بنجاح');
    }



    public function editSub(User $user)
    {
        abort_if((int)$user->role_id !== 2, 404);

        $title = 'تعديل سَب أدمن';
        $role  = 2;

        return view('dsadmin.admin_users.edit', compact('user', 'title', 'role'));
    }

    public function updateSub(Request $request, User $user)
    {
        abort_if((int)$user->role_id !== 2, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('sub-admins.index')->with('success', 'تم تحديث السَب أدمن بنجاح');
    }

    public function destroySub(User $user)
    {
        abort_if((int)$user->role_id !== 2, 404);

        if (auth()->id() === $user->id) {
            return back()->with('error', 'لا يمكنك حذف حسابك الحالي');
        }

        $user->delete();

        return back()->with('success', 'تم حذف السَب أدمن بنجاح');
    }
}
