<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Str;

class PropertyForm extends Form
{
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

    public function store()
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

    }
}
