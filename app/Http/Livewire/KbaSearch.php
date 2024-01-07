<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class KbaSearch extends Component
{
    public Collection $partTypes;

    public string $hsn = "";
    public string $tsn = "";
    public int | null $partType = null;

    // Error states
    public string $hsnError = "";
    public string $tsnError = "";

    public function render()
    {
        return view('livewire.kba-search');
    }

    public function handleValidate(): void
    {
        if(strlen($this->hsn) !== 4) {
            $this->hsnError = 'HSN must be 4 characters';
        }

        if(strlen($this->tsn) !== 3) {
            $this->tsnError = 'TSN must be 3 characters';
        }
    }
}
