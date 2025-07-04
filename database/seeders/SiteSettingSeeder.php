<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::firstOrCreate([], [
            // Geral
            'site_name' => 'Imobiliária Premium',
            'site_description' => 'Encontre o imóvel dos seus sonhos...',
            'primary_color' => '#3b82f6',
            'secondary_color' => '#10b981',

            // Contato
            'contact_phone' => '(11) 98765-4321',
            'contact_email' => 'contato@imobiliariapremium.com.br',
            'contact_address' => 'Av. Paulista, 1000, São Paulo - SP',

            // Redes Sociais
            'social_facebook' => 'https://facebook.com/imobiliariapremium',
            'social_instagram' => 'https://instagram.com/imobiliariapremium',
            'social_whatsapp' => '11987654321',

            // SEO
            'meta_title' => 'Imobiliária Premium | Seu lar dos sonhos',
            'meta_description' => 'Especialistas em imóveis residenciais e comerciais...',

            // Homepage
            'hero_title' => 'Encontre seu imóvel dos sonhos',
            'hero_subtitle' => 'Mais de 1.000 propriedades disponíveis...',
            'about_title' => 'Sobre Nossa Imobiliária',
            'about_content' => 'Somos uma imobiliária com mais de 20 anos...',
        ]);

        $this->command->info('✅ Configurações do site criadas com sucesso! (sem imagens)');
        // Limpa imagens antigas (opcional)
        // Storage::deleteDirectory('public/settings');
        // Storage::deleteDirectory('public/homepage');

        // Cria diretórios se não existirem
        // Storage::makeDirectory('public/settings');
        // Storage::makeDirectory('public/homepage');

        // Cria ou atualiza as configurações do site
        // SiteSetting::firstOrCreate([], [
        //     // Geral
        //     'site_name' => 'Imobiliária Premium',
        //     'site_description' => 'Encontre o imóvel dos seus sonhos com a melhor assessoria do mercado',
        //     'primary_color' => '#3b82f6', // Azul
        //     'secondary_color' => '#10b981', // Verde

        //     // Contato
        //     'contact_phone' => '(11) 98765-4321',
        //     'contact_email' => 'contato@imobiliariapremium.com.br',
        //     'contact_address' => 'Av. Paulista, 1000, Sala 101, São Paulo - SP',

        //     // Redes Sociais
        //     'social_facebook' => 'https://facebook.com/imobiliariapremium',
        //     'social_instagram' => 'https://instagram.com/imobiliariapremium',
        //     'social_linkedin' => 'https://linkedin.com/company/imobiliariapremium',
        //     'social_youtube' => 'https://youtube.com/imobiliariapremium',
        //     'social_whatsapp' => '11987654321',

        //     // SEO
        //     'meta_title' => 'Imobiliária Premium | Seu lar dos sonhos',
        //     'meta_description' => 'Especialistas em imóveis residenciais e comerciais. Mais de 20 anos transformando sonhos em realidade.',

        //     // Homepage
        //     'hero_title' => 'Encontre seu imóvel dos sonhos',
        //     'hero_subtitle' => 'Mais de 1.000 propriedades disponíveis com as melhores condições do mercado',
        //     'about_title' => 'Sobre Nossa Imobiliária',
        //     'about_content' => 'Somos uma imobiliária com mais de 20 anos de experiência no mercado, ajudando famílias a encontrar o lar perfeito. Nossa equipe de corretores altamente qualificados está pronta para oferecer o melhor atendimento e encontrar a solução ideal para suas necessidades imobiliárias.',
        // ]);

        // Copia imagens de exemplo (opcional - você precisará ter essas imagens na pasta /storage/seed)
        // $this->copySeedImages();

        // $this->command->info('✅ Configurações do site criadas com sucesso!');
    }
    protected function copySeedImages()
    {
        try {
            // Logo
            copy(
                storage_path('seed/logo.png'),
                storage_path('app/public/settings/logo.png')
            );

            // Favicon
            copy(
                storage_path('seed/favicon.png'),
                storage_path('app/public/settings/favicon.png')
            );

            // Meta Image
            copy(
                storage_path('seed/meta-image.jpg'),
                storage_path('app/public/settings/meta-image.jpg')
            );

            // Hero Image
            copy(
                storage_path('seed/hero-image.jpg'),
                storage_path('app/public/homepage/hero-image.jpg')
            );

            // About Image
            copy(
                storage_path('seed/about-image.jpg'),
                storage_path('app/public/homepage/about-image.jpg')
            );

            // Atualiza paths no banco
            SiteSetting::first()->update([
                'site_logo' => 'public/settings/logo.png',
                'site_favicon' => 'public/settings/favicon.png',
                'meta_image' => 'public/settings/meta-image.jpg',
                'hero_image' => 'public/homepage/hero-image.jpg',
                'about_image' => 'public/homepage/about-image.jpg'
            ]);
        } catch (\Exception $e) {
            $this->command->warn('⚠️  Não foi possível copiar imagens de exemplo: ' . $e->getMessage());
        }
    }
}
