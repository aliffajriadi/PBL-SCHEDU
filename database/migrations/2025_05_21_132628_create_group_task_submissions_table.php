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
        Schema::create('group_task_submissions', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->integer('score')->nullable()->default(0);
            $table->uuid('user_uuid');
            $table->foreign('user_uuid')->references('uuid')->on('users');
            $table->foreignId('group_task_id')->constrained(
                table: 'group_tasks',
                column: 'id'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_task_submissions');
    }
};
