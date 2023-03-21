<div>
    <div class="mb-3">
        <label for="car_model" class="form-label">Select car model</label>
        <select class="form-select" name="brand" id="car_model" wire:model="selectedBrand" wire:change="changeBrand">
            <option selected disabled>Select car Brand</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}"
                        @if($brand->name === old('brand')) selected @endif>{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="car_model" class="form-label">Select car model</label>
        <select class="form-select" wire:loading>
            <option>
                Loading...
            </option>
        </select>
        <select wire:loading.remove class="form-select" name="brand" id="car_model">
            <option selected disabled>Select car model</option>
            @foreach($models as $model)
                <option value="{{ $model->name }}"
                        @if($model->name === old('model')) selected @endif>{{ $model->name }}</option>
            @endforeach
        </select>
    </div>
</div>
