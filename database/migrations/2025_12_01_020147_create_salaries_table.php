<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kalau tabel sudah ada, jangan buat lagi (hindari "Table already exists")
        if (Schema::hasTable('salaries')) {
            return;
        }

        Schema::create('salaries', function (Blueprint $table) {
        $table->id();

        // relasi ke users (asprak)
        $table->foreignId('asprak_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        $table->string('nama_mahasiswa');
        $table->string('nim', 20);
        $table->string('kelas', 30)->nullable();
        $table->unsignedInteger('jumlah_shift')->default(0);
        $table->unsignedBigInteger('slip_gaji')->default(0);
        $table->string('status', 20)->default('success');

        $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
        $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

        $table->timestamps();

        $table->index(['nim', 'nama_mahasiswa']);
});

    }

    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
