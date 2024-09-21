<?php

namespace App\Http\Livewire;

use App\Models\CarPartType;
use Livewire\Component;

class SearchForms extends Component {

    public $isSmallScreen = false;
    public $openForm = 'model'; // Default open form
    public $partTypes;

    public function mount() {
        $this->partTypes = CarPartType::all();
    }

    public function openForm($form) {
        $this->openForm = $form;
    }

    public function render() {
        return view('livewire.search-forms');
    }
}
