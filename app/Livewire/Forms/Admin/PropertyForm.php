<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class PropertyForm extends Form
{
    use WithFileUploads; // Habilita o upload de arquivos no Form Object

    public ?Property $property = null; // Instância do Property para edição

    // SEO
    #[Validate('nullable|string|max:255')]
    public ?string $meta_title = null; // NOVO: Meta Título para SEO

    #[Validate('nullable|string')]
    public ?string $meta_description = null; // NOVO: Meta Descrição para SEO


    // Para lidar com imagens existentes (edição)
    public array $existingGalleryImages = []; // Array de URLs/IDs de imagens já salvas
    public ?string $existingThumbnailUrl = null; // URL da miniatura existente


    public string $slug = ''; // Slug gerado automaticamente
    public string $title = '';
    public string $description = '';
    public string $type = 'casa'; // Valor padrão
    public string $purpose = 'venda'; // Valor padrão
    public string $status = 'disponivel'; // Valor padrão
    public ?float $price = null;
    public ?float $rent_price = null;
    public ?int $bedrooms = null;
    public ?int $bathrooms = null;
    public ?int $suites = null; // Adicionado
    public ?int $garage_spaces = null;
    public ?float $area = null; // Alterado para float como no schema
    // public ?float $total_area = null;
    // public ?float $construction_area = null;
    // public ?int $floors = null;
    // public ?int $year_built = null;
    public string $street = '';
    public string $number = '';
    public ?string $complement = null;
    public string $neighborhood = '';
    public string $city = '';
    public string $state = '';
    public string $zip_code = '';
    // public ?float $latitude = null;
    // public ?float $longitude = null;
    public bool $featured = false; // Valor padrão
    // public ?string $video_url = null;
    // public ?string $virtual_tour_url = null;
    public ?array $amenities = []; // Valor padrão como array vazio
    public $thumbnail; // Para upload de arquivo Livewire
    public ?array $galleryImages = []; // Array de arquivos para galeria


    // Propriedade para controlar a visibilidade do modal
    public bool $showMediaModal = false;

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            // Opções de tipo de imóvel atualizadas para incluir 'sitio/chacara' e 'galpao'
            'type' => 'required|string|in:casa,apartamento,terreno,comercial,sitio/chacara,galpao,outro',
            'purpose' => 'required|string|in:venda,aluguel,ambos',
            'status' => 'required|string|in:disponivel,vendido,alugado,rascunho',

            // // Validação condicional de preço e preço de aluguel
            'price' => [
                // 'price' é requerido se 'purpose' for 'venda' ou 'ambos'
                Rule::requiredIf(fn() => in_array($this->purpose, ['venda', 'ambos'])),
                'nullable', // Permite nulo se não for requerido pela condição acima
                'numeric',
                'min:0',
            ],
            'rent_price' => [
                // 'rent_price' é requerido se 'purpose' for 'aluguel' ou 'ambos'
                Rule::requiredIf(fn() => in_array($this->purpose, ['aluguel', 'ambos'])),
                'nullable', // Permite nulo se não for requerido pela condição acima
                'numeric',
                'min:0',
            ],

            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'suites' => 'nullable|integer|min:0', // Validação para suites
            'garage_spaces' => 'nullable|integer|min:0',
            'area' => 'nullable|numeric|min:0', // Alterado para numeric

            // 'total_area' => 'nullable|numeric|min:0',
            // 'construction_area' => 'nullable|numeric|min:0',
            // 'floors' => 'nullable|integer|min:0',
            // 'year_built' => 'nullable|integer|min:1800|max:' . (date('Y') + 5), // Validação dinâmica OK

            'street' => 'required|string|max:255',
            'number' => 'required|string|max:50',
            'complement' => 'nullable|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|size:2',
            'zip_code' => 'required|string|regex:/^\d{5}-\d{3}$/', // Formato esperado: 99999-999

            // 'latitude' => 'nullable|numeric|between:-90,90',
            // 'longitude' => 'nullable|numeric|between:-180,180',
            'featured' => 'boolean',
            // 'video_url' => 'nullable|url|max:255',
            // 'virtual_tour_url' => 'nullable|url|max:255',
            'amenities' => 'nullable|array',
            // 'thumbnail' => 'nullable|image|max:2048', // 2MB
            'thumbnail' => 'nullable|image', // 2MB
            'galleryImages' => 'nullable|array',
            // 'galleryImages.*' => 'nullable|image|max:2048', // 2MB para cada imagem da galeria
            'galleryImages.*' => 'nullable|image', // 2MB para cada imagem da galeria
        ];
    }


    public function setProperty(?Property $property = null): void
    {
        $this->property = $property;

        $this->fill([
            'title' => $property->title,
            'description' => $property->description,
            'type' => $property->type,
            'purpose' => $property->purpose,
            'status' => $property->status,
            'price' => $property->price,
            'rent_price' => $property->rent_price,
            'bedrooms' => $property->bedrooms,
            'bathrooms' => $property->bathrooms,
            'suites' => $property->suites,
            'garage_spaces' => $property->garage_spaces,
            'area' => $property->area,
            // 'total_area' => $property->total_area,
            // 'construction_area' => $property->construction_area,
            // 'floors' => $property->floors,
            // 'year_built' => $property->year_built,
            'street' => $property->street,
            'number' => $property->number,
            'complement' => $property->complement,
            'neighborhood' => $property->neighborhood,
            'city' => $property->city,
            'state' => $property->state,
            'zip_code' => $property->zip_code,
            // 'latitude' => $property->latitude,
            // 'longitude' => $property->longitude,
            'featured' => $property->featured,
            // 'video_url' => $property->video_url,
            // 'virtual_tour_url' => $property->virtual_tour_url,
            'amenities' => $property->amenities, // Assume que 'amenities' está com cast 'array' no modelo Property
        ]);

        // if ($property) {
        //     $this->fill([
        //         'title' => $property->title,
        //         'slug' => $property->slug,
        //         'description' => $property->description,
        //         'type' => $property->property_type, // Mapeia coluna DB para propriedade do form
        //         'purpose' => $property->transaction_type, // Mapeia coluna DB para propriedade do form
        //         'status' => $property->status,
        //         'price' => $property->price,
        //         'rent_price' => $property->rent_price,
        //         'currency' => $property->currency ?? 'BRL',
        //         'bedrooms' => $property->bedrooms,
        //         'bathrooms' => $property->bathrooms,
        //         'suites' => $property->suites,
        //         'garage_spaces' => $property->garage_spaces,
        //         'area' => $property->area,
        //         'total_area' => $property->total_area,
        //         'construction_area' => $property->construction_area,
        //         'floors' => $property->floors,
        //         'year_built' => $property->year_built,
        //         'street' => $property->street,
        //         'number' => $property->number,
        //         'complement' => $property->complement,
        //         'neighborhood' => $property->neighborhood,
        //         'city' => $property->city,
        //         'state' => $property->state,
        //         'zip_code' => $property->zip_code,
        //         'latitude' => $property->latitude,
        //         'longitude' => $property->longitude,
        //         'featured' => $property->is_featured, // Mapeia coluna DB para propriedade do form
        //         'video_url' => $property->video_url,
        //         'virtual_tour_url' => $property->virtual_tour_url,
        //         'amenities' => json_decode($property->amenities ?? '[]', true), // Decodifica JSON para array
        //         'meta_title' => $property->meta_title,
        //         'meta_description' => $property->meta_description,
        //     ]);

        //     // Popula URLs de mídia existentes para exibição na view
        //     $this->existingThumbnailUrl = $property->getFirstMediaUrl('thumbnails');
        //     $this->existingGalleryImages = $property->getMedia('gallery')->map(fn($media) => [
        //         'id' => $media->id,
        //         'url' => $media->getUrl(),
        //     ])->toArray();
        // }
    }

    public function save(): Property
    {
        $this->validate(); // Chama o método rules() para validar os dados
        
        // dd($this->all());
        // Lógica para definir company_id
        $companyId = Auth::user()->company_id ?? null;
        // Se o usuário logado for uma empresa (e não um corretor vinculado), usa o ID dele como company_id
        // Adapte esta lógica conforme a sua estrutura de permissões/roles
        // Exemplo: if (Auth::user()->hasRole('company')) { $companyId = Auth::id(); }

        $property = Property::updateOrCreate(
            ['id' => $this->property->id ?? null], // Tenta encontrar pelo ID se estiver editando, senão cria um novo
            [
                'user_id' => Auth::id(), // ID do usuário (corretor) que está cadastrando
                'company_id' => $companyId, // ID da imobiliária proprietária
                'title' => $this->title,
                'slug' => Str::slug($this->title), // Geração do slug
                'description' => $this->description,
                'price' => $this->price,
                // Define rent_price apenas se a finalidade incluir aluguel
                'rent_price' => in_array($this->purpose, ['aluguel', 'ambos']) ? $this->rent_price : null,
                'currency' => 'BRL', // Moeda padrão
                'street' => $this->street,
                'number' => $this->number,
                'complement' => $this->complement,
                'neighborhood' => $this->neighborhood,
                'city' => $this->city,
                'state' => $this->state,
                'zip_code' => $this->zip_code,
                'type' => $this->type,
                'purpose' => $this->purpose,
                'bedrooms' => $this->bedrooms,
                'bathrooms' => $this->bathrooms,
                'suites' => $this->suites,
                'area' => $this->area,
                // 'total_area' => $this->total_area,
                // 'construction_area' => $this->construction_area,
                // 'floors' => $this->floors,
                // 'year_built' => $this->year_built,
                'garage_spaces' => $this->garage_spaces,
                'amenities' => (array) $this->amenities, // Assumindo que o cast para array está no modelo Property
                'status' => $this->status,
                'featured' => $this->featured,
                // 'latitude' => $this->latitude,
                // 'longitude' => $this->longitude,
                // 'video_url' => $this->video_url,
                // 'virtual_tour_url' => $this->virtual_tour_url,
            ]
        );

        // --- Lógica de Manipulação de Imagens com MediaLibrary ---

        // 1. Thumbnail (Imagem Principal)
        if ($this->thumbnail) {
            // Se um novo thumbnail foi enviado, limpa o antigo e adiciona o novo
            if ($property->hasMedia('thumbnails')) {
                $property->clearMediaCollection('thumbnails');
            }
            $property->addMedia($this->thumbnail)
                ->toMediaCollection('thumbnails');
        } else { // Caso de edição: se não há novo thumbnail, mas havia um existente e foi 'removido'
            // (você precisaria de um input hidden ou checkbox na view para sinalizar remoção explícita)
            // Por enquanto, esta lógica assume que se $this->thumbnail é null em uma atualização,
            // e já havia thumbnail, ele deve ser removido.
            if ($this->property && $property->hasMedia('thumbnails')) {
                // Se estamos editando e o campo de upload de thumbnail está vazio,
                // e já existia um thumbnail, isso pode indicar que o usuário o removeu.
                // Ajuste esta lógica se você tiver um botão explícito de remoção na UI.
                $property->clearMediaCollection('thumbnails');
            }
        }


        // 2. Galeria de Imagens
        // Para a galeria, a lógica de atualização pode ser mais complexa (identificar imagens removidas).
        // Por simplicidade neste MVP, novas imagens são apenas adicionadas à coleção existente.
        // Se você precisar de funcionalidade de remoção de imagens individuais da galeria na UI,
        // o componente Livewire precisará de métodos para lidar com isso (ex: `removeGalleryImage($mediaId)`).
        foreach ($this->galleryImages as $image) {
            $property->addMedia($image)
                ->toMediaCollection('gallery');
        }

        return $property;
    }

    // public function save(): Property
    // {
    //     $this->validate(); // Roda as validações definidas nas propriedades

    //     // Gera ou atualiza o slug se o título mudou ou não existe
    //     if (empty($this->slug) || ($this->property && $this->property->title !== $this->title)) {
    //         $this->slug = Str::slug($this->title);
    //     }

    //     $data = $this->all(); // Pega todos os dados do formulário

    //     // Converte o array de comodidades para JSON string para salvar no banco
    //     $data['amenities'] = json_encode($this->amenities);

    //     // Mapeia nomes de campos do formulário para nomes de colunas do banco, se diferentes
    //     $data['property_type'] = $this->type;
    //     $data['transaction_type'] = $this->purpose;
    //     $data['is_featured'] = $this->featured;

    //     // Remove campos do formulário que não são colunas do DB ou são tratados separadamente
    //     unset($data['type'], $data['purpose'], $data['featured']); // Mapeados
    //     unset($data['thumbnail'], $data['galleryImages']); // Gerenciados pelo MediaLibrary
    //     unset($data['existingThumbnailUrl'], $data['existingGalleryImages']); // Apenas para exibição na view
    //     unset($data['property']); // A própria instância do modelo

    //     // Define rent_price como null se a finalidade não for aluguel/ambos
    //     if (!in_array($this->purpose, ['aluguel', 'ambos'])) {
    //         $data['rent_price'] = null;
    //     }

    //     // Cria ou Atualiza a Propriedade
    //     if ($this->property) {
    //         $this->property->update($data);
    //         $property = $this->property;
    //     } else {
    //         // Atribui user_id e company_id para novas propriedades
    //         $data['user_id'] = Auth::id();
    //         $data['company_id'] = Auth::user()->company_id ?? null; // Ajuste conforme a sua lógica de empresa
    //         $property = Property::create($data);
    //     }

    //     // Lidar com uploads via Media Library (miniaturas e imagens da galeria)
    //     if ($this->thumbnail) {
    //         // Remove a miniatura antiga se existir antes de adicionar a nova
    //         if ($property->getFirstMedia('thumbnails')) {
    //             $property->getFirstMedia('thumbnails')->delete();
    //         }
    //         $property->addMedia($this->thumbnail)
    //             ->toMediaCollection('thumbnails');
    //     }

    //     // Adiciona novas imagens à galeria
    //     foreach ($this->galleryImages as $newImage) {
    //         $property->addMedia($newImage)
    //             ->toMediaCollection('gallery');
    //     }

    //     // Lógica para remover imagens existentes da galeria deve ser tratada no componente Livewire principal (Create/Edit),
    //     // pois envolve interações com a UI para exclusão de itens específicos.

    //     return $property;
    // }
}
