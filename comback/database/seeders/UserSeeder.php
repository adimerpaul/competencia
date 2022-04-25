<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ["name"=>"Administrador","email"=>"admin@test.com","password"=>Hash::make("admin")],
            ["name"=>"Administrador2","email"=>"admin2@test.com","password"=>Hash::make("admin")],
        ]);
    }
}
