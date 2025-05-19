<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\WebPage;

class WebsiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        // Get first page as homepage
        $homepage = WebPage::first();

        if (!$homepage) {
            $homepage = WebPage::create([
                'title' => 'Welcome',
                'html_content' => '<h1>Welcome to our site</h1>',
            ]);
        }

        DB::table('website_settings')->insert([
            'site_title' => 'My Awesome Website',
            'homepage_id' => $homepage->id,
            'footer_content' => '<p>&copy; 2025 My Awesome Website. All rights reserved.</p>',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

         DB::table('navigation_items')->insert([
            'label' => 'Home',
            'page_id' => $homepage->id,
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
