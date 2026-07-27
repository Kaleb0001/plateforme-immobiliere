<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    protected $fillable = ['slug', 'meta_title', 'meta_description'];

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->orderBy('order');
    }
}
