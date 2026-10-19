<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    private function setting()
    {
        try {
            return Setting::firstOrCreate(['id' => 1]);
        } catch (\Throwable $e) {
            $ds = \App\Helpers\DataStore::getCollection('settings');
            $setting = new Setting();
            $setting->id = 1;
            $setting->website_name = $ds['website_name'] ?? 'Dewa Sharif Portal';
            $setting->website_url = $ds['website_url'] ?? 'http://127.0.0.1:8000';
            $setting->phone = $ds['whatsapp_number'] ?? '+91 9648777223';
            $setting->email = $ds['email'] ?? 'shahzade.alam707@gmail.com';
            $setting->address = $ds['address'] ?? 'Dewa Sharif, Barabanki, UP - 225301';
            return $setting;
        }
    }

    /* ===========================
       General
    =========================== */

    public function general()
    {
        $setting = $this->setting();
        return view('admin.settings.general', compact('setting'));
    }

    public function updateGeneral(SettingRequest $request)
    {
        $setting = $this->setting();
        $data = array_merge($request->validated(), $request->except(['_token', '_method']));

        if (isset($data['key_capabilities_items']) && is_array($data['key_capabilities_items'])) {
            $data['key_capabilities_items'] = array_values(array_filter($data['key_capabilities_items'], function($item) {
                return !empty($item['heading']) || !empty($item['icon']) || !empty($item['desc']);
            }));
        } else {
            $data['key_capabilities_items'] = [];
        }

        $setting->update($data);

        return back()->with('success', 'General settings updated successfully.');
    }

    /* ===========================
       Company
    =========================== */

    public function company()
    {
        $setting = $this->setting();
        return view('admin.settings.company', compact('setting'));
    }

    public function updateCompany(SettingRequest $request)
    {
        $setting = $this->setting();

        $data = array_merge($request->validated(), $request->except(['_token', '_method', 'logo', 'footer_logo', 'favicon']));

        if ($request->hasFile('logo')) {

            if ($setting->logo && file_exists(public_path($setting->logo))) {
                @unlink(public_path($setting->logo));
            }

            $file = $request->file('logo');
            $name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/settings'), $name);
            $data['logo'] = 'uploads/settings/'.$name;
        }

        if ($request->hasFile('footer_logo')) {

            if ($setting->footer_logo && file_exists(public_path($setting->footer_logo))) {
                @unlink(public_path($setting->footer_logo));
            }

            $file = $request->file('footer_logo');
            $name = time().'_footer_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/settings'), $name);
            $data['footer_logo'] = 'uploads/settings/'.$name;
        }

        if ($request->hasFile('favicon')) {

            if ($setting->favicon && file_exists(public_path($setting->favicon))) {
                @unlink(public_path($setting->favicon));
            }

            $file = $request->file('favicon');
            $name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/settings'), $name);
            $data['favicon'] = 'uploads/settings/'.$name;
        }

        $setting->update($data);

        return back()->with('success', 'Company settings updated successfully.');
    }

    /* ===========================
       Contact
    =========================== */

    public function contact()
    {
        $setting = $this->setting();
        return view('admin.settings.contact', compact('setting'));
    }

    public function updateContact(SettingRequest $request)
    {
        $setting = $this->setting();
        $data = array_merge($request->validated(), $request->except(['_token', '_method']));

        $setting->update($data);

        return back()->with('success', 'Contact settings updated successfully.');
    }

    /* ===========================
       Social
    =========================== */

    public function social()
    {
        $setting = $this->setting();
        return view('admin.settings.social', compact('setting'));
    }

    public function updateSocial(SettingRequest $request)
    {
        $setting = $this->setting();
        $data = array_merge($request->validated(), $request->except(['_token', '_method']));

        $setting->update($data);

        return back()->with('success', 'Social links updated successfully.');
    }

    /* ===========================
       Payment
    =========================== */

    public function payment()
    {
        $setting = $this->setting();
        return view('admin.settings.payment', compact('setting'));
    }

    public function updatePayment(SettingRequest $request)
    {
        $setting = $this->setting();
        $data = array_merge($request->validated(), $request->except(['_token', '_method']));

        $setting->update($data);

        return back()->with('success', 'Payment settings updated successfully.');
    }

    /* ===========================
       SEO
    =========================== */

    public function seo()
    {
        $setting = $this->setting();
        return view('admin.settings.seo', compact('setting'));
    }

    public function updateSeo(SettingRequest $request)
    {
        $setting = $this->setting();
        $data = array_merge($request->validated(), $request->except(['_token', '_method']));

        $setting->update($data);

        return back()->with('success', 'SEO settings updated successfully.');
    }

    /* ===========================
       API
    =========================== */

    public function api()
    {
        $setting = $this->setting();
        return view('admin.settings.api', compact('setting'));
    }

    public function updateApi(SettingRequest $request)
    {
        $setting = $this->setting();
        $data = array_merge($request->validated(), $request->except(['_token', '_method']));

        $setting->update($data);

        return back()->with('success', 'API settings updated successfully.');
    }
}