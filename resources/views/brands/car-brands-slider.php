    <div class="d-flex justify-content-center align-items-center mt-3 text-white">
        <h1>Car Brands</h1>
    </div>

    <div class="d-flex justify-content-center align-items-center">
        <ul class="d-flex list-unstyled mb-0">
            @foreach ($brands as $brand)
                <li>
                    <img src="{{ $brand->image }}" alt="audi brand logo" class="img-fluid"
                        style="width: 11rem; height: 8.2rem; object-fit: contain; border: 1px solid black;">
                </li>
            @endforeach
        </ul>
    </div>
    <div class="d-flex justify-content-center mt-3">
        <button type="button" class="btn btn-light">Click to view more car brands</button>
    </div>
