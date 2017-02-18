<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdSkpdToSlider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('slider', function($table){
        $table->integer('id_skpd')->after('id')->unsigned()->nullable();
      });

      Schema::table('slider', function($table){
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
