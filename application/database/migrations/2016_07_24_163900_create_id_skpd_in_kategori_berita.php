<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdSkpdInKategoriBerita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('kategori_berita', function($table){
        $table->integer("id_skpd")->unsigned()->nullable()->after('keterangan_kategori');
      });

      Schema::table('kategori_berita', function($table){
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
