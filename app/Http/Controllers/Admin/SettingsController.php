<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::query()
            ->orderBy('group')
            ->orderBy('key')
            ->get()
            ->groupBy('group');

        return view('admin.settings.index', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $existing = SiteSetting::query()->get()->keyBy('key');
        $input = (array) $request->input('settings', []);

        $rules = [];
        foreach ($existing as $key => $setting) {
            $rules["settings.$key"] = match ($setting->type) {
                'textarea', 'text' => ['nullable', 'string'],
                'boolean' => ['nullable'],
                default => ['nullable'],
            };
        }

        // Validate non-file inputs first.
        $validated = $request->validate($rules);

        // Validate file inputs by known keys (seeded default).
        if ($existing->has('site_logo')) {
            $request->validate([
                'site_logo' => ['nullable', 'image', 'max:2048'],
            ]);
        }

        DB::transaction(function () use ($request, $existing, $validated, $input) {
            foreach ($existing as $key => $setting) {
                if ($setting->type === 'image') {
                    continue;
                }

                $value = $input[$key] ?? null;
                if ($setting->type === 'boolean') {
                    $value = (bool) $value;
                    $value = $value ? '1' : '0';
                }

                $setting->update([
                    'value' => $value,
                ]);
            }

            if ($existing->has('site_logo') && $request->hasFile('site_logo')) {
                $logoSetting = $existing->get('site_logo');
                $oldPath = $logoSetting->value;

                $path = $request->file('site_logo')->store('site', 'public');
                $logoSetting->update(['value' => $path]);

                if ($oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
        });

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated.');
    }
}
