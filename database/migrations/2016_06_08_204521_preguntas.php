<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Preguntas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preguntas', function(Blueprint $table) {
            $table->increments('id');
            $table->text('pregunta');
            $table->integer('id_categoria')->unsigned()->nullable();
            $table->foreign('id_categoria')
                  ->references('id')->on('categorias')
                  ->onDelete('cascade'); 
            $table->integer('id_tipo_respuesta')->unsigned()->nullable();
            $table->foreign('id_tipo_respuesta')
                  ->references('id')->on('tipos_respuesta')
                  ->onDelete('cascade');  
            $table->timestamps();
            $table->softDeletes();           
            $table->integer('created_by')->unsigned()->nullable();
            $table->foreign('created_by')
                  ->references('id')->on('users')
                  ->onDelete('cascade');                       
            $table->integer('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')
                  ->references('id')->on('users')
                  ->onDelete('cascade');            
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->foreign('deleted_by')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('preguntas');
    }
}
