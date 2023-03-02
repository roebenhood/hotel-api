<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema:: create('Rooms', function(Blueprint $table){
            $table->id();
            $table->string('roomName');
            $table->string('roomDescription');
            $table->string('roomCapacity');
            $table->string('roomPrice');
            $table->dateTime('createdOn');
            $table->dateTime('updatedOn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
