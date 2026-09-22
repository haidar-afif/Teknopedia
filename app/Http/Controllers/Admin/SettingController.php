<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminCmsService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected AdminCmsService $cmsService;

    public function __construct(AdminCmsService $cmsService)
    {
        $this->cmsService = $cmsService;
    }

    public function index()
    {
        $settings = $this->cmsService->getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:100',
            'site_tagline' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'contact_email' => 'nullable|email|max:150',
            'contact_phone' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:300',
            'social_github' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'site_logo' => 'nullable|string|max:500',
            'site_favicon' => 'nullable|string|max:500',
        ]);

        $this->cmsService->updateSettings($validated);

        return redirect()->back()->with('success', 'Pengaturan website berhasil diperbarui!');
    }
}
