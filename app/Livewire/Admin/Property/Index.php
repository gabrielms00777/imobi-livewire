<?php

namespace App\Livewire\Admin\Property;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Index extends Component
{
    use Toast, WithPagination;

    public string $search = '';
    public bool $drawer = false;
    public array $sortBy = ['column' => 'created_at', 'direction' => 'desc'];
    
    // Filtros
    public $status = '';
    public $type = '';
    public $bedrooms = '';
    public $bathrooms = '';
    public $price_min = '';
    public $price_max = '';

    // Clear filters
    public function clear(): void
    {
        $this->reset();
        $this->resetPage();
        $this->success('Filtros limpos com sucesso.', position: 'toast-bottom');
    }

    // Delete action
    public function delete($id): void
    {
        Property::find($id)->delete();
        $this->success("Imóvel #$id deletado", position: 'toast-bottom');
    }

    // Table headers
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-16'],
            ['key' => 'thumbnail', 'label' => 'Foto', 'class' => 'w-20', 'sortable' => false],
            ['key' => 'title', 'label' => 'Título', 'class' => 'w-64'],
            ['key' => 'type', 'label' => 'Tipo'],
            ['key' => 'price', 'label' => 'Preço'],
            ['key' => 'status', 'label' => 'Status'],
            ['key' => 'created_at', 'label' => 'Cadastrado em', 'sortBy' => 'created_at'],
        ];
    }

    public function properties()
    {
        return Property::query()
            ->with('media')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', "%{$this->search}%")
                      ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->when($this->status, fn($query) => $query->where('status', $this->status))
            ->when($this->type, fn($query) => $query->where('type', $this->type))
            ->when($this->bedrooms, fn($query) => $query->where('bedrooms', '>=', $this->bedrooms))
            ->when($this->bathrooms, fn($query) => $query->where('bathrooms', '>=', $this->bathrooms))
            ->when($this->price_min, fn($query) => $query->where('price', '>=', $this->price_min))
            ->when($this->price_max, fn($query) => $query->where('price', '<=', $this->price_max))
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(10);
    }
    
    public function render()
    {
        return view('livewire.admin.property.index', [
            'properties' => $this->properties(),
            'headers' => $this->headers()
        ]);
    }
}