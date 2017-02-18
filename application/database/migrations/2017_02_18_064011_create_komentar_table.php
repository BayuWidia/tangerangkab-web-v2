<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKomentarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komentar', function(Blueprint $table){
          $table->increments('id');
          $table->string('nama');
          $table->string('email');
          $table->string('komentar');
          $table->integer('id_berita')->nullable()->unsigned();

          // 1 = tayang, 0 = tidak tayang
          $table->integer('flag_komentar');

          $table->timestamps();
        });

        Schema::table('komentar', function($table){
          $table->foreign('id_berita')->references('id')->on('berita');
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
