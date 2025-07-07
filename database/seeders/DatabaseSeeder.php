<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            // SiteSettingSeeder::class, // REMOVA ou COMENTE esta linha se ela era para as configurações globais
            CompanySeeder::class,
            UserSeeder::class,
            TenantSettingSeeder::class, // AGORA ESSA É PARA AS CONFIGURAÇÕES DOS TENANTS
            PropertySeeder::class,
        ]);
    }
}
