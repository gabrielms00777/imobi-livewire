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
                'main_image_url' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGNhc2F8ZW58MHx8MHx8fDA%3D',
            ]);
            
            Property::create([
                'user_id' => $joaoCorretor->id,
                'company_id' => null,
                'title' => 'Casa Compacta em Bairro Tranquilo',
                'description' => 'Casa aconchegante com pequeno quintal, perfeita para quem busca paz e sossego sem abrir mão da cidade. Próximo a parques e escolas.',
                'price' => 280000.00,
                'address' => 'Rua das Flores, 50',
                'city' => 'Curitiba',
                'state' => 'PR',
                'zip_code' => '81000-000',
                'property_type' => 'Casa',
                'transaction_type' => 'Venda',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'suites' => 0,
                'area' => 80.0,
                'garage_spaces' => 1,
                'amenities' => json_encode(['Quintal', 'Permite animais']),
                'status' => 'available',
                'is_featured' => false,
                'main_image_url' => 'https://images.unsplash.com/photo-1580582932707-52c5df107204?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTd8fGNhc2F8ZW58MHx8MHx8fDA%3D',
                // 'highlights' => json_encode(['Recém reformada', 'Jardim de inverno', 'Ventilação natural']),
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
                'main_image_url' => 'https://images.unsplash.com/photo-1480074568708-e7b720bb3f09?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8Y2FzYXxlbnwwfHwwfHx8MA%3D%3D',
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
                'main_image_url' => 'https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8Y2FzYXxlbnwwfHwwfHx8MA%3D%3D',
            ]);
             Property::create([
                'user_id' => $pedroCorretor->id,
                'company_id' => $megaImoveis->id,
                'title' => 'Apartamento Pé na Areia',
                'description' => 'Apartamento espaçoso com vista direta para o mar. Localização privilegiada na praia central.',
                'price' => 980000.00,
                'address' => 'Av. Beira Mar, 100',
                'city' => 'Balneário Camboriú',
                'state' => 'SC',
                'zip_code' => '88330-000',
                'property_type' => 'Apartamento',
                'transaction_type' => 'Venda',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'suites' => 1,
                'area' => 110.0,
                'garage_spaces' => 2,
                'amenities' => json_encode(['Acesso à Praia', 'Piscina Condomínio', 'Academia']),
                'status' => 'available',
                'is_featured' => true,
                'main_image_url' => 'https://images.unsplash.com/photo-1549488310-85f269a84b06?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTR8fGJlYWNoJTIwYXBhcnRtZW50fGVufDB8fDB8fHww',
                // 'highlights' => json_encode(['Vista mar total', 'Ampla sacada gourmet', 'Mobiliado']),
            ]);

            // NOVO IMÓVEL 3 (Pedro Corretor - Sala Comercial)
            Property::create([
                'user_id' => $pedroCorretor->id,
                'company_id' => $megaImoveis->id,
                'title' => 'Sala Comercial no Centro Corporativo',
                'description' => 'Excelente sala comercial em prédio moderno, ideal para escritórios e consultórios. Próximo a transporte público e shoppings.',
                'price' => 380000.00,
                'address' => 'Av. Paulista, 1500, Sala 1005',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '01310-100',
                'property_type' => 'Comercial',
                'transaction_type' => 'Venda',
                'bedrooms' => null,
                'bathrooms' => 1,
                'suites' => null,
                'area' => 45.0,
                'garage_spaces' => 1,
                'amenities' => json_encode(['Recepção 24h', 'Sala de Reuniões', 'Estacionamento Visitantes']),
                'status' => 'available',
                'is_featured' => false,
                'main_image_url' => 'https://images.unsplash.com/photo-1554988456-e9703657b98c?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTl8fG9mZmljZSUyMHNwYWNlfGVufDB8fDB8fHww',
                // 'highlights' => json_encode(['Localização estratégica', 'Mobiliada', 'Ar condicionado central']),
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
                'main_image_url' => 'https://images.unsplash.com/photo-1572120360610-d971b9d7767c?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2FzYXxlbnwwfHwwfHx8MA%3D%3D',
            ]);
             Property::create([
                'user_id' => $anaCorretora->id,
                'company_id' => $litoralPrime->id,
                'title' => 'Sítio com Casa de Campo',
                'description' => 'Amplo sítio com casa principal, chalé de hóspedes e área de lazer completa. Ideal para fins de semana ou moradia permanente.',
                'price' => 2500000.00,
                'address' => 'Estrada dos Cafezais, KM 20',
                'city' => 'Atibaia',
                'state' => 'SP',
                'zip_code' => '12940-000',
                'property_type' => 'Sítio/Chácara',
                'transaction_type' => 'Venda',
                'bedrooms' => 5,
                'bathrooms' => 4,
                'suites' => 3,
                'area' => 15000.0, // 15.000 m²
                'garage_spaces' => 4,
                'amenities' => json_encode(['Piscina', 'Campo de Futebol', 'Pomar', 'Nascente', 'Casa de Hóspedes']),
                'status' => 'available',
                'is_featured' => true,
                'main_image_url' => 'https://images.unsplash.com/photo-1574362141512-be2080a9a103?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8ZmFybWhvdXNlfGVufDB8fDB8fHww',
                // 'highlights' => json_encode(['Área verde exuberante', 'Privacidade total', 'Estrutura completa de lazer']),
            ]);

            // NOVO IMÓVEL 5 (Ana Corretora - Galpão para Aluguel)
            Property::create([
                'user_id' => $anaCorretora->id,
                'company_id' => $litoralPrime->id,
                'title' => 'Galpão Industrial para Locação',
                'description' => 'Galpão novo com excelente localização em zona industrial, próximo a rodovias. Ideal para logística ou indústria leve.',
                'price' => 15000.00, // Preço de aluguel mensal
                'address' => 'Rua da Indústria, 700',
                'city' => 'Sorocaba',
                'state' => 'SP',
                'zip_code' => '18000-000',
                'property_type' => 'Comercial',
                'transaction_type' => 'Aluguel', // Tipo de transação alterado
                'bedrooms' => null,
                'bathrooms' => 2,
                'suites' => null,
                'area' => 1200.0,
                'garage_spaces' => 10, // Vagas para caminhões/veículos
                'amenities' => json_encode(['Pé Direito Alto', 'Piso Industrial', 'Escritório', 'Docas de Carga']),
                'status' => 'available',
                'is_featured' => false,
                'main_image_url' => 'https://images.unsplash.com/photo-1628178875569-8260b4594c92?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8d2FyZWhvdXNlfGVufDB8fDB8fHww',
                // 'highlights' => json_encode(['Localização logística', 'Estrutura nova', 'Amplo pátio para manobra']),
            ]);
        }
    }
}
