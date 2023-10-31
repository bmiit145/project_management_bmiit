<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommitteeMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('committee_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')->constrained('faculties');
            // here type is eigher head so head = 0 or member = 1 , So select enum
            $table->tinyInteger('type')->comment('0 = head , 1 = member');
            $table->foreignId('committee_id')->constrained('committees');
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
        Schema::dropIfExists('committee_members');
    }
}
