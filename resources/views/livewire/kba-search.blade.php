<form action="{{ route('car-parts.search-by-code') }}">
    <div class="mb-3">
        <label for="hsn" class="form-label">HSN*</label>
        <input type="text" class="form-control" name="hsn" value="{{ old('hsn') }}" wire:model="hsn">
    </div>
    <div class="mb-3">
        <label for="hsn" class="form-label">TSN*</label>
        <input type="text" class="form-control" name="tsn" value="{{ old('tsn') }}" wire:model="tsn">
    </div>

    <div class="mb-3">
        <label for="part-type" class="form-label">Part type</label>
        <select name="part-type" class="form-select" id="part-type" wire:model="partType">
            <option disabled selected>Everything</option>
            @foreach($partTypes as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
    </div>

    <div style="margin-top: 3rem;">
        <button class="btn btn-primary w-100 uppercase">Search {{ $partCount }}</button>
    </div>
</form>
