<footer class="bg-dark text-white pt-4 pb-2">
    <div class="container small">
        <div class="row text-center justify-content-center">
            <div class="col-md-3 mb-3 mx-4">
                <h5 class="text-uppercase fw-bold mb-2">{{ __('footer-company-info') }}</h5>
                <p class="mb-1">{{ __('footer-vat') }}: DK44583712</p>
                <p class="mb-0">{{ __('footer-management') }}: Markus Priess</p>
            </div>

            <div class="col-md-3 mb-3 mx-4">
                <h5 class="text-uppercase fw-bold mb-2">{{ __('footer-company-name') }}</h5>
                <p class="mb-1">Rentemestervej 67</p>
                <p class="mb-1">DK 2400 København NV</p>
                <p class="mb-0">Danmark</p>
            </div>

            <div class="col-md-3 mb-3 mx-4">
                <h5 class="text-uppercase fw-bold mb-2">{{ __('footer-contact') }}</h5>
                <p class="mb-1">{{ __('footer-customer-service') }}: +45 77 34 38 77</p>
                <p class="mb-1">
                    {{ __('footer-email') }}: <a href="mailto:service@currus-connect.com"
                        class="text-success text-decoration-none">service@currus-connect.com</a>
                </p>
                <p class="mb-0">{{ __('footer-office-hours') }}: {{ __('footer-monday') }} - {{ __('footer-friday') }}
                    9.00 - 16.00</p>
            </div>
        </div>

        <hr class="border-success opacity-50 my-3">

        <div class="text-center pb-2">
            <a href="https://www.linkedin.com/company/currus-connect/" target="_blank" class="text-success fs-4 me-2">
                <i class="fab fa-linkedin"></i>
            </a>
            <p class="mb-0 mt-2">&copy; {{ date('Y') }} Currus Connect. {{ __('copyright-text') }}</p>
        </div>
    </div>
</footer>