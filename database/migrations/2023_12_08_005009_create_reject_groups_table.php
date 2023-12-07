<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRejectGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reject_groups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('groupNumber');
            // add a foreign key with studentenro and courseYearId
            $table->bigInteger('studentenro');
            $table->bigInteger('courseYearId')->unsigned();
            $table->string('title');
            $table->longText('definition');
            $table->string('created_by')->nullable();
            $table->foreign('created_by')->references('username')->on('users')->onUpdate('no action');
            $table->timestamps();
            $table->foreign('studentenro')->references('enro')->on('students');
            $table->foreign('courseYearId')->references('id')->on('course_years');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reject_groups');
    }
}
