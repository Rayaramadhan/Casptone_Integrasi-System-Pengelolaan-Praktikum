<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shift_slots', function (Blueprint $table) {
            $table->id();

            // ✅ Nama Praktikum (bukan division_id)
            $table->string('praktikum');          // contoh: "Praktikum Basis Data"

            // Nama shift & kelas
            $table->string('name', 50);           // contoh: "SHIFT 1"
            $table->string('class_code', 50);     // contoh: "SI-46-10"

            // Tanggal & jam
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');

            // Kuota
            $table->unsignedInteger('capacity')->default(1);

            // siapa yang buat (laboran)
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            // Foreign key ke users (opsional, kalau tabel users ada)
            $table->foreign('created_by')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shift_slots');
    }
};
