<?php

use Illuminate\Database\Seeder;

class PreguntasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('preguntas')->insert([
		           'pregunta' => str_random(30), 
		           'id_categoria' => 3, 
		           'id_tipo_respuesta' => 3, 
		           'created_at' => date('Y-m-d H:i:s'),
		           'updated_at' => date('Y-m-d H:i:s'),           
		           'created_by' => 1,
		           'updated_by' => 1
        ]);
    }
}
