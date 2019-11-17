<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateEventTable extends Migration
{
    use SoftDeletes;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('description');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->string('image')->nullable()->default(NULL);
            $table->string('contact_no')->nullable()->default(NULL);
            $table->bigInteger('color_id')->unsigned();
            $table->boolean('interested_flag')->default(0);
            $table->integer('created_by');
            $table->integer('modified_by');
            $table->timestamps();
            $table->foreign('color_id')->references('id')->on('colors');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
