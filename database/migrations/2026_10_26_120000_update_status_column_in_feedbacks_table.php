<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('feedbacks')) {
            // Modify status column from restrictive ENUM to VARCHAR(30) to allow 'pending', 'resolved', 'new', 'reviewed', 'archived'
            DB::statement("ALTER TABLE `feedbacks` MODIFY `status` VARCHAR(30) NOT NULL DEFAULT 'pending'");
            
            // Normalize any existing 'new' records to 'pending'
            DB::table('feedbacks')->where('status', 'new')->update(['status' => 'pending']);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('feedbacks')) {
            DB::statement("ALTER TABLE `feedbacks` MODIFY `status` ENUM('new', 'reviewed', 'archived') NOT NULL DEFAULT 'new'");
        }
    }
};
