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
        Schema::create('nilai_praktikums', function (Blueprint $table) {
            $table->id();

            // Kolom sesuai form
            $table->string('lab', 100);
            $table->string('praktikum', 150);
            $table->string('kelas', 50);

            $table->string('nim', 50)->index();
            $table->string('nama_lengkap', 150);

            $table->string('modul', 150);
            $table->decimal('nilai_total', 5, 2)->default(0);

            // Path/file name bukti nilai modul (upload)
            $table->string('bukti_nilai_modul')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_praktikums');
    }
};
