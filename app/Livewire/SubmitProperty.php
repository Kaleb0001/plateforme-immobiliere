<?php

namespace App\Livewire;

use App\Enums\PropertyStatus;
use App\Models\City;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
class SubmitProperty extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $description = '';
    public string $transaction_type = 'vente';
    public ?int $city_id = null;
    public ?int $property_type_id = null;
    public ?string $price = null;
    public array $photos = [];
    public bool $submitted = false;

    public function submit(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:3000'],
            'transaction_type' => ['required', 'in:vente,location'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'property_type_id' => ['nullable', 'exists:property_types,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'photos.*' => ['nullable', 'image', 'max:5120'],
        ]);

        $property = Property::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'transaction_type' => $validated['transaction_type'],
            'city_id' => $validated['city_id'],
            'property_type_id' => $validated['property_type_id'],
            'price' => $validated['price'],
            'status' => PropertyStatus::EnAttenteValidation,
            'submitted_by' => Auth::id(),
        ]);

        foreach ($this->photos as $photo) {
            $property->addMedia($photo->getRealPath())
                ->usingFileName($photo->getClientOriginalName())
                ->toMediaCollection('gallery');
        }

        $this->reset(['title', 'description', 'price', 'photos', 'city_id', 'property_type_id']);
        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.submit-property', [
            'cities' => City::orderBy('name')->get(),
            'propertyTypes' => PropertyType::orderBy('name')->get(),
        ]);
    }
}
