<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RubrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rubros = [
            ['nombre' => 'Electricista'],
            ['nombre' => 'Plomero'],
            ['nombre' => 'Carpintero'],
            ['nombre' => 'Pintor'],
            ['nombre' => 'Jardinero'],
            ['nombre' => 'Cerrajero'],
            ['nombre' => 'Albañil'],
            ['nombre' => 'Fontanero'],
            ['nombre' => 'Mecánico'],
            ['nombre' => 'Constructor'],
        ];

        // Insertar los rubros en la tabla 'rubros'
        DB::table('rubros')->insert($rubros);
    }
}
