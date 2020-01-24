<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterestedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interested_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('event_id')->unsigned();
            $table->string('name');
            $table->string('email');
            $table->dateTime('departure_date');
            $table->string('departure_city');
            $table->string('destination');
            $table->string('budget_per_person');
            $table->string('no_of_person');
            $table->string('contact_no')->nullable()->default(NULL);
            $table->timestamps();
            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interested_users');
    }
}
