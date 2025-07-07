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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Corretor que cadastrou
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('set null'); // Imobiliária proprietária (pode ser diferente do user->company_id)

            $table->string('title');
            $table->text('description');
            $table->decimal('price', 15, 2);
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code')->nullable();
            $table->string('property_type'); // Ex: 'Casa', 'Apartamento', 'Terreno', 'Comercial'
            $table->string('transaction_type'); // Ex: 'Venda', 'Aluguel'
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('suites')->nullable();
            $table->float('area')->nullable(); // em m²
            $table->integer('garage_spaces')->nullable();
            $table->text('amenities')->nullable(); // Campo JSON para listar comodidades (piscina, churrasqueira, etc.)

            $table->string('status')->default('available'); // Ex: 'available', 'pending', 'sold', 'rented'
            $table->boolean('is_featured')->default(false); // Para imóveis em destaque

            // Adicione colunas para imagens se for armazenar diretamente no DB ou URLs
            // É mais comum ter uma tabela 'property_images' separada para múltiplas imagens
            $table->string('main_image_url')->nullable(); // Imagem principal

            // $table->softDeletes(); // Para permitir exclusão lógica

            $table->timestamps();
        });
        // Schema::create('properties', function (Blueprint $table) {
        //     $table->id();

        //     // Informações básicas
        //     $table->string('title');
        //     $table->string('slug')->unique();
        //     $table->text('description');
        //     $table->enum('type', ['casa', 'apartamento', 'terreno', 'comercial', 'outro']);
        //     $table->enum('purpose', ['venda', 'aluguel', 'ambos']);
        //     $table->enum('status', ['rascunho', 'disponivel', 'vendido', 'alugado'])->default('rascunho');
        //     $table->decimal('price', 12, 2);
        //     $table->decimal('rent_price', 12, 2)->nullable();
        //     $table->string('currency')->default('BRL');

        //     // Características
        //     $table->integer('bedrooms')->nullable();
        //     $table->integer('bathrooms')->nullable();
        //     $table->integer('garage_spaces')->nullable();
        //     $table->integer('area')->nullable(); // m²
        //     $table->integer('total_area')->nullable(); // m² (para terreno)
        //     $table->integer('construction_area')->nullable(); // m²
        //     $table->integer('floors')->nullable();
        //     $table->integer('year_built')->nullable();

        //     // Endereço
        //     $table->string('street');
        //     $table->string('number');
        //     $table->string('complement')->nullable();
        //     $table->string('neighborhood');
        //     $table->string('city');
        //     $table->string('state', 2);
        //     $table->string('zip_code', 9);
        //     $table->decimal('latitude', 10, 7)->nullable();
        //     $table->decimal('longitude', 10, 7)->nullable();

        //     // Destaques e SEO
        //     $table->boolean('featured')->default(false);
        //     $table->string('video_url')->nullable();
        //     $table->string('virtual_tour_url')->nullable();
        //     $table->json('amenities')->nullable(); // Array de comodidades
        //     $table->string('meta_title')->nullable();
        //     $table->text('meta_description')->nullable();

        //     // Relacionamentos
        //     $table->foreignId('user_id')->constrained()->onDelete('cascade');

        //     $table->softDeletes();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
