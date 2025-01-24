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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->date('due_date')->nullable();
            $table->time('due_time')->nullable();
            $table->enum('priority', ['High', 'Medium', 'Low'])->default('Low');
            $table->enum('status', ['To Do', 'Ongoing', 'Done'])->default('To Do');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');

            // Add points to the task
            $table->integer('points')->default(0); // Points that will be awarded when task is completed
            
            // Optionally, track the user who completed the task (if needed)
            $table->foreignId(column: 'completed_by')->nullable()->constrained('users')->onDelete('set null'); // User who marked it as done
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
        */                                                                                                                                                                                                                                      
   public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
