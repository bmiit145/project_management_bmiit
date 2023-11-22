<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypePanddingGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // change type string to long text for defination
        Schema::table('pandding_groups', function (Blueprint $table) {
            // change type string to long text for defination
            $table->longText('definition')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
                // change type long text to string for defination
                Schema::table('pandding_groups', function (Blueprint $table) {
                    // change type long text to string for defination
                    $table->string('definition')->change();
            });
    }
}
