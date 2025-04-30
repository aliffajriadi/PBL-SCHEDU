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
        Schema::create('member_ofs', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid');
            $table->UnsignedBigInteger('group_id');
            $table->boolean('verified');
            $table->foreign('user_uuid')->references('uuid')->on('users');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_ofs');
    }
};
