<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $joaoCorretor = User::where('email', 'joao@corretor.com')->first();
        $pedroCorretor = User::where('email', 'pedro@megaimoveis.com.br')->first();
        $anaCorretora = User::where('email', 'ana@litoralprime.com.br')->first();

        $megaImoveis = Company::where('name', 'Mega Imóveis S.A.')->first();
        $litoralPrime = Company::where('name', 'Litoral Prime Imobiliária')->first();

        // Imóvel do Corretor Autônomo
        if ($joaoCorretor) {
            Property::create([
                'user_id' => $joaoCorretor->id,
                'company_id' => null, // Autônomo, sem vínculo direto com Imobiliária para este imóvel
                'title' => 'Apartamento Moderno no Centro',
                'description' => 'Apartamento compacto e moderno, ideal para solteiros ou casais jovens. Perto de tudo!',
                'price' => 320000.00,
                'address' => 'Rua da Central, 123',
                'city' => 'Curitiba',
                'state' => 'PR',
                'zip_code' => '80010-000',
                'property_type' => 'Apartamento',
                'transaction_type' => 'Venda',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'suites' => 0,
                'area' => 65.0,
                'garage_spaces' => 1,
                'amenities' => json_encode(['Academia', 'Salão de Festas']),
                'status' => 'available',
                'is_featured' => true,
                'main_image_url' => 'https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ]);
        }

        // Imóveis da Mega Imóveis S.A. (cadastrados por Pedro Corretor)
        if ($pedroCorretor && $megaImoveis) {
            Property::create([
                'user_id' => $pedroCorretor->id,
                'company_id' => $megaImoveis->id,
                'title' => 'Casa Térrea Espaçosa',
                'description' => 'Linda casa térrea com amplo quintal na Zona Leste. Ótima para famílias!',
                'price' => 450000.00,
                'address' => 'Av. Leste, 456',
                'city' => 'Porto Alegre',
                'state' => 'RS',
                'zip_code' => '90010-000',
                'property_type' => 'Casa',
                'transaction_type' => 'Venda',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'suites' => 1,
                'area' => 120.0,
                'garage_spaces' => 2,
                'amenities' => json_encode(['Churrasqueira', 'Jardim']),
                'status' => 'available',
                'is_featured' => true,
                'main_image_url' => 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ]);

            Property::create([
                'user_id' => $pedroCorretor->id,
                'company_id' => $megaImoveis->id,
                'title' => 'Cobertura Duplex de Luxo',
                'description' => 'Vista panorâmica e design exclusivo nesta cobertura de alto padrão. Um verdadeiro sonho!',
                'price' => 1800000.00,
                'address' => 'Rua do Mar, 789',
                'city' => 'Florianópolis',
                'state' => 'SC',
                'zip_code' => '88000-000',
                'property_type' => 'Apartamento',
                'transaction_type' => 'Venda',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'suites' => 2,
                'area' => 280.0,
                'garage_spaces' => 3,
                'amenities' => json_encode(['Piscina Privativa', 'Espaço Gourmet', 'Sauna']),
                'status' => 'available',
                'is_featured' => false,
                'main_image_url' => 'https://images.unsplash.com/photo-1605146769289-440113cc3d00?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ]);
        }

        // Imóvel da Litoral Prime Imobiliária (cadastrado por Ana Corretora)
        if ($anaCorretora && $litoralPrime) {
            Property::create([
                'user_id' => $anaCorretora->id,
                'company_id' => $litoralPrime->id,
                'title' => 'Terreno Residencial em Condomínio',
                'description' => 'Excelente terreno para construir a casa dos seus sonhos em condomínio fechado com segurança 24h.',
                'price' => 600000.00,
                'address' => 'Alameda dos Ipês, 10',
                'city' => 'Campinas',
                'state' => 'SP',
                'zip_code' => '13000-000',
                'property_type' => 'Terreno',
                'transaction_type' => 'Venda',
                'bedrooms' => null,
                'bathrooms' => null,
                'suites' => null,
                'area' => 500.0,
                'garage_spaces' => null, // Não se aplica diretamente a terrenos, mas pode ser para projeto
                'amenities' => json_encode(['Portaria 24h', 'Área Verde']),
                'status' => 'available',
                'is_featured' => false,
                'main_image_url' => 'https://images.unsplash.com/photo-1600566752225-53769df8b5e5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ]);
        }
    }
}
