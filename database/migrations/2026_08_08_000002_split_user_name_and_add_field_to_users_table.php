<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->enum('field', ['Company', 'Organization', 'Individual'])->default('Individual')->after('last_name');
        });

        // Copy existing name column to first_name / last_name
        DB::table('users')->orderBy('id')->chunk(100, function ($users) {
            foreach ($users as $user) {
                if ($user->name) {
                    $parts = explode(' ', trim($user->name), 2);
                    $first = $parts[0] ?? '';
                    $last = $parts[1] ?? '';
                    
                    DB::table('users')->where('id', $user->id)->update([
                        'first_name' => $first,
                        'last_name' => $last,
                    ]);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'field']);
        });
    }
};
