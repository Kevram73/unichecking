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
        Schema::create('machine_requests', function (Blueprint $table) {
            $table->id();
            $table->string("request_code");
            $table->string("dev_id");
            $table->string("dev_model");
            $table->string("token");
            $table->datetime("time");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machine_requests');
    }
};
