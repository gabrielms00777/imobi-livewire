<div>
    <x-header title="Cadastrar Novo Imóvel" separator>
        <x-slot:actions>
            <x-button label="Cancelar" link="{{ route('admin.properties.index') }}" icon="o-arrow-uturn-left" class="btn-ghost" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit="save">
        {{-- Seção de Informações Básicas --}}
        <x-card title="Informações Básicas" shadow separator>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <x-input label="Título*" wire:model="form.title" placeholder="Ex: Casa moderna com piscina no centro" />
                <x-textarea label="Descrição*" wire:model="form.description" placeholder="Descreva detalhadamente o imóvel..." rows="5" />

                <x-select label="Tipo*" wire:model="form.type" :options="$typeOptions" placeholder="Selecione o tipo..." />
                <x-select label="Finalidade*" wire:model="form.purpose" :options="$purposeOptions" placeholder="Selecione a finalidade..." />

                <x-select label="Status*" wire:model="form.status" :options="$statusOptions" placeholder="Selecione o status..." />
                <x-checkbox label="Destaque" wire:model="form.featured" class="checkbox-primary" />

                <x-input label="Preço de Venda (R$)*" wire:model="form.price" icon="o-currency-dollar" type="number" step="0.01" x-mask:dynamic="$money($input, ',')" />
                {{-- Campo Preço de Aluguel aparece condicionalmente --}}
                @if (in_array($form->purpose, ['aluguel', 'ambos']))
                    <x-input label="Preço de Aluguel (R$)" wire:model="form.rent_price" icon="o-currency-dollar" type="number" step="0.01" x-mask:dynamic="$money($input, ',')" />
                @else
                    {{-- Campo oculto para garantir que o rent_price seja setado como null se a finalidade mudar. --}}
                    {{-- Usamos um Livewire Model Listener para garantir que o valor seja limpo quando a finalidade for alterada. --}}
                    <input type="hidden" wire:model="form.rent_price">
                    @script
                        <script>
                            $wire.on('change', ({ el, model, value }) => {
                                if (model === 'form.purpose' && !['aluguel', 'ambos'].includes(value)) {
                                    $wire.set('form.rent_price', null);
                                }
                            });
                        </script>
                    @endscript
                @endif
                <x-input label="Moeda" wire:model="form.currency" placeholder="Ex: BRL, USD" />

                <x-input label="Quartos" wire:model="form.bedrooms" type="number" min="0" />
                <x-input label="Banheiros" wire:model="form.bathrooms" type="number" min="0" />
                <x-input label="Suítes" wire:model="form.suites" type="number" min="0" /> {{-- NOVO CAMPO --}}
                <x-input label="Vagas de Garagem" wire:model="form.garage_spaces" type="number" min="0" />
                <x-input label="Área Útil (m²)" wire:model="form.area" type="number" step="0.01" min="0" />
                <x-input label="Área Total (m²)" wire:model="form.total_area" type="number" step="0.01" min="0" /> {{-- NOVO CAMPO --}}
                <x-input label="Área Construída (m²)" wire:model="form.construction_area" type="number" step="0.01" min="0" /> {{-- NOVO CAMPO --}}
                <x-input label="Andares" wire:model="form.floors" type="number" min="0" /> {{-- NOVO CAMPO --}}
                <x-input label="Ano de Construção" wire:model="form.year_built" type="number" min="1800" max="{{ date('Y') + 5 }}" /> {{-- NOVO CAMPO --}}
            </div>
        </x-card>

        {{-- Seção de Endereço --}}
        <x-card title="Endereço" shadow separator class="mt-5">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <x-input label="CEP*" wire:model="form.zip_code" placeholder="Ex: 14000-000" x-mask="99999-999" />
                <x-input label="Rua*" wire:model="form.street" placeholder="Ex: Rua das Flores" />
                <x-input label="Número*" wire:model="form.number" placeholder="Ex: 123" />
                <x-input label="Complemento" wire:model="form.complement" placeholder="Ex: Apto 101" /> {{-- NOVO CAMPO --}}
                <x-input label="Bairro*" wire:model="form.neighborhood" placeholder="Ex: Centro" /> {{-- NOVO CAMPO --}}
                <x-input label="Cidade*" wire:model="form.city" placeholder="Ex: Ribeirão Preto" />
                <x-select label="Estado*" wire:model="form.state" :options="$stateOptions" placeholder="Selecione o estado..." />
                <x-input label="Latitude" wire:model="form.latitude" type="number" step="0.0000001" placeholder="-21.1764654" /> {{-- NOVO CAMPO --}}
                <x-input label="Longitude" wire:model="form.longitude" type="number" step="0.0000001" placeholder="-47.8202534" /> {{-- NOVO CAMPO --}}
            </div>
        </x-card>

        {{-- Seção de Imagens e Vídeos --}}
        <x-card title="Mídia e Tour Virtual" shadow separator class="mt-5">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                {{-- Miniatura --}}
                <div>
                    <x-file label="Miniatura Principal" wire:model="form.thumbnail" accept="image/png, image/jpeg, image/webp" />
                    @if ($form->thumbnail)
                        <div class="flex items-center gap-4 mt-2">
                            <x-avatar :image="$form->thumbnail->temporaryUrl()" class="!w-32 !h-auto" />
                            {{-- Botão para remover a miniatura recém-carregada --}}
                            <x-button icon="o-trash" wire:click="$set('form.thumbnail', null)" spinner class="btn-sm btn-ghost text-error" />
                        </div>
                    @elseif ($form->existingThumbnailUrl)
                        <div class="flex items-center gap-4 mt-2 relative group">
                            <x-avatar :image="$form->existingThumbnailUrl" class="!w-32 !h-auto" />
                            {{-- Botão para remover a miniatura existente (chamando método no componente Livewire) --}}
                            <x-button icon="o-trash" wire:click="removeThumbnail" spinner class="absolute top-1 right-1 btn-ghost btn-xs text-error opacity-0 group-hover:opacity-100 transition-opacity" />
                        </div>
                    @endif
                </div>

                {{-- Galeria de Imagens --}}
                <div>
                    <x-file label="Galeria de Imagens (máx. 5)" wire:model="form.galleryImages" accept="image/png, image/jpeg, image/webp" multiple />
                    {{-- Exibe imagens da galeria recém-carregadas --}}
                    @if (!empty($form->galleryImages))
                        <div class="grid grid-cols-3 gap-2 mt-2">
                            @foreach($form->galleryImages as $index => $image)
                                <div class="relative group">
                                    <x-avatar :image="$image->temporaryUrl()" class="!w-full !h-32 !rounded" />
                                    {{-- Botão para remover uma imagem recém-carregada --}}
                                    <x-button icon="o-trash" wire:click="$set('form.galleryImages.{{ $index }}', null)" spinner class="absolute top-1 right-1 btn-ghost btn-xs text-error opacity-0 group-hover:opacity-100 transition-opacity" />
                                </div>
                            @endforeach
                        </div>
                    @endif
                    {{-- Exibe imagens da galeria existentes (para edição) --}}
                    @if (!empty($form->existingGalleryImages))
                        <div class="grid grid-cols-3 gap-2 mt-2">
                            @foreach($form->existingGalleryImages as $image)
                                <div class="relative group">
                                    <x-avatar :image="$image['url']" class="!w-full !h-32 !rounded" />
                                    {{-- Botão para remover uma imagem existente (chamando método no componente Livewire) --}}
                                    <x-button icon="o-trash" wire:click="removeGalleryImage({{ $image['id'] }})" spinner class="absolute top-1 right-1 btn-ghost btn-xs text-error opacity-0 group-hover:opacity-100 transition-opacity" />
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Vídeos e Tours Virtuais --}}
                <x-input label="URL do Vídeo (Youtube/Vimeo)" wire:model="form.video_url" placeholder="https://www.youtube.com/watch?v=..." />
                <x-input label="URL do Tour Virtual" wire:model="form.virtual_tour_url" placeholder="https://my.matterport.com/show/..." />
            </div>
        </x-card>

        {{-- Seção de Comodidades --}}
        <x-card title="Comodidades" shadow separator class="mt-5">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($amenityOptions as $value => $label)
                    <x-checkbox :label="$label" wire:model="form.amenities" value="{{ $value }}" class="checkbox-primary" />
                @endforeach
            </div>
        </x-card>

        {{-- Seção de SEO --}}
        <x-card title="SEO (Search Engine Optimization)" shadow separator class="mt-5">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <x-input label="Meta Título" wire:model="form.meta_title" placeholder="Título para mecanismos de busca" /> {{-- NOVO CAMPO --}}
                <x-textarea label="Meta Descrição" wire:model="form.meta_description" placeholder="Descrição para mecanismos de busca" rows="3" /> {{-- NOVO CAMPO --}}
            </div>
        </x-card>

        {{-- Botão de Submit --}}
        <div class="mt-5 flex justify-end gap-x-3">
            <x-button label="Cancelar" link="{{ route('admin.properties.index') }}" />
            <x-button label="Salvar" type="submit" icon="o-check" class="btn-primary" spinner="save" />
        </div>
    </x-form>
</div>