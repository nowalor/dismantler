<form action="{{ route('car-parts.search-by-oem') }}">
    <div class="mb-3">
        <label for="oem" class="form-label">OEM</label>
        <input id="oem" type="text" class="form-control" name="oem" value="">
    </div>
    <div class="mb-3">
        <label for="engine_code" class="form-label">Engine code</label>
        <input id="engine_code" type="text" class="form-control" name="engine_code">
    </div>
    <div class="mb-3">
        <label for="gearbox_code" class="form-label">Gearbox code</label>
        <input id="gearbox_code" type="text" class="form-control" name="gearbox_code">
    </div>
    <div style="margin-top: 3rem;">
        <button class="btn btn-primary w-100 uppercase">
            Search
        </button>
    </div>
</form>
