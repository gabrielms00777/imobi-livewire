<?php

namespace App\Livewire\Admin\Property;

use App\Livewire\Forms\Admin\PropertyForm; // Importa o Form Object
use App\Models\Property; // Pode ser necessário para tipagem ou outras operações
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads; // Mantenha este trait AQUI!
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast, WithFileUploads; // Habilita o uso de toasts/notificações da MaryUI e uploads de arquivos

    public PropertyForm $form; // Declara a propriedade do formulário

    // Propriedade para controlar a visibilidade do modal de mídia
    public bool $showMediaModal = false;

    // Opções para selects e checkboxes (inicializadas aqui, pois são dados de UI/apresentação)
    public array $typeOptions;
    public array $purposeOptions;
    public array $statusOptions;
    public array $amenityOptions;
    public array $stateOptions;

    /**
     * O método mount é executado quando o componente é inicializado.
     * Usado para inicializar opções de UI e carregar dados para edição.
     * @param Property|null $property Instância do imóvel se estiver editando.
     */
    public function mount(): void
    {
        $this->form->existingThumbnails = collect();
        $this->form->existingGalleryImages = collect()->toArray();
        
        $this->typeOptions = [
            ['id' => 'casa', 'name' => 'Casa'],
            ['id' => 'apartamento', 'name' => 'Apartamento'],
            ['id' => 'terreno', 'name' => 'Terreno'],
            ['id' => 'comercial', 'name' => 'Comercial'],
            ['id' => 'outro', 'name' => 'Outro']
        ];
        $this->purposeOptions = [
            ['id' => 'venda', 'name' => 'Venda'],
            ['id' => 'aluguel', 'name' => 'Aluguel'],
            ['id' => 'ambos', 'name' => 'Venda e Aluguel']
        ];
        $this->statusOptions = [
            ['id' => 'disponivel', 'name' => 'Disponível'],
            ['id' => 'vendido', 'name' => 'Vendido'],
            ['id' => 'alugado', 'name' => 'Alugado'],
            ['id' => 'rascunho', 'name' => 'Rascunho']
        ];
        $this->amenityOptions = [
            'piscina' => 'Piscina',
            'churrasqueira' => 'Churrasqueira',
            'academia' => 'Academia',
            'varanda' => 'Varanda',
            'portaria-24h' => 'Portaria 24h',
            'salao-de-festas' => 'Salão de Festas',
            'playground' => 'Playground',
            'elevador' => 'Elevador',
            'moveis-planejados' => 'Móveis Planejados',
            'area-servico' => 'Área de Serviço',
        ];
        $this->stateOptions = [
            ['id' => 'AC', 'name' => 'Acre'], ['id' => 'AL', 'name' => 'Alagoas'],
            ['id' => 'AP', 'name' => 'Amapá'], ['id' => 'AM', 'name' => 'Amazonas'],
            ['id' => 'BA', 'name' => 'Bahia'], ['id' => 'CE', 'name' => 'Ceará'],
            ['id' => 'DF', 'name' => 'Distrito Federal'], ['id' => 'ES', 'name' => 'Espírito Santo'],
            ['id' => 'GO', 'name' => 'Goiás'], ['id' => 'MA', 'name' => 'Maranhão'],
            ['id' => 'MT', 'name' => 'Mato Grosso'], ['id' => 'MS', 'name' => 'Mato Grosso do Sul'],
            ['id' => 'MG', 'name' => 'Minas Gerais'], ['id' => 'PA', 'name' => 'Pará'],
            ['id' => 'PB', 'name' => 'Paraíba'], ['id' => 'PR', 'name' => 'Paraná'],
            ['id' => 'PE', 'name' => 'Pernambuco'], ['id' => 'PI', 'name' => 'Piauí'],
            ['id' => 'RJ', 'name' => 'Rio de Janeiro'], ['id' => 'RN', 'name' => 'Rio Grande do Norte'],
            ['id' => 'RS', 'name' => 'Rio Grande do Sul'], ['id' => 'RO', 'name' => 'Rondônia'],
            ['id' => 'RR', 'name' => 'Roraima'], ['id' => 'SC', 'name' => 'Santa Catarina'],
            ['id' => 'SP', 'name' => 'São Paulo'], ['id' => 'SE', 'name' => 'Sergipe'],
            ['id' => 'TO', 'name' => 'Tocantins'], // Corrigido 'Tocantin' para 'Tocantins'
        ];
    }

    /**
     * Abre o modal de adição de mídia.
     * Limpa quaisquer uploads temporários prévios no form.
     * @return void
     */
    public function openMediaModal(): void
    {
        $this->form->reset(['newThumbnail', 'newGalleryImages', 'isNewImagePrincipal', 'principalImageIndex']);
        $this->showMediaModal = true;
    }

    /**
     * Fecha o modal de adição de mídia.
     * @return void
     */
    public function closeMediaModal(): void
    {
        $this->showMediaModal = false;
        $this->form->reset(['newThumbnail', 'newGalleryImages', 'isNewImagePrincipal', 'principalImageIndex']); // Limpa uploads temporários ao fechar
    }

    /**
     * Salva as novas imagens que foram selecionadas no modal.
     * Este método é chamado pelo Alpine.js após a seleção de arquivos no modal.
     * A validação e o salvamento real da mídia são feitos no Form Object.
     * @return void
     */
    public function saveNewMediaFromModal(): void
    {
        try {
            // A validação 'newGalleryImages.*' também é executada aqui pelo Livewire
            // antes de passar os arquivos para o Form Object se estiver no rules() do Form Object.
            // Se preferir validação específica de upload aqui:
            $this->validate([
                'form.newThumbnail' => 'nullable|image|max:2048',
                'form.newGalleryImages.*' => 'nullable|image|max:2048',
            ]);

            // Se o imóvel ainda não existe, salva o imóvel primeiro
            if (!$this->form->property || !$this->form->property->exists) {
                // Valida e salva os dados básicos do imóvel primeiro
                $this->form->validate();
                $this->form->save(); // Isso vai criar o imóvel e anexá-lo ao $this->form->property
            }

            // Agora que o imóvel existe (ou foi criado), o método save() do Form Object
            // pode lidar com o upload das mídias.
            $this->form->save(); // O método save() do form agora lida com os uploads de mídia

            $this->success('Mídia adicionada com sucesso!', position: 'toast-top');
            $this->closeMediaModal();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->error('Erro de validação ao adicionar mídia. Verifique os campos.', position: 'toast-top');
            // Os erros serão exibidos automaticamente ao lado dos campos do formulário
        } catch (\Exception $e) {
            $this->error('Ocorreu um erro ao adicionar mídia: ' . $e->getMessage(), position: 'toast-top');
            Log::error('Erro ao adicionar mídia no componente Create: ' . $e->getMessage(), ['exception' => $e]);
        }
    }

    /**
     * Remove uma imagem existente do imóvel.
     * Chama o método removeMedia do Form Object.
     * @param int $mediaId
     * @return void
     */
    public function removeMedia(int $mediaId): void
    {
        try {
            $this->form->removeMedia($mediaId);
            $this->success('Imagem removida com sucesso!', position: 'toast-top');
        } catch (\Exception $e) {
            $this->error('Erro ao remover imagem: ' . $e->getMessage(), position: 'toast-top');
            Log::error('Erro ao remover imagem no componente Create: ' . $e->getMessage(), ['media_id' => $mediaId, 'exception' => $e]);
        }
    }

    /**
     * Define uma imagem existente como principal.
     * Chama o método setMediaAsPrincipal do Form Object.
     * @param int $mediaId
     * @return void
     */
    public function setMediaAsPrincipal(int $mediaId): void
    {
        try {
            $this->form->setMediaAsPrincipal($mediaId);
            $this->success('Imagem definida como principal!', position: 'toast-top');
        } catch (\Exception $e) {
            $this->error('Erro ao definir imagem como principal: ' . $e->getMessage(), position: 'toast-top');
            Log::error('Erro ao definir imagem principal no componente Create: ' . $e->getMessage(), ['media_id' => $mediaId, 'exception' => $e]);
        }
    }

    /**
     * Salva as informações gerais do formulário.
     * Chama o método save do Form Object.
     * @return void
     */
    public function save(): void
    {
        try {
            $this->form->save(); // O form->save() agora também lida com as mídias temporárias

            $message = $this->form->property->wasRecentlyCreated ? 'Imóvel criado com sucesso!' : 'Imóvel atualizado com sucesso!';
            $this->success($message, redirectTo: route('admin.properties.index'), position: 'toast-top');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->error('Houve um erro na validação. Verifique os campos.', position: 'toast-top');
            // O Livewire automaticamente exibirá os erros de validação ao lado dos campos.
        } catch (\Exception $e) {
            $this->error('Ocorreu um erro ao salvar: ' . $e->getMessage(), position: 'toast-top');
            Log::error('Erro ao salvar imóvel no componente Create: ' . $e->getMessage(), ['exception' => $e]);
        }
    }

    /**
     * Renderiza a view do componente.
     */
    public function render()
    {
        return view('livewire.admin.property.create');
    }
}