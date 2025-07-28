<?php

namespace App\Livewire\Admin\Property;

use App\Livewire\Forms\Admin\PropertyForm;
use App\Models\Property;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;
use Spatie\MediaLibrary\MediaCollections\Models\Media; // Import para o modelo Media

class Edit extends Component
{
    use Toast, WithFileUploads;

    public PropertyForm $form;

    // Opções para selects e checkboxes (inicializadas no mount)
    public array $typeOptions;
    public array $purposeOptions;
    public array $statusOptions;
    public array $amenityOptions;
    public array $stateOptions;

    // Propriedades para lidar com novos uploads de arquivos temporários
    public array $newlyUploadedImages = [];
    public ?int $principalNewImageIndex = null;

    /**
     * O método mount é executado quando o componente é inicializado.
     * @param Property $property A instância do modelo Property (via Route Model Binding).
     * @return void
     */
    public function mount(Property $property): void
    {
        // Define a instância da propriedade no objeto de formulário
        $this->form->setProperty($property);

        // Inicializa as opções dos selects/checkboxes (idêntico ao Create.php)
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
            'seguranca_24h' => 'Segurança 24h',
            'portaria' => 'Portaria',
            'elevador' => 'Elevador',
            'mobiliado' => 'Mobiliado',
            'ar_condicionado' => 'Ar Condicionado',
            'lareira' => 'Lareira',
            'sacada' => 'Sacada',
            'quadra_esportiva' => 'Quadra Esportiva',
            'salao_festas' => 'Salão de Festas',
            'jardim' => 'Jardim',
            'vista_mar' => 'Vista para o Mar',
            'vista_cidade' => 'Vista para a Cidade',
            'closet' => 'Closet',
            'escritorio' => 'Escritório',
            'area_servico' => 'Área de Serviço',
            'copa' => 'Copa',
            'despensa' => 'Despensa',
            'lavabo' => 'Lavabo',
            'dependencia_empregada' => 'Dependência de Empregada',
            'interfone' => 'Interfone',
            'portao_eletronico' => 'Portão Eletrônico',
            'gas_encanado' => 'Gás Encanado',
            'energia_solar' => 'Energia Solar',
            'aquecimento_solar' => 'Aquecimento Solar',
            'gerador_energia' => 'Gerador de Energia',
            'acesso_deficientes' => 'Acesso para Deficientes',
            'guarita' => 'Guarita',
            'brinquedoteca' => 'Brinquedoteca',
            'deck' => 'Deck',
            'sauna' => 'Sauna',
            'sala_ginastica' => 'Sala de Ginástica',
            'espaco_gourmet' => 'Espaço Gourmet',
            'sala_jogos' => 'Sala de Jogos',
            'salao_beleza' => 'Salão de Beleza',
            'hidromassagem' => 'Hidromassagem',
            'piso_laminado' => 'Piso Laminado',
            'piso_porcelanato' => 'Piso Porcelanato',
            'armarios_embutidos' => 'Armários Embutidos',
            'sistema_alarme' => 'Sistema de Alarme',
            'cerca_eletrica' => 'Cerca Elétrica',
            'cameras_seguranca' => 'Câmeras de Segurança',
            'cozinha_americana' => 'Cozinha Americana',
            'edicula' => 'Edícula',
            'quintal' => 'Quintal',
            'pomar' => 'Pomar',
            'horta' => 'Horta',
            'lago' => 'Lago',
            'rio' => 'Rio',
            'nascente' => 'Nascente',
            'poco_artesiano' => 'Poço Artesiano',
            'topografia_plana' => 'Topografia Plana',
            'topografia_aclive' => 'Topografia Aclive',
            'topografia_declive' => 'Topografia Declive',
            'area_verde' => 'Área Verde',
            'permite_animais' => 'Permite Animais',
            'condominio_fechado' => 'Condomínio Fechado',
            'reserva_legal' => 'Reserva Legal',
            'planta_aprovada' => 'Planta Aprovada',
            'rua_asfaltada' => 'Rua Asfaltada',
            'iluminacao_publica' => 'Iluminação Pública',
            'saneamento_basico' => 'Saneamento Básico',
            'agua' => 'Água',
            'esgoto' => 'Esgoto',
            'pavimentacao' => 'Pavimentação',
            'rede_eletrica' => 'Rede Elétrica',
            'transporte_publico_proximo' => 'Transporte Público Próximo',
            'escolas_proximo' => 'Escolas Próximo',
            'hospitais_proximo' => 'Hospitais Próximo',
            'comercios_proximo' => 'Comércios Próximo',
            'parques_proximo' => 'Parques Próximo',
            'praca_proximo' => 'Praça Próximo',
            'ciclovia_proximo' => 'Ciclovia Próximo',
            'restaurantes_proximo' => 'Restaurantes Próximo',
            'farmacias_proximo' => 'Farmácias Próximo',
            'supermercados_proximo' => 'Supermercados Próximo',
            'shoppings_proximo' => 'Shoppings Próximo',
        ];

