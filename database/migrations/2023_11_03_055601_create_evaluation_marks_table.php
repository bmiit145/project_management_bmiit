<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteriaId')->constrained('evaluationCriteria' , 'id');
            $table->integer('outof');
            $table->foreignId('courseYearId')->constrained('course_years' , 'id');
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
        Schema::dropIfExists('evaluation_marks');
    }
}
