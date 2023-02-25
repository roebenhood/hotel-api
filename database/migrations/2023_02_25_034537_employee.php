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
        Schema:: create('Employee', function(Blueprint $table){
            $table->id();
            $table->string('employee_id');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('username');
            $table->string('email');
            $table->string('contactNo');
            $table->string('password');
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
