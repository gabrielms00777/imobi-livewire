<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'Mega Imóveis S.A.',
            'slug' => Str::slug('Mega Imóveis S.A.'),
            'slogan' => 'Seu sonho, nossa realidade.',
            'logo' => 'https://placehold.co/100x100/ff0000/white?text=MI',
            'address' => 'Rua do Imóvel, 123, Centro, São Paulo - SP',
            'phone' => '(11) 5555-1234',
            'email' => 'contato@megaimoveis.com.br',
            'website' => 'https://www.megaimoveis.com.br',
            'commission_rate' => 6.00,
            'description' => 'Líder de mercado em imóveis de alto padrão na capital paulista.'
        ]);

        Company::create([
            'name' => 'Litoral Prime Imobiliária',
            'slug' => Str::slug('Litoral Prime Imobiliária'),
            'slogan' => 'O paraíso te espera.',
            'logo' => 'https://placehold.co/100x100/0000ff/white?text=LP',
            'address' => 'Av. da Praia, 456, Gonzaga, Santos - SP',
            'phone' => '(13) 9988-7766',
            'email' => 'info@litoralprime.com.br',
            'website' => 'https://www.litoralprime.com.br',
            'commission_rate' => 5.50,
            'description' => 'Especialistas em casas e apartamentos de frente para o mar no litoral paulista.'
        ]);
    }
}
