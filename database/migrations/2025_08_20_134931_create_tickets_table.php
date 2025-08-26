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
         Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('status');
            $table->foreignId('reporter_id')->constrained('users');
            $table->timestamp('made_timestamp');
            $table->timestamp('last_update_on');
            $table->foreignId('assignee_id')->nullable()->constrained('users');
            $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
