<?php

namespace App\Http\Livewire;

use App\Models\CarPartType;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class SearchForms extends Component {

    public $isSmallScreen = false;
    public $openForm = 'model'; // Default open form
    public $partTypes;

    public function mount() {
        $this->partTypes = Cache::remember('car_part_types', 86400, fn () => CarPartType::all());
    }

    public function openForm($form) {
        $this->openForm = $form;
    }

    public function render() {
        return view('livewire.search-forms');
    }
}
