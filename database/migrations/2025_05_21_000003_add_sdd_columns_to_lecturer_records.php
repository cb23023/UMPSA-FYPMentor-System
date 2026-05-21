<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lecturer_records', function (Blueprint $table) {
            $table->integer('current_students')->default(0)->after('numberQuota');
            $table->boolean('accepting_students')->default(true)->after('current_students');
        });
    }

    public function down()
    {
        Schema::table('lecturer_records', function (Blueprint $table) {
            $table->dropColumn(['current_students', 'accepting_students']);
        });
    }
};
