<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        // نجلب أول صف، وإذا لم يوجد نرسل أوبجكت فارغ لتجنب الأخطاء في الفيو
        $setting = Setting::first() ?? new Setting();
        return view('dsadmin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        // 1. التحقق من البيانات
        $request->validate([
            'site_name' => 'required|string|max:255',
            'logo'      => 'nullable|image|max:2048',
            'favicon'   => 'nullable|image|max:1024',
        ]);

        // 2. جلب الإعدادات الحالية أو إنشاء جديد
        $setting = Setting::firstOrNew();

        // 3. تحديث البيانات النصية (ماعدا الصور)
        $setting->site_name = $request->site_name;
        $setting->currency = $request->currency;
        $setting->contact_email = $request->contact_email;
        $setting->contact_number = $request->contact_number; // لاحظ الاسم كما في الجدول
        $setting->address = $request->address;
        $setting->whatsapp = $request->whatsapp;
        $setting->facebook = $request->facebook;
        $setting->twitter = $request->twitter;
        $setting->instagram = $request->instagram;
        $setting->youtube = $request->youtube; // إذا أضفته في الفيو
        $setting->team_name = $request->team_name;
        $setting->copyright_text = $request->copyright_text;

        // التعامل مع وضع الصيانة (Checkbox)
        $setting->maintenance_mode = $request->has('maintenance_mode');
        $setting->maintenance_message = $request->maintenance_message;

        // 4. رفع الصور (Logo)
        if ($request->hasFile('logo')) {
            // حذف القديم إن وجد
            if ($setting->logo && Storage::disk('public')->exists(str_replace('storage/', '', $setting->logo))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $setting->logo));
            }
            // رفع الجديد
            $path = $request->file('logo')->store('uploads/settings', 'public');
            $setting->logo = 'storage/' . $path;
        }

        // 5. رفع الأيقونة (Favicon)
        if ($request->hasFile('favicon')) {
            if ($setting->favicon && Storage::disk('public')->exists(str_replace('storage/', '', $setting->favicon))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $setting->favicon));
            }
            $path = $request->file('favicon')->store('uploads/settings', 'public');
            $setting->favicon = 'storage/' . $path;
        }

        $setting->save();

        return redirect()->back()->with('success', 'تم حفظ الإعدادات بنجاح');
    }
}
