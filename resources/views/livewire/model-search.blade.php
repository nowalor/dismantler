<form action="{{ route('car-parts.search-by-model') }}" >
    <div style="text-align: left;">
        <div class="mb-3 mt-2">
            <label for="car_model" class="form-label">{{__('model-brand')}}</label>
            <select class="form-select" name="brand" id="car_model" wire:model="selectedBrand"
                    wire:change="changeBrand">
                <option value="-1" selected disabled>{{__('model-brand-placeholder')}}</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}"
                            @if($brand->name === old('brand')) selected @endif>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="car_model" class="form-label">{{__('model-model')}}</label>
            <select class="form-select" wire:loading name="dito_number_id">
                <option>
                    Loading...
                </option>
            </select>
            <select wire:loading.remove class="form-select" name="dito_number_id" id="car_model"
                    wire:model="selectedModel"
                    wire:change="getPartCount">
                <option value="-1" selected disabled>{{__('model-model-placeholder')}}</option>
                @if($models)
                    @foreach($models as $model)
                        <option value="{{ $model->id }}"
                                @if($model->new_name === old('model')) selected @endif>{{ $model->new_name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">{{__('model-part-type')}}</label>
            <select name="type_id" id="type" class="form-select" wire:model="selectedType" wire:change="getPartCount">
                <option value="-1" selected disabled>{{__('model-search-placeholder')}}</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        @if($partCount !== -1)
            <div style="margin-top: 1rem;">
                <button class="btn btn-primary w-100 uppercase" @if($partCount === 0 ) disabled @endif>
                    Search {{ $partCount }} results
                </button>
            </div>
        @else
            <div style="margin-top: 1rem;">
                <button class="btn btn-primary w-100 uppercase" disabled>{{__('model-search-button')}}</button>
            </div>
        @endif
    </div>
</form>
