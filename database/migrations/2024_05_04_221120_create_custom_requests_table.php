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
        Schema::create('custom_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_name')->nullable();
            $table->integer('unit_position')->default(1);
            $table->integer('positions')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->double('budget')->nullable();
            $table->integer('created_by')->nullable();
            $table->bigInteger('designation_id')->unsigned()->index()->nullable();
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_requests');
    }
};
