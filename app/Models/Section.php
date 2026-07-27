<?php

namespace App\Models;

use App\Enums\SectionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model
{
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
}
