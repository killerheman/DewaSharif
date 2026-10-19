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
            if (!Schema::hasColumn('email_services', 'icon')) {
                $table->string('icon')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('email_services', 'icon_image')) {
                $table->string('icon_image')->nullable()->after('icon');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_services', function (Blueprint $table) {
            if (Schema::hasColumn('email_services', 'icon')) {
                $table->dropColumn('icon');
            }
            if (Schema::hasColumn('email_services', 'icon_image')) {
                $table->dropColumn('icon_image');
            }
        });
    }
};
