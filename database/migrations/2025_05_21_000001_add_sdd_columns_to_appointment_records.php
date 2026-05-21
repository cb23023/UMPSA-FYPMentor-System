<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointment_records', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            $table->text('description')->nullable()->after('title');
            $table->string('meeting_type')->nullable()->default('physical')->after('status'); // 'online' or 'physical'
            $table->string('meeting_link')->nullable()->after('meeting_type');
            $table->text('rejection_reason')->nullable()->after('meeting_link');
        });
    }

    public function down()
    {
        Schema::table('appointment_records', function (Blueprint $table) {
            $table->dropColumn(['title', 'description', 'meeting_type', 'meeting_link', 'rejection_reason']);
        });
    }
};
