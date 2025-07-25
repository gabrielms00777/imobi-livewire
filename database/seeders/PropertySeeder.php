<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str; // Para gerar slugs
use Illuminate\Support\Facades\Storage; // Para manipulação de arquivos se for o caso

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

        // Limpa todas as mídias e propriedades existentes para evitar duplicatas e inconsistências
        // CUIDADO: Isso irá deletar todas as mídias associadas a propriedades!
        Property::all()->each(function ($property) {
            $property->clearMediaCollection('thumbnails');
            $property->clearMediaCollection('gallery');
            $property->delete();
        });


        // Imóvel do Corretor Autônomo
        if ($joaoCorretor) {
            // Imóvel 1
            $property1 = Property::create([
                'user_id' => $joaoCorretor->id,
                'company_id' => null, // Autônomo, sem vínculo direto com Imobiliária para este imóvel
                'title' => 'Apartamento Moderno no Centro',
                'slug' => Str::slug('Apartamento Moderno no Centro'), // Adicionado slug
                'description' => 'Apartamento compacto e moderno, ideal para solteiros ou casais jovens. Perto de tudo!',
                'price' => 320000.00,
                'rent_price' => null, // É venda
                'currency' => 'BRL', // Moeda
                'street' => 'Rua da Central', // Endereço granular
                'number' => '123',
                'complement' => null,
                'neighborhood' => 'Centro',
                'city' => 'Curitiba',
                'state' => 'PR',
                'zip_code' => '80010-000',
                'type' => 'apartamento', // Renomeado de property_type
                'purpose' => 'venda', // Renomeado de transaction_type
                'bedrooms' => 2,
                'bathrooms' => 1,
                'suites' => 0,
                'area' => 65.0,
                'garage_spaces' => 1,
                'amenities' => ['Academia', 'Salão de Festas'],
                'status' => 'available',
                'featured' => true, // Renomeado de is_featured
            ]);
            // Adicionando imagem via MediaLibrary
            $property1->addMediaFromUrl('https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGNhc2F8ZW58MHx8MHx8fDA%3D')
                      ->toMediaCollection('thumbnails');

            // Imóvel 2
            $property2 = Property::create([
                'user_id' => $joaoCorretor->id,
                'company_id' => null,
                'title' => 'Casa Compacta em Bairro Tranquilo',
                'slug' => Str::slug('Casa Compacta em Bairro Tranquilo'),
                'description' => 'Casa aconchegante com pequeno quintal, perfeita para quem busca paz e sossego sem abrir mão da cidade. Próximo a parques e escolas.',
                'price' => 280000.00,
                'rent_price' => null,
                'currency' => 'BRL',
                'street' => 'Rua das Flores',
                'number' => '50',
                'complement' => null,
                'neighborhood' => 'Boa Vista',
                'city' => 'Curitiba',
                'state' => 'PR',
                'zip_code' => '81000-000',
                'type' => 'casa',
                'purpose' => 'venda',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'suites' => 0,
                'area' => 80.0,
                'garage_spaces' => 1,
                'amenities' => ['Quintal', 'Permite animais'],
                'status' => 'available',
                'featured' => false,
            ]);
            $property2->addMediaFromUrl('https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGNhc2F8ZW58MHx8MHx8fDA%3D')
                      ->toMediaCollection('thumbnails');
        }

        // Imóveis da Mega Imóveis S.A. (cadastrados por Pedro Corretor)
        if ($pedroCorretor && $megaImoveis) {
            // Imóvel 3
            $property3 = Property::create([
                'user_id' => $pedroCorretor->id,
                'company_id' => $megaImoveis->id,
                'title' => 'Casa Térrea Espaçosa',
                'slug' => Str::slug('Casa Térrea Espaçosa'),
                'description' => 'Linda casa térrea com amplo quintal na Zona Leste. Ótima para famílias!',
                'price' => 450000.00,
                'rent_price' => null,
                'currency' => 'BRL',
                'street' => 'Av. Leste',
                'number' => '456',
                'complement' => null,
                'neighborhood' => 'Jardim Lindo',
                'city' => 'Porto Alegre',
                'state' => 'RS',
                'zip_code' => '90010-000',
                'type' => 'casa',
                'purpose' => 'venda',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'suites' => 1,
                'area' => 120.0,
                'garage_spaces' => 2,
                'amenities' => ['Churrasqueira', 'Jardim'],
                'status' => 'available',
                'featured' => true,
            ]);
            $property3->addMediaFromUrl('https://images.unsplash.com/photo-1480074568708-e7b720bb3f09?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8Y2FzYXxlbnwwfHwwfHx8MA%3D%3D')
                      ->toMediaCollection('thumbnails');

            // Imóvel 4
            $property4 = Property::create([
                'user_id' => $pedroCorretor->id,
                'company_id' => $megaImoveis->id,
                'title' => 'Cobertura Duplex de Luxo',
                'slug' => Str::slug('Cobertura Duplex de Luxo'),
                'description' => 'Vista panorâmica e design exclusivo nesta cobertura de alto padrão. Um verdadeiro sonho!',
                'price' => 1800000.00,
                'rent_price' => null,
                'currency' => 'BRL',
                'street' => 'Rua do Mar',
                'number' => '789',
                'complement' => null,
                'neighborhood' => 'Beira Mar',
                'city' => 'Florianópolis',
                'state' => 'SC',
                'zip_code' => '88000-000',
                'type' => 'apartamento',
                'purpose' => 'venda',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'suites' => 2,
                'area' => 280.0,
                'garage_spaces' => 3,
                'amenities' => ['Piscina Privativa', 'Espaço Gourmet', 'Sauna'],
                'status' => 'available',
                'featured' => false,
            ]);
            $property4->addMediaFromUrl('https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8Y2FzYXxlbnwwfHwwfHx8MA%3D%3D')
                      ->toMediaCollection('thumbnails');

            // Imóvel 5
            $property5 = Property::create([
                'user_id' => $pedroCorretor->id,
                'company_id' => $megaImoveis->id,
                'title' => 'Apartamento Pé na Areia',
                'slug' => Str::slug('Apartamento Pé na Areia'),
                'description' => 'Apartamento espaçoso com vista direta para o mar. Localização privilegiada na praia central.',
                'price' => 980000.00,
                'rent_price' => null,
                'currency' => 'BRL',
                'street' => 'Av. Beira Mar',
                'number' => '100',
                'complement' => null,
                'neighborhood' => 'Praia Central',
                'city' => 'Balneário Camboriú',
                'state' => 'SC',
                'zip_code' => '88330-000',
                'type' => 'apartamento',
                'purpose' => 'venda',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'suites' => 1,
                'area' => 110.0,
                'garage_spaces' => 2,
                'amenities' => ['Acesso à Praia', 'Piscina Condomínio', 'Academia'],
                'status' => 'available',
                'featured' => true,
            ]);
            $property5->addMediaFromUrl('https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGNhc2F8ZW58MHx8MHx8fDA%3D')
                      ->toMediaCollection('thumbnails');

            // Imóvel 6 (Sala Comercial)
            $property6 = Property::create([
                'user_id' => $pedroCorretor->id,
                'company_id' => $megaImoveis->id,
                'title' => 'Sala Comercial no Centro Corporativo',
                'slug' => Str::slug('Sala Comercial no Centro Corporativo'),
                'description' => 'Excelente sala comercial em prédio moderno, ideal para escritórios e consultórios. Próximo a transporte público e shoppings.',
                'price' => 380000.00,
                'rent_price' => null,
                'currency' => 'BRL',
                'street' => 'Av. Paulista',
                'number' => '1500',
                'complement' => 'Sala 1005',
                'neighborhood' => 'Consolação',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '01310-100',
                'type' => 'comercial',
                'purpose' => 'venda',
                'bedrooms' => null,
                'bathrooms' => 1,
                'suites' => null,
                'area' => 45.0,
                'garage_spaces' => 1,
                'amenities' => ['Recepção 24h', 'Sala de Reuniões', 'Estacionamento Visitantes'],
                'status' => 'available',
                'featured' => false,
            ]);
            $property6->addMediaFromUrl('https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGNhc2F8ZW58MHx8MHx8fDA%3D')
                      ->toMediaCollection('thumbnails');
        }

        // Imóvel da Litoral Prime Imobiliária (cadastrado por Ana Corretora)
        if ($anaCorretora && $litoralPrime) {
            // Imóvel 7
            $property7 = Property::create([
                'user_id' => $anaCorretora->id,
                'company_id' => $litoralPrime->id,
                'title' => 'Terreno Residencial em Condomínio',
                'slug' => Str::slug('Terreno Residencial em Condomínio'),
                'description' => 'Excelente terreno para construir a casa dos seus sonhos em condomínio fechado com segurança 24h.',
                'price' => 600000.00,
                'rent_price' => null,
                'currency' => 'BRL',
                'street' => 'Alameda dos Ipês',
                'number' => '10',
                'complement' => null,
                'neighborhood' => 'Condomínio Florido',
                'city' => 'Campinas',
                'state' => 'SP',
                'zip_code' => '13000-000',
                'type' => 'terreno',
                'purpose' => 'venda',
                'bedrooms' => null,
                'bathrooms' => null,
                'suites' => null,
                'area' => 500.0,
                'garage_spaces' => null,
                'amenities' => ['Portaria 24h', 'Área Verde'],
                'status' => 'available',
                'featured' => false,
            ]);
            $property7->addMediaFromUrl('https://images.unsplash.com/photo-1572120360610-d971b9d7767c?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2FzYXxlbnwwfHwwfHx8MA%3D%3D')
                      ->toMediaCollection('thumbnails');

            // Imóvel 8
            $property8 = Property::create([
                'user_id' => $anaCorretora->id,
                'company_id' => $litoralPrime->id,
                'title' => 'Sítio com Casa de Campo',
                'slug' => Str::slug('Sítio com Casa de Campo'),
                'description' => 'Amplo sítio com casa principal, chalé de hóspedes e área de lazer completa. Ideal para fins de semana ou moradia permanente.',
                'price' => 2500000.00,
                'rent_price' => null,
                'currency' => 'BRL',
                'street' => 'Estrada dos Cafezais',
                'number' => 'KM 20',
                'complement' => null,
                'neighborhood' => 'Zona Rural',
                'city' => 'Atibaia',
                'state' => 'SP',
                'zip_code' => '12940-000',
                'type' => 'sitio/chacara', // Tipo de imóvel mais específico
                'purpose' => 'venda',
                'bedrooms' => 5,
                'bathrooms' => 4,
                'suites' => 3,
                'area' => 15000.0, // 15.000 m²
                'garage_spaces' => 4,
                'amenities' => ['Piscina', 'Campo de Futebol', 'Pomar', 'Nascente', 'Casa de Hóspedes'],
                'status' => 'available',
                'featured' => true,
            ]);
            $property8->addMediaFromUrl('https://images.unsplash.com/photo-1572120360610-d971b9d7767c?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2FzYXxlbnwwfHwwfHx8MA%3D%3D')
                      ->toMediaCollection('thumbnails');

            // Imóvel 9 (Galpão para Aluguel)
            $property9 = Property::create([
                'user_id' => $anaCorretora->id,
                'company_id' => $litoralPrime->id,
                'title' => 'Galpão Industrial para Locação',
                'slug' => Str::slug('Galpão Industrial para Locação'),
                'description' => 'Galpão novo com excelente localização em zona industrial, próximo a rodovias. Ideal para logística ou indústria leve.',
                'price' => 15000.00, // Preço de venda (mantido, mas vamos usar rent_price)
                'rent_price' => 15000.00, // ESSENCIAL: Preço de aluguel mensal
                'currency' => 'BRL',
                'street' => 'Rua da Indústria',
                'number' => '700',
                'complement' => null,
                'neighborhood' => 'Zona Industrial',
                'city' => 'Sorocaba',
                'state' => 'SP',
                'zip_code' => '18000-000',
                'type' => 'comercial',
                'purpose' => 'aluguel', // Tipo de transação alterado
                'bedrooms' => null,
                'bathrooms' => 2,
                'suites' => null,
                'area' => 1200.0,
                'garage_spaces' => 10, // Vagas para caminhões/veículos
                'amenities' => ['Pé Direito Alto', 'Piso Industrial', 'Escritório', 'Docas de Carga'],
                'status' => 'available',
                'featured' => false,
            ]);
            $property9->addMediaFromUrl('https://images.unsplash.com/photo-1572120360610-d971b9d7767c?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2FzYXxlbnwwfHwwfHx8MA%3D%3D')
                      ->toMediaCollection('thumbnails');
        }
    }
}