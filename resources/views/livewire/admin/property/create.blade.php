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
                <x-input label="Título*" wire:model="title" placeholder="Ex: Casa moderna com piscina no centro" />
                <x-textarea label="Descrição*" wire:model="description" placeholder="Descreva detalhadamente o imóvel..." rows="5" />
                
                <x-select label="Tipo*" wire:model="type" :options="$typeOptions" placeholder="Selecione o tipo..." />
                <x-select label="Finalidade*" wire:model="purpose" :options="$purposeOptions" placeholder="Selecione a finalidade..." />
                
                <x-select label="Status*" wire:model="status" :options="$statusOptions" placeholder="Selecione o status..." />
                <x-checkbox label="Destaque" wire:model="featured" class="checkbox-primary" />
                
                <x-input label="Preço (R$)*" wire:model="price" icon="o-currency-dollar" type="number" x-mask:dynamic="$money($input, ',')" />
                <x-input label="Preço de Aluguel (R$)" wire:model="rent_price" icon="o-currency-dollar" type="number" x-mask:dynamic="$money($input, ',')" :disabled="$purpose === 'venda'" />
            </div>
        </x-card>

        {{-- Seção de Características --}}
        <x-card title="Características" shadow separator class="mt-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <x-input label="Quartos" wire:model="bedrooms" type="number" />
                <x-input label="Banheiros" wire:model="bathrooms" type="number" />
                <x-input label="Vagas" wire:model="garage_spaces" type="number" />
                <x-input label="Área (m²)" wire:model="area" type="number" />
                
                <x-input label="Área Total (m²)" wire:model="total_area" type="number" :disabled="$type !== 'terreno'" />
                <x-input label="Área Construída (m²)" wire:model="construction_area" type="number" :disabled="$type === 'terreno'" />
                <x-input label="Andares" wire:model="floors" type="number" />
                <x-input label="Ano de Construção" wire:model="year_built" type="number" />
            </div>
        </x-card>

        {{-- Seção de Endereço --}}
        <x-card title="Localização" shadow separator class="mt-5">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <x-input label="Logradouro*" wire:model="street" placeholder="Rua, Avenida, etc." />
                <x-input label="Número*" wire:model="number" placeholder="Número ou S/N" />
                
                <x-input label="Complemento" wire:model="complement" placeholder="Apto, Bloco, etc." />
                <x-input label="Bairro*" wire:model="neighborhood" />
                
                <x-input label="Cidade*" wire:model="city" />
                <x-select label="Estado*" wire:model="state" :options="$stateOptions" placeholder="Selecione o estado..." />
                
                <x-input label="CEP*" wire:model="zip_code" x-mask="99999-999" placeholder="00000-000" />
                
                <div class="grid grid-cols-2 gap-4">
                    <x-input label="Latitude" wire:model="latitude" type="number" step="0.000001" />
                    <x-input label="Longitude" wire:model="longitude" type="number" step="0.000001" />
                </div>
            </div>
            
            {{-- Mapa (será implementado posteriormente) --}}
            <div class="mt-4 h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                <p class="text-gray-500">Mapa de localização será implementado aqui</p>
            </div>
        </x-card>

        {{-- Seção de Mídia --}}
        <x-card title="Mídia" shadow separator class="mt-5">
            <div class="grid grid-cols-1 gap-4">
                {{-- Thumbnail --}}
                <x-file  label="Thumbnail (Imagem Principal)" wire:model="thumbnail" accept="image/png, image/jpeg" hint="Clique para enviar ou arraste uma imagem" />
                
                @if($thumbnail)
                    <div class="flex items-center gap-2">
                        <x-avatar :image="$thumbnail->temporaryUrl()" class="!w-24 !h-24" />
                        <x-button icon="o-trash" wire:click="$set('thumbnail', null)" spinner class="btn-ghost btn-sm text-error" />
                    </div>
                @endif
                
                {{-- Galeria --}}
                <x-file  label="Galeria de Imagens (Máx. 20)" wire:model="gallery" multiple accept="image/png, image/jpeg" hint="Clique para enviar ou arraste múltiplas imagens" />
                
                @if(count($gallery) > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                        @foreach($gallery as $index => $image)
                            <div class="relative group">
                                <x-avatar :image="$image->temporaryUrl()" class="!w-full !h-32 !rounded" />
                                <x-button icon="o-trash" wire:click="removeGalleryImage({{ $index }})" spinner class="absolute top-1 right-1 btn-ghost btn-xs text-error opacity-0 group-hover:opacity-100 transition-opacity" />
                            </div>
                        @endforeach
                    </div>
                @endif
                
                {{-- Vídeos --}}
                <x-input label="URL do Vídeo (Youtube/Vimeo)" wire:model="video_url" placeholder="https://youtu.be/..." />
                <x-input label="URL do Tour Virtual" wire:model="virtual_tour_url" placeholder="https://..." />
            </div>
        </x-card>

        {{-- Seção de Comodidades --}}
        <x-card title="Comodidades" shadow separator class="mt-5">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($amenityOptions as $value => $label)
                    <x-checkbox :label="$label" wire:model="amenities" value="{{ $value }}" class="checkbox-primary" />
                @endforeach
            </div>
        </x-card>

        {{-- Botão de Submit --}}
        <div class="mt-5 flex justify-end gap-x-3">
            <x-button label="Cancelar" link="{{ route('admin.properties.index') }}" />
            <x-button label="Salvar" type="submit" icon="o-check" class="btn-primary" spinner="save" />
        </div>
    </x-form>
</div>