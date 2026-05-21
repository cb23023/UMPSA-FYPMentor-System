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
        Schema::create('topic_records', function (Blueprint $table) {
            $table->id('topicID');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['Pending', 'Active', 'Closed'])->default('Pending');
            $table->string('lecturerID');
            $table->timestamps();

            $table->foreign('lecturerID')->references('lecturerID')->on('lecturer_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topic_records');
    }
};
