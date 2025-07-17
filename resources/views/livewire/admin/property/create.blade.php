@assets
<script defer type="text/javascript" src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js"></script>
@endassets

<div>
    <x-header title="Cadastrar Novo Imóvel" separator>
        <x-slot:actions>
            <x-button label="Cancelar" link="{{ route('admin.properties.index') }}" icon="o-arrow-uturn-left"
                class="btn-ghost" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit="save">
        {{-- Seção de Informações Básicas --}}
        <x-card title="Informações Básicas" shadow separator>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <x-input label="Título*" wire:model="form.title" placeholder="Ex: Casa moderna com piscina no centro" />
                <x-textarea label="Descrição*" wire:model="form.description"
                    placeholder="Descreva detalhadamente o imóvel..." rows="5" />

                <x-select label="Tipo*" wire:model="form.type" :options="$typeOptions" placeholder="Selecione o tipo..." />
                <x-select label="Finalidade*" wire:model.live="form.purpose" :options="$purposeOptions"
                    placeholder="Selecione a finalidade..." />

                <x-select label="Status*" wire:model="form.status" :options="$statusOptions"
                    placeholder="Selecione o status..." />
                <x-checkbox label="Destaque" wire:model="form.featured" class="checkbox-primary" />

                <x-input label="Preço (R$)*"  wire:model="form.price" icon="o-currency-dollar"  money locale="pt-BR" />
                <x-input label="Preço de Aluguel (R$)" wire:model="form.rent_price" icon="o-currency-dollar"
                     money locale="pt-BR" :disabled="$form->purpose === 'venda'" />
            </div>
        </x-card>

        {{-- Seção de Características --}}
        <x-card title="Características" shadow separator class="mt-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <x-input label="Quartos" wire:model="form.bedrooms" type="number" />
                <x-input label="Banheiros" wire:model="form.bathrooms" type="number" />
                <x-input label="Vagas" wire:model="form.garage_spaces" type="number" />
                <x-input label="Área (m²)" wire:model="form.area" type="number" />
                
                {{-- <x-input label="Área Total (m²)" wire:model="form.total_area" type="number" :disabled="$form->type !== 'terreno'" /> --}}
                {{-- <x-input label="Área Construída (m²)" wire:model="form.construction_area" type="number" :disabled="$form->type === 'terreno'" /> --}}
                {{-- <x-input label="Andares" wire:model="form.floors" type="number" /> --}}
                {{-- <x-input label="Ano de Construção" wire:model="form.year_built" type="number" /> --}}
            </div>
        </x-card>

        {{-- Seção de Endereço --}}
        <x-card title="Localização" shadow separator class="mt-5">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <x-input label="Logradouro*" wire:model="form.street" placeholder="Rua, Avenida, etc." />
                <x-input label="Número*" wire:model="form.number" placeholder="Número ou S/N" />
                
                <x-input label="Complemento" wire:model="form.complement" placeholder="Apto, Bloco, etc." />
                <x-input label="Bairro*" wire:model="form.neighborhood" />
                
                <x-input label="Cidade*" wire:model="form.city" />
                <x-select label="Estado*" wire:model="form.state" :options="$stateOptions" placeholder="Selecione o estado..." />
                
                <x-input label="CEP*" wire:model="form.zip_code" x-mask="99999-999" placeholder="00000-000" />
                
                {{-- <div class="grid grid-cols-2 gap-4">
                    <x-input label="Latitude" wire:model="form.latitude" type="number" step="0.000001" />
                    <x-input label="Longitude" wire:model="form.longitude" type="number" step="0.000001" />
                </div> --}}
            </div>
            
            <div class="mt-4 h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                <p class="text-gray-500">Mapa de localização será implementado aqui</p>
            </div>
        </x-card>

        {{-- Seção de Mídia --}}
        <x-card title="Mídia" shadow separator class="mt-5">
            <div class="grid grid-cols-1 gap-4">
                <x-file  label="Thumbnail (Imagem Principal)" wire:model="form.thumbnail" accept="image/png, image/jpeg" hint="Clique para enviar ou arraste uma imagem" />
                
                @if ($form->thumbnail)
                    <div class="flex items-center gap-2">
                        <x-avatar :image="$form->thumbnail->temporaryUrl()" class="!w-24 !h-24" />
                        <x-button icon="o-trash" wire:click="$set('thumbnail', null)" spinner class="btn-ghost btn-sm text-error" />
                    </div>
                @endif
                
                <x-file  label="Galeria de Imagens (Máx. 20)" wire:model="form.galleryImages" multiple accept="image/png, image/jpeg" hint="Clique para enviar ou arraste múltiplas imagens" />
                
                @if (count($form->galleryImages) > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                        @foreach ($form->galleryImages as $index => $image)
                            <div class="relative group">
                                <x-avatar :image="$image->temporaryUrl()" class="!w-full !h-32 !rounded" />
                                <x-button icon="o-trash" wire:click="removeGalleryImage({{ $index }})" spinner class="absolute top-1 right-1 btn-ghost btn-xs text-error opacity-0 group-hover:opacity-100 transition-opacity" />
                            </div>
                        @endforeach
                    </div>
                @endif
                
                {{-- <x-input label="URL do Vídeo (Youtube/Vimeo)" wire:model="form.video_url" placeholder="https://youtu.be/..." />
                <x-input label="URL do Tour Virtual" wire:model="form.virtual_tour_url" placeholder="https://..." /> --}}
            </div>
        </x-card>

        {{-- Seção de Comodidades --}}
        <x-card title="Comodidades" shadow separator class="mt-5">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach ($amenityOptions as $value => $label)
                    <x-checkbox :label="$label" wire:model="form.amenities" value="{{ $value }}" class="checkbox-primary" />
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
