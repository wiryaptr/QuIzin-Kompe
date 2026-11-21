<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nickname', 50);
            $table->integer('total_score')->default(0);
            $table->timestamps();

            $table->unique(['room_id', 'nickname']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};