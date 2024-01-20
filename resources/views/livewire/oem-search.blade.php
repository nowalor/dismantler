<form action="{{ route('car-parts.search-by-oem') }}">
    <div class="mb-3">
        <label for="hsn" class="form-label">OEM</label>
        <input type="text" class="form-control" name="hsn" value="{{ old('hsn') }}">
    </div>
    <div class="mb-3">
        <label for="hsn" class="form-label">Engine code</label>
        <input type="text" class="form-control" name="tsn" value="{{ old('tsn') }}">
    </div>
    <div class="mb-3">
        <label for="hsn" class="form-label">Gearbox code</label>
        <input type="text" class="form-control" name="tsn" value="{{ old('tsn') }}">
    </div>
        <div style="margin-top: 3rem;">
            <button class="btn btn-primary w-100 uppercase">
                Search
            </button>
        </div>
</form>
