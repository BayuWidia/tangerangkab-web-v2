<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('galeri', function(Blueprint $table){
        $table->increments('id');
        $table->integer('id_skpd')->unsigned()->nullable();
        $table->string('url_gambar');
        $table->string('keterangan_gambar');
        $table->integer('flag_gambar');
        $table->timestamps();
      });

      Schema::table('galeri', function($table){
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
