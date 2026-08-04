<?php

namespace App\Livewire;

use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FavoriteButton extends Component
{
    public Property $property;
    public bool $isFavorited = false;

    public function mount(Property $property): void
    {
        $this->property = $property;
        $this->isFavorited = Auth::check()
            && $this->property->favoritedBy()->wherePivot('user_id', Auth::id())->exists();
    }

    public function toggle()
    {
        if (! Auth::check()) {
            return $this->redirect(route('login'));
        }

        if ($this->isFavorited) {
            $this->property->favoritedBy()->detach(Auth::id());
        } else {
            $this->property->favoritedBy()->attach(Auth::id());
        }

        $this->isFavorited = ! $this->isFavorited;
    }

    public function render()
    {
        return view('livewire.favorite-button');
    }
}
