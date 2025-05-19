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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->datetime('visible_schedule');
            $table->boolean('is_reminder');
            $table->foreignId('group_id')->nullable()->constrained(
                table: 'groups',
                column: 'id'
            )->onDelete('cascade')->onUpdate('cascade');
            
            $table->morphs('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
