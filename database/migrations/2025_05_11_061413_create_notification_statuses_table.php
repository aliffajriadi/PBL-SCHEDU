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
        Schema::create('notification_statuses', function (Blueprint $table) {
            $table->uuid('user_uuid');
            $table->foreignId('notif_id')->constrained(
                table: 'notifications',
                column: 'id'
            );
            $table->boolean('is_read')->default(false);

            $table->primary(['user_uuid', 'notif_id']);
            $table->foreign('user_uuid')->references('uuid')->on('users');


            $table->index('user_uuid');
            $table->index(['user_uuid', 'notif_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_statuses');
    }
};
