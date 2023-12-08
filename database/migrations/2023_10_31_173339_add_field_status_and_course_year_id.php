<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldStatusAndCourseYearId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // add field status and courseYearId to stusents table
        // status = 1 means active, status = 0 means inactive

        Schema::table('students', function (Blueprint $table) {
            $table->integer('status')->default(1)->comment('1 = active , 0 = inactive');
            $table->foreignId('programId')->constrained('programs' ,'id')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

            // drop field status and courseYearId from students table
            Schema::table('students', function (Blueprint $table) {
                $table->dropColumn('status');
                $table->dropColumn('programId');
            });
    }
}
