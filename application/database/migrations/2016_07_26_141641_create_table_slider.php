<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSlider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('slider', function(Blueprint $table){
        $table->increments('id');
        $table->integer('id_user')->unsigned()->nullable();
        $table->string('url_slider');
        $table->string('keterangan_slider');
        $table->integer('flag_slider');
        $table->timestamps();
      });

      Schema::table('slider', function($table){
        $table->foreign('id_user')->references('id')->on('users');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
