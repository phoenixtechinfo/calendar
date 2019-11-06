<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeInUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'firstname');
            $table->string('lastname')->after('name');
            $table->integer('role')->comment('1=super admin,2=admin,3=user')->default(3)->after('email');
            $table->string('category')->default('default')->after('role');
            $table->string('profile_image')->nullable()->after('category');
            $table->string('mobilenumber')->nullable()->after('profile_image');
            $table->integer('created_by')->nullable()->after('created_at');
            $table->integer('modified_by')->nullable()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('firstname', 'name');
            $table->dropColumn('lastname');
            $table->dropColumn('role');
            $table->dropColumn('category');
            $table->dropColumn('profile_image');
            $table->dropColumn('mobilenumber');
            $table->dropColumn('created_by');
            $table->dropColumn('modified_by');
        });
    }
}
