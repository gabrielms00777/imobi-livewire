<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Mary\Traits\Toast;
use Livewire\WithFileUploads;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;

class SiteSettings extends Component
{
    use Toast, WithFileUploads;

    public string $tab = 'general';

    // General Settings
    public string $site_name = '';
    public string $site_description = '';
    public $site_logo;
    public $site_favicon;
    public string $primary_color = '#3b82f6';
    public string $secondary_color = '#10b981';

    // Contact Info
    public string $contact_phone = '';
    public string $contact_email = '';
    public string $contact_address = '';

    // Social Media
    public string $social_facebook = '';
    public string $social_instagram = '';
    public string $social_linkedin = '';
    public string $social_youtube = '';
    public string $social_whatsapp = '';

    // SEO
    public string $meta_title = '';
    public string $meta_description = '';
    public $meta_image;

    // Homepage Content
    public string $hero_title = '';
    public string $hero_subtitle = '';
    public $hero_image;
    public string $about_title = '';
    public string $about_content = '';
    public $about_image;

    // public ?string $siteMetaImage = null;

    protected $rules = [
        'site_name' => 'required|string|max:100',
        'site_description' => 'required|string|max:255',
        'site_logo' => 'nullable|image|max:2048',
        'site_favicon' => 'nullable|image|mimes:ico,png|max:512',
        'primary_color' => 'required|string',
        'secondary_color' => 'required|string',
        'contact_phone' => 'required|string|max:20',
        'contact_email' => 'required|email|max:100',
        'contact_address' => 'required|string|max:255',
        'social_facebook' => 'nullable|url',
        'social_instagram' => 'nullable|url',
        'social_linkedin' => 'nullable|url',
        'social_youtube' => 'nullable|url',
        'social_whatsapp' => 'nullable|string',
        'meta_title' => 'nullable|string|max:100',
        'meta_description' => 'nullable|string|max:255',
        'meta_image' => 'nullable|image|max:2048',
        'hero_title' => 'nullable|string|max:100',
        'hero_subtitle' => 'nullable|string|max:255',
        'hero_image' => 'nullable|image|max:2048',
        'about_title' => 'nullable|string|max:100',
        'about_content' => 'nullable|string',
        'about_image' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        $settings = SiteSetting::firstOrNew();

        // $this->siteMetaImage = SiteSetting::first()?->meta_image;

        // Preenche todos os campos com valores existentes
        foreach ($settings->toArray() as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value ?? '';
            }
        }
        // dd($settings);
    }

    public function save()
    {
        $this->validate();

        $settings = SiteSetting::firstOrNew();

        // Atualiza campos normais
        $fields = [
            'site_name',
            'site_description',
            'primary_color',
            'secondary_color',
            'contact_phone',
            'contact_email',
            'contact_address',
            'social_facebook',
            'social_instagram',
            'social_linkedin',
            'social_youtube',
            'social_whatsapp',
            'meta_title',
            'meta_description',
            'hero_title',
            'hero_subtitle',
            'about_title',
            'about_content'
        ];

        foreach ($fields as $field) {
            $settings->$field = $this->$field;
        }

        // Processa uploads de imagens
        $imageFields = [
            'site_logo' => 'public/settings',
            'site_favicon' => 'public/settings',
            'meta_image' => 'public/settings',
            'hero_image' => 'public/homepage',
            'about_image' => 'public/homepage'
        ];

        foreach ($imageFields as $field => $path) {
            if ($this->$field) {
                // Remove imagem antiga se existir
                if ($settings->$field) {
                    Storage::delete($settings->$field);
                }

                // Armazena a nova imagem
                $settings->$field = $this->$field->store($path);
            }
        }

        $settings->save();

        $this->success('Configurações salvas com sucesso!');
    }

    public function render()
    {
        return view('livewire.admin.site-settings');
    }
}
