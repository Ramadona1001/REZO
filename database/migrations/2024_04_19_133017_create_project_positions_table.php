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
        Schema::create('project_positions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('position_id')->unsigned()->index()->nullable();
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->integer('position_employees_number')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_positions');
    }
};
