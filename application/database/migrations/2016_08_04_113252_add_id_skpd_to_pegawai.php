<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdSkpdToPegawai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('pegawai', function($table){
        $table->integer('id_skpd')->unsigned()->nullable();
      });

      Schema::table('pegawai', function($table){
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
