<?php

use Illuminate\Database\Seeder;

class TiposRespuestaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_respuesta')->insert([
		           'tipo_respuesta' => str_random(10), 
		           'created_at' => date('Y-m-d H:i:s'),
		           'updated_at' => date('Y-m-d H:i:s'),           
		           'created_by' => 1,
		           'updated_by' => 1
        ]);
    }
}
