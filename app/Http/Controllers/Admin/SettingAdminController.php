<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\DataStore;
use Illuminate\Http\Request;

class SettingAdminController extends Controller
{
    public function index()
    {
        $settings = DataStore::getCollection('settings');
        return view('admin.settings.general', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = DataStore::getCollection('settings');
        $settings['sbi_acc_name'] = trim($request->input('sbi_acc_name', $settings['sbi_acc_name'] ?? ''));
        $settings['sbi_acc_no'] = trim($request->input('sbi_acc_no', $settings['sbi_acc_no'] ?? ''));
        $settings['sbi_ifsc'] = trim($request->input('sbi_ifsc', $settings['sbi_ifsc'] ?? ''));
        $settings['sbi_branch'] = trim($request->input('sbi_branch', $settings['sbi_branch'] ?? ''));
        $settings['razorpay_key'] = trim($request->input('razorpay_key', $settings['razorpay_key'] ?? ''));
        $settings['whatsapp_number'] = trim($request->input('whatsapp_number', $settings['whatsapp_number'] ?? ''));
        $settings['mela_banner'] = trim($request->input('mela_banner', $settings['mela_banner'] ?? ''));

        $all = DataStore::get();
        $all['settings'] = $settings;
        DataStore::save($all);

        return back()->with('success', 'Enterprise Platform Settings & SBI Settlement Account details updated successfully!');
    }
}
