<form action="{{ route('car-parts.search-by-model') }}">
    <div>
        <!-- Brand Dropdown -->
        <div class="mb-3 mt-2">
            <select class="form-select" name="brand" id="car_brand" 
                    wire:model="selectedBrand" 
                    wire:change="changeBrand" 
                    style="border: 1px solid #ccc; border-radius: 12px; padding: 10px;">
                <option value="-1" selected disabled>{{ __('model-brand-placeholder') }}</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" @if($brand->name === old('brand')) selected @endif>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Model Dropdown -->
        <div class="mb-3">
            <select class="form-select" name="dito_number_id" id="car_model" 
                    wire:model="selectedModel" 
                    style="border: 1px solid #ccc; border-radius: 12px; padding: 10px;">
                <option value="-1" selected disabled>{{ __('model-model-placeholder') }}</option>
                @if($models)
                    @foreach($models as $model)
                        <option value="{{ $model->id }}" @if($model->new_name === old('model')) selected @endif>
                            {{ $model->new_name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        <!-- Type Dropdown -->
        <div class="mb-3">
            <select name="type_id" id="type" class="form-select" 
                    wire:model="selectedType" 
                    style="border: 1px solid #ccc; border-radius: 12px; padding: 10px;">
                <option value="-1" selected disabled>{{ __('model-search-placeholder') }}</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Search Button -->
        @if($partCount !== -1)
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
                    disabled>{{ __('model-search-button') }}</button>
        </div>
        @endif
    </div>
</form>
