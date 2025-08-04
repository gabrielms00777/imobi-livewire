<?php

namespace App\Livewire\Admin\TenantSettings;

use App\Livewire\Forms\TenantSettingsForm;
use App\Models\Company;
use App\Models\TenantSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class Index extends Component
{
    use Toast, WithFileUploads; // Habilita o uso de toasts/notificações da MaryUI

    public TenantSettingsForm $form;

    public string $tab = 'general'; //'homepage'; // Para controlar a aba ativa

    /**
     * O método mount é executado quando o componente é inicializado.
     * Aqui, vamos obter as configurações do tenant logado.
     */
    public function mount(): void
    {
        $authUser = Auth::user();

        // Determina qual entidade é o "tenant" principal (Company ou User)
        // Isso depende da lógica que você definiu no cadastro.
        // Se o usuário é um 'company_admin', o tenant é a Company.
        // Se o usuário é um 'real_estate_agent', o tenant é o próprio User.
        $tenantEntity = null;
        if ($authUser->user_type === 'company_admin') {
            $tenantEntity = $authUser->company; // Assume que o user tem uma relação belongsTo com Company
        } elseif ($authUser->user_type === 'real_estate_agent') {
            $tenantEntity = $authUser; // O próprio usuário é o tenant
        }

        if (!$tenantEntity) {
            // Tratar caso onde o tipo de usuário não é reconhecido ou não tem tenant
            $this->error('Não foi possível identificar as configurações do seu site. Por favor, entre em contato com o suporte.');
            return; // Interrompe a execução
        }
        
        // Tenta encontrar as configurações existentes para este tenant (polimórfico)
        $tenantSetting = TenantSetting::firstOrNew([
            'configurable_id' => $tenantEntity->id,
            'configurable_type' => get_class($tenantEntity),
        ]);

        // Se for um novo registro, preenche com valores padrão que podem vir da entidade ou seeder
        if (!$tenantSetting->exists) {
            $tenantSetting->site_name = ($tenantEntity instanceof Company) ? $tenantEntity->name : $tenantEntity->name;
            $tenantSetting->site_description = ($tenantEntity instanceof Company) ? 'Sua imobiliária de confiança.' : 'Seu corretor de imóveis especializado.';
            // Outros defaults do TenantSetting podem ser aplicados aqui se não vierem do seeder
        }

        // Popula o formulário com os dados do TenantSetting
        $this->form->setTenantSetting($tenantSetting);
    }

    public function addEngagementMetric(): void
    {
        $this->form->addMetric();
    }

    public function removeEngagementMetric(int $index): void
    {
        $this->form->removeMetric($index);
    }

    public function addAboutFeature(): void
    {
        $this->form->addFeature();
    }

    public function removeAboutFeature(int $index): void
    {
        $this->form->removeFeature($index);
    }

    /**
     * Salva as configurações do Tenant.
     */
    public function save(): void
    {
        $this->form->save(); // Chama o método save do Form Object
        try {

            $this->success('Configurações salvas com sucesso!', redirectTo: route('admin.tenant-settings.index'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->error('Houve um erro na validação. Verifique os campos.');
            // O Livewire automaticamente exibirá os erros de validação ao lado dos campos.
        } catch (\Exception $e) {
            $this->error('Ocorreu um erro ao salvar: ' . $e->getMessage());
            Log::error('Erro ao salvar tenant settings: ' . $e->getMessage(), ['exception' => $e]);
        }
    }

    /**
     * Renderiza a view do componente.
     */
    public function render()
    {
        return view('livewire.admin.tenant-settings.index');
    }
}
