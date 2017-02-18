<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaPromosiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('media_promosi', function(Blueprint $table){
        $table->increments('id');
        $table->integer('id_skpd')->unsigned()->nullable();
        $table->integer('id_user')->unsigned()->nullable();
        $table->string('nama_promosi');
        $table->string('url_foto');
        $table->timestamps();
      });

      Schema::table('media_promosi', function($table){
        $table->foreign('id_skpd')->references('id')->on('master_skpd');
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
