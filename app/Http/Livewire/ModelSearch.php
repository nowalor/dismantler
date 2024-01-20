<?php

namespace App\Http\Livewire;

use App\Models\CarBrand;
use App\Models\CarPartType;
use App\Models\DitoNumber;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class ModelSearch extends Component
{
    public Collection $brands;
    public Collection | null $models;
    public Collection $types;

    public int $selectedBrand = -1;
    public int $selectedModel = -1;
    public int $selectedType = -1;

    public int $partCount = -1;

    public function mount(): void
    {
        $this->brands = CarBrand::all();
        $this->models = null;
        $this->types = CarPartType::all();
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
        return view('livewire.model-search');
    }

    public function getPartCount(): void
    {
        if($this->selectedModel === -1) {
            return;
        }
        $ditoNumber = DitoNumber::find($this->selectedModel);

        $sbr = $ditoNumber->sbrCodes()->first();

        if(!$sbr) {
            return;
        }

        $countQuery = $sbr->carParts();

        if($this->selectedType !== -1) {
            $type = CarPartType::find($this->selectedType);

            $countQuery->where('car_part_type_id', $type->id);
        }

        $this->partCount = $countQuery->count();
    }
}
