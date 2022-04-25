<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('eventos')->insert([
            ["nombre"=>"100 mts","tipo"=>"PISTA"],
            ["nombre"=>"200 mts","tipo"=>"PISTA"],
            ["nombre"=>"400 mts","tipo"=>"PISTA"],
            ["nombre"=>"800 mts","tipo"=>"PISTA"],
            ["nombre"=>"1500 mts","tipo"=>"PISTA"],
            ["nombre"=>"3000 mts","tipo"=>"PISTA"],
            ["nombre"=>"5000 mts","tipo"=>"PISTA"],
            ["nombre"=>"10000 mts","tipo"=>"PISTA"],
            ["nombre"=>"5000 camita","tipo"=>"PISTA"],
            ["nombre"=>"10000 camita","tipo"=>"PISTA"],
            ["nombre"=>"Bala","tipo"=>"CAMPO"],
            ["nombre"=>"Disto","tipo"=>"CAMPO"],
            ["nombre"=>"Jabalina","tipo"=>"CAMPO"],
            ["nombre"=>"Matute","tipo"=>"CAMPO"],
            ["nombre"=>"Martillo","tipo"=>"CAMPO"],
            ["nombre"=>"Salto largo","tipo"=>"CAMPO"],
        ]);
    }
}
