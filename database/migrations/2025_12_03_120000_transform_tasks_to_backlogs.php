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
        // Rename table from tasks to backlogs
        Schema::rename('tasks', 'backlogs');

        // Modify the backlogs table
        Schema::table('backlogs', function (Blueprint $table) {
            // Drop columns that are no longer needed
            $table->dropColumn(['priority', 'category']);
            
            // Add new columns
            $table->string('assign_to')->nullable()->after('description');
            $table->text('progress_notes')->nullable()->after('assign_to');
            $table->string('progress_file')->nullable()->after('progress_notes');
            
            // Modify status enum
            $table->dropColumn('status');
        });

        // Add status column with new values
        Schema::table('backlogs', function (Blueprint $table) {
            $table->enum('status', ['belum_dikerjakan', 'on_progress', 'done'])
                  ->default('belum_dikerjakan')
                  ->after('deadline');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert status enum
        Schema::table('backlogs', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('backlogs', function (Blueprint $table) {
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
        });

        // Revert column changes
        Schema::table('backlogs', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn(['assign_to', 'progress_notes', 'progress_file']);
            
            // Add back old columns
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('status');
            $table->string('category')->nullable()->after('priority');
        });

        // Rename table back to tasks
        Schema::rename('backlogs', 'tasks');
    }
};
