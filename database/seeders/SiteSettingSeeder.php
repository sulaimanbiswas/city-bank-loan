<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // We are inserting only one row for the site settings
        DB::table('site_settings')->insert([
            'site_link' => 'https://yourdomain.com',
            'site_title' => 'My Awesome Website',
            'description' => 'This is a great description for my awesome website. It is good for SEO.',
            'keywords' => 'laravel, php, web development, awesome site',
            'site_name' => 'My Website',
            'tiktok' => 'https://tiktok.com/@username',
            'whatsapp' => '+8801XXXXXXXXX',
            'youtube' => 'https://youtube.com/c/channelname',
            'telegram' => 'https://t.me/username',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
