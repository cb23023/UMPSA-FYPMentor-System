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
        Schema::create('lecturer_records', function (Blueprint $table) {
            $table->string('lecturerID')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('name')->nullable();
            $table->string('numberQuota')->nullable();
            $table->string('profilePicture')->nullable();
            $table->string('timetable')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lecturer_records');
    }
};
