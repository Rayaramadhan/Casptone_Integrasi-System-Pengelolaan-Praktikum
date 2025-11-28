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
            $table->foreignId('requester_id')->constrained('users'); // yang minta tukar
            $table->foreignId('target_user_id')->constrained('users'); // yang dituju tukar
            $table->date('requester_date');           // tanggal shift yang dimiliki requester
            $table->string('requester_time');          // jam shift requester (ex: 06.30 - 09.30)
            $table->string('requester_shift_code');    // ex: SHIFT 3 (SI-48-06)
    
            $table->date('target_date');               // tanggal shift target
            $table->string('target_time');             // jam shift target
            $table->string('target_shift_code');
    
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'taken'])->default('pending');
            $table->foreignId('taken_by')->nullable()->constrained('users'); // yang ambil
            $table->timestamp('taken_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_requests');
    }
};
