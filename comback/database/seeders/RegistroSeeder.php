<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegistroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('registros')->insert([
            [
                "fecha"=>"2022-04-25",
                "edad"=>"30-34",
                "dato1"=>"1",
                "dato2"=>"2",
                "dato3"=>"3",
                "dato4"=>"4",
                "dato5"=>"5",
                "evento_id"=>"1",
                "player_id"=>"1",
            ],
            [
                "fecha"=>"2022-04-24",
                "edad"=>"30-34",
                "dato1"=>"1",
                "dato2"=>"2",
                "dato3"=>"3",
                "dato4"=>"4",
                "dato5"=>"5",
                "evento_id"=>"1",
                "player_id"=>"1",
            ],
        ]);
    }
}
