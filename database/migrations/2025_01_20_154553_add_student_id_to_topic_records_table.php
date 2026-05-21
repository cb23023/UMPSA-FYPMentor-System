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
        Schema::table('topic_records', function (Blueprint $table) {
            $table->string('studentID')->nullable(); // Add the studentID column
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
        Schema::table('topic_records', function (Blueprint $table) {
            $table->dropForeign(['studentID']); // Drop the foreign key
            $table->dropColumn('studentID');
        });
    }
};
