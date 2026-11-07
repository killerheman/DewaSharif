<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Hotel Partners Table
        if (!Schema::hasTable('hotel_partners')) {
            Schema::create('hotel_partners', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('hotel_id')->nullable()->index();
                $table->string('name');
                $table->string('hotel_name')->nullable();
                $table->string('email')->unique();
                $table->string('phone')->unique();
                $table->string('password');
                $table->string('status')->default('active'); // active, suspended, pending_approval
                $table->string('bank_name')->nullable();
                $table->string('account_no')->nullable();
                $table->string('account_holder')->nullable();
                $table->string('ifsc_code')->nullable();
                $table->string('upi_id')->nullable();
                $table->decimal('commission_rate', 5, 2)->default(20.00); // 20% platform cut
                $table->rememberToken();
                $table->timestamps();
            });
        }

        // 2. Hotel Settlements Table
        if (!Schema::hasTable('hotel_settlements')) {
            Schema::create('hotel_settlements', function (Blueprint $table) {
                $table->id();
                $table->string('settlement_code')->unique();
                $table->unsignedBigInteger('hotel_id')->index();
                $table->unsignedBigInteger('hotel_partner_id')->nullable()->index();
                $table->decimal('amount_paid', 10, 2);
                $table->decimal('remaining_balance', 10, 2)->default(0.00);
                $table->string('payment_mode')->default('UPI'); // UPI, Cash, NEFT / IMPS
                $table->string('transaction_ref')->nullable(); // UTR / Cheque / Ref ID
                $table->text('admin_notes')->nullable();
                $table->unsignedBigInteger('settled_by_admin_id')->nullable();
                $table->timestamp('settled_at')->nullable();
                $table->timestamps();
            });
        }

        // 3. Update Hotels Table
        Schema::table('hotels', function (Blueprint $table) {
            if (!Schema::hasColumn('hotels', 'partner_id')) {
                $table->unsignedBigInteger('partner_id')->nullable()->after('id')->index();
            }
            if (!Schema::hasColumn('hotels', 'image_6')) {
                $table->string('image_6', 255)->nullable()->after('image_extra');
            }
        });

        // 4. Update Hotel Bookings Table
        Schema::table('hotel_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('hotel_bookings', 'admin_commission_pct')) {
                $table->decimal('admin_commission_pct', 5, 2)->default(20.00)->after('price_per_night');
            }
            if (!Schema::hasColumn('hotel_bookings', 'admin_commission_amount')) {
                $table->decimal('admin_commission_amount', 10, 2)->default(0.00)->after('admin_commission_pct');
            }
            if (!Schema::hasColumn('hotel_bookings', 'hotel_payout_amount')) {
                $table->decimal('hotel_payout_amount', 10, 2)->default(0.00)->after('admin_commission_amount');
            }
            if (!Schema::hasColumn('hotel_bookings', 'checkin_pin')) {
                $table->string('checkin_pin', 10)->nullable()->after('hotel_payout_amount');
            }
            if (!Schema::hasColumn('hotel_bookings', 'checkin_verified_at')) {
                $table->timestamp('checkin_verified_at')->nullable()->after('checkin_pin');
            }
            if (!Schema::hasColumn('hotel_bookings', 'cancellation_fee_total')) {
                $table->decimal('cancellation_fee_total', 10, 2)->default(0.00)->after('checkin_verified_at');
            }
            if (!Schema::hasColumn('hotel_bookings', 'cancellation_admin_share')) {
                $table->decimal('cancellation_admin_share', 10, 2)->default(0.00)->after('cancellation_fee_total');
            }
            if (!Schema::hasColumn('hotel_bookings', 'cancellation_hotel_share')) {
                $table->decimal('cancellation_hotel_share', 10, 2)->default(0.00)->after('cancellation_admin_share');
            }
            if (!Schema::hasColumn('hotel_bookings', 'cancellation_customer_refund')) {
                $table->decimal('cancellation_customer_refund', 10, 2)->default(0.00)->after('cancellation_hotel_share');
            }
            if (!Schema::hasColumn('hotel_bookings', 'refund_status')) {
                $table->string('refund_status', 50)->default('none')->after('cancellation_customer_refund');
            }
            if (!Schema::hasColumn('hotel_bookings', 'refund_utr')) {
                $table->string('refund_utr', 100)->nullable()->after('refund_status');
            }
            if (!Schema::hasColumn('hotel_bookings', 'refund_processed_at')) {
                $table->timestamp('refund_processed_at')->nullable()->after('refund_utr');
            }
            if (!Schema::hasColumn('hotel_bookings', 'settlement_status')) {
                $table->string('settlement_status', 50)->default('pending')->after('refund_processed_at');
            }
            if (!Schema::hasColumn('hotel_bookings', 'settlement_id')) {
                $table->unsignedBigInteger('settlement_id')->nullable()->after('settlement_status')->index();
            }
        });
    }

    public function down(): void
    {
        // Safe reversible logic
    }
};
