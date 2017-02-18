<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlamatLogoColumnToMasterSkpd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('master_skpd', function($table){
        $table->string('alamat_skpd')->after('domain_skpd')->nullable();
        $table->string('logo_skpd')->after('alamat_skpd')->nullable();
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
