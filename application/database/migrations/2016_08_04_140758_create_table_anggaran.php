<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAnggaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('anggaran', function(Blueprint $table){
        $table->increments('id');
        $table->string('uraian');
        $table->string('tahun');
        $table->integer('id_skpd')->unsigned()->nullable();
        $table->timestamps();
      });

      Schema::table('anggaran', function($table){
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
