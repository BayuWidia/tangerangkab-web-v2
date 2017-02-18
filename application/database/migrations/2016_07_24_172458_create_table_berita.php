<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBerita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('berita', function(Blueprint $table){
        $table->increments('id');
        $table->integer('id_kategori')->unsigned()->nullable();
        $table->integer('id_skpd')->unsigned()->nullable();
        //0:bukan headline, 1:headline.
        $table->integer('flag_headline')->default(0);
        //0:belum publish, 1:publish.
        $table->integer('flag_publish')->default(0);
        $table->string('judul_berita');
        $table->date('tanggal_publish');
        $table->string('url_foto')->nullable();
        $table->string('tags')->nullable();
        $table->string('isi_berita');
        $table->timestamps();
      });

      Schema::table('berita', function($table){
        $table->foreign('id_skpd')->references('id')->on('master_skpd');
        $table->foreign('id_kategori')->references('id')->on('kategori_berita');
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
