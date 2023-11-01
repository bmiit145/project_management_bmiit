<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldCalledStatusToStudentGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_groups', function (Blueprint $table) {
            $table->integer('status')->default(1)->comment('0 - inactive , 1 - Active')->after('courseYearId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_groups', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
