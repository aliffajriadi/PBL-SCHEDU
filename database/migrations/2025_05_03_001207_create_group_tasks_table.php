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
        Schema::create('group_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->date('deadline');
            $table->foreignId('group_id')->constrained(
                table: 'groups',
                column: 'id'
            )->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('unit_id')->constrained(
                table: 'group_task_units',
                column: 'id'
            )->onDelete('cascade')->onUpdate('cascade');
            $table->uuid('created_by');
            $table->foreign('created_by')->references('uuid')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_tasks');
    }
};
