<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(CategoriasTableSeeder::class);
        $this->call(TiposRespuestaTableSeeder::class);
        $this->call(PreguntasTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
    }
}
