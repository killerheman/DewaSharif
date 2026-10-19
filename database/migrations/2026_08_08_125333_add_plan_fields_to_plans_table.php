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
        Schema::table('plans', function (Blueprint $table) {
            if (!Schema::hasColumn('plans', 'plan_type')) {
                $table->string('plan_type')->nullable()->after('name');
            }
            if (!Schema::hasColumn('plans', 'mrp')) {
                $table->decimal('mrp', 10, 2)->nullable()->after('price');
            }
            if (!Schema::hasColumn('plans', 'faqs')) {
                $table->json('faqs')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['plan_type', 'mrp', 'faqs']);
        });
    }
};
