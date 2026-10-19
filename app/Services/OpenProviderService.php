<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenProviderService
{
    protected $baseUrl;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->baseUrl = config('services.openprovider.base_url');
        $this->username = config('services.openprovider.username');
        $this->password = config('services.openprovider.password');
    }

    public function login()
    {
        try {
            return Http::timeout(4)->connectTimeout(2)->post($this->baseUrl . '/auth/login', [
                'username' => $this->username,
                'password' => $this->password,
                'ip' => request()->ip(),
            ])->json();
        } catch (\Exception $e) {
            Log::warning('OpenProvider login timeout/error: ' . $e->getMessage());
            return ['code' => 500, 'message' => $e->getMessage()];
        }
    }

    public function checkDomain($domain)
    {
        $login = $this->login();

        $token = $login['data']['token'] ?? null;

        if (!$token) {
            return [
                'success' => false,
                'message' => 'OpenProvider authentication failed'
            ];
        }

        $domain = strtolower(trim($domain));

        $parts = explode('.', $domain);

        if (count($parts) < 2 || empty($parts[1])) {
            $domain = $domain . '.com';
            $parts = explode('.', $domain);
        }

        $name = $parts[0];
        $extension = implode('.', array_slice($parts, 1));

        try {
            return Http::timeout(4)->connectTimeout(2)->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/domains/check', [

                'domains' => [
                    [
                        'name' => $name,
                        'extension' => $extension,
                    ]
                ],

                'with_price' => true,

            ])->json();
        } catch (\Exception $e) {
            Log::warning('OpenProvider checkDomain timeout: ' . $e->getMessage());
            return ['code' => 500, 'message' => $e->getMessage()];
        }
    }

    public function whois($domain)
    {
        @set_time_limit(60);

        $domain = strtolower(trim($domain));
        $domain = preg_replace('/^https?:\/\//i', '', $domain);
        $domain = preg_replace('/^www\./i', '', $domain);
        $domain = rtrim($domain, '/');

        $parts = explode('.', $domain);
        if (count($parts) < 2 || empty($parts[0]) || empty(end($parts))) {
            return [
                'success' => false,
                'message' => 'Please enter a valid domain name (e.g. example.com).'
            ];
        }

        // 1. Check domain availability & price via OpenProvider API
        $openProviderResult = null;
        try {
            $checkRes = $this->checkDomain($domain);
            if (isset($checkRes['data']['results'][0])) {
                $openProviderResult = $checkRes['data']['results'][0];
            }
        } catch (\Exception $e) {
            Log::warning('OpenProvider checkDomain failed: ' . $e->getMessage());
        }

        // 2. Query WHOIS via socket with strict stream timeout
        $rawWhois = $this->querySocketWhois($domain);

        // 3. Parse WHOIS text
        $parsedWhois = $this->parseWhoisText($rawWhois);

        // Determine registration status accurately
        $isRegistered = false;

        // DNS records (fast query for A, MX, NS)
        $dnsRecords = [];
        $hasDns = false;
        try {
            $dns = @dns_get_record($domain, DNS_A + DNS_MX + DNS_NS);
            if (is_array($dns) && count($dns) > 0) {
                $hasDns = true;
                foreach ($dns as $rec) {
                    $dnsRecords[] = [
                        'type' => $rec['type'] ?? '',
                        'target' => $rec['target'] ?? $rec['ip'] ?? $rec['ipv6'] ?? ($rec['entries'][0] ?? ''),
                        'pri' => $rec['pri'] ?? null,
                        'ttl' => $rec['ttl'] ?? null,
                    ];
                }
            }
        } catch (\Exception $e) {
            // DNS lookup optional
        }

        if ($hasDns) {
            $isRegistered = true;
        } elseif (!empty($parsedWhois['registrar']) || !empty($parsedWhois['creation_date'])) {
            $isRegistered = true;
        } elseif ($openProviderResult && isset($openProviderResult['status']) && strtolower($openProviderResult['status']) !== 'free') {
            $isRegistered = true;
        } elseif (!empty($rawWhois) && !preg_match('/(No match for|NOT FOUND|Not Registered|Status:\s*free|No Data Found|Domain Not Found)/i', $rawWhois)) {
            if (strpos($rawWhois, 'Could not connect') === false) {
                $isRegistered = true;
            }
        }

        // Nameservers merge
        $nameservers = array_values(array_unique(array_filter(array_merge(
            $parsedWhois['nameservers'],
            array_column(array_filter($dnsRecords, fn($r) => $r['type'] === 'NS'), 'target')
        ))));

        // Pricing details
        $priceInfo = null;
        if ($openProviderResult && isset($openProviderResult['price'])) {
            $priceInfo = $openProviderResult['price'];
        }

        return [
            'success' => true,
            'domain' => $domain,
            'registered' => $isRegistered,
            'status' => $isRegistered ? 'Registered / Unavailable' : 'Available for Registration',
            'registrar' => $parsedWhois['registrar'] ?? 'N/A',
            'creation_date' => $this->formatWhoisDate($parsedWhois['creation_date']),
            'expiration_date' => $this->formatWhoisDate($parsedWhois['expiration_date']),
            'updated_date' => $this->formatWhoisDate($parsedWhois['updated_date']),
            'domain_status' => !empty($parsedWhois['status']) ? implode(', ', $parsedWhois['status']) : 'N/A',
            'nameservers' => $nameservers,
            'dns_records' => $dnsRecords,
            'price' => $priceInfo,
            'openprovider' => $openProviderResult,
            'raw_whois' => !empty(trim($rawWhois)) ? trim($rawWhois) : 'No WHOIS record details returned from WHOIS server.',
        ];
    }

    protected function querySocketWhois($domain)
    {
        $parts = explode('.', $domain);
        $tld = strtolower(end($parts));

        $whoisServers = [
            'com' => 'whois.verisign-grs.com',
            'net' => 'whois.verisign-grs.com',
            'org' => 'whois.pir.org',
            'info' => 'whois.afilias.net',
            'in' => 'whois.registry.in',
            'co.in' => 'whois.registry.in',
            'net.in' => 'whois.registry.in',
            'org.in' => 'whois.registry.in',
            'io' => 'whois.nic.io',
            'co' => 'whois.nic.co',
            'us' => 'whois.nic.us',
            'uk' => 'whois.nic.uk',
            'co.uk' => 'whois.nic.uk',
            'biz' => 'whois.biz',
            'ca' => 'whois.cira.ca',
            'me' => 'whois.nic.me',
            'dev' => 'whois.nic.google',
            'app' => 'whois.nic.google',
            'ai' => 'whois.nic.ai',
            'xyz' => 'whois.nic.xyz',
            'tech' => 'whois.nic.tech',
            'online' => 'whois.nic.online',
            'site' => 'whois.nic.site',
            'store' => 'whois.nic.store',
        ];

        $server = $whoisServers[$tld] ?? 'whois.iana.org';

        $fp = @fsockopen($server, 43, $errno, $errstr, 3);
        if (!$fp) {
            return "Could not connect to WHOIS server ($server).";
        }

        stream_set_timeout($fp, 3);

        fputs($fp, $domain . "\r\n");
        $out = "";
        while (!feof($fp)) {
            $out .= fgets($fp, 128);
            $info = stream_get_meta_data($fp);
            if (!empty($info['timed_out'])) {
                break;
            }
        }
        fclose($fp);

        return $out;
    }


    protected function parseWhoisText($rawText)
    {
        $info = [
            'registrar' => null,
            'creation_date' => null,
            'expiration_date' => null,
            'updated_date' => null,
            'status' => [],
            'nameservers' => [],
        ];

        if (empty($rawText)) {
            return $info;
        }

        $lines = explode("\n", $rawText);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || str_starts_with($line, '%') || str_starts_with($line, '#')) {
                continue;
            }

            if (preg_match('/^\s*Registrar:\s*(.+)$/i', $line, $m)) {
                if (!$info['registrar']) {
                    $info['registrar'] = trim($m[1]);
                }
            } elseif (preg_match('/^\s*(Creation Date|Created On|Registered On):\s*(.+)$/i', $line, $m)) {
                if (!$info['creation_date']) {
                    $info['creation_date'] = trim($m[2]);
                }
            } elseif (preg_match('/^\s*(Registry Expiry Date|Expiration Date|Expiry Date|Paid-till):\s*(.+)$/i', $line, $m)) {
                if (!$info['expiration_date']) {
                    $info['expiration_date'] = trim($m[2]);
                }
            } elseif (preg_match('/^\s*(Updated Date|Last Updated On):\s*(.+)$/i', $line, $m)) {
                if (!$info['updated_date']) {
                    $info['updated_date'] = trim($m[2]);
                }
            } elseif (preg_match('/^\s*Domain Status:\s*(.+)$/i', $line, $m)) {
                $parts = explode(' ', trim($m[1]));
                $statusVal = trim($parts[0]);
                if ($statusVal && !in_array($statusVal, $info['status'])) {
                    $info['status'][] = $statusVal;
                }
            } elseif (preg_match('/^\s*Name Server:\s*(.+)$/i', $line, $m)) {
                $ns = strtolower(trim($m[1]));
                if ($ns && !in_array($ns, $info['nameservers'])) {
                    $info['nameservers'][] = $ns;
                }
            }
        }

        return $info;
    }

    protected function formatWhoisDate($dateStr)
    {
        if (empty($dateStr)) {
            return 'N/A';
        }
        try {
            return \Carbon\Carbon::parse($dateStr)->format('d M Y, h:i A T');
        } catch (\Exception $e) {
            return $dateStr;
        }
    }

    public function createCustomer(\App\Models\User $user)
    {
        $login = $this->login();
        $token = $login['data']['token'] ?? null;
        if (!$token) {
            return ['success' => false, 'message' => 'OpenProvider authentication failed'];
        }

        // Name parsing
        $nameParts = explode(' ', trim($user->name));
        $firstName = $nameParts[0] ?? 'User';
        $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : 'Customer';
        
        // Phone parsing
        $rawPhone = $user->phone ?? '9876543210';
        $cleanPhone = preg_replace('/[^\d+]/', '', $rawPhone);
        if (str_starts_with($cleanPhone, '+')) {
            $cleanPhone = substr($cleanPhone, 1);
        }
        $countryCode = '91';
        $areaCode = '0';
        $subscriberNumber = $cleanPhone;
        
        if (strlen($cleanPhone) >= 12) {
            $countryCode = substr($cleanPhone, 0, 2);
            $subscriberNumber = substr($cleanPhone, 2);
        } elseif (strlen($cleanPhone) === 10) {
            $countryCode = '91';
            $subscriberNumber = $cleanPhone;
        }

        // Address parsing
        $rawAddress = $user->address ?? 'Main Street';
        $street = substr($rawAddress, 0, 50);
        preg_match('/\d+/', $rawAddress, $matches);
        $number = $matches[0] ?? '1';
        
        $zipcode = $user->postal_code ?? '400001';
        $city = $user->city?->name ?? 'Mumbai';
        
        // Map country name to ISO 2-letter code
        $countryName = $user->country?->name ?? 'India';
        $countryMap = [
            'india' => 'IN', 'united states' => 'US', 'united kingdom' => 'GB',
            'australia' => 'AU', 'canada' => 'CA', 'germany' => 'DE', 'france' => 'FR',
            'netherlands' => 'NL', 'singapore' => 'SG', 'nepal' => 'NP', 'bangladesh' => 'BD',
            'pakistan' => 'PK', 'sri lanka' => 'LK', 'uae' => 'AE', 'united arab emirates' => 'AE'
        ];
        $countryCodeIso = $countryMap[strtolower(trim($countryName))] ?? 'IN';

        $payload = [
            'company_name' => $user->company,
            'email' => $user->email,
            'name' => [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'initials' => substr($firstName, 0, 1) . '.' . substr($lastName, 0, 1) . '.',
            ],
            'address' => [
                'street' => $street,
                'number' => $number,
                'zipcode' => $zipcode,
                'city' => $city,
                'country' => $countryCodeIso,
            ],
            'phone' => [
                'country_code' => '+' . $countryCode,
                'area_code' => $areaCode,
                'subscriber_number' => $subscriberNumber,
            ]
        ];

        try {
            $response = Http::timeout(4)->connectTimeout(2)->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/customers', $payload)->json();

            if (isset($response['data']['handle'])) {
                $user->update(['openprovider_handle' => $response['data']['handle']]);
                return ['success' => true, 'handle' => $response['data']['handle']];
            }

            Log::error('OpenProvider createCustomer failed: ' . json_encode($response));
            return ['success' => false, 'message' => $response['desc'] ?? 'Failed to create customer'];
        } catch (\Exception $e) {
            Log::error('OpenProvider createCustomer exception: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function registerDomain($domain, $ownerHandle, $period = 1)
    {
        $login = $this->login();
        $token = $login['data']['token'] ?? null;
        if (!$token) {
            return ['success' => false, 'message' => 'OpenProvider authentication failed'];
        }

        $parts = explode('.', strtolower(trim($domain)));
        if (count($parts) < 2) {
            return ['success' => false, 'message' => 'Invalid domain name'];
        }
        $name = $parts[0];
        $extension = implode('.', array_slice($parts, 1));

        $payload = [
            'owner_handle' => $ownerHandle,
            'admin_handle' => $ownerHandle,
            'tech_handle' => $ownerHandle,
            'billing_handle' => $ownerHandle,
            'domain' => [
                'name' => $name,
                'extension' => $extension,
            ],
            'period' => (int) ($period ?: 1),
            'autorenew' => 'off',
            'name_servers' => [
                [
                    'name' => 'ns1.openprovider.nl',
                ],
                [
                    'name' => 'ns2.openprovider.be',
                ]
            ]
        ];

        try {
            $response = Http::timeout(5)->connectTimeout(2)->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/domains', $payload)->json();

            if (isset($response['data']['id'])) {
                return ['success' => true, 'domain_id' => $response['data']['id']];
            }

            Log::error('OpenProvider registerDomain failed: ' . json_encode($response));
            return ['success' => false, 'message' => $response['desc'] ?? 'Failed to register domain'];
        } catch (\Exception $e) {
            Log::error('OpenProvider registerDomain exception: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function transferDomain($domain, $authCode, $ownerHandle)
    {
        $login = $this->login();
        $token = $login['data']['token'] ?? null;
        if (!$token) {
            return ['success' => false, 'message' => 'OpenProvider authentication failed'];
        }

        $parts = explode('.', strtolower(trim($domain)));
        if (count($parts) < 2) {
            return ['success' => false, 'message' => 'Invalid domain name'];
        }
        $name = $parts[0];
        $extension = implode('.', array_slice($parts, 1));

        $payload = [
            'owner_handle' => $ownerHandle,
            'admin_handle' => $ownerHandle,
            'tech_handle' => $ownerHandle,
            'billing_handle' => $ownerHandle,
            'domain' => [
                'name' => $name,
                'extension' => $extension,
            ],
            'period' => 1,
            'auth_code' => $authCode,
            'autorenew' => 'off',
            'name_servers' => [
                [
                    'name' => 'ns1.openprovider.nl',
                ],
                [
                    'name' => 'ns2.openprovider.be',
                ]
            ]
        ];

        try {
            $response = Http::timeout(5)->connectTimeout(2)->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/domains/transfer', $payload)->json();

            if (isset($response['data']['id'])) {
                return ['success' => true, 'domain_id' => $response['data']['id']];
            }

            Log::error('OpenProvider transferDomain failed: ' . json_encode($response));
            return ['success' => false, 'message' => $response['desc'] ?? 'Failed to transfer domain'];
        } catch (\Exception $e) {
            Log::error('OpenProvider transferDomain exception: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}

