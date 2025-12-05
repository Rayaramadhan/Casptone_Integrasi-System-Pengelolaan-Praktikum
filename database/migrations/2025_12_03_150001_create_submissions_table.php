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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            
            // Assignment yang di-submit
            $table->foreignId('assignment_id')
                ->constrained('assignments')
                ->onDelete('cascade');
            
            // Asprak yang submit
            $table->foreignId('asprak_id')
                ->constrained('users')
                ->onDelete('cascade');
            
            // File submission
            $table->string('file_path');
            
            // Catatan dari asprak (optional)
            $table->text('catatan')->nullable();
            
            // Status: pending, approved, rejected
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            // Feedback dari laboran
            $table->text('feedback')->nullable();
            
            // Review details
            $table->foreignId('reviewed_by')->nullable()
                ->constrained('users')
                ->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            
            $table->timestamps();
            
            // Satu asprak hanya bisa submit 1x per assignment (unique constraint)
            $table->unique(['assignment_id', 'asprak_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
