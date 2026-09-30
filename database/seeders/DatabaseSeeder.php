<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SiteSettingSeeder::class,
            ProductSeeder::class,
            BlogPostSeeder::class,
        ]);

        // Partners and team members are intentionally NOT seeded.
        // Only records added through the Admin Panel appear on the website.
    }
}
