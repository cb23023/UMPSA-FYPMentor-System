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
        Schema::create('appointment_records', function (Blueprint $table) {
            $table->id(); // This will create an auto-incrementing primary key
            $table->string('time');
            $table->string('date');
            $table->string('status');
            $table->string('lecturerID');
            $table->string('studentID');
            $table->timestamps();

            // Foreign keys to the lecturer and student records
            $table->foreign('lecturerID')->references('lecturerID')->on('lecturer_records')->onDelete('cascade');
            $table->foreign('studentID')->references('studentID')->on('student_records')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment_records');
    }
};
