<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string("emp_code")->nullable();
            $table->string("punch_time")->nullable();
            $table->string("punch_state")->nullable();
            $table->string("verify_type")->nullable();
            $table->string("work_code")->nullable();
            $table->string("terminal_sn")->nullable();
            $table->string("terminal_alias")->nullable();
            $table->string("area_alias")->nullable();
            $table->string("longitude")->nullable();
            $table->string("latitude")->nullable();
            $table->string("gps_location")->nullable();
            $table->string("mobile")->nullable();
            $table->string("source")->nullable();
            $table->string("purpose")->nullable();
            $table->string("crc")->nullable();
            $table->string("is_attendance")->nullable();
            $table->string("reserved")->nullable();
            $table->string("sync_status")->nullable();
            $table->string("sync_time")->nullable();
            $table->string("company")->nullable();
            $table->string("emp")->nullable();
            $table->string("terminal")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
