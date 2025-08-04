<div>
    <x-header title="Imóveis" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Buscar imóvel..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Filtros" @click="$wire.drawer = true" responsive icon="o-funnel" class="btn-outline" />
            <x-button label="Adicionar" link="/admin/properties/create" responsive icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-table :headers="$headers" :rows="$properties" :sort-by="$sortBy" with-pagination>
            {{-- Coluna Thumbnail --}}
            @scope('cell_thumbnail', $property)
                @if($property->hasMedia('thumbnails'))
                    <x-avatar :image="$property->getFirstMediaUrl('thumbnails', 'thumb')" class="!w-12 !h-12" />
                @else
                    <x-avatar image="{{ asset('placeholder-property.png') }}" class="!w-12 !h-12" />
                @endif
            @endscope

            {{-- Coluna Preço --}}
            @scope('cell_price', $property)
                @if($property->price)
                    R$ {{ number_format($property->price, 2, ',', '.') }}
                @elseif($property->rent_price)
                    R$ {{ number_format($property->rent_price, 2, ',', '.') }} (Aluguel)
                @else
                    N/A
                @endif
            @endscope

            {{-- Coluna Suítes (Novo) --}}
            {{-- @scope('cell_suites', $property)
                {{ $property->suites ?? 'N/A' }}
            @endscope --}}

            {{-- Coluna Área Total (Novo) --}}
            {{-- @scope('cell_total_area', $property)
                {{ $property->total_area ? number_format($property->total_area, 2, ',', '.') . ' m²' : 'N/A' }}
            @endscope --}}

            {{-- Coluna Status --}}
            @scope('cell_status', $property)
                <x-badge :value=" ucfirst($property->status)" @class([
                    'badge-outline' => $property->status === 'rascunho',
                    'badge-primary' => $property->status === 'disponivel',
                    'badge-success' => $property->status === 'vendido',
                    'badge-warning' => $property->status === 'alugado',
                ]) />
            @endscope

            {{-- Coluna Cadastrado em --}}
            @scope('cell_created_at', $property)
                {{ $property->created_at->format('d/m/Y') }}
            @endscope

            {{-- Coluna Ações --}}
            @scope('actions', $property)
            {{-- @dd($property) --}}
                <div class="flex items-center gap-2">
                    {{-- <a href="{{ route('tenant.properties.show', ['tenantSlug' => ($property->user->slug ?? $property->company->slug), 'property' => $property->slug]) }}" target="_blank" class="btn-ghost btn-sm" tooltip="Visualizar no site" ></a> --}}
                    <x-button icon="o-eye" external  link="{{ route('tenant.properties.show', ['tenantSlug' => ($property->user->slug ?? $property->company->slug), 'property' => $property->slug]) }}" target="_blank" class="btn-ghost btn-sm" tooltip="Visualizar no site" />
                    {{-- <x-button icon="o-eye" link="{{ $property->user->slug ?? $property->company->slug }}/imovel/{{ $property->slug }}" target="_blank" class="btn-ghost btn-sm" tooltip="Visualizar no site" /> --}}
                    <x-button icon="o-pencil" link="/admin/properties/{{ $property->id }}/edit" class="btn-ghost btn-sm" tooltip="Editar" />
                    <x-button icon="o-trash" wire:click="openDeleteModal({{ $property->id }})" spinner class="btn-ghost btn-sm text-error" tooltip="Excluir" />
                </div>
            @endscope
        </x-table>
    </x-card>

    <x-modal wire:model="deleteModal" title="Confirmar Exclusão" class="backdrop-blur" separator>
        @if ($propertyToDelete)
            <p>Tem certeza que deseja excluir o imóvel <b>#{{ $propertyToDelete->title }}</b>?</p>
            <p class="mt-2">Esta ação é <b>irreversível</b>.</p>
        @else
            <p>Nenhum imóvel selecionado para exclusão.</p>
        @endif

        <x-slot:actions>
            <x-button label="Cancelar" @click="$wire.deleteModal = false" />
            <x-button label="Excluir" wire:click="delete" spinner class="btn-error" />
        </x-slot:actions>
    </x-modal>

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
                'comercial' => 'Comercial',
                'sitio/chacara' => 'Sítio/Chácara', {{-- NOVO --}}
                'galpao' => 'Galpão', {{-- NOVO --}}
                'outro' => 'Outro'
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

                {{-- NOVO FILTRO: Suítes --}}
                <x-select label="Suítes" wire:model.live="suites" :options="[
                    '' => 'Qualquer',
                    '1' => '1+',
                    '2' => '2+',
                    '3' => '3+'
                ]" />

                {{-- NOVO FILTRO: Andares --}}
                <x-select label="Andares" wire:model.live="floors" :options="[
                    '' => 'Qualquer',
                    '1' => '1+',
                    '2' => '2+',
                    '3' => '3+',
                    '4' => '4+'
                ]" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <x-input label="Preço Mínimo" wire:model.live.debounce.500ms="price_min" icon="o-currency-dollar" type="number" />
                <x-input label="Preço Máximo" wire:model.live.debounce.500ms="price_max" icon="o-currency-dollar" type="number" />
            </div>

            {{-- NOVOS FILTROS: Área Total --}}
            {{-- <div class="grid grid-cols-2 gap-4">
                <x-input label="Área Total Mín. (m²)" wire:model.live.debounce.500ms="total_area_min" type="number" />
                <x-input label="Área Total Máx. (m²)" wire:model.live.debounce.500ms="total_area_max" type="number" />
            </div> --}}

            {{-- NOVOS FILTROS: Área Construída --}}
            {{-- <div class="grid grid-cols-2 gap-4">
                <x-input label="Área Const. Mín. (m²)" wire:model.live.debounce.500ms="construction_area_min" type="number" />
                <x-input label="Área Const. Máx. (m²)" wire:model.live.debounce.500ms="construction_area_max" type="number" />
            </div> --}}

            {{-- NOVOS FILTROS: Ano de Construção --}}
            {{-- <div class="grid grid-cols-2 gap-4">
                <x-input label="Ano Const. Mín." wire:model.live.debounce.500ms="year_built_min" type="number" placeholder="Ex: 1980" />
                <x-input label="Ano Const. Máx." wire:model.live.debounce.500ms="year_built_max" type="number" placeholder="Ex: 2025" />
            </div> --}}
        </div>

        <x-slot:actions>
            <x-button label="Limpar" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Aplicar" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer>
</div>