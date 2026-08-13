<?php

namespace App\Models;

use App\Enums\PropertyStatus;
use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Property extends Model implements HasMedia
{
    use HasFactory, HasSlug, InteractsWithMedia, Searchable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'transaction_type',
        'property_type_id',
        'property_style_id',
        'price',
        'city_id',
        'address',
        'latitude',
        'longitude',
        'surface',
        'bedrooms',
        'bathrooms',
        'status',
        'featured',
        'points_of_interest',
        'submitted_by',
        'assigned_agent_id',
        'rejection_reason',
        'meta_title',
        'meta_description',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'transaction_type' => TransactionType::class,
            'status' => PropertyStatus::class,
            'featured' => 'boolean',
            'points_of_interest' => 'array',
            'price' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'published_at' => 'datetime',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Galerie photos/video du bien (module medias, gerable depuis le back-office).
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery');
    }

    /**
     * Conversions d'images pour la performance/SEO (Core Web Vitals) :
     * format WebP + tailles adaptees a chaque contexte d'affichage, plutot
     * que de servir le fichier original (potentiellement plusieurs Mo) a
     * l'identique sur toutes les tailles d'ecran.
     * ->nonQueued() : generees immediatement a l'upload, sans dependre d'un
     * worker de file d'attente actif (plus fiable en environnement local).
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('card')
            ->width(640)
            ->height(480)
            ->format('webp')
            ->quality(80)
            ->nonQueued();

        $this->addMediaConversion('detail')
            ->width(1600)
            ->format('webp')
            ->quality(85)
            ->nonQueued();
    }

    /**
     * URL d'affichage d'une conversion avec repli gracieux : si la
     * conversion demandee n'a pas ete generee (media ajoute avant son
     * enregistrement, echec de generation...), on retombe sur le fichier
     * original plutot que de casser l'affichage.
     */
    public function imageUrl(string $conversion = ''): ?string
    {
        $media = $this->getFirstMedia('gallery');

        if (! $media) {
            return null;
        }

        if ($conversion && $media->hasGeneratedConversion($conversion)) {
            return $media->getUrl($conversion);
        }

        return $media->getUrl();
    }

    /**
     * Uniquement les biens publies sont indexes pour la recherche publique.
     */
    public function shouldBeSearchable(): bool
    {
        return $this->status === PropertyStatus::Publie;
    }

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'city' => $this->city?->name,
            'property_type' => $this->propertyType?->name,
            'transaction_type' => $this->transaction_type?->value,
            'price' => (float) $this->price,
        ];
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function propertyStyle(): BelongsTo
    {
        return $this->belongsTo(PropertyStyle::class);
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function assignedAgent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_agent_id');
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }
}
