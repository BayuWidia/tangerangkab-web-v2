<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('video', function(Blueprint $table){
        $table->increments('id');
        $table->integer('id_skpd')->unsigned()->nullable();
        $table->string('url_video');
        $table->string('judul_video');
        $table->integer('flag_video');
        $table->timestamps();
      });

      Schema::table('video', function($table){
        $table->foreign('id_skpd')->references('id')->on('master_skpd');
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
