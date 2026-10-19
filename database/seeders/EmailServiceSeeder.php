<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailService;
use App\Models\Plan;
use App\Models\Faq;

class EmailServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name'               => 'Google Gmail Suite',
                'slug'               => 'google-gmail-suite',
                'banner_title'       => 'HostLok brings you Google Workspace & Gmail Suite Plans',
                'banner_description' => 'Power your organization with the world\'s most trusted email and productivity suite. Enjoy professional @yourdomain.com Gmail, Google Drive cloud storage, Google Meet video meetings, and real-time collaboration.',
                'banner_service'     => 'Google Workspace',
                'description'        => 'Google Workspace seamlessly integrates all of Google\'s industry-leading tools into an all-in-one productivity suite designed for modern businesses. Work faster and smarter with custom Gmail, Docs, Sheets, Slides, Calendar, Meet, and Drive.',
                'sort_order'         => 1,
                'plans'              => [
                    [
                        'name'             => 'Business Starter',
                        'offer_percentage' => 30,
                        'price'            => 175.00,
                        'period'           => 'month',
                        'description'      => 'Custom Business Email (@yourdomain), 30 GB Cloud Storage per user, 100 Participant Video Meetings, Google Docs/Sheets/Slides/Forms, Google Chat & Shared Calendar, Standard Security & Management, 99.9% Uptime Guarantee, 24/7 Phone & Email Support',
                        'sort_order'       => 1,
                    ],
                    [
                        'name'             => 'Business Standard',
                        'offer_percentage' => 25,
                        'price'            => 750.00,
                        'period'           => 'month',
                        'description'      => 'Custom Business Email (@yourdomain), 2 TB Cloud Storage per user, 150 Participant Video Meetings + Recording, Team Shared Drives & Permissions, Noise Cancellation in Meet, Enhanced Audit & Security Controls, 99.9% Uptime SLA, 24/7 Priority Support',
                        'sort_order'       => 2,
                    ],
                    [
                        'name'             => 'Business Plus',
                        'offer_percentage' => 20,
                        'price'            => 1400.00,
                        'period'           => 'month',
                        'description'      => 'Custom Business Email + eDiscovery, 5 TB Cloud Storage per user, 500 Participant Meetings + Attendance Tracking, Google Vault for Retention & Compliance, Advanced Endpoint & Device Security, Security Investigation Tool Access, 99.99% Financial Uptime SLA, 24/7 Dedicated VIP Support',
                        'sort_order'       => 3,
                    ],
                ],
                'faqs' => [
                    [
                        'question'   => 'How do I set up Google Workspace with my existing domain?',
                        'answer'     => 'After completing your purchase, our team helps you verify domain ownership and update your MX and SPF records in your DNS manager so that all emails route seamlessly through Google.',
                        'sort_order' => 1,
                    ],
                    [
                        'question'   => 'Can I use the official Gmail app on mobile devices?',
                        'answer'     => 'Yes, your custom email works seamlessly on the official Gmail app for Android and iOS, as well as desktop clients like Microsoft Outlook and Apple Mail via IMAP/POP.',
                        'sort_order' => 2,
                    ],
                    [
                        'question'   => 'How does HostLok help with email data migration?',
                        'answer'     => 'We provide complimentary email migration support. We safely migrate existing emails, contacts, and calendar entries from your previous provider to Google Workspace without downtime.',
                        'sort_order' => 3,
                    ],
                    [
                        'question'   => 'What is the difference between personal Gmail and Google Workspace?',
                        'answer'     => 'Google Workspace gives you a custom professional email address (@yourdomain.com), admin management console, increased cloud storage (up to 5 TB), 99.9% uptime SLA, and zero advertisements.',
                        'sort_order' => 4,
                    ],
                    [
                        'question'   => 'Can I upgrade my plan or add more users later?',
                        'answer'     => 'Yes, Google Workspace is completely flexible. You can add more user inboxes or upgrade from Business Starter to Business Standard anytime as your team grows.',
                        'sort_order' => 5,
                    ],
                ]
            ],
            [
                'name'               => 'Microsoft Office 365',
                'slug'               => 'microsoft-office-365',
                'banner_title'       => 'HostLok brings you Powerful Microsoft Office 365 Plans',
                'banner_description' => 'Elevate your business productivity with industry-leading Microsoft 365 cloud solutions. Get professional custom email (@yourdomain), 1 TB secure OneDrive storage, Microsoft Teams, and real-time collaboration.',
                'banner_service'     => 'Microsoft 365',
                'description'        => 'Microsoft 365 combines the best-in-class Office apps like Word, Excel, and PowerPoint with intelligent cloud services and world-class cybersecurity. Whether you are working from the office, from home, or on mobile, collaborate in real time with Microsoft Teams and cloud-synced files.',
                'sort_order'         => 2,
                'plans'              => [
                    [
                        'name'             => 'Business Basic',
                        'offer_percentage' => 30,
                        'price'            => 210.00,
                        'period'           => 'month',
                        'description'      => '50 GB Business Mailbox (@yourdomain), 1 TB OneDrive Cloud Storage, Web & Mobile Word/Excel/PowerPoint, Microsoft Teams (Up to 300 users), Exchange/SharePoint/OneDrive, Anti-Spam & Anti-Phishing Filter, 99.9% Uptime SLA, 24/7 Phone & Ticket Support',
                        'sort_order'       => 1,
                    ],
                    [
                        'name'             => 'Business Standard',
                        'offer_percentage' => 25,
                        'price'            => 780.00,
                        'period'           => 'month',
                        'description'      => 'Everything in Business Basic, Desktop Apps for PC & Mac (Word/Excel/PPT), Full Microsoft Outlook Desktop App, Install on 5 Phones + 5 Tablets + 5 PCs, Webinar Hosting with Registration, Appointment Booking with Bookings, 99.9% Uptime Guarantee, 24/7 Priority Support',
                        'sort_order'       => 2,
                    ],
                    [
                        'name'             => 'Business Premium',
                        'offer_percentage' => 20,
                        'price'            => 1740.00,
                        'period'           => 'month',
                        'description'      => 'Everything in Business Standard, Microsoft Defender for Business (Ransomware Shield), Mobile Device Management (Intune), Data Loss Prevention (DLP) Policies, Azure Information Protection, Advanced Cyber Threat Intelligence, 99.99% Financial Uptime SLA, 24/7 Dedicated VIP Support',
                        'sort_order'       => 3,
                    ],
                ],
                'faqs' => [
                    [
                        'question'   => 'Can I use my existing domain name with Microsoft 365?',
                        'answer'     => 'Yes, absolutely. You can connect your custom domain (e.g., info@yourbusiness.com) seamlessly. Our technical team assists with all DNS and MX record configurations at no extra cost.',
                        'sort_order' => 1,
                    ],
                    [
                        'question'   => 'Can I install Office desktop applications on multiple devices?',
                        'answer'     => 'With Business Standard and Business Premium plans, each user can install desktop apps on up to 5 PCs or Macs, 5 tablets, and 5 smartphones simultaneously.',
                        'sort_order' => 2,
                    ],
                    [
                        'question'   => 'Will HostLok assist in migrating emails from my current provider?',
                        'answer'     => 'Yes! We offer assisted email migration from cPanel, Google Workspace, or other IMAP/POP servers with zero data loss and minimal downtime.',
                        'sort_order' => 3,
                    ],
                    [
                        'question'   => 'Is built-in spam and malware security included?',
                        'answer'     => 'Yes, all Microsoft 365 plans include Exchange Online Protection (EOP) to guard against spam, phishing attempts, malware attachments, and known cyber threats.',
                        'sort_order' => 4,
                    ],
                    [
                        'question'   => 'What is the difference between Business Basic and Business Standard?',
                        'answer'     => 'Business Basic provides web and mobile versions of Office apps with 50 GB mailbox and 1 TB cloud storage. Business Standard additionally provides fully installable desktop apps for Windows and Mac computers.',
                        'sort_order' => 5,
                    ],
                ]
            ],
            [
                'name'               => 'Professional Business Mail',
                'slug'               => 'professional-business-mail',
                'banner_title'       => 'HostLok brings you High-Performance Professional Business Mail Plans',
                'banner_description' => 'Build brand credibility and customer trust with personalized business email addresses on your custom domain. Enjoy generous SSD mailbox storage, robust spam filtering, and lightning-fast delivery.',
                'banner_service'     => 'Professional Mail',
                'description'        => 'Show the world you mean business with professional email addresses matching your website domain name. Free email providers like generic @gmail or @yahoo addresses don\'t inspire the confidence that modern customers expect from reputable businesses.',
                'sort_order'         => 3,
                'plans'              => [
                    [
                        'name'             => 'Starter Mail',
                        'offer_percentage' => 30,
                        'price'            => 60.00,
                        'period'           => 'month',
                        'description'      => '1 Custom Email Account (@yourdomain), 10 GB Pure SSD Email Storage, Intuitive Webmail & Calendar Sync, IMAP / POP3 / SMTP Support, Built-in Anti-Spam & Virus Shield, Free SSL / TLS Mail Encryption, 99.9% Uptime Guarantee, 24/7 Technical Support',
                        'sort_order'       => 1,
                    ],
                    [
                        'name'             => 'Business Mail',
                        'offer_percentage' => 25,
                        'price'            => 120.00,
                        'period'           => 'month',
                        'description'      => '5 Custom Email Accounts (@yourdomain), 25 GB SSD High-Speed Storage, Unlimited Email Aliases & Forwarders, Auto-Responders & Routing Rules, Daily Automated Mail Backups, SpamAssassin & SPF/DKIM Configuration, 99.9% Uptime SLA, 24/7 Priority Support',
                        'sort_order'       => 2,
                    ],
                    [
                        'name'             => 'Enterprise Mail',
                        'offer_percentage' => 20,
                        'price'            => 240.00,
                        'period'           => 'month',
                        'description'      => '10 Custom Email Accounts (@yourdomain), 50 GB SSD Ultra-Fast Storage, Dedicated IP & Premium Delivery Pool, Unlimited Aliases/Groups/Auto-responders, Advanced Multi-Layer Threat Protection, Encrypted Storage & Secure Backup, 99.99% Enterprise Uptime SLA, 24/7 Dedicated VIP Support',
                        'sort_order'       => 3,
                    ],
                ],
                'faqs' => [
                    [
                        'question'   => 'How do I access my business email webmail?',
                        'answer'     => 'You can access your webmail from any browser by navigating to webmail.yourdomain.com or through the HostLok client portal using your email credentials.',
                        'sort_order' => 1,
                    ],
                    [
                        'question'   => 'Can I configure my email on Outlook, Apple Mail, or smartphone?',
                        'answer'     => 'Yes, all plans come with standard IMAP, POP3, and SMTP support. You can easily connect your mailbox to Microsoft Outlook, Mozilla Thunderbird, Apple Mail, and your Android or iOS devices.',
                        'sort_order' => 2,
                    ],
                    [
                        'question'   => 'How do you protect my inboxes from spam and phishing?',
                        'answer'     => 'We implement enterprise-grade spam filtering, SPF records, DKIM cryptographic signing, and DMARC verification to ensure inbound spam is blocked and your outgoing emails land in inboxes.',
                        'sort_order' => 3,
                    ],
                    [
                        'question'   => 'Can I create email forwarders and auto-responders?',
                        'answer'     => 'Yes, you can configure unlimited email aliases (e.g., support@, sales@) and automated vacation/out-of-office autoreply messages effortlessly from your control panel.',
                        'sort_order' => 4,
                    ],
                    [
                        'question'   => 'Can I add more storage or email accounts later?',
                        'answer'     => 'Yes, you can upgrade your plan or purchase additional mailbox accounts seamlessly through your HostLok account dashboard at any time without downtime.',
                        'sort_order' => 5,
                    ],
                ]
            ]
        ];

        foreach ($services as $sData) {
            $plans = $sData['plans'];
            $faqs = $sData['faqs'];
            unset($sData['plans'], $sData['faqs']);

            $emailService = EmailService::updateOrCreate(
                ['slug' => $sData['slug']],
                $sData
            );

            // Clean existing plans/faqs if any
            Plan::where('common_id', $emailService->id)
                ->where('common_type', EmailService::class)
                ->delete();

            Faq::where('common_id', $emailService->id)
                ->where('common_type', EmailService::class)
                ->delete();

            foreach ($plans as $p) {
                Plan::create([
                    'name'             => $p['name'],
                    'offer_percentage' => $p['offer_percentage'],
                    'price'            => $p['price'],
                    'period'           => $p['period'],
                    'description'      => $p['description'],
                    'common_type'      => EmailService::class,
                    'common_id'        => $emailService->id,
                    'sort_order'       => $p['sort_order'],
                    'is_active'        => true,
                ]);
            }

            foreach ($faqs as $f) {
                Faq::create([
                    'question'    => $f['question'],
                    'answer'      => $f['answer'],
                    'common_type' => EmailService::class,
                    'common_id'   => $emailService->id,
                    'sort_order'  => $f['sort_order'],
                    'is_active'   => true,
                ]);
            }
        }
    }
}
