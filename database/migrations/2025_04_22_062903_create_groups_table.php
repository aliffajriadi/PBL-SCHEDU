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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->char('group_code', 6)->unique();
            $table->uuid('instance_uuid');
            $table->foreign('instance_uuid')->references('uuid')->on('staff')->onDelete('cascade')->onUpdate('cascade');
            $table->text('pic')->nullable();
            $table->uuid('created_by');
            $table->foreign('created_by')->references('uuid')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