        $this->stateOptions = [
            ['id' => 'AC', 'name' => 'Acre'],
            ['id' => 'AL', 'name' => 'Alagoas'],
            ['id' => 'AP', 'name' => 'Amapá'],
            ['id' => 'AM', 'name' => 'Amazonas'],
            ['id' => 'BA', 'name' => 'Bahia'],
            ['id' => 'CE', 'name' => 'Ceará'],
            ['id' => 'DF', 'name' => 'Distrito Federal'],
            ['id' => 'ES', 'name' => 'Espírito Santo'],
            ['id' => 'GO', 'name' => 'Goiás'],
            ['id' => 'MA', 'name' => 'Maranhão'],
            ['id' => 'MT', 'name' => 'Mato Grosso'],
            ['id' => 'MS', 'name' => 'Mato Grosso do Sul'],
            ['id' => 'MG', 'name' => 'Minas Gerais'],
            ['id' => 'PA', 'name' => 'Pará'],
            ['id' => 'PB', 'name' => 'Paraíba'],
            ['id' => 'PR', 'name' => 'Paraná'],
            ['id' => 'PE', 'name' => 'Pernambuco'],
            ['id' => 'PI', 'name' => 'Piauí'],
            ['id' => 'RJ', 'name' => 'Rio de Janeiro'],
            ['id' => 'RN', 'name' => 'Rio Grande do Norte'],
            ['id' => 'RS', 'name' => 'Rio Grande do Sul'],
            ['id' => 'RO', 'name' => 'Rondônia'],
            ['id' => 'RR', 'name' => 'Roraima'],
            ['id' => 'SC', 'name' => 'Santa Catarina'],
            ['id' => 'SP', 'name' => 'São Paulo'],
            ['id' => 'SE', 'name' => 'Sergipe'],
            ['id' => 'TO', 'name' => 'Tocantins'],
        ];
    }

    /**
     * Salva as alterações na propriedade existente.
     * Este método orquestra a atualização do formulário e o gerenciamento de mídias.
     */
    public function save(): void
    {
        try {
            // Salva os dados principais do imóvel usando o objeto de formulário
            // O form->save() irá atualizar a propriedade existente neste caso.
            $property = $this->form->save();

            // Lida com novos uploads de mídia
            if (!empty($this->newlyUploadedImages)) {
                // Se uma nova imagem principal for definida, remove a antiga miniatura principal
                if ($this->principalNewImageIndex !== null && $property->getFirstMedia('thumbnails')) {
                    $property->getFirstMedia('thumbnails')->delete();
                }

                foreach ($this->newlyUploadedImages as $index => $file) {
                    if ($this->principalNewImageIndex === $index) {
                        // Esta é a nova imagem principal
                        $property->addMedia($file)->toMediaCollection('thumbnails');
                    } else {
                        // Estas são novas imagens da galeria
                        $property->addMedia($file)->toMediaCollection('gallery');
                    }
                }
            }

            // Após salvar, recarrega as coleções de mídia existentes do formulário
            // para refletir as alterações (ex: se uma nova principal foi definida, a antiga deve desaparecer)
            $this->form->loadExistingMedia();

            $this->success('Imóvel atualizado com sucesso!', redirectTo: route('admin.properties.index'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->error('Houve um erro na validação. Verifique os campos.');
            Log::error('Validation Error updating property: ' . $e->getMessage(), ['errors' => $e->errors()]);
        } catch (\Exception $e) {
            $this->error('Ocorreu um erro ao atualizar o imóvel: ' . $e->getMessage());
            Log::error('Error updating property: ' . $e->getMessage(), ['exception' => $e]);
        }
    }

    /**
     * Remove um item de mídia existente (miniatura ou imagem da galeria).
     * @param int $mediaId O ID do item de mídia a ser removido.
     * @return void
     */
    public function removeMedia(int $mediaId): void
    {
        if ($this->form->property) {
            try {
                $media = Media::find($mediaId);
                // Garante que a mídia pertence a esta propriedade antes de excluir
                if ($media && $media->model_id === $this->form->property->id) {
                    $media->delete();
                    $this->form->loadExistingMedia(); // Recarrega as mídias existentes após a exclusão
                    $this->success('Imagem removida com sucesso!');
                } else {
                    $this->error('Mídia não encontrada ou não pertence a este imóvel.');
                }
            } catch (\Exception $e) {
                $this->error('Erro ao remover imagem: ' . $e->getMessage());
                Log::error('Error removing media: ' . $e->getMessage(), ['exception' => $e]);
            }
        } else {
            $this->error('Erro: Imóvel não carregado.');
        }
    }

    /**
     * Define uma imagem da galeria existente como a miniatura principal.
     * @param int $mediaId O ID do item de mídia a ser definido como principal.
     * @return void
     */
    public function setMediaAsPrincipal(int $mediaId): void
    {
        if ($this->form->property) {
            try {
                $property = $this->form->property;
                $newPrincipalMedia = Media::find($mediaId);

                if ($newPrincipalMedia && $newPrincipalMedia->model_id === $property->id && $newPrincipalMedia->collection_name === 'gallery') {
                    // 1. Obtém a miniatura principal atual (se existir)
                    $currentThumbnail = $property->getFirstMedia('thumbnails');

                    // 2. Limpa a seleção de nova imagem principal (se houver uma selecionada de novos uploads)
                    $this->principalNewImageIndex = null;

                    // 3. Move a miniatura atual para a galeria (se existir)
                    if ($currentThumbnail) {
                        $currentThumbnail->move($property, 'gallery');
                    }

                    // 4. Move a imagem selecionada da galeria para as miniaturas
                    $newPrincipalMedia->move($property, 'thumbnails');

                    // 5. Recarrega as mídias existentes no formulário para atualizar a UI
                    $this->form->loadExistingMedia();

                    $this->success('Imagem definida como principal com sucesso!');
                } else {
                    $this->error('Mídia inválida para definir como principal.');
                }
            } catch (\Exception $e) {
                $this->error('Erro ao definir imagem como principal: ' . $e->getMessage());
                Log::error('Error setting media as principal: ' . $e->getMessage(), ['exception' => $e]);
            }
        } else {
            $this->error('Erro: Imóvel não carregado.');
        }
    }

    /**
     * Renderiza a view do componente.
     */
    public function render()
    {
        return view('livewire.admin.property.edit');
    }
}