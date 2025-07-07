<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin da plataforma
        User::create([
            'name' => 'Admin do Sistema',
            'email' => 'admin@plataforma.com',
            'password' => Hash::make('password'),
            'user_type' => 'admin',
            'company_id' => null,
            'creci_number' => null,
        ]);

        // Corretor autônomo
        User::create([
            'name' => 'João Corretor',
            'slug' => Str::slug('Joao Corretor'),
            'email' => 'joao@corretor.com',
            'password' => Hash::make('password'),
            'user_type' => 'real_estate_agent',
            'company_id' => null,
            'creci_number' => '12345-F',
        ]);

        // Usuários vinculados a Imobiliárias
        $megaImoveis = Company::where('name', 'Mega Imóveis S.A.')->first();
        if ($megaImoveis) {
            User::create([
                'name' => 'Maria Gerente (Mega)',
                'email' => 'maria@megaimoveis.com.br',
                'password' => Hash::make('password'),
                'user_type' => 'company_admin', // Administrador da Imobiliária
                'company_id' => $megaImoveis->id,
                'creci_number' => null, // Admins não precisam de CRECI
            ]);
            User::create([
                'name' => 'Pedro Corretor (Mega)',
                'email' => 'pedro@megaimoveis.com.br',
                'password' => Hash::make('password'),
                'user_type' => 'company_agent', // Corretor da Imobiliária
                'company_id' => $megaImoveis->id,
                'creci_number' => '54321-F',
            ]);
        }

        $litoralPrime = Company::where('name', 'Litoral Prime Imobiliária')->first();
        if ($litoralPrime) {
            User::create([
                'name' => 'Ana Corretora (Litoral)',
                'email' => 'ana@litoralprime.com.br',
                'password' => Hash::make('password'),
                'user_type' => 'company_agent',
                'company_id' => $litoralPrime->id,
                'creci_number' => '98765-F',
            ]);
        }
    }
}
