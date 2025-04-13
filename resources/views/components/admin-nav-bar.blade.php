<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="" id="navbarNav">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="text-danger nav-link {{ activeMenu('admin/export-parts') }}"
                            href="{{ route('admin.export-parts.index') }}">EGLUIT parts</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.engine-types.index') }}" class="nav-link">Engine Types</a>
                    </li>
                    <li class="nav-item">
                        <a class="text-danger nav-link {{ activeMenu('admin/dito-numbers') }}"
                            href="{{ route('admin.dito-numbers.index') }}">Dito numbers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ activeMenu('admin/kba') }}"
                            href="{{ route('admin.kba.index') }}">KBA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ activeMenu('admin/newsletter') }}"
                            href="{{ route('admin.newsletter.index') }}">Newsletter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ activeMenu('admin/car-part-categories') }}"
                            href="{{ route('admin.part-types-categories.index') }}">Parts Categories</a>
                    </li>
                    <!-- °<li class="nav-item">
            <a class="nav-link" href="{{ route('admin.car-parts.index') }}">Parts</a>
        </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.new-parts') }}">Parts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.orders.index') }}">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.information') }}">Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="text-danger nav-link {{ activeMenu('admin/sbr-codes') }}"
                            href="{{ route('admin.sbr-codes.index') }}">SBR</a>
                    </li>
                    <li class="nav-item">
                        <a class="text-danger nav-link {{ activeMenu('admin/blogs') }}"
                            href="{{ route('admin.blogs.index') }}">Blog</a>
                    </li>
                </ul>
            </div>
        </div>
</nav>
