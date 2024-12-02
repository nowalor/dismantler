<form action="{{ route('car-parts.search-by-oem') }}" method="GET">
    <div>
        <!-- OEM Input -->
        <div class="mb-3 mt-2 position-relative">
            <input id="oem" type="text" class="form-control" name="oem" 
                   value="{{ old('oem') }}" 
                   placeholder="{{ __('oem-oem') }}" 
                   style="border: 1px solid #ccc; border-radius: 12px; padding: 10px; padding-right: 40px;">
            <span class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                <i class="fas fa-search" style="color: #ccc;"></i>
            </span>
        </div>

        <!-- Engine Code Input -->
        <div class="mb-3 position-relative">
            <input id="engine_code" type="text" class="form-control" name="engine_code" 
                   value="{{ old('engine_code') }}" 
                   placeholder="{{ __('oem-engine-code') }}" 
                   style="border: 1px solid #ccc; border-radius: 12px; padding: 10px; padding-right: 40px;">
            <span class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                <i class="fas fa-cogs" style="color: #ccc;"></i>
            </span>
        </div>

        <!-- Gearbox Input -->
        <div class="mb-3 position-relative">
            <input id="gearbox" type="text" class="form-control" name="gearbox" 
                   value="{{ old('gearbox') }}" 
                   placeholder="{{ __('oem-gearbox-code') }}" 
                   style="border: 1px solid #ccc; border-radius: 12px; padding: 10px; padding-right: 40px;">
            <span class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                <i class="fas fa-tools" style="color: #ccc;"></i>
            </span>
        </div>

        <!-- Search Button -->
        <div class="d-flex justify-content-center mt-3">
            <button id="searchButton" type="submit" class="btn btn-success text-uppercase" 
                    style="padding: 8px 20px; border-radius: 12px; background-color: #28a745; border: none; color: white;" 
                    disabled>
                {{ __('oem-search-button') }}
            </button>
        </div>
    </div>
</form>

<script>
    // Get references to the input fields and button
    const inputs = document.querySelectorAll('#oem, #engine_code, #gearbox');
    const searchButton = document.getElementById('searchButton');

    // Function to enable/disable the button
    function toggleButtonState() {
        // Check if at least one input has a value
        const isAnyInputFilled = Array.from(inputs).some(input => input.value.trim() !== '');
        searchButton.disabled = !isAnyInputFilled;
    }

    // Add event listeners to inputs
    inputs.forEach(input => {
        input.addEventListener('input', toggleButtonState);
    });
</script>
