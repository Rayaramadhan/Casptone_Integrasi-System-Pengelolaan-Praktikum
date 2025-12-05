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
        Schema::table('resource_requests', function (Blueprint $table) {
            // Drop columns that are no longer needed
            $table->dropColumn(['resource_name', 'priority']);
            
            // Add new columns for Laboratorium & Nama Praktikum
            $table->enum('laboratorium', ['EISD', 'ERP', 'EDM', 'EIM', 'SAG'])->after('user_id');
            $table->string('nama_praktikum')->after('laboratorium');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resource_requests', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn(['laboratorium', 'nama_praktikum']);
            
            // Add back old columns
            $table->string('resource_name')->after('resource_type');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('duration');
        });
    }
};
