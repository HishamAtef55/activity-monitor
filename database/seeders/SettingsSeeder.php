<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                "name" => "Idle timer",
                "description" => "Idle time in minutes before user is marked as inactive",
                "key" => "idle_timeout",
                "value" => "5",
            ],

        ];
        collect($settings)->map(fn($setting) => Setting::firstOrCreate(['key' => $setting['key']], $setting));
    }
}
