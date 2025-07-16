<?php

namespace App\Livewire\Forms;

use App\Models\TenantSetting;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
// use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads; // Importar o trait para lidar com uploads

class TenantSettingsForm extends Form
{
    use WithFileUploads; // Habilita o upload de arquivos no Form Object

    public ?TenantSetting $tenantSetting = null; // Inicialize como null

    // Propriedades do formulário, com validação Livewire V3
    #[Validate('required|string|max:255')]
    public string $site_name = '';

    #[Validate('nullable|string')]
    public ?string $site_description = null;

    #[Validate('nullable|image|max:2048')] // 2MB max
    public $site_logo; // Livewire\Features\SupportFileUploads\TemporaryUploadedFile instance

    public ?string $site_logo_url_existing = null; // Para manter a URL da logo existente

    #[Validate('nullable|image|max:1024')] // 1MB max for favicon
    public $site_favicon;

    public ?string $site_favicon_url_existing = null; // Para manter a URL do favicon existente

    #[Validate('required|regex:/^#[0-9a-fA-F]{6}$/')]
    public string $primary_color = '#3B82F6'; // Ajuste para o valor default do DB

    #[Validate('required|regex:/^#[0-9a-fA-F]{6}$/')]
    public string $secondary_color = '#F59E0B'; // Ajuste para o valor default do DB

    #[Validate('required|regex:/^#[0-9a-fA-F]{6}$/')]
    public string $text_color = '#0b0809'; // Ajuste para o valor default do DB

    // #[Validate(['required', Rule::in(['logo_only', 'name_only', 'logo_and_name'])])]
    #[Validate(['required', 'in:logo_only,name_only,logo_and_name'])]
    public string $header_display_type = 'logo_only'; // Ajuste para o valor default do DB

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

    #[Validate('nullable|string|max:20')] // Telefone, não URL
    public ?string $social_whatsapp = null;

    // SEO
    #[Validate('nullable|string|max:60')]
    public ?string $meta_title = null;

    #[Validate('nullable|string|max:160')]
    public ?string $meta_description = null;

    #[Validate('nullable|image|max:2048')]
    public $meta_image;

    public ?string $meta_image_url_existing = null;

    // Homepage - Hero
    // #[Validate(['required', Rule::in(['gradient', 'image'])])] // Changed to required based on default value
    #[Validate(['required', 'string'])] // Changed to required based on default value
    public string $hero_background_type = 'gradient';

    #[Validate('nullable|string|max:20')]
    public ?string $hero_gradient_direction = null;

    #[Validate('nullable|regex:/^#[0-9a-fA-F]{6}$/')] // Cor, então regex
    public ?string $hero_gradient_from_color = null;

    #[Validate('nullable|regex:/^#[0-9a-fA-F]{6}$/')] // Cor, então regex
    public ?string $hero_gradient_to_color = null;

    #[Validate('nullable|image|max:2048')]
    public $hero_image_url; // Campo de upload

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

    // #[Validate('nullable|array')] // Esta validação será feita manualmente no save
    public ?array $hero_avatars = null; // Será um array de URLs

    #[Validate('nullable|string')] // Valida a string de URLs
    public string $hero_avatars_string = ''; // Para o textarea (string de URLs separadas por vírgula)

    #[Validate('nullable|numeric|min:0|max:5')]
    public ?float $hero_stars_rating = null;

    #[Validate('nullable|string|max:255')]
    public ?string $hero_form_title = null;

    #[Validate('nullable|string')] // Valida a string JSON
    public string $hero_select_options_json = ''; // Para o textarea (JSON string)

    // #[Validate('nullable|array')] // Esta validação será feita manualmente no save
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

    public ?string $about_image_url_existing = null; // Para manter a URL da imagem existente


    // REMOVER: #[Validate('nullable|string')]
    public string $about_features_json = ''; // Para o textarea (JSON string)

    // NOVO: Propriedade para o array de características da seção "Sobre"
    // Não precisa de #[Validate] aqui, as validações serão nos campos individuais e ao salvar
    public array $about_features_list = []; // Inicializa como um array vazio

    // Homepage - Engagement Metrics
    #[Validate('nullable|string|max:255')]
    public ?string $engagement_title = null;

    #[Validate('nullable|string')]
    public ?string $engagement_description = null;

    // #[Validate('nullable|array')] // Esta validação será feita manualmente no save
    public ?array $engagement_metrics = null; // Será um array de objetos JSON

    // NOVO: Propriedade para o array de métricas da seção de Engajamento
    public array $engagement_metrics_list = []; // Inicializa como um array vazio

