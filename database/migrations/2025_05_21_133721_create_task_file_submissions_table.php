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
        Schema::create('task_file_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('stored_name')->nullable();
            $table->text('original_name');
            $table->morphs('fileable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_file_submissions');
    }
};
