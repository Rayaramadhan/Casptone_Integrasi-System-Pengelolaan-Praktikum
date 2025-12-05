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
        Schema::create('shift_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requester_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('target_user_id')->constrained('users')->onDelete('cascade');
            
            // Kalau ada tabel shifts, pakai foreign ini (ganti date/time/code jadi ID)
            //$table->foreignId('requester_shift_id')->nullable()->constrained('shifts')->onDelete('set null');
            //$table->foreignId('target_shift_id')->nullable()->constrained('shifts')->onDelete('set null');
            
            // Kalau belum ada tabel shifts, pakai yang ini (seperti kode kamu)
            $table->date('requester_date')->nullable();
            $table->string('requester_time')->nullable();
            $table->string('requester_shift_code')->nullable();
            $table->date('target_date')->nullable();
            $table->string('target_time')->nullable();
            $table->string('target_shift_code')->nullable();
            
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->foreignId('taken_by')->nullable()->constrained('users'); // Opsional, kalau accepted
            $table->timestamp('taken_at')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Tambah ini biar rejected bisa di-hide tanpa hapus
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shift_requests');
    }
};