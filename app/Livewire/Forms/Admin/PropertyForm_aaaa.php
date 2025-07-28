<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Importe Log
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Collection; // Importe Collection

class PropertyForm extends Form
{
    // Não use WithFileUploads aqui. Ele deve estar no COMPONENTE que usa este form.

    public ?Property $property = null; // Instância do Property para edição

    // SEO
    #[Validate('nullable|string|max:255')]
    public ?string $meta_title = null;

    #[Validate('nullable|string')]
    public ?string $meta_description = null;

    // Para lidar com novas imagens temporárias (vindos do modal/input de arquivo)
    // Estas propriedades armazenarão instâncias de Livewire\Features\SupportFileUploads\TemporaryUploadedFile
    // A validação 'on: newGalleryImages.*' deve ser aplicada no componente ou na validação manual antes de chamar save().
    #[Validate('nullable|image|max:2048')]
    public $newThumbnail = null; // Uma única imagem temporária para o thumbnail

    #[Validate('nullable|array|max:20')]
    // #[Validate('nullable|image|max:2048', on: 'newGalleryImages.*')] // Validação para cada item do array (pode ser movida para o componente)
    public $newGalleryImages = []; // Múltiplas imagens temporárias para a galeria

    // Propriedades para gerenciar o estado da imagem principal ao adicionar novas no modal
    public bool $isNewImagePrincipal = false;
    public ?int $principalImageIndex = null; // Índice da imagem principal se for uma das newGalleryImages

    // Coleções para armazenar as mídias existentes do imóvel (carregadas do modelo Property)
    public Collection $existingThumbnails;
    public $existingGalleryImages;

    // Demais campos do formulário
    public string $slug = '';
    public string $title = '';
    public string $description = '';
    public string $type = 'casa';
    public string $purpose = 'venda';
    public string $status = 'disponivel';
    public ?float $price = null;
    public ?float $rent_price = null;
    public ?int $bedrooms = null;
    public ?int $bathrooms = null;
    public ?int $suites = null;
    public ?int $garage_spaces = null;
    public ?int $area = null;
    public ?int $total_area = null;
    public ?int $construction_area = null;
    public ?int $floors = null;
    public ?int $year_built = null;
    public string $street = '';
    public string $number = '';
    public ?string $complement = null;
    public string $neighborhood = '';
    public string $city = '';
    public string $state = '';
    public string $zip_code = '';
    public ?float $latitude = null;
    public ?float $longitude = null;
    public bool $featured = false;
    public ?string $video_url = null;
    public ?string $virtual_tour_url = null;
    public array $amenities = [];

    /**
     * Define a instância do Property para o formulário e carrega as mídias existentes.
     * @param Property|null $property
     * @return void
     */
    public function setProperty(?Property $property = null): void
    {
        $this->property = $property;

        if ($this->property) {
            // Preenche o formulário com os dados do imóvel existente
            $this->fill($this->property->toArray());

            // Garante que amenities seja um array (se for JSON no DB)
            if (is_string($this->amenities)) {
                $this->amenities = json_decode($this->amenities, true) ?? [];
            }

            // Carrega as mídias existentes do modelo Spatie Media Library
            $this->existingThumbnails = $this->property->getMedia('thumbnails');
            $this->existingGalleryImages = $this->property->getMedia('gallery');
        } else {
            // Inicializa coleções vazias para novo imóvel
            $this->existingThumbnails = collect();
            $this->existingGalleryImages = collect();
        }
    }

    public function loadExistingMedia(): void
    {
        if ($this->property) {
            $this->existingThumbnails = $this->property->getMedia('thumbnails');
            $this->existingGalleryImages = $this->property->getMedia('gallery');
        } else {
            $this->existingThumbnails = new Collection();
            $this->existingGalleryImages = new Collection();
        }
    }

