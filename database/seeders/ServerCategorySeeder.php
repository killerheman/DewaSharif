<?php

namespace Database\Seeders;

use App\Models\ServerCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServerCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'VPS Server',
            'Dedicated Server',
        ];

        foreach ($categories as $index => $name) {
            ServerCategory::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name'       => $name,
                    'sort_order' => $index + 1,
                    'is_active'  => true,
                ]
            );
        }
    }
}
