<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldCreatedByInPanddingGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pandding_groups', function (Blueprint $table) {
            // add filed called created_by with foreign key of users table username
            $table->string('created_by')->nullable();
            $table->foreign('created_by')->references('username')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pandding_groups', function (Blueprint $table) {
            //
        });
    }
}
