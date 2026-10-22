<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

    /* ===========================
       SMTP / Mail Settings
    =========================== */

    public function smtp()
    {
        $setting = $this->setting();
        return view('admin.settings.smtp', compact('setting'));
    }

    public function updateSmtp(SettingRequest $request)
    {
        $setting = $this->setting();
        $data = $request->only([
            'mail_mailer',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_encryption',
            'mail_from_address',
            'mail_from_name',
        ]);

        $data['mail_mailer'] = $data['mail_mailer'] ?: 'smtp';
        $data['mail_host'] = $data['mail_host'] ?: 'smtp.gmail.com';
        $data['mail_port'] = $data['mail_port'] ?: '587';
        $data['mail_encryption'] = $data['mail_encryption'] ?: 'tls';
        $data['mail_from_name'] = $data['mail_from_name'] ?: 'DEWASHARIF';
        if (empty($data['mail_from_address']) && !empty($data['mail_username'])) {
            $data['mail_from_address'] = $data['mail_username'];
        }

        // 1. Update Database / Settings Map
        $setting->update($data);

        // 2. Update .env File safely
        $this->updateEnvFile([
            'MAIL_MAILER' => $data['mail_mailer'],
            'MAIL_HOST' => $data['mail_host'],
            'MAIL_PORT' => $data['mail_port'],
            'MAIL_USERNAME' => $data['mail_username'] ?? '',
            'MAIL_PASSWORD' => $data['mail_password'] ?? '',
            'MAIL_ENCRYPTION' => $data['mail_encryption'] === 'none' ? 'null' : $data['mail_encryption'],
            'MAIL_FROM_ADDRESS' => $data['mail_from_address'] ?? '',
            'MAIL_FROM_NAME' => '"' . trim($data['mail_from_name'], '"') . '"',
        ]);

        // 3. Clear configuration cache
        try {
            \Illuminate\Support\Facades\Artisan::call('config:clear');
        } catch (\Throwable $e) {}

        return back()->with('success', 'SMTP Mail settings updated and applied successfully.');
    }

    public function testSmtp(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        $setting = $this->setting();

        try {
            $encryption = $setting->mail_encryption === 'none' ? null : ($setting->mail_encryption ?: 'tls');

            config([
                'mail.default' => $setting->mail_mailer ?: 'smtp',
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => $setting->mail_host ?: 'smtp.gmail.com',
                'mail.mailers.smtp.port' => (int) ($setting->mail_port ?: 587),
                'mail.mailers.smtp.encryption' => $encryption,
                'mail.mailers.smtp.username' => $setting->mail_username,
                'mail.mailers.smtp.password' => $setting->mail_password,
                'mail.from.address' => $setting->mail_from_address ?: ($setting->mail_username ?: 'info@dewasharif.com'),
                'mail.from.name' => trim((string)($setting->mail_from_name ?: 'DEWASHARIF'), '"'),
            ]);

            $recipient = $request->test_email;
            $siteName = trim((string)($setting->mail_from_name ?: 'DEWASHARIF'), '"');

            Mail::raw(
                "Hello,\n\nCongratulations! This test email confirms that your SMTP Mail settings are working 100% perfectly on {$siteName}.\n\nHost: {$setting->mail_host}\nPort: {$setting->mail_port}\nEncryption: {$setting->mail_encryption}\nUsername: {$setting->mail_username}\nTimestamp: " . now()->format('d M Y, h:i:s A') . "\n\nRegards,\n{$siteName} Technical Team",
                function ($message) use ($recipient, $siteName) {
                    $message->to($recipient)
                            ->subject("✅ SMTP Live Test Successful - {$siteName}");
                }
            );

            return back()->with('success', "Live test email sent successfully to {$recipient}! Please check your inbox or spam folder.");
        } catch (\Throwable $e) {
            return back()->with('error', "SMTP Connection Failed: " . $e->getMessage());
        }
    }

    /* ===========================
       WhatsApp Cloud API Settings
    =========================== */

    public function whatsapp()
    {
        $setting = $this->setting();
        return view('admin.settings.whatsapp', compact('setting'));
    }

    public function updateWhatsapp(SettingRequest $request)
    {
        $setting = $this->setting();
        $data = $request->only([
            'whatsapp_token',
            'whatsapp_phone_number_id',
            'whatsapp_business_account_id',
            'whatsapp_number',
        ]);

        // 1. Update Database / Settings Map
        $setting->update($data);

        // 2. Update .env File safely
        $token = trim($data['whatsapp_token'] ?? '');
        $phoneId = trim($data['whatsapp_phone_number_id'] ?? '');

        $this->updateEnvFile([
            'WHATSAPP_TOKEN' => '"' . trim($token, '"') . '"',
            'WHATSAPP_PHONE_NUMBER_ID' => '"' . trim($phoneId, '"') . '"',
        ]);

        // 3. Clear configuration cache
        try {
            \Illuminate\Support\Facades\Artisan::call('config:clear');
        } catch (\Throwable $e) {}

        return back()->with('success', 'WhatsApp Cloud API settings updated and applied successfully.');
    }

    public function testWhatsapp(Request $request)
    {
        $request->validate([
            'test_phone' => 'required|string|min:10',
        ]);

        $res = \App\Services\MetaWhatsAppService::sendTestMessage($request->test_phone);

        if ($res['success']) {
            return back()->with('success', $res['message']);
        } else {
            return back()->with('error', $res['message']);
        }
    }

    private function updateEnvFile(array $values)
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            return;
        }

        $content = file_get_contents($envPath);

        foreach ($values as $key => $value) {
            $keyPattern = "/^{$key}=(.*)$/m";

            if (preg_match($keyPattern, $content)) {
                $content = preg_replace($keyPattern, "{$key}={$value}", $content);
            } else {
                $content .= PHP_EOL . "{$key}={$value}";
            }
        }

        file_put_contents($envPath, $content);
    }
}