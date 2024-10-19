<?php

namespace App\Http\Livewire;

use App\Models\GermanDismantler;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class KbaSearch extends Component
{
    public Collection $partTypes;

    public string $hsn = "";
    public string $tsn = "";
    public int | null $partType = -1;

    protected array $rules = [
        'hsn' => 'required|size:4',
        'tsn' => 'required|size:3',
    ];

    public int $partCount = -1;

    public function render()
    {
        return view('livewire.kba-search');
    }

    public function updated($property)
    {
//        $this->validateOnly($property);

        $this->handleCount();
    }

    public function handleCount(): void
    {
        // Check if tsn and hsn are fully provided (HSN: 4 digits, TSN: 3 digits)
        if(strlen($this->tsn) !== 3 || strlen($this->hsn) !== 4) {
            return; // Don't proceed if both HSN and TSN are not fully entered
        }

        $kba = GermanDismantler::where("hsn", $this->hsn)
            ->where("tsn", $this->tsn)
            ->first();

        if(!$kba) {
            $this->emit('noResultsFound'); // Emit event to show modal if no KBA is found
            return;
        }

        $query = $kba->newCarParts();

        if($this->partType !== -1) {
            $query = $query->where('car_part_type_id', $this->partType);
        }

        $this->partCount = $query->count();

        if ($this->partCount === 0) {
            $this->emit('noResultsFound'); // Emit event to show modal if no parts found
        }
    }
}
