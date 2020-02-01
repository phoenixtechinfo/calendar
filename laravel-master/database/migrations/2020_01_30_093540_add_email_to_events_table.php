<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('whatsapp')->nullable()->default(NULL);
			$table->string('messenger')->nullable()->default(NULL);
			$table->string('email')->nullable()->default(NULL);	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
             $table->dropColumn('whatsapp');
			  $table->dropColumn('messenger');
			   $table->dropColumn('email');
        });
    }
}
