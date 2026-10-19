<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('email_services', function (Blueprint $table) {
            if (!Schema::hasColumn('email_services', 'plan_subtitle')) {
                $table->text('plan_subtitle')->nullable()->after('banner_description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_services', function (Blueprint $table) {
            if (Schema::hasColumn('email_services', 'plan_subtitle')) {
                $table->dropColumn('plan_subtitle');
            }
        });
    }
};
