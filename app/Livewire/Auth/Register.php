<?php

namespace App\Livewire\Auth;

use App\Models\Company;
use App\Models\User;
use App\Models\TenantSetting; // Certifique-se de que este modelo exista e seja usado para as configurações do site
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('Cadastre-se')]
#[Layout('components.layouts.auth')]
class Register extends Component
{
    // Novo campo para escolher o tipo de conta
    #[Rule('required|in:imobiliaria,corretor')]
    public string $account_type = ''; // 'imobiliaria' ou 'corretor'

    // Dados da Imobiliária (company)
    #[Rule('required_if:account_type,imobiliaria|min:3')]
    public string $company_name = '';

    #[Rule('required_if:account_type,imobiliaria')]
    public string $company_phone = '';

    #[Rule('nullable|unique:companies,email')] // Não obrigatório para corretores, mas único para imobiliárias
    public string $company_email = ''; // Separar do email do usuário para imobiliárias

    // Dados do Usuário (name, email, password) - Comuns para ambos
    #[Rule('required|min:3')]
    public string $name = ''; // Nome do corretor autônomo ou do admin da imobiliária

    #[Rule('required|email|unique:users,email')]
    public string $email = ''; // Email do corretor autônomo ou do admin da imobiliária

    #[Rule('required|min:8|confirmed')]
    public string $password = '';

    #[Rule('required')]
    public string $password_confirmation = '';

    // Dados específicos do Corretor Autônomo
    #[Rule('required_if:account_type,corretor|alpha_dash|min:5')] // Ex: 12345-F, J-12345
    public string $creci_number = '';

    // Propriedades para personalização inicial do site
    #[Rule('nullable|string')]
    public ?string $site_slogan = null;

    #[Rule('nullable|url')]
    public ?string $site_logo_url = null; // Caminho para o logo padrão, se houver

    public function mount()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        // Define um valor padrão para o tipo de conta, se quiser que um seja o inicial
        // $this->account_type = 'imobiliaria';
    }

    public function updatedAccountType()
    {
        // Reseta validações ao mudar o tipo para evitar resquícios de erros anteriores
        $this->resetValidation();
        // Opcional: você pode limpar campos específicos se a UX exigir
        // if ($this->account_type === 'corretor') {
        //     $this->company_name = '';
        //     $this->company_phone = '';
        //     $this->company_email = '';
        // } else {
        //     $this->creci_number = '';
        // }
    }

    public function register()
    {
        $this->validate(); // Valida todos os campos com base nas regras dinâmicas

        try {
            DB::transaction(function () {
                $user = null;
                $company = null;
                $slug = '';

                if ($this->account_type === 'imobiliaria') {
                    // Cria a Imobiliária
                    $company = Company::create([
                        'name' => $this->company_name,
                        'email' => $this->company_email ?: $this->email, // Usa o email da imobiliária, ou o do admin
                        'phone' => $this->company_phone,
                        'slug' => Str::slug($this->company_name), // Geração do slug
                        'slogan' => $this->site_slogan,
                        'logo' => $this->site_logo_url,
                        // Outros campos da tabela 'companies' podem ser nulos inicialmente
                    ]);

                    // Cria o usuário admin para a Imobiliária
                    $user = User::create([
                        'company_id' => $company->id,
                        'name' => $this->name,
                        'email' => $this->email,
                        'password' => Hash::make($this->password),
                        'user_type' => 'company_admin', // Define o tipo de usuário como admin da imobiliária
                        'creci_number' => null,
                        'slug' => null, // O slug da URL é da empresa, não do admin neste modelo
                    ]);

                    $ownerEntity = $company; // A entidade que "possui" as configurações do site é a Company
                    $ownerType = Company::class;

                } elseif ($this->account_type === 'corretor') {
                    // Cria o Corretor Autônomo (diretamente como User)
                    $user = User::create([
                        'company_id' => null, // Sem vínculo com imobiliária
                        'name' => $this->name,
                        'email' => $this->email,
                        'password' => Hash::make($this->password),
                        'user_type' => 'real_estate_agent', // Define o tipo de usuário como corretor autônomo
                        'creci_number' => $this->creci_number,
                        'slug' => Str::slug($this->name), // O slug da URL é do próprio corretor
                    ]);

                    $ownerEntity = $user; // A entidade que "possui" as configurações do site é o User
                    $ownerType = User::class;
                }

                // Cria as configurações iniciais do site (TenantSetting) para a entidade proprietária
                // Adaptando os campos do seu seed para a criação inicial
                if ($ownerEntity) {
                    TenantSetting::create([
                        'configurable_id' => $ownerEntity->id,
                        'configurable_type' => $ownerType,
                        'site_name' => ($ownerType === Company::class) ? $this->company_name : $this->name,
                        'site_description' => ($ownerType === Company::class) ? 'Sua imobiliária de confiança.' : 'Seu corretor de imóveis especializado.',
                        'site_logo' => $this->site_logo_url ?: null, // Use o logo default ou o que foi carregado/definido
                        // 'primary_color' => '#3B82F6', // Cor padrão, o usuário pode mudar depois
                        // 'secondary_color' => '#F59E0B',
                        'text_color' => '#1F2937',
                        'header_display_type' => 'logo_and_name',
                        'contact_phone' => ($ownerType === Company::class) ? $this->company_phone : null,
                        'contact_email' => ($ownerType === Company::class) ? $this->company_email : $this->email,
                        'contact_address' => null,
                        'social_whatsapp' => null, // Pode ser preenchido depois
                        'meta_title' => ($ownerType === Company::class) ? $this->company_name . ' Imóveis' : $this->name . ' Imóveis',
                        'meta_description' => ($ownerType === Company::class) ? 'Encontre os melhores imóveis com a ' . $this->company_name : 'Encontre seu imóvel ideal com ' . $this->name,
                        // ... outros campos podem ser nulos ou ter valores padrão
                    ]);
                }

                Auth::login($user);
                request()->session()->regenerate();
            });

            return redirect()->route('admin.dashboard'); // Ou para o painel principal
        } catch (\Exception $e) {
            $this->addError('registration', 'Ocorreu um erro durante o registro. Por favor, tente novamente: ' . $e->getMessage());
            // Log::error('Registration error: '.$e->getMessage()); // Descomente para logar erros em produção
        }
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}