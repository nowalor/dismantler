<?php

namespace App\Http\Livewire;

use App\Models\CarBrand;
use App\Models\CarModel;
use App\Models\DitoNumber;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class CarModelDropdowns extends Component
{
    public Collection $brands;
    public Collection | null $models;

    public int $selectedBrand = -1;

    public function mount(): void
    {
        $this->brands = CarBrand::all();
        $this->models = null;
    }

    public function changeBrand(): void
    {
        $brand = CarBrand::find($this->selectedBrand);

        $models = DitoNumber::where('producer', $brand->name)
            ->get();

        $this->models = $models;
    }

    public function render(): View
    {
        return view('livewire.car-model-dropdowns');
    }
}