    /**
     * Regras de validação para o formulário.
     * As validações de arquivo (`newThumbnail`, `newGalleryImages`) podem ser feitas aqui ou no componente.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => ['required', Rule::in(['casa', 'apartamento', 'terreno', 'comercial', 'outro'])],
            'purpose' => ['required', Rule::in(['venda', 'aluguel', 'ambos'])],
            'status' => ['required', Rule::in(['disponivel', 'vendido', 'alugado', 'rascunho'])],
            'price' => 'nullable|numeric|min:0',
            'rent_price' => 'nullable|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'suites' => 'nullable|integer|min:0',
            'garage_spaces' => 'nullable|integer|min:0',
            'area' => 'nullable|integer|min:0',
            'total_area' => 'nullable|integer|min:0',
            'construction_area' => 'nullable|integer|min:0',
            'floors' => 'nullable|integer|min:0',
            'year_built' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:20',
            'complement' => 'nullable|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2',
            'zip_code' => 'required|string|max:10',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'featured' => 'boolean',
            'video_url' => 'nullable|url|max:255',
            'virtual_tour_url' => 'nullable|url|max:255',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            // Validações para as propriedades de upload temporário
            'newThumbnail' => 'nullable|image|max:2048',
            'newGalleryImages.*' => 'nullable|image|max:2048', // Validação para cada item do array de imagens
        ];
    }

    /**
     * Salva ou atualiza a propriedade e manipula as mídias associadas.
     * @return Property
     */
    public function save(): Property
    {
        $this->validate(); // Valida todas as propriedades do formulário, incluindo uploads temporários

        $data = $this->all();

        // Garante que 'rent_price' seja null se a finalidade for apenas 'venda'
        if ($data['purpose'] === 'venda') {
            $data['rent_price'] = null;
        }

        // Garante que 'amenities' seja armazenado como JSON no DB
        $data['amenities'] = json_encode($this->amenities);

        // Gera o slug antes de salvar
        $data['slug'] = Str::slug($this->title);

        // Cria ou Atualiza a Propriedade
        if ($this->property) {
            $this->property->update($data);
        } else {
            $data['user_id'] = Auth::id();
            $data['company_id'] = Auth::user()->company_id ?? null;
            $this->property = Property::create($data);
        }

        // --- Lógica de manipulação de Mídia com Spatie Media Library ---

        // 1. Lidar com a nova miniatura principal (newThumbnail)
        if ($this->newThumbnail) {
            $this->property->clearMediaCollection('thumbnails'); // Remove qualquer thumbnail antiga
            $this->property->addMedia($this->newThumbnail->getRealPath())
                           ->usingFileName($this->newThumbnail->getClientOriginalName())
                           ->toMediaCollection('thumbnails');
        }

        // 2. Lidar com as novas imagens da galeria (newGalleryImages)
        foreach ($this->newGalleryImages as $index => $newImage) {
            $media = $this->property->addMedia($newImage->getRealPath())
                                    ->usingFileName($newImage->getClientOriginalName())
                                    ->toMediaCollection('gallery');

            // Se esta nova imagem de galeria foi marcada como principal no modal,
            // e se não há thumbnail existente ou se o usuário explicitamente a marcou como principal
            if ($this->isNewImagePrincipal && $this->principalImageIndex === $index) {
                // Se já existir uma thumbnail, move-a para a galeria antes de definir a nova
                if ($this->property->getFirstMedia('thumbnails')) {
                    $this->property->getFirstMedia('thumbnails')->move($this->property, 'gallery');
                }
                $media->move($this->property, 'thumbnails'); // Move a nova imagem para a coleção de thumbnails
            }
        }

        // Recarrega as coleções de mídia do modelo para que o formulário reflita as mudanças
        // fresh() garante que o modelo seja recarregado do DB
        $this->property = $this->property->fresh();
        $this->existingThumbnails = $this->property->getMedia('thumbnails');
        $this->existingGalleryImages = $this->property->getMedia('gallery');

        // Limpa as propriedades de upload temporário no formulário após o salvamento
        $this->reset(['newThumbnail', 'newGalleryImages', 'isNewImagePrincipal', 'principalImageIndex']);

        return $this->property;
    }

    /**
     * Remove uma mídia existente do modelo.
     * @param int $mediaId O ID da mídia a ser removida.
     * @return void
     */
    public function removeMedia(int $mediaId): void
    {
        try {
            if ($this->property) {
                $mediaItem = $this->property->media()->find($mediaId);
                if ($mediaItem) {
                    $mediaItem->delete();
                    // Recarrega as coleções para refletir a remoção
                    $this->property = $this->property->fresh();
                    $this->existingThumbnails = $this->property->getMedia('thumbnails');
                    $this->existingGalleryImages = $this->property->getMedia('gallery');
                }
            }
        } catch (\Exception $e) {
            Log::error('Erro ao remover mídia no PropertyForm: ' . $e->getMessage(), ['media_id' => $mediaId, 'property_id' => $this->property->id ?? null, 'exception' => $e]);
            throw $e; // Re-lança a exceção para que o componente possa lidar com o erro (ex: exibir toast)
        }
    }

    /**
     * Define uma mídia existente como a principal (thumbnail).
     * @param int $mediaId O ID da mídia a ser definida como principal.
     * @return void
     */
    public function setMediaAsPrincipal(int $mediaId): void
    {
        try {
            if ($this->property) {
                $mediaToSetAsPrincipal = $this->property->media()->find($mediaId);
                if ($mediaToSetAsPrincipal) {
                    // Move a thumbnail existente para a galeria, se houver
                    if ($this->property->getFirstMedia('thumbnails')) {
                        $this->property->getFirstMedia('thumbnails')->move($this->property, 'gallery');
                    }
                    // Move a mídia selecionada para a coleção de thumbnails
                    $mediaToSetAsPrincipal->move($this->property, 'thumbnails');

                    // Recarrega as coleções para refletir as mudanças
                    $this->property = $this->property->fresh();
                    $this->existingThumbnails = $this->property->getMedia('thumbnails');
                    $this->existingGalleryImages = $this->property->getMedia('gallery');
                }
            }
        } catch (\Exception $e) {
            Log::error('Erro ao definir mídia como principal no PropertyForm: ' . $e->getMessage(), ['media_id' => $mediaId, 'property_id' => $this->property->id ?? null, 'exception' => $e]);
            throw $e; // Re-lança a exceção
        }
    }

    /**
     * Reinicia as propriedades do formulário para os valores padrão.
     * Útil para limpar o formulário após salvar ou para um novo cadastro.
     * @return void
     */
    public function resetForm(): void
    {
        $this->reset([
            'title', 'description', 'type', 'purpose', 'status', 'price', 'rent_price',
            'bedrooms', 'bathrooms', 'suites', 'garage_spaces', 'area', 'total_area',
            'construction_area', 'floors', 'year_built', 'street', 'number', 'complement',
            'neighborhood', 'city', 'state', 'zip_code', 'latitude', 'longitude',
            'featured', 'video_url', 'virtual_tour_url', 'amenities',
            'meta_title', 'meta_description', 'slug',
            'newThumbnail', 'newGalleryImages', 'isNewImagePrincipal', 'principalImageIndex',
        ]);
        $this->existingThumbnails = collect();
        $this->existingGalleryImages = collect();
        $this->property = null; // Zera a instância do imóvel
    }
}