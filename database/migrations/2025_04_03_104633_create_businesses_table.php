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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('company_name');
            $table->string('kvk_number')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('phone')->nullable();
            $table->text('notes')->nullable();
            $table->string('contract_signed_by_admin')->nullable();
            $table->string('contract_signed_by_business')->nullable();
            $table->string('contract_status')->default('pending');
            $table->string('contract_file_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
