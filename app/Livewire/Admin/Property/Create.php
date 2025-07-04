<?php

namespace App\Livewire\Admin\Property;

// use App\Livewire\Forms\Admin\PropertyForm;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;
// use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class Create extends Component
{
    use Toast, WithFileUploads;

    // public PropertyForm $form;

    // Form fields
    public string $title = 'Teste';
    public string $description = 'Descrição teste';
    public string $type = 'casa';
    public string $purpose = 'venda';
    public string $status = 'rascunho';
    public ?float $price = 1000000;
    public ?float $rent_price = 1000;
    public ?int $bedrooms = 2;
    public ?int $bathrooms = 2;
    public ?int $garage_spaces = 1;
    public ?int $area = 300;
    public ?int $total_area = 400;
    public ?int $construction_area = 200;
    public ?int $floors = null;
    public ?int $year_built = null;
    public string $street = 'Teste';
    public string $number = '123';
    public ?string $complement = 'casa';
    public string $neighborhood = 'Teste';
    public string $city = 'Ribeirão Preto';
    public string $state = 'SP';
    public string $zip_code = '14050090';
    public ?float $latitude = null;
    public ?float $longitude = null;
    public bool $featured = true;
    public ?string $video_url = null;
    public ?string $virtual_tour_url = null;
    public array $amenities = [];
    public array $gallery = [];
    public $thumbnail;

    // Amenities options
    public array $amenityOptions = [
        'piscina' => 'Piscina',
        'academia' => 'Academia',
        'churrasqueira' => 'Churrasqueira',
        'salao-de-festas' => 'Salão de Festas',
        'playground' => 'Playground',
        'portaria-24h' => 'Portaria 24h',
        'elevador' => 'Elevador',
        'quadra' => 'Quadra',
        'salao-de-jogos' => 'Salão de Jogos',
        'area-verde' => 'Área Verde'
    ];

    // Validation rules
    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'type' => 'required|in:casa,apartamento,terreno,comercial,outro',
            'purpose' => 'required|in:venda,aluguel,ambos',
            'status' => 'required|in:rascunho,disponivel,vendido,alugado',
            'price' => 'required_if:purpose,venda,ambos|numeric|min:0',
            'rent_price' => 'required_if:purpose,aluguel,ambos|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'garage_spaces' => 'nullable|integer|min:0',
            'area' => 'nullable|integer|min:0',
            'total_area' => 'nullable|integer|min:0',
            'construction_area' => 'nullable|integer|min:0',
            'floors' => 'nullable|integer|min:0',
            'year_built' => 'nullable|integer|min:1800|max:' . (date('Y') + 1),
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:20',
            'complement' => 'nullable|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|size:2',
            'zip_code' => 'required|string|max:9',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'featured' => 'boolean',
            'video_url' => 'nullable|url',
            'virtual_tour_url' => 'nullable|url',
            'amenities' => 'array',
            'amenities.*' => 'string|in:' . implode(',', array_keys($this->amenityOptions)),
            'gallery' => 'array|max:20',
            'thumbnail' => 'nullable|image|max:10240', // 10MB
        ];
    }

    // Save property
    public function save()
    {
        $this->validate();

        // Create property
        $property = Property::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'type' => $this->type,
            'purpose' => $this->purpose,
            'status' => $this->status,
            'price' => $this->price,
            'rent_price' => $this->purpose !== 'venda' ? $this->rent_price : null,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'garage_spaces' => $this->garage_spaces,
            'area' => $this->area,
            'total_area' => $this->total_area,
            'construction_area' => $this->construction_area,
            'floors' => $this->floors,
            'year_built' => $this->year_built,
            'street' => $this->street,
            'number' => $this->number,
            'complement' => $this->complement,
            'neighborhood' => $this->neighborhood,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'featured' => $this->featured,
            'video_url' => $this->video_url,
            'virtual_tour_url' => $this->virtual_tour_url,
            'amenities' => $this->amenities,
            'user_id' => Auth::id(),
        ]);

        // Handle thumbnail
        if ($this->thumbnail) {
            $property->addMedia($this->thumbnail)
                ->toMediaCollection('thumbnails');
        }

        // Handle gallery images
        foreach ($this->gallery as $image) {
            $property->addMedia($image)
                ->toMediaCollection('gallery');
        }

        $this->success('Imóvel cadastrado com sucesso!');
        return redirect()->route('admin.properties.index');
    }

    public function removeGalleryImage($index)
    {
        unset($this->gallery[$index]);
        $this->gallery = array_values($this->gallery); // Reindexa o array
        $this->success('Imagem removida da galeria.');
    }

    public function render()
    {
        return view('livewire.admin.property.create', [
            'stateOptions' => [
                ['id' => 'AC', 'name' => 'Acre'],
                ['id' => 'AL', 'name' => 'Alagoas'],
                ['id' => 'AP', 'name' => 'Amapá'],
                ['id' => 'AM', 'name' => 'Amazonas'],
                ['id' => 'BA', 'name' => 'Bahia'],
                ['id' => 'CE', 'name' => 'Ceará'],
                ['id' => 'DF', 'name' => 'Distrito Federal'],
                ['id' => 'ES', 'name' => 'Espírito Santo'],
                ['id' => 'GO', 'name' => 'Goiás'],
                ['id' => 'MA', 'name' => 'Maranhão'],
                ['id' => 'MT', 'name' => 'Mato Grosso'],
                ['id' => 'MS', 'name' => 'Mato Grosso do Sul'],
                ['id' => 'MG', 'name' => 'Minas Gerais'],
                ['id' => 'PA', 'name' => 'Pará'],
                ['id' => 'PB', 'name' => 'Paraíba'],
                ['id' => 'PR', 'name' => 'Paraná'],
                ['id' => 'PE', 'name' => 'Pernambuco'],
                ['id' => 'PI', 'name' => 'Piauí'],
                ['id' => 'RJ', 'name' => 'Rio de Janeiro'],
                ['id' => 'RN', 'name' => 'Rio Grande do Norte'],
                ['id' => 'RS', 'name' => 'Rio Grande do Sul'],
                ['id' => 'RO', 'name' => 'Rondônia'],
                ['id' => 'RR', 'name' => 'Roraima'],
                ['id' => 'SC', 'name' => 'Santa Catarina'],
                ['id' => 'SP', 'name' => 'São Paulo'],
                ['id' => 'SE', 'name' => 'Sergipe'],
                ['id' => 'TO', 'name' => 'Tocantin'],
            ],
            'typeOptions' => [
                ['id' => 'casa', 'name' => 'Casa'],
                ['id' => 'apartamento', 'name' => 'Apartamento'],
                ['id' => 'terreno', 'name' => 'Terreno'],
                ['id' => 'comercial', 'name' => 'Comercial'],
                ['id' => 'outro', 'name' => 'Outro']
            ],
            'purposeOptions' => [
                ['id' => 'venda', 'name' => 'Venda'],
                ['id' => 'aluguel', 'name' => 'Aluguel'],
                ['id' => 'ambos', 'name' => 'Venda e Aluguel']
            ],
            'statusOptions' => [
                ['id' => 'rascunho', 'name' => 'Rascunho'],
                ['id' => 'disponivel', 'name' => 'Disponível'],
                ['id' => 'vendido', 'name' => 'Vendido'],
                ['id' => 'alugado', 'name' => 'Alugado']
            ]
        ]);
    }
}
