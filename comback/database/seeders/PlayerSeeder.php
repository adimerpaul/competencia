<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('players')->insert([
            [
                'paterno'=>"RUIZ",
                'materno'=>"",
                'nombres'=>"MIGUEL",
                'ci'=>"7336199",
                'fechanac'=>"2000-01-01",
            ]
        ]);
    }
}
