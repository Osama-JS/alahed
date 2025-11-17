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
        $settings = Setting::orderBy('group')->orderBy('key')->get();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get();

        $rules = [];
        foreach ($settings as $setting) {
            $inputKey = "settings.{$setting->key}";
            if ($setting->type === 'image') {
                $rules[$inputKey] = 'nullable|image|max:4096';
            } elseif ($setting->type === 'textarea') {
                $rules[$inputKey] = 'nullable|string';
            } else {
                $rules[$inputKey] = 'nullable|string|max:1000';
            }
        }

        $validated = $request->validate($rules);

        foreach ($settings as $setting) {
            $inputKey = "settings.{$setting->key}";

            if ($setting->type === 'image' && $request->hasFile($inputKey)) {
                $file = $request->file($inputKey);
                $path = $file->store('settings', 'public');

                if ($setting->value) {
                    Storage::disk('public')->delete($setting->value);
                }

                $setting->update(['value' => $path]);
                continue;
            }

            if ($setting->type !== 'image') {
                $value = data_get($validated, $inputKey, '');
                $setting->update(['value' => $value ?? '']);
            }
        }

        Setting::flushCache();

        return redirect()->route('admin.settings.index')
            ->with('success', app()->getLocale() === 'ar'
                ? 'تم تحديث الإعدادات بنجاح'
                : 'Settings updated successfully');
    }
}
