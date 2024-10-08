<div class="d-flex flex-column custom-sidemenu-width bg-dark text-white">
    <div class="px-4 flex-grow-1">
        <h1 class="display-6 font-weight-bold mt-2.5 ml-2 pt-3">PARTS</h1>
        <nav class="mt-4">
            <ul class="list-unstyled">
                <hr>
                <li class="py-2 px-1">
                    <a href="{{ route('car-parts.search-by-name', array_merge(request()->query(), ['type_id' => null])) }}" 
                        class="text-white text-decoration-none d-block" style="font-size: 1rem;">
                        All
                    </a>
                </li>
                <hr>
                
                {{-- Dynamically generate part type list --}}
                @foreach($partTypes as $partType)
                    <li class="py-0 px-1">
                        <a href="
                            @if (Route::currentRouteName() === 'car-parts.search-by-name')
                                {{ route('car-parts.search-by-name', array_merge(request()->query(), ['type_id' => $partType->id])) }}
                            @elseif (Route::currentRouteName() === 'car-parts.search-by-oem')
                                {{ route('car-parts.search-by-oem', array_merge(request()->query(), ['type_id' => $partType->id])) }}
                            @elseif (Route::currentRouteName() === 'car-parts.search-by-model')
                                {{ route('car-parts.search-by-model', array_merge(request()->query(), ['type_id' => $partType->id])) }}
                            @else
                                #
                            @endif
                            " class="text-white text-decoration-none d-block" style="font-size: 1rem;">
                            {{ $partType->name }}
                        </a>
                    </li>
                    <hr>
                @endforeach
                
                <li class="py-2 px-1">
                    <a href="#" class="text-white text-decoration-none d-block" style="font-size: 1rem;">Contact Us</a>
                </li>
                <hr>
            </ul>
        </nav>
        <div class="d-flex justify-content-start pt-3">
            <ul class="list-unstyled d-flex">
                <li class=""><a class="fab fa-facebook text-white" rel="noopener noreferrer" target="_blank" href="https://www.facebook.com/" style="font-size: 2.1rem;"></a></li>
                <li style="margin-left: 1rem;"><a class="fab fa-linkedin text-white" rel="noopener noreferrer" target="_blank" href="https://www.linkedin.com/" style="font-size: 2.1rem;"></a></li>
                <li style="margin-left: 1rem;"><a class="fab fa-instagram text-white" rel="noopener noreferrer" target="_blank" href="https://www.instagram.com/" style="font-size: 2.1rem;"></a></li>
                <li style="margin-left: 1rem;"><a class="fab fa-twitter text-white" rel="noopener noreferrer" target="_blank" href="https://twitter.com/?lang=da" style="font-size: 2.1rem;"></a></li>
            </ul>
        </div>
    </div>
</div>


<style>
    .custom-sidemenu-width {
    width: 17%;
    opacity: 0.85;
    }

</style>

<script>
    function updateQueryParam(value) {
        // Get the current URL
        let currentUrl = new URL(window.location.href);

        // Update or add the query parameter
        currentUrl.searchParams.set('type_id', value);

        // Redirect to the new URL
        window.location.href = currentUrl.toString();
    }

</script>
