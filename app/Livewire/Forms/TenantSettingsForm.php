<?php

namespace App\Livewire\Forms;

use App\Models\TenantSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class TenantSettingsForm extends Form
{
    // use WithFileUploads; // Habilita o upload de arquivos no Form Object

    // A instância do TenantSetting que estamos editando
    public ?TenantSetting $tenantSetting;

    // Propriedades do formulário, com validação Livewire V3
    #[Validate('required|string|max:255')]
    public string $site_name = '';

    #[Validate('nullable|string')]
    public ?string $site_description = null;

    #[Validate('nullable|image|max:2048')] // 2MB max
    public $site_logo; // Livewire\Features\SupportFileUploads\TemporaryUploadedFile instance

    #[Validate('nullable|string')]
    public ?string $site_logo_url_existing = null; // Para manter a URL da logo existente

    #[Validate('nullable|image|max:1024')] // 1MB max for favicon
    public $site_favicon;

    #[Validate('nullable|string')]
    public ?string $site_favicon_url_existing = null; // Para manter a URL do favicon existente

    #[Validate('required|regex:/^#[0-9a-fA-F]{6}$/')]
    public string $primary_color = '#422ad5';

    #[Validate('required|regex:/^#[0-9a-fA-F]{6}$/')]
    public string $secondary_color = '#f43098';

    #[Validate('required|regex:/^#[0-9a-fA-F]{6}$/')]
    public string $text_color = '#0b0809';

    // #[Validate(['required', Rule::in(['logo_only', 'name_only', 'logo_and_name'])])]
    public string $header_display_type = 'logo_only';

    // Contato
    #[Validate('nullable|string|max:20')]
    public ?string $contact_phone = null;

    #[Validate('nullable|email|max:255')]
    public ?string $contact_email = null;

    #[Validate('nullable|string|max:500')]
    public ?string $contact_address = null;

    // Redes Sociais
    #[Validate('nullable|url|max:255')]
    public ?string $social_facebook = null;

    #[Validate('nullable|url|max:255')]
    public ?string $social_instagram = null;

    #[Validate('nullable|url|max:255')]
    public ?string $social_linkedin = null;

    #[Validate('nullable|url|max:255')]
    public ?string $social_youtube = null;

    #[Validate('nullable|string|max:20')]
    public ?string $social_whatsapp = null;

    // SEO
    #[Validate('nullable|string|max:60')]
    public ?string $meta_title = null;

    #[Validate('nullable|string|max:160')]
    public ?string $meta_description = null;

    #[Validate('nullable|image|max:2048')]
    public $meta_image;

    #[Validate('nullable|string')]
    public ?string $meta_image_url_existing = null;

    // Homepage - Hero
    #[Validate('nullable|string|max:255')]
    public ?string $hero_background_type = 'gradient'; // 'gradient' or 'image'

    #[Validate('nullable|string|max:20')]
    public ?string $hero_gradient_direction = null;

    #[Validate('nullable|string|max:20')]
    public ?string $hero_gradient_from_color = null;

    #[Validate('nullable|string|max:20')]
    public ?string $hero_gradient_to_color = null;

    #[Validate('nullable|image|max:2048')]
    public $hero_image_url; // Campo de upload

    #[Validate('nullable|string')]
    public ?string $hero_image_url_existing = null; // Para manter a URL da imagem existente

    #[Validate('nullable|string|max:255')]
    public ?string $hero_image_alt_text = null;

    #[Validate('nullable|string|max:255')]
    public ?string $hero_image_class = null;

    #[Validate('boolean')]
    public bool $hero_show_text_content = true;

    #[Validate('nullable|string|max:255')]
    public ?string $hero_title = null;

    #[Validate('nullable|string')]
    public ?string $hero_description = null;

    #[Validate('nullable|string|max:255')]
    public ?string $hero_clients_satisfied_text = null;

    #[Validate('nullable|array')]
    public ?array $hero_avatars = null; // Será um array de URLs

    public string $hero_avatars_string = ''; // Para o textarea (string de URLs separadas por vírgula)

    #[Validate('nullable|numeric|min:0|max:5')]
    public ?float $hero_stars_rating = null;

    #[Validate('nullable|string|max:255')]
    public ?string $hero_form_title = null;

    public string $hero_select_options_json = ''; // Para o textarea (JSON string)

    #[Validate('nullable|array')]
    public ?array $hero_select_options = null; // Será um array de objetos JSON

    #[Validate('nullable|string|max:50')]
    public ?string $hero_search_button_text = null;

    #[Validate('nullable|string|max:50')]
    public ?string $hero_search_button_icon = null;

    // Homepage - About
    #[Validate('nullable|string|max:255')]
    public ?string $about_title = null;

    #[Validate('nullable|string')]
    public ?string $about_content = null;

    #[Validate('nullable|image|max:2048')]
    public $about_image; // Campo de upload

    #[Validate('nullable|string')]
    public ?string $about_image_url_existing = null; // Para manter a URL da imagem existente

    #[Validate('nullable|array')]
    public ?array $about_features = null; // Será um array de objetos JSON

    public string $about_features_json = ''; // Para o textarea (JSON string)

    // Homepage - Engagement Metrics
    #[Validate('nullable|string|max:255')]
    public ?string $engagement_title = null;

    #[Validate('nullable|string')]
    public ?string $engagement_description = null;

    #[Validate('nullable|array')]
    public ?array $engagement_metrics = null; // Será um array de objetos JSON

    public string $engagement_metrics_json = ''; // Para o textarea (JSON string)

    #[Validate('nullable|string|max:50')]
    public ?string $engagement_btn_properties_text = null;

    #[Validate('nullable|string|max:50')]
    public ?string $engagement_btn_properties_icon = null;

    #[Validate('nullable|string|max:255')]
    public ?string $engagement_btn_properties_link = null;

    #[Validate('nullable|string|max:50')]
    public ?string $engagement_btn_contact_text = null;

    #[Validate('nullable|string|max:50')]
    public ?string $engagement_btn_contact_icon = null;

    #[Validate('nullable|string|max:255')]
    public ?string $engagement_btn_contact_link = null;


    /**
     * Define a instância de TenantSetting para edição.
     * @param TenantSetting $tenantSetting
     */
    /**
     * Define a instância de TenantSetting para edição.
     * @param TenantSetting $tenantSetting
     */
    public function setTenantSetting(TenantSetting $tenantSetting): void
    {
        $this->tenantSetting = $tenantSetting;

        foreach ($tenantSetting->getFillable() as $field) {
            // Lidar com campos de upload de imagem para guardar a URL existente
            if (in_array($field, ['site_logo', 'site_favicon', 'meta_image', 'hero_image_url', 'about_image'])) {
                $existingUrlField = $field . '_url_existing';
                $this->$existingUrlField = $tenantSetting->$field;
                continue;
            }

            // Lidar com campos JSON que serão editados como string no textarea
            if (in_array($field, ['hero_avatars', 'hero_select_options', 'about_features', 'engagement_metrics'])) {
                if ($tenantSetting->$field) {
                    if ($field === 'hero_avatars') {
                        $this->hero_avatars_string = implode(', ', json_decode($tenantSetting->$field, true));
                    } else {
                        $jsonStringField = $field . '_json';
                        $this->$jsonStringField = json_encode($tenantSetting->$field, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    }
                }
                continue;
            }

            // Preencher outras propriedades diretamente
            if (property_exists($this, $field)) {
                $this->$field = $tenantSetting->$field;
            }
        }
    }
    // public function setTenantSetting(TenantSetting $tenantSetting): void
    // {
    //     $this->tenantSetting = $tenantSetting;

    //     // Preenche as propriedades do formulário com os dados existentes
    //     // Percorre os fillables para preencher dinamicamente
    //     foreach ($tenantSetting->getFillable() as $field) {
    //         // Verifica se o campo é um upload e tem um valor URL para armazenar
    //         if (in_array($field, ['site_logo', 'site_favicon', 'meta_image', 'hero_image_url', 'about_image'])) {
    //             $existingUrlField = $field . '_existing'; // Ex: site_logo_url_existing
    //             $this->$existingUrlField = $tenantSetting->$field;
    //             continue; // Pula o preenchimento da propriedade de upload
    //         }

    //         // Para campos JSON, eles já vêm como arrays devido ao $casts na Model
    //         // Outros campos são preenchidos diretamente
    //         if (property_exists($this, $field)) {
    //             $this->$field = $tenantSetting->$field;
    //         }
    //     }
    // }

    /**
     * Valida e salva/atualiza as configurações do Tenant.
     */
    public function save(): void
    {
        $this->validate(); // Valida todas as propriedades marcadas com #[Validate]

        $data = $this->all(); // Pega todos os dados do formulário

        // Processar uploads de arquivos e remover temporários
        $this->handleFileUpload($data, 'site_logo');
        $this->handleFileUpload($data, 'site_favicon');
        $this->handleFileUpload($data, 'meta_image');
        $this->handleFileUpload($data, 'hero_image_url');
        $this->handleFileUpload($data, 'about_image');

        // Converter strings de textarea JSON para arrays
        $data['hero_select_options'] = json_decode($this->hero_select_options_json, true);
        $data['about_features'] = json_decode($this->about_features_json, true);
        $data['engagement_metrics'] = json_decode($this->engagement_metrics_json, true);

        // Converter string de avatares para array
        $data['hero_avatars'] = array_map('trim', explode(',', $this->hero_avatars_string));
        $data['hero_avatars'] = array_filter($data['hero_avatars']); // Remove entradas vazias

        // Remover propriedades auxiliares antes de salvar no DB
        unset(
            $data['site_logo_url_existing'],
            $data['site_favicon_url_existing'],
            $data['meta_image_url_existing'],
            $data['hero_image_url_existing'],
            $data['about_image_url_existing'],
            $data['hero_avatars_string'],
            $data['hero_select_options_json'],
            $data['about_features_json'],
            $data['engagement_metrics_json'],
        );

        // Remover as propriedades de upload temporárias que não são para salvar no DB
        unset(
            $data['site_logo'],
            $data['site_favicon'],
            $data['meta_image'],
            $data['hero_image_url'],
            $data['about_image'],
        );
        
        $this->tenantSetting->update($data);
    }

    // public function save(): void
    // {
    //     $data = $this->validate();

    //     // Processar uploads de arquivos
    //     $this->handleFileUpload($data, 'site_logo');
    //     $this->handleFileUpload($data, 'site_favicon');
    //     $this->handleFileUpload($data, 'meta_image');
    //     $this->handleFileUpload($data, 'hero_image_url');
    //     $this->handleFileUpload($data, 'about_image');

    //     // Remove as propriedades '_existing' antes de salvar no banco
    //     unset(
    //         $data['site_logo_url_existing'],
    //         $data['site_favicon_url_existing'],
    //         $data['meta_image_url_existing'],
    //         $data['hero_image_url_existing'],
    //         $data['about_image_url_existing'],
    //     );

    //     if ($this->tenantSetting->exists) {
    //         $this->tenantSetting->update($data);
    //     } else {
    //         // Isso não deve acontecer se setTenantSetting for sempre chamado com uma instância existente
    //         // Mas, como fallback, você pode criar um novo TenantSetting aqui, se necessário.
    //         // Para este caso de uso, assumimos que o TenantSetting já existe para o tenant logado.
    //     }
    // }

    /**
     * Helper para lidar com upload de arquivos.
     */
    private function handleFileUpload(array &$data, string $propertyName): void
    {
        if (isset($this->$propertyName) && is_object($this->$propertyName) && method_exists($this->$propertyName, 'store')) {
            // Exclui a imagem antiga se existir
            if ($this->{$propertyName . '_url_existing'}) {
                Storage::delete($this->{$propertyName . '_url_existing'});
            }
            // Armazena o novo arquivo
            $data[$propertyName] = $this->$propertyName->store('public/tenant_settings');
        } elseif (!empty($this->{$propertyName . '_url_existing'})) {
            // Mantém a URL da imagem existente se não houver novo upload
            $data[$propertyName] = $this->{$propertyName . '_url_existing'};
        } else {
            // Se o campo de upload foi limpo e não havia URL existente, define como null
            if (isset($this->$propertyName) && is_null($this->$propertyName) && empty($this->{$propertyName . '_url_existing'})) {
                if ($this->tenantSetting->{$propertyName}) { // Se havia uma imagem no DB e foi removida
                    Storage::delete($this->tenantSetting->{$propertyName});
                }
                $data[$propertyName] = null;
            } else {
                // Caso em que não houve alteração no campo de imagem
                $data[$propertyName] = $this->tenantSetting->{$propertyName};
            }
        }
    }
    // private function handleFileUpload(array &$data, string $propertyName): void
    // {
    //     if (isset($this->$propertyName) && is_object($this->$propertyName) && method_exists($this->$propertyName, 'store')) {
    //         // Se um novo arquivo foi enviado, armazene-o
    //         $data[$propertyName] = $this->$propertyName->store('public/tenant_settings');
    //     } elseif (!empty($this->{$propertyName . '_url_existing'})) {
    //         // Se não foi enviado um novo arquivo, mas existe um existente, mantenha a URL existente
    //         $data[$propertyName] = $this->{$propertyName . '_url_existing'};
    //     } else {
    //         // Se nenhum arquivo foi enviado e não há existente, defina como null
    //         $data[$propertyName] = null;
    //     }
    // }
}
