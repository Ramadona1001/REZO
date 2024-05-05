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
        Schema::create('custom_request_positions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('custom_request_id')->unsigned()->index()->nullable();
            $table->foreign('custom_request_id')->references('id')->on('custom_requests')->onDelete('cascade');
            $table->integer('position_employees_number')->default(0);
            $table->bigInteger('position_id')->unsigned()->index()->nullable();
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_request_positions');
    }
};
