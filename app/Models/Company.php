<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slogan',
        'logo',
        'address',
        'phone',
        'email',
        'website',
        'commission_rate',
        'description',
        'slug', 
    ];

    // Relação com os usuários vinculados a esta imobiliária
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relação com os imóveis pertencentes a esta imobiliária
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    // Relação polimórfica para as configurações do site da própria imobiliária (se ela for um tenant)
    public function tenantSettings(): MorphOne
    {
        return $this->morphOne(TenantSetting::class, 'configurable');
    }
}
