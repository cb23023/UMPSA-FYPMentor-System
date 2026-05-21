<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('time_frame_records', function (Blueprint $table) {
            $table->string('semester')->nullable()->after('description');
            $table->string('academic_year')->nullable()->after('semester');
            $table->string('status')->default('active')->after('endDate'); // 'active', 'inactive'
            $table->boolean('is_active')->default(false)->after('status');
        });
    }

    public function down()
    {
        Schema::table('time_frame_records', function (Blueprint $table) {
            $table->dropColumn(['semester', 'academic_year', 'status', 'is_active']);
        });
    }
};
