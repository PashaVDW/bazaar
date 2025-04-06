<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('return_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->cascadeOnDelete();
            $table->string('photo_path');
            $table->timestamp('submitted_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('return_requests');
    }
};
