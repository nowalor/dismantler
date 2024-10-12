    <form action="{{ route('car-parts.search-by-code') }}">
        <div style="text-align: left;">
            <!-- HSN Input -->
            <div class="mb-3">
                <label for="hsn" class="form-label">HSN</label>
                <input type="text" class="form-control" name="hsn" value="{{ old('hsn', $search['hsn'] ?? '') }}" wire:model="hsn">
            </div>

            <!-- TSN Input -->
            <div class="mb-3">
                <label for="tsn" class="form-label">TSN</label>
                <input type="text" class="form-control" name="tsn" value="{{ old('tsn', $search['tsn'] ?? '') }}" wire:model="tsn">
            </div>

            <!-- Part Type Selection -->
            <div class="mb-3">
                <label for="part-type" class="form-label">{{__('kba-part-type')}}</label>
                <select name="type_id" class="form-select" id="part-type" wire:model="partType">
                    <option value="-1" disabled selected>{{__('kba-search-placeholder')}}</option>
                    @foreach($partTypes as $type)
                        <option value="{{ $type->id }}" 
                            @if(isset($search['type_id']) && $type->id == $search['type_id']) selected @endif>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Search Button -->
            @if(isset($partCount) && $partCount !== -1)
                <div style="margin-top: 1rem;">
                    <button class="btn btn-primary w-100 uppercase" @if($partCount === 0) disabled @endif>
                        Search {{ $partCount }} results
                    </button>
                </div>
            @else
                <div style="margin-top: 1rem;">
                    <button class="btn btn-primary w-100 uppercase" disabled>{{__('kba-search-button')}}</button>
                </div>
            @endif
        </div>
    </form>
