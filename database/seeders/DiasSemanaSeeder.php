<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DiasSemanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('dias')->insert([
            ['nombre' => 'Lunes', 'abreviatura' => 'Lun', 'orden' => 1],
            ['nombre' => 'Martes', 'abreviatura' => 'Mar', 'orden' => 2],
            ['nombre' => 'Miércoles', 'abreviatura' => 'Mié', 'orden' => 3],
            ['nombre' => 'Jueves', 'abreviatura' => 'Jue', 'orden' => 4],
            ['nombre' => 'Viernes', 'abreviatura' => 'Vie', 'orden' => 5],
            ['nombre' => 'Sábado', 'abreviatura' => 'Sáb', 'orden' => 6],
            ['nombre' => 'Domingo', 'abreviatura' => 'Dom', 'orden' => 7],
        ]);
    }

}
