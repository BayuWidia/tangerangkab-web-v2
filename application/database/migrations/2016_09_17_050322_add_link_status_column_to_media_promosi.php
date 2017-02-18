<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinkStatusColumnToMediaPromosi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('media_promosi', function($table){
        $table->string('link')->nullable()->after('nama_promosi');
        $table->integer('flag_aktif')->nullable()->after('url_foto')->default(0);
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
