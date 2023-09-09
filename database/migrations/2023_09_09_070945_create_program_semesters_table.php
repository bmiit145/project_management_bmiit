<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_semesters', function (Blueprint $table) {
            $table->id();
            $table->string('programCode');
            $table->unsignedBigInteger('semesterid');
            $table->foreign('programCode')->references('code')->on('programs');
            $table->foreign('semesterid')->references('id')->on('semesters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_semesters');
    }
}
