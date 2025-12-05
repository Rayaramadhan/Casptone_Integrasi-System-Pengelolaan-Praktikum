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
        Schema::create('resource_requests', function (Blueprint $table) {
            $table->id();
            
            // Requester (Asprak)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Request Details
            $table->string('title');
            $table->text('description');
            $table->enum('resource_type', [
                'room',           // Ruangan
                'tool_account',   // Akun Tools (GitHub, AWS, etc.)
                'hardware',       // Perangkat Keras
                'software',       // Software/License
                'other'          // Lainnya
            ]);
            $table->string('resource_name'); // Nama spesifik resource
            $table->integer('quantity')->default(1); // Jumlah yang diminta
            $table->date('needed_date'); // Tanggal dibutuhkan
            $table->time('needed_time')->nullable(); // Waktu (untuk ruangan)
            $table->integer('duration')->nullable(); // Durasi dalam menit (untuk ruangan)
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            
            // Status
            $table->enum('status', [
                'pending',    // Menunggu review
                'approved',   // Disetujui
                'rejected'    // Ditolak
            ])->default('pending');
            
            // Approval/Rejection by Laboran
            $table->text('feedback')->nullable(); // WAJIB: Alasan approve/reject
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('status');
            $table->index('resource_type');
            $table->index('needed_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_requests');
    }
};
