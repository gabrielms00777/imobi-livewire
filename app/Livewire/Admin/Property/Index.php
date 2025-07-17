<?php

namespace App\Livewire\Admin\Property;

use App\Models\Property;
use Illuminate\Support\Facades\Auth;
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

    public $suites = ''; // Para 1+, 2+, etc.
    public $total_area_min = '';
    public $total_area_max = '';
    public $construction_area_min = '';
    public $construction_area_max = '';
    public $floors = ''; // Para 1+, 2+, etc.
    public $year_built_min = '';
    public $year_built_max = '';

    // Clear filters
    public function clear(): void
    {
        $this->reset([
            'search',
            'drawer',
            'status',
            'type',
            'bedrooms',
            'bathrooms',
            'price_min',
            'price_max',
            'suites',
            'total_area_min',
            'total_area_max',
            'construction_area_min',
            'construction_area_max',
            'floors',
            'year_built_min',
            'year_built_max'
        ]);
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
    // public function headers(): array
    // {
    //     return [
    //         ['key' => 'id', 'label' => '#', 'class' => 'w-16'],
    //         ['key' => 'thumbnail', 'label' => 'Foto', 'class' => 'w-20', 'sortable' => false],
    //         ['key' => 'title', 'label' => 'Título', 'class' => 'w-64'],
    //         ['key' => 'type', 'label' => 'Tipo'],
    //         ['key' => 'price', 'label' => 'Preço'],
    //         ['key' => 'status', 'label' => 'Status'],
    //         ['key' => 'created_at', 'label' => 'Cadastrado em', 'sortBy' => 'created_at'],
    //     ];
    // }

    // public function properties()
    // {
    //     $user = Auth::user();
    //     if($user->slug){
    //         return Property::query()
    //         ->with('media')
    //         ->where('user_id', $user->id)
    //         ->when($this->search, function ($query) {
    //             $query->where('title', 'like', "%{$this->search}%")
    //                   ->orWhere('description', 'like', "%{$this->search}%");
    //         })
    //         ->when($this->status, fn($query) => $query->where('status', $this->status))
    //         ->when($this->type, fn($query) => $query->where('type', $this->type))
    //         ->when($this->bedrooms, fn($query) => $query->where('bedrooms', '>=', $this->bedrooms))
    //         ->when($this->bathrooms, fn($query) => $query->where('bathrooms', '>=', $this->bathrooms))
    //         ->when($this->price_min, fn($query) => $query->where('price', '>=', $this->price_min))
    //         ->when($this->price_max, fn($query) => $query->where('price', '<=', $this->price_max))
    //         ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
    //         ->paginate(10);
    //     } elseif($user->company_id){
    //         return Property::query()
    //             ->with('media')
    //             ->where('company_id', $user->company_id)
    //             ->when($this->search, function ($query) {
    //                 $query->where('title', 'like', "%{$this->search}%")
    //                       ->orWhere('description', 'like', "%{$this->search}%");
    //             })
    //             ->when($this->status, fn($query) => $query->where('status', $this->status))
    //             ->when($this->type, fn($query) => $query->where('type', $this->type))
    //             ->when($this->bedrooms, fn($query) => $query->where('bedrooms', '>=', $this->bedrooms))
    //             ->when($this->bathrooms, fn($query) => $query->where('bathrooms', '>=', $this->bathrooms))
    //             ->when($this->price_min, fn($query) => $query->where('price', '>=', $this->price_min))
    //             ->when($this->price_max, fn($query) => $query->where('price', '<=', $this->price_max))
    //             ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
    //             ->paginate(10);
    //     }
    // }

    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-16'],
            ['key' => 'thumbnail', 'label' => 'Foto', 'class' => 'w-500', 'sortable' => false],
            ['key' => 'title', 'label' => 'Título', 'class' => 'w-64'],
            ['key' => 'type', 'label' => 'Tipo'],
            ['key' => 'price', 'label' => 'Preço'],
            ['key' => 'status', 'label' => 'Status'],
            ['key' => 'created_at', 'label' => 'Cadastrado em', 'sortBy' => 'created_at'],
            // ['key' => 'suites', 'label' => 'Suítes'], // Adicionando coluna na tabela para visualização rápida
            // ['key' => 'total_area', 'label' => 'Área Total (m²)'], // Adicionando coluna na tabela
        ];
    }

    public function properties()
    {
        $user = Auth::user();
        $query = Property::query()->with('media');

        // Lógica de filtro por usuário/empresa (mantida como está no seu código original)
        if ($user->slug) {
            $query->where('user_id', $user->id);
        } elseif ($user->company_id) {
            $query->where('company_id', $user->company_id);
        } else {
            // Se o usuário não tem slug nem company_id, consideramos que ele não deve ver propriedades
            // ou é um admin que verá todas. Para este contexto, vamos retornar uma coleção vazia
            // ou uma mensagem de erro se o acesso não for permitido.
            // Para garantir que o filtro funcione para tipos de usuários específicos,
            // vamos impedir que a consulta retorne tudo se nenhum filtro de usuário/empresa for aplicado.
            return $query->whereRaw('1 = 0')->paginate(10); // Retorna uma paginação vazia
        }

        // Aplicação de filtros comuns
        $query->when($this->search, function ($q) {
            $q->where('title', 'like', "%{$this->search}%")
                ->orWhere('description', 'like', "%{$this->search}%");
        })
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->type, fn($q) => $q->where('type', $this->type))
            ->when($this->bedrooms, fn($q) => $q->where('bedrooms', '>=', $this->bedrooms))
            ->when($this->bathrooms, fn($q) => $q->where('bathrooms', '>=', $this->bathrooms))
            ->when($this->price_min, fn($q) => $q->where('price', '>=', $this->price_min))
            ->when($this->price_max, fn($q) => $q->where('price', '<=', $this->price_max));

        // Aplicação dos NOVOS FILTROS
        // $query->when($this->suites, fn($q) => $q->where('suites', '>=', $this->suites))
        //     ->when($this->total_area_min, fn($q) => $q->where('total_area', '>=', $this->total_area_min))
        //     ->when($this->total_area_max, fn($q) => $q->where('total_area', '<=', $this->total_area_max))
        //     ->when($this->construction_area_min, fn($q) => $q->where('construction_area', '>=', $this->construction_area_min))
        //     ->when($this->construction_area_max, fn($q) => $q->where('construction_area', '<=', $this->construction_area_max))
        //     ->when($this->floors, fn($q) => $q->where('floors', '>=', $this->floors))
        //     ->when($this->year_built_min, fn($q) => $q->where('year_built', '>=', $this->year_built_min))
        //     ->when($this->year_built_max, fn($q) => $q->where('year_built', '<=', $this->year_built_max));

        return $query->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(10);
    }

    public function render()
    {
        // dd($this->properties());
        return view('livewire.admin.property.index', [
            'properties' => $this->properties(),
            'headers' => $this->headers()
        ]);
    }
}
