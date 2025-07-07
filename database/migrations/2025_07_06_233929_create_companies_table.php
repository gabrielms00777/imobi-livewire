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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique(); // Slug único para a imobiliária
            $table->string('slogan')->nullable(); // Slogan da imobiliária
            $table->string('logo')->nullable(); // URL da logo da imobiliária
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('website')->nullable();
            $table->decimal('commission_rate', 5, 2)->default(0.00); // Ex: 5.00 para 5%
            $table->text('description')->nullable(); // Pequena descrição da imobiliária
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