    #[Validate('nullable|string')] // Valida a string JSON
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
    public function setTenantSetting(TenantSetting $tenantSetting): void
    {
        $this->tenantSetting = $tenantSetting;
        // dd($this->tenantSetting);
        // dd(asset('about_image.jpg'));
        // dd($tenantSetting->getFillable());

        // Preenche as propriedades do formulário com os dados existentes
        // Percorre os fillables para preencher dinamicamente
        foreach ($tenantSetting->getFillable() as $field) {
            // Lidar com campos de upload de imagem para guardar a URL existente
            if (in_array($field, ['site_logo', 'site_favicon', 'meta_image', 'hero_image_url', 'about_image'])) {
                $existingUrlField = $field . '_url_existing';
                // A propriedade do Form Object deve ser preenchida com o valor do banco de dados
                $this->$existingUrlField = $tenantSetting->$field;
                // if($field === 'about_image') {
                //     dd($this->$existingUrlField);
                // }
                // dd($this->$existingUrlField);
                continue; // Pula o preenchimento da propriedade de upload temporário
            }

            // AQUI MUDAMOS O TRATAMENTO DE about_features
            if ($field === 'about_features') {
                // Se existir, preenche o about_features_list com os dados do banco
                $this->about_features_list = $tenantSetting->$field ?? [];
                continue;
            }

            // AQUI MUDAMOS O TRATAMENTO DE engagement_metrics
            if ($field === 'engagement_metrics') {
                $this->engagement_metrics_list = $tenantSetting->$field ?? [];
                continue;
            }

            // Lidar com campos JSON que serão editados como string no textarea
            if (in_array($field, ['hero_avatars', 'hero_select_options'])) {
                if ($tenantSetting->$field !== null) { // Garante que não é null
                    if ($field === 'hero_avatars') {
                        // Hero Avatars é um array simples de strings (URLs)
                        $this->hero_avatars_string = implode(', ', $tenantSetting->$field);
                    } else {
                        // Outros campos JSON são arrays de objetos e devem ser convertidos para JSON string formatada
                        $jsonStringField = $field . '_json';
                        $this->$jsonStringField = json_encode($tenantSetting->$field, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    }
                } else {
                    // Se o campo JSON for null no DB, garanta que a string seja vazia
                    if ($field === 'hero_avatars') {
                        $this->hero_avatars_string = '';
                    } else {
                        $jsonStringField = $field . '_json';
                        $this->$jsonStringField = '';
                    }
                }
                continue;
            }

            // Preencher outras propriedades diretamente se existirem no modelo e no formulário
            if (property_exists($this, $field)) {
                $this->$field = $tenantSetting->$field;
            }
            // Garante que pelo menos um item exista se o array estiver vazio, para ter um campo para o usuário preencher
        }
        if (empty($this->about_features_list)) {
            $this->addFeature();
        }

        if (empty($this->engagement_metrics_list)) {
            $this->addMetric();
        }
        // dd($tenantSetting, $this->engagement_metrics_list, $this->engagement_metrics_list);
    }

    public function addFeature(): void
    {
        $this->about_features_list[] = [
            'title' => '',
            'description' => '',
            'icon' => '' // Você pode querer um valor padrão para o ícone
        ];
    }

    public function addMetric(): void
    {
        $this->engagement_metrics_list[] = [
            'value' => '',
            'description' => '',
        ];
    }

    public function removeFeature(int $index): void
    {
        unset($this->about_features_list[$index]);
        $this->about_features_list = array_values($this->about_features_list); // Reindexa o array
        if (empty($this->about_features_list)) {
            $this->addFeature(); // Garante que sempre há pelo menos um item
        }
    }

    public function removeMetric(int $index): void
    {
        unset($this->engagement_metrics_list[$index]);
        $this->engagement_metrics_list = array_values($this->engagement_metrics_list); // Reindexa o array
        if (empty($this->engagement_metrics_list)) {
            $this->addMetric(); // Garante que sempre há pelo menos um item
        }
    }

    public function save(): void
    {
        // Validações para os campos individuais das características
        $rules = [
            'about_features_list.*.title' => 'nullable|string|max:100',
            'about_features_list.*.description' => 'nullable|string|max:255',
            'about_features_list.*.icon' => 'nullable|string|max:50', // Ex: 'fas fa-check-circle'

            'hero_avatars_string' => 'nullable|string',
            'hero_select_options_json' => 'nullable|json',
            'about_features_json' => 'nullable|json',
            'engagement_metrics_json' => 'nullable|json',

            'engagement_metrics_list.*.value' => 'nullable|string|max:50', // Ex: '1.200+', '98%'
            'engagement_metrics_list.*.description' => 'nullable|string|max:255',
        ];

        // Adiciona outras regras de validação que você já tem
        // Ex: $rules['site_name'] = 'required|string|max:255';
        // Para simplificar, vou assumir que você já tem as regras globais e aqui apenas complementamos.
        $this->validate($rules);

        $data = $this->all(); // Pega todos os dados do formulário

        // Processar uploads de arquivos e remover temporários
        // $this->handleFileUpload($data, 'site_logo');
        // $this->handleFileUpload($data, 'site_favicon');
        // $this->handleFileUpload($data, 'meta_image');
        // $this->handleFileUpload($data, 'hero_image_url');
        $this->handleFileUpload($data, 'about_image');

        // Converter strings de textarea JSON para arrays PHP
        $data['hero_select_options'] = $this->hero_select_options_json ? json_decode($this->hero_select_options_json, true) : null;
        // $data['about_features'] = $this->about_features_json ? json_decode($this->about_features_json, true) : null;
        // $data['engagement_metrics'] = $this->engagement_metrics_json ? json_decode($this->engagement_metrics_json, true) : null;

        // Converter string de avatares para array de URLs
        if (!empty($this->hero_avatars_string)) {
            $data['hero_avatars'] = array_map('trim', explode(',', $this->hero_avatars_string));
            $data['hero_avatars'] = array_filter($data['hero_avatars']); // Remove entradas vazias
        } else {
            $data['hero_avatars'] = null;
        }

        // dd($data['about_image_url_existing'], $data['about_image'], $data['about_image_url_existing']);
        $data['about_features'] = $this->about_features_list;
        $data['engagement_metrics'] = $this->engagement_metrics_list;

        // Remover propriedades auxiliares antes de salvar no DB
        unset(
            $data['site_logo_url_existing'],
            $data['site_favicon_url_existing'],
            $data['meta_image_url_existing'],
            $data['hero_image_url_existing'],
            $data['about_image_url_existing'],
            $data['hero_avatars_string'],
            $data['hero_select_options_json'],
            // $data['about_features_json'],
            // $data['engagement_metrics_json'],
            $data['about_features_list'],
            $data['engagement_metrics_list'],
            // Remover as propriedades de upload temporárias que não são para salvar no DB
            $data['site_logo'],
            $data['site_favicon'],
            $data['meta_image'],
            $data['hero_image_url'],
            // $data['about_image'],
        );


        // dd($data);

        $this->tenantSetting->update($data);
    }

    /**
     * Helper para lidar com upload de arquivos.
     * @param array $data O array de dados que será atualizado.
     * @param string $propertyName O nome da propriedade do upload (ex: 'site_logo').
     */
    private function handleFileUpload(array &$data, string $propertyName): void
    {
        // dd($data, $propertyName);
        $existingUrlProperty = $propertyName . '_url_existing'; // Propriedade para a URL existente
        // Verifica se um novo arquivo foi carregado
        if (isset($this->$propertyName) && is_object($this->$propertyName) && method_exists($this->$propertyName, 'store')) {
            // Exclui a imagem antiga se existir e for diferente do novo upload (para evitar excluir a própria imagem ao re-salvar sem mudança)
            if ($this->tenantSetting->{$propertyName} && $this->tenantSetting->{$propertyName} !== $this->$existingUrlProperty) {
                Storage::delete($this->tenantSetting->{$propertyName});
            }
            // Armazena o novo arquivo e atualiza o caminho no array de dados
            $data[$propertyName] = $this->$propertyName->storePublicly('tenant_settings');
            // $data[$propertyName] = Storage::put('tenant_settings', $this->$propertyName, 'public'); // Armazena publicamente
            // dd('1',$data[$propertyName]);
        } elseif (!empty($this->$existingUrlProperty)) {
            // Se nenhum novo arquivo foi carregado, mas há uma URL existente (significa que o usuário não mudou a imagem ou a manteve)
            $data[$propertyName] = $this->$existingUrlProperty;
        } else {
            dd('3', $this->tenantSetting->{$propertyName});
            // Se o campo de upload foi limpo (novo upload é null e não há url existente)
            // Ou se a imagem existente foi removida via botão de lixeira
            if ($this->tenantSetting->{$propertyName}) { // Se havia uma imagem no DB e foi explicitamente removida
                Storage::delete($this->tenantSetting->{$propertyName});
            }
            $data[$propertyName] = null;
        }

        // dd($data[$propertyName]);
    }
}
