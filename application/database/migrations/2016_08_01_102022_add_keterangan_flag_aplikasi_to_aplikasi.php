<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKeteranganFlagAplikasiToAplikasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('aplikasi', function($table){
        $table->string('keterangan_aplikasi')->after('url_logo')->nullable();
        $table->integer('flag_aplikasi')->after('keterangan_aplikasi')->default(1);
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
