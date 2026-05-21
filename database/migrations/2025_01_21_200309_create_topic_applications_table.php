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
        Schema::create('topic_applications', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('topicID');
            $table->string('studentID');
            $table->timestamps();
            $table->foreign('topicID')->references('topicID')->on('topic_records')->onDelete('cascade');
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
        Schema::dropIfExists('topic_applications');
    }
};
