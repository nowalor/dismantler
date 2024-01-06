<div>
    <div class="mb-3">
        <label for="car_model" class="form-label">Brand*</label>
        <select class="form-select" name="brand" id="car_model" wire:model="selectedBrand" wire:change="changeBrand">
            <option value="-1" selected disabled>Select car Brand</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}"
                        @if($brand->name === old('brand')) selected @endif>{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="car_model" class="form-label">Model*</label>
        <select class="form-select" wire:loading>
            <option>
                Loading...
            </option>
        </select>
        <select wire:loading.remove class="form-select" name="brand" id="car_model" wire:model="selectedModel"
                wire:change="changeModel">
            <option selected disabled>Select car model</option>
            @if($models)
                @foreach($models as $model)
                    <option value="{{ $model->id }}"
                            @if($model->new_name === old('model')) selected @endif>{{ $model->new_name }}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="mb-3">
        <label for="type" class="form-label">Part of type</label>
        <select name="type" id="type" class="form-select" wire:model="selectedType" wire:change="changeType">
            @foreach($types as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
    </div>

    @if($partCount !== -1)
    <div style="margin-top: 3rem;">
        <button class="btn btn-primary w-100 uppercase">Search {{ $partCount }} results</button>
    </div>
    @else
        <div style="margin-top: 3rem;">
            <button class="btn btn-primary w-100 uppercase" disabled>Fill in search</button>
        </div>
    @endif
</div>
