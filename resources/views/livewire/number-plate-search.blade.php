<form action="{{ route('search-by-plate') }}" method="POST">
    @csrf
    <div style="text-align: left;">
        <div class="mb-3">
            <label for="oem" class="form-label">{{__('number-plate')}}</label>
            <input id="oem" type="text" class="form-control" name="search" value="">
        </div>
        <div style="margin-top: 1rem;">
            <button type="submit" class="btn btn-primary w-100 uppercase">
                {{__('oem-search-button')}}
            </button>
        </div>
    </div>
</form>
