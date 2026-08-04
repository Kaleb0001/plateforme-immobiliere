<?php

namespace App\Livewire;

use App\Enums\PropertyStatus;
use App\Models\City;
use App\Models\Property;
use App\Models\PropertyStyle;
use App\Models\PropertyType;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class PropertySearch extends Component
{
    use WithPagination;

    #[Url]
    public string $transaction = 'location';

    #[Url]
    public ?int $city_id = null;

    #[Url]
    public ?int $property_type_id = null;

    #[Url]
    public ?int $property_style_id = null;

    #[Url]
    public ?string $price_min = null;

    #[Url]
    public ?string $price_max = null;

    public function updated(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['city_id', 'property_type_id', 'property_style_id', 'price_min', 'price_max']);
        $this->resetPage();
    }

    public function render()
    {
        $properties = Property::query()
            ->where('status', PropertyStatus::Publie->value)
            ->where('transaction_type', $this->transaction)
            ->when($this->city_id, fn ($q) => $q->where('city_id', $this->city_id))
            ->when($this->property_type_id, fn ($q) => $q->where('property_type_id', $this->property_type_id))
            ->when($this->property_style_id, fn ($q) => $q->where('property_style_id', $this->property_style_id))
            ->when($this->price_min, fn ($q) => $q->where('price', '>=', $this->price_min))
            ->when($this->price_max, fn ($q) => $q->where('price', '<=', $this->price_max))
            ->latest('id')
            ->paginate(9);

        return view('livewire.property-search', [
            'properties' => $properties,
            'cities' => City::orderBy('name')->get(),
            'propertyTypes' => PropertyType::orderBy('name')->get(),
            'propertyStyles' => PropertyStyle::orderBy('name')->get(),
        ]);
    }
}
