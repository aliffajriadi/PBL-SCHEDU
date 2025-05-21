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
            $table->uuid('file_name')->primary();
            $table->foreignId('submission_id')->constrained(
                table: 'group_task_submissions',
                column: 'id'
            );
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
