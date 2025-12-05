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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            
            // Laboran yang membuat assignment
            $table->foreignId('created_by')
                ->constrained('users')
                ->onDelete('cascade');
            
            // Assignment details
            $table->string('judul');
            $table->text('deskripsi');
            
            // Tipe assignment: LPJ, RAB, Laporan, etc
            $table->enum('tipe', ['LPJ', 'RAB', 'Laporan', 'Proposal', 'Lainnya']);
            
            // Target praktikum (nama praktikum, bukan FK karena tidak ada tabel praktikum)
            $table->string('praktikum');
            
            // Deadline
            $table->datetime('deadline');
            
            // Status: active (masih bisa submit), closed (sudah lewat deadline/ditutup manual)
            $table->enum('status', ['active', 'closed'])->default('active');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
