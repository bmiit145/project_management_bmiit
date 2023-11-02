<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresentationPanelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presentation_panels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('panelId')->constrained('panels' , 'id')->onDelete('cascade');
            $table->foreignId('facultyId')->constrained('faculties' , 'id')->onDelete('cascade');
            $table->foreignId('courseYearId')->constrained('course_years' , 'id')->onDelete('cascade');
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
        Schema::dropIfExists('presentation_panels');
    }
}
