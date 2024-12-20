<form action="{{ route('car-parts.search-by-code') }}">
    <div>
        <!-- HSN Input with Icon -->
        <div class="mb-3 mt-2 position-relative">
            <input type="text" id="hsn" class="form-control" name="hsn" 
                   value="{{ old('hsn', $search['hsn'] ?? '') }}" 
                   wire:model="hsn" maxLength="4" 
                   placeholder="Geben Sie HSN ein" 
                   style="border: 1px solid #ccc; border-radius: 12px; padding: 10px; padding-right: 40px;">
            <span class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                <i class="fas fa-barcode" style="color: #ccc;"></i>
            </span>
        </div>

        <!-- TSN Input with Icon -->
        <div class="mb-3 position-relative">
            <input type="text" id="tsn" class="form-control" name="tsn" 
                   value="{{ old('tsn', $search['tsn'] ?? '') }}" 
                   wire:model="tsn" maxLength="3" 
                   placeholder="Geben Sie TSN ein" 
                   style="border: 1px solid #ccc; border-radius: 12px; padding: 10px; padding-right: 40px;">
            <span class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                <i class="fas fa-barcode" style="color: #ccc;"></i>
            </span>
        </div>

        <!-- Part Type Dropdown -->
        <div class="mb-3">
            <select name="type_id" class="form-select" id="part-type" 
                    wire:model="partType" 
                    style="border: 1px solid #ccc; border-radius: 12px; padding: 10px;">
                <option value="-1" disabled selected>{{ __('kba-search-placeholder') }}</option>
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
            <div class="d-flex justify-content-center mt-3">
                <button class="btn btn-success text-uppercase"
                        style="padding: 8px 20px; border-radius: 12px; background-color: #28a745; border: none; color: white;" 
                        @if($partCount === 0) disabled @endif>
                    Search {{ $partCount }} results
                </button>
            </div>
        @else
            <div class="d-flex justify-content-center mt-3">
                <button class="btn btn-success text-uppercase"
                        style="padding: 8px 20px; border-radius: 12px; background-color: #28a745; border: none; color: white;" 
                        disabled>{{ __('kba-search-button') }}</button>
            </div>
        @endif
    </div>
</form>

<script>
    document.getElementById('hsn').addEventListener('input', function() {
        if (this.value.length === 4) {
            document.getElementById('tsn').focus();
        }
    });
</script>
