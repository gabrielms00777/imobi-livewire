<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type', 
        'creci_number', 
        'company_id', 
        'slug', 

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relação com a Imobiliária (se for um corretor vinculado)
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relação polimórfica para as configurações do site do próprio usuário (se ele for um tenant)
    public function tenantSettings(): MorphOne // Adicione esta relação
    {
        return $this->morphOne(TenantSetting::class, 'configurable');
    }

    // Relação com os imóveis cadastrados por este usuário
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
