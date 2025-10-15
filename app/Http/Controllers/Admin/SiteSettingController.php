<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SiteSettingController extends Controller
{
    public function index()
    {
        $setting = SiteSetting::first();
        return view('admin.site-settings.index', compact('setting'));
    }

    public function edit(SiteSetting $site_setting)
    {
        return view('admin.site-settings.edit', ['setting' => $site_setting]);
    }

    public function update(Request $request, SiteSetting $site_setting)
    {
        $data = $request->validate([
            'site_link' => ['nullable', 'url', 'max:255'],
            'site_title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'keywords' => ['nullable', 'string', 'max:255'],
            'site_name' => ['nullable', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'telegram' => ['nullable', 'string', 'max:255'],
        ]);

        $site_setting->update($data);

        return redirect()->route('admin.site-settings.edit', $site_setting)->with('status', 'Site setting updated');
    }

    public function store(Request $request)
    {
        // Prevent multiple records: if exists, redirect to edit
        if ($first = SiteSetting::first()) {
            return redirect()->route('admin.site-settings.edit', $first);
        }

        $data = $request->validate([
            'site_link' => ['nullable', 'url', 'max:255'],
            'site_title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'keywords' => ['nullable', 'string', 'max:255'],
            'site_name' => ['nullable', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'telegram' => ['nullable', 'string', 'max:255'],
        ]);

        $setting = SiteSetting::create($data);
        return redirect()->route('admin.site-settings.edit', $setting)->with('status', 'Site setting created');
    }
}
