<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();

        Setting::create([
            'id' => '1',
            'logo' => "164275653842983.png",
            'favicon' => "164275644019941.png",
            'footer_text' => "Youssef Ahmed Abbas At IT Center."
        ]);
    }
}
