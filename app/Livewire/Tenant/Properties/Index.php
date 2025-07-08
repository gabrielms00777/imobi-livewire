<?php

namespace App\Livewire\Tenant\Properties;

use Livewire\Component;
use App\Models\Property;
use Livewire\WithPagination; // Para paginação

class Index extends Component
{
    use WithPagination;

    // Propriedades para filtros
    public ?string $search = '';
    public array $propertyTypes = []; // ['Casa', 'Apartamento', 'Terreno', 'Comercial']
    public int $minPrice = 0;
    public int $maxPrice = 10000000; // Valor máximo a ser ajustado conforme a realidade
    public ?int $bedrooms = null;
    public ?int $bathrooms = null;
    public ?int $garages = null;
    public ?int $minArea = null;
    public ?int $maxArea = null;
    public string $orderBy = 'relevance'; // relevance, price_asc, price_desc, latest, area_desc

    protected $queryString = [
        'search' => ['except' => ''],
        'propertyTypes' => ['except' => []],
        'minPrice' => ['except' => 0],
        'maxPrice' => ['except' => 10000000],
        'bedrooms' => ['except' => null],
        'bathrooms' => ['except' => null],
        'garages' => ['except' => null],
        'minArea' => ['except' => null],
        'maxArea' => ['except' => null],
        'orderBy' => ['except' => 'relevance'],
    ];

    public function mount($id)
    {
        // Inicializa os tipos de imóveis se houver um padrão
        // $this->propertyTypes = ['Casa', 'Apartamento', 'Terreno', 'Comercial']; // Exemplo
    }

    public function updating($name, $value)
    {
        // Reseta a paginação ao mudar os filtros
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 'propertyTypes', 'minPrice', 'maxPrice',
            'bedrooms', 'bathrooms', 'garages', 'minArea', 'maxArea', 'orderBy'
        ]);
    }

    public function render()
    {
        $tenant = app('tenant');

        if (!$tenant) {
            // Redirecionar ou mostrar erro se o tenant não for encontrado
            abort(404, 'Tenant not found');
        }

        $properties = Property::where('tenant_id', $tenant->id);

        // Aplicar filtros
        if ($this->search) {
            $properties->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('address', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->propertyTypes)) {
            $properties->whereIn('type', $this->propertyTypes);
        }

        $properties->whereBetween('price', [$this->minPrice, $this->maxPrice]);

        if ($this->bedrooms) {
            $properties->where('bedrooms', '>=', $this->bedrooms);
        }
        if ($this->bathrooms) {
            $properties->where('bathrooms', '>=', $this->bathrooms);
        }
        if ($this->garages) {
            $properties->where('garages', '>=', $this->garages);
        }
        if ($this->minArea) {
            $properties->where('area', '>=', $this->minArea);
        }
        if ($this->maxArea) {
            $properties->where('area', '<=', $this->maxArea);
        }

        // Aplicar ordenação
        switch ($this->orderBy) {
            case 'price_asc':
                $properties->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $properties->orderBy('price', 'desc');
                break;
            case 'latest':
                $properties->orderBy('created_at', 'desc');
                break;
            case 'area_desc':
                $properties->orderBy('area', 'desc');
                break;
            case 'relevance':
            default:
                $properties->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
                break;
        }

        $properties = $properties->paginate(9); // 9 imóveis por página

        $propertyTypesOptions = [
            'Casa', 'Apartamento', 'Terreno', 'Comercial'
        ]; // Você pode buscar isso dinamicamente se tiver um enum ou tabela

        return view('livewire.tenant.properties.index', [
            'properties' => $properties,
            'tenant' => $tenant,
            'propertyTypesOptions' => $propertyTypesOptions,
        ]);
    }
}
