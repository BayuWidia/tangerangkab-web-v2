<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMenuKonten extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('menu_konten', function(Blueprint $table){
        $table->increments('id');
        $table->integer('id_skpd')->unsigned()->nullable();
        $table->integer('id_user')->unsigned()->nullable();
        $table->integer('flagpublish')->default(0);
        $table->integer('view_counter')->default(0);
        $table->integer('id_submenu')->unsigned()->nullable();
        $table->string('judul_konten');
        $table->date('tanggal_publish');
        $table->string('url_foto');
        $table->string('tags');
        $table->longtext('isi_konten');
        $table->timestamps();
      });

      Schema::table('menu_konten', function($table){
        $table->foreign('id_skpd')->references('id')->on('master_skpd');
        $table->foreign('id_user')->references('id')->on('users');
        $table->foreign('id_submenu')->references('id')->on('menu');
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
