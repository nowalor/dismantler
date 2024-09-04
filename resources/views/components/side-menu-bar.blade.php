<div class="d-flex flex-column custom-sidemenu-width bg-dark text-white">

    <div class="px-5 flex-grow-1">
        <h1 class="display-5 font-weight-bold mt-3 ml-2 pt-4">PARTS</h1>
        <nav class="mt-4">
            <ul class="list-unstyled">
                <hr>
                <li class="py-3 px-2"><a onclick="updateQueryParam('all')" href="#" class="text-white text-decoration-none d-block" style="font-size: 1.4rem;">All</a></li>
                <hr>
                <li class="py-3 px-2"><a onclick="updateQueryParam(1)" href="#" class="text-white text-decoration-none d-block" style="font-size: 1.4rem;">Motors</a></li>
                <hr>
                <li class="py-3 px-2"><a href="#" class="text-white text-decoration-none d-block" style="font-size: 1.4rem;">Gearboxes</a></li>
                <hr>
                <li class="py-3 px-2"><a href="#" class="text-white text-decoration-none d-block" style="font-size: 1.4rem;">Underbody</a></li>
                <hr>
                <li class="py-3 px-2"><a href="#" class="text-white text-decoration-none d-block" style="font-size: 1.4rem;">Car Interior</a></li>
                <hr>
                <li class="py-3 px-2"><a href="#" class="text-white text-decoration-none d-block" style="font-size: 1.4rem;">Car Exterior</a></li>
                <hr>
                <li class="py-3 px-2"><a href="#" class="text-white text-decoration-none d-block" style="font-size: 1.4rem;">Contact Us</a></li>
                <hr>
            </ul>
        </nav>
        <div class="d-flex justify-content-start pt-4">
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
