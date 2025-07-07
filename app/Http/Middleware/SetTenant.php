<?php

namespace App\Http\Middleware;

use App\Models\Company;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $tenantSlug = $request->route('tenantSlug');
        if (!$tenantSlug) {
            // Este caso seria para o site principal da plataforma, se você tiver um.
            // Por enquanto, vamos considerar um erro se não houver slug, já que todas as rotas esperam um.
            abort(404, 'Tenant não especificado na URL.');
        }

        // Tenta encontrar o tenant pela coluna 'slug'
        $tenant = Company::where('slug', $tenantSlug)->first();

        // Se não encontrar como Company, tenta como User (Corretor Autônomo)
        if (!$tenant) {
            $tenant = User::where('slug', $tenantSlug)
                          ->where('user_type', 'real_estate_agent') // Apenas corretores autônomos com slug
                          ->first();
        }

        if (!$tenant) {
            abort(404, 'Tenant não encontrado para o slug: ' . $tenantSlug);
        }

        // Armazena o tenant no container de serviços
        app()->instance('tenant', $tenant);

        // Carrega as configurações do tenant
        $tenant->load('tenantSettings');

        return $next($request);
    }
}
