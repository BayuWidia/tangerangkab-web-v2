<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('pegawai', function(Blueprint $table){
        $table->increments('id');
        $table->string('nama_pegawai');
        //1:Pria 2:Wanita
        $table->integer('jenis_kelamin');
        $table->integer('id_esselon')->unsigned()->nullable();
        $table->integer('id_pangkat')->unsigned()->nullable();
        //1:Aktif 2:Tidak Aktif
        $table->integer('flag_pegawai')->default(1);
        $table->timestamps();
      });

      Schema::table('pegawai', function($table){
        $table->foreign('id_esselon')->references('id')->on('esselon');
        $table->foreign('id_pangkat')->references('id')->on('pangkat');
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
