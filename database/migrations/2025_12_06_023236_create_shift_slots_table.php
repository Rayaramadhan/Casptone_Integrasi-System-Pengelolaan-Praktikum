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
        Schema::create('shift_slots', function (Blueprint $table) {
            $table->id();

            // Cukup tuliskan di sini, otomatis akan berada setelah ID
            $table->string('lab', 50); 

            $table->string('praktikum');
            $table->string('name', 50);
            $table->string('class_code', 50);
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('capacity')->default(1);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_slots');
    }
};