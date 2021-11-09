<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
          'company_name' => 'Groser',
          'company_address' => 'Jl. Raya Merdeka, no 25, Jakarta Pusat',
          'logo' => 'logo.png',
          'company_phone' => '0219876436',
          'member_card' => 'card.jpg',
          'note_type' => 1
        ]);
    }
}
