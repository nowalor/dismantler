<div>
    <div class="mb-3">
        <label for="car_model" class="form-label">Brand</label>
        <select class="form-select" name="brand" id="car_model" wire:model="selectedBrand" wire:change="changeBrand">
            <option value="-1" selected disabled>Select car Brand</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}"
                        @if($brand->name === old('brand')) selected @endif>{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>


    @if($selectedBrand !== -1)
        <div class="mb-3">
            <label for="car_model" class="form-label">Model</label>
            <select class="form-select" wire:loading>
                <option>
                    Loading...
                </option>
            </select>
            <select wire:loading.remove class="form-select" name="brand" id="car_model">
                <option selected disabled>Select car model</option>
                @foreach($models as $model)
                    <option value="{{ $model->new_name }}"
                            @if($model->new_name === old('model')) selected @endif>{{ $model->new_name }}</option>
                @endforeach
            </select>
        </div>
    @else
        <div class="mb-3">
            <label for="car_model" class="form-label">Model</label>
            <select class="form-select" wire:loading>
                <option>
                    Loading...
                </option>
            </select>
            <select wire:loading.remove class="form-select" name="brand" id="car_model" disabled>
                <option selected disabled>Select brand first</option>
            </select>
        </div>
    @endif
</div>
