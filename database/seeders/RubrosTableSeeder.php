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
            // Rubros de profesiones con servicios
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
            ['nombre' => 'Gasista'],
            ['nombre' => 'Yesero'],
            ['nombre' => 'Soldador'],
            ['nombre' => 'Techista'],
            ['nombre' => 'Vidriero'],
            ['nombre' => 'Herrero'],
            ['nombre' => 'Tapicero'],
            ['nombre' => 'Reparador de electrodomésticos'],
            ['nombre' => 'Técnico en refrigeración'],
            ['nombre' => 'Montador de aire acondicionado'],
            ['nombre' => 'Instalador de sistemas solares'],
            ['nombre' => 'Técnico en redes y telecomunicaciones'],
            ['nombre' => 'Técnico en CCTV y seguridad electrónica'],
            ['nombre' => 'Mantenimiento de piscinas'],
            ['nombre' => 'Mudanzas y fletes'],
            ['nombre' => 'Limpieza y mantenimiento'],
            ['nombre' => 'Cuidado de adultos mayores'],
            ['nombre' => 'Cuidado de niños'],
            ['nombre' => 'Paseador de perros'],
            ['nombre' => 'Adiestrador de perros'],
            ['nombre' => 'Peluquero canino'],
            ['nombre' => 'Maestro particular'],
            ['nombre' => 'Contador'],
            ['nombre' => 'Abogado'],
            ['nombre' => 'Diseñador gráfico'],
            ['nombre' => 'Desarrollador web'],
            ['nombre' => 'Marketing digital'],
            ['nombre' => 'Fotógrafo'],
            ['nombre' => 'Entrenador personal'],
            ['nombre' => 'Nutricionista'],
            ['nombre' => 'Masajista'],
            ['nombre' => 'Peluquero'],
            ['nombre' => 'Esteticista'],
            ['nombre' => 'Tatuador'],
            ['nombre' => 'DJ y Sonido para eventos'],
            ['nombre' => 'Organizador de eventos'],
            ['nombre' => 'Chef a domicilio'],
            ['nombre' => 'Repostero'],
        ];
        

        // Insertar los rubros en la tabla 'rubros'
        DB::table('rubros')->insert($rubros);
    }
}
