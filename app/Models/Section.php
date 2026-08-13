<?php

namespace App\Models;

use App\Enums\SectionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Section extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['page_id', 'type', 'order', 'config', 'visible'];

    protected function casts(): array
    {
        return [
            'type' => SectionType::class,
            'config' => 'array',
            'visible' => 'boolean',
        ];
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Photo de fond optionnelle (hero, footer). Une seule image par section
     * ("background_image"), remplacee automatiquement en cas de nouvel
     * upload (singleFile). Les vues appliquent un degrade de reserve tant
     * qu'aucune photo n'est definie.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('background_image')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('banner')
            ->width(2400)
            ->format('webp')
            ->quality(80)
            ->nonQueued();
    }

    /**
     * URL de la photo de fond avec repli gracieux sur l'original si la
     * conversion n'a pas encore ete generee.
     */
    public function backgroundImageUrl(string $conversion = 'banner'): ?string
    {
        $media = $this->getFirstMedia('background_image');

        if (! $media) {
            return null;
        }

        if ($conversion && $media->hasGeneratedConversion($conversion)) {
            return $media->getUrl($conversion);
        }

        return $media->getUrl();
    }
}
