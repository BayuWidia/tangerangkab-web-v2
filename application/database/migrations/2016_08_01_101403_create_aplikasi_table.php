<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAplikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('aplikasi', function(Blueprint $table){
        $table->increments('id');
        $table->integer('id_skpd')->unsigned()->nullable();
        $table->string('nama_aplikasi');
        $table->string('domain_aplikasi')->nullable();
        $table->string('url_logo')->nullable();
        $table->timestamps();
      });

      Schema::table('aplikasi', function($table){
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
