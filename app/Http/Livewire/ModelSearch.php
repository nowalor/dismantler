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
    public Collection|null $models;
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
        // Reset Model and Type dropdowns when Brand changes
        $this->selectedModel = -1;
        $this->selectedType = -1;

        // Load models related to the selected brand
        $brand = CarBrand::find($this->selectedBrand);
        $this->models = $brand ? DitoNumber::where('producer', $brand->name)->get() : null;

        // Reset part count
        $this->partCount = -1;
    }

    public function updatedSelectedModel(): void
    {
        // Recalculate part count whenever the model changes
        $this->getPartCount();
    }

    public function updatedSelectedType(): void
    {
        // Recalculate part count whenever the type changes
        $this->getPartCount();
    }

    public function getPartCount(): void
    {
        if ($this->selectedModel === -1) {
            $this->partCount = -1;
            return;
        }

        $ditoNumber = DitoNumber::find($this->selectedModel);

        if (!$ditoNumber) {
            $this->partCount = 0;
            return;
        }

        $sbr = $ditoNumber->sbrCodes()->first();

        if (!$sbr) {
            $this->partCount = 0;
            return;
        }

        $countQuery = $sbr->carParts();

        if ($this->selectedType !== -1) {
            $type = CarPartType::find($this->selectedType);
            $countQuery->where('car_part_type_id', $type->id);
        }

        $this->partCount = $countQuery->count();
    }

    public function render(): View
    {
        return view('livewire.model-search');
    }
}
