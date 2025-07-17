<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;

class Property extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\PropertyFactory> */
    // use SoftDeletes;
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'company_id',
        'title',
        'slug',
        'description',
        'price',
        'rent_price',
        'currency',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'zip_code',
        'type',
        'purpose',
        'bedrooms',
        'bathrooms',
        'suites', // Adicionado
        'area',
        'total_area',
        'construction_area',
        'floors',
        'year_built',
        'garage_spaces',
        'amenities',
        'status',
        'featured',
        'latitude',
        'longitude',
        'video_url',
        'virtual_tour_url',
        // 'highlights', // Se você adicionar essa coluna
    ];

    protected $casts = [
        'amenities' => 'array', // ESSENCIAL: Garante que amenities seja tratado como array
        'price' => 'float', // Boa prática
        'rent_price' => 'float', // Boa prática
        'area' => 'float',
        'total_area' => 'float',
        'construction_area' => 'float',
        'featured' => 'boolean',
        // 'highlights' => 'array', // Se você adicionar essa coluna
    ];

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Métodos para MediaLibrary (opcional, mas bom para organização)
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnails')
            ->singleFile(); // Apenas uma imagem principal

        $this->addMediaCollection('gallery'); // Múltiplas imagens para galeria
    }

    // protected $fillable = [
    //     'user_id',
    //     'company_id',
    //     'title',
    //     'description',
    //     'price',
    //     'address',
    //     'city',
    //     'state',
    //     'zip_code',
    //     'property_type',
    //     'transaction_type',
    //     'bedrooms',
    //     'bathrooms',
    //     'suites',
    //     'area',
    //     'garage_spaces',
    //     'amenities',
    //     'status',
    //     'is_featured',
    //     'main_image_url',
    // ];

    // protected $casts = [
    //     'price' => 'float',
    //     'area' => 'float',
    //     'is_featured' => 'boolean',
    //     'amenities' => 'array',
    // ];

    // // Relação com o usuário que cadastrou (corretor)
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // // Relação com a imobiliária proprietária do imóvel
    // public function company()
    // {
    //     return $this->belongsTo(Company::class);
    // }

    // protected $fillable = [
    //     'title',
    //     'slug',
    //     'description',
    //     'type',
    //     'purpose',
    //     'status',
    //     'price',
    //     'rent_price',
    //     'currency',
    //     'bedrooms',
    //     'bathrooms',
    //     'garage_spaces',
    //     'area',
    //     'total_area',
    //     'construction_area',
    //     'floors',
    //     'year_built',
    //     'street',
    //     'number',
    //     'complement',
    //     'neighborhood',
    //     'city',
    //     'state',
    //     'zip_code',
    //     'latitude',
    //     'longitude',
    //     'featured',
    //     'video_url',
    //     'virtual_tour_url',
    //     'amenities',
    //     'meta_title',
    //     'meta_description',
    //     'user_id'
    // ];

    // protected $casts = [
    //     'amenities' => 'array',
    //     'featured' => 'boolean',
    //     'price' => 'decimal:2',
    //     'rent_price' => 'decimal:2',
    // ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->slug = Str::slug($model->title);
    //     });

    //     static::updating(function ($model) {
    //         // Opcional: só atualiza o slug se o título mudou
    //         if ($model->isDirty('title')) {
    //             $model->slug = Str::slug($model->title);
    //         }
    //     });
    // }

    // Relacionamentos
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // Media collections
    // public function registerMediaCollections(): void
    // {
    //     $this->addMediaCollection('gallery')
    //         ->useDisk('properties')
    //         ->withResponsiveImages();

    //     $this->addMediaCollection('thumbnails')
    //         ->useDisk('properties')
    //         ->singleFile()
    //         ->withResponsiveImages();
    // }

    // Scopes
    // public function scopeAvailable($query)
    // {
    //     return $query->where('status', 'disponivel');
    // }

    // public function scopeFeatured($query)
    // {
    //     return $query->where('featured', true);
    // }

    // // Acessores
    // public function getFormattedPriceAttribute()
    // {
    //     return 'R$ ' . number_format($this->price, 2, ',', '.');
    // }

    // public function getFormattedRentPriceAttribute()
    // {
    //     return $this->rent_price ? 'R$ ' . number_format($this->rent_price, 2, ',', '.') : null;
    // }

    // public function getFullAddressAttribute()
    // {
    //     return "{$this->street}, {$this->number}" . ($this->complement ? " - {$this->complement}" : "") .
    //         ", {$this->neighborhood}, {$this->city} - {$this->state}";
    // }

    // public function getMainImageAttribute()
    // {
    //     return $this->getFirstMediaUrl('thumbnails') ?: '/placeholder-property.jpg';
    // }
}
