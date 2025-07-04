<div>
    <!-- HEADER -->
    <x-header title="Imóveis" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Buscar imóvel..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Filtros" @click="$wire.drawer = true" responsive icon="o-funnel" class="btn-outline" />
            <x-button label="Adicionar" link="/admin/properties/create" responsive icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$headers" :rows="$properties" :sort-by="$sortBy" with-pagination>
            @scope('cell_thumbnail', $property)
                @if($property->hasMedia('thumbnails'))
                    <x-avatar :image="$property->getFirstMediaUrl('thumbnails', 'thumb')" class="!w-12 !h-12" />
                @else
                    <x-avatar image="/placeholder-property.jpg" class="!w-12 !h-12" />
                @endif
            @endscope

            @scope('cell_price', $property)
                R$ {{ number_format($property->price, 2, ',', '.') }}
            @endscope

            @scope('cell_status', $property)
                <x-badge :value="$property->status" @class([
                    'badge-outline' => $property->status === 'rascunho',
                    'badge-primary' => $property->status === 'disponivel',
                    'badge-success' => $property->status === 'vendido',
                    'badge-warning' => $property->status === 'alugado',
                ]) />
            @endscope

            @scope('cell_created_at', $property)
                {{ $property->created_at->format('d/m/Y') }}
            @endscope

            @scope('actions', $property)
                <div class="flex items-center gap-2">
                    <x-button icon="o-eye" link="/imovel/{{ $property->slug }}" target="_blank" class="btn-ghost btn-sm" tooltip="Visualizar no site" />
                    <x-button icon="o-pencil" link="/admin/properties/{{ $property->id }}/edit" class="btn-ghost btn-sm" tooltip="Editar" />
                    <x-button icon="o-trash" wire:click="delete({{ $property->id }})" spinner class="btn-ghost btn-sm text-error" tooltip="Excluir" />
                </div>
            @endscope
        </x-table>
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Filtros Avançados" right separator with-close-button class="lg:w-1/3">
        <div class="grid gap-5">
            <x-input label="Buscar" placeholder="Título ou descrição..." wire:model.live.debounce="search" icon="o-magnifying-glass" />

            <x-select label="Status" wire:model.live="status" :options="[
                '' => 'Todos',
                'rascunho' => 'Rascunho',
                'disponivel' => 'Disponível',
                'vendido' => 'Vendido',
                'alugado' => 'Alugado'
            ]" placeholder="Selecione..." />

            <x-select label="Tipo de Imóvel" wire:model.live="type" :options="[
                '' => 'Todos',
                'casa' => 'Casa',
                'apartamento' => 'Apartamento',
                'terreno' => 'Terreno',
                'comercial' => 'Comercial'
            ]" placeholder="Selecione..." />

            <div class="grid grid-cols-2 gap-4">
                <x-select label="Quartos" wire:model.live="bedrooms" :options="[
                    '' => 'Qualquer',
                    '1' => '1+',
                    '2' => '2+',
                    '3' => '3+',
                    '4' => '4+'
                ]" />

                <x-select label="Banheiros" wire:model.live="bathrooms" :options="[
                    '' => 'Qualquer',
                    '1' => '1+',
                    '2' => '2+',
                    '3' => '3+'
                ]" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <x-input label="Preço Mínimo" wire:model.live.debounce.500ms="price_min" icon="o-currency-dollar" type="number" />
                <x-input label="Preço Máximo" wire:model.live.debounce.500ms="price_max" icon="o-currency-dollar" type="number" />
            </div>
        </div>

        <x-slot:actions>
            <x-button label="Limpar" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Aplicar" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer>
</div>