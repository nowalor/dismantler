<?php

namespace App\Http\Livewire;

use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class CarModelDropdowns extends Component
{
    public Collection $brands;
    public Collection $models;

    public int $selectedBrand = -1;

    public function mount(): void
    {
        $this->models = CarModel::all();
        $this->brands = CarBrand::all();
    }

    public function changeBrand(): void
    {
        $this->models = CarModel::where('car_brand_id', $this->selectedBrand)->get();
    }

    public function render(): View
    {
        return view('livewire.car-model-dropdowns');
    }
}