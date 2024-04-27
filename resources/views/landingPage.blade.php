<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Currus - Car Parts</title>
   {{-- <link rel="shortcut icon" type="image/png" href="{{ asset('logo/currus.jpg') }}"> --}}
</head>
<body class="bg-cover bg-center" style="background-image: url('/img/engine.jpg')"> 

    <!-- {{-- first div Currus - Car Parts --}} -->
    <div class="text-center pt-12 w-fit mx-auto">
        <!-- {{-- <img src="logo/currus.png" alt="" srcset=""> --}} -->
        <h1 class="text-7xl font-bold border-b-4 border-green-900">CURRUS</h1>
        <h2 class="text-4xl font-bold">CAR PARTS</h2>
    </div>

    <!-- {{------------------------------- BROWSE ALL BUTTON - redirects to /browse ----------------------------------------------}} -->

    <div class="flex justify-center items-center w-fit mx-auto">
        <div class="text-center mt-32">
            <!-- {{-----------------------------// remove block if you want it less bulkier -------------------------------}} -->
            <a href="/browse" class="font-semibold block py-2 px-4 rounded-md bg-green-900 text-white mb-4">BROWSE ALL</a>
        </div>
    </div>

<!-- {{------------------------------- BUTTONS FOR HSN + TSN & CAR & OEM ----------------------------------------------}} -->
    <div class="flex justify-center items-center w-fit mx-auto">
        <div class="text-center mt-16">
            <a href="/" class="font-semibold inline-block py-2 px-4 rounded-md bg-green-900 text-white mb-12 mr-12">SEARCH BY HSN + TSN</a>
            <a href="/" class="font-semibold inline-block py-2 px-4 rounded-md bg-green-900 text-white mb-12 mr-12">SEARCH BY CAR</a>
            <a href="/" class="font-semibold inline-block py-2 px-4 rounded-md bg-green-900 text-white mb-12 mr-12">SEARCH BY OEM</a>
        </div>
    </div>


    <!-- {{-------------------------------  LICENSE PLATE SEARCH BAR + MODEL & CAR BRAND DROPDOWN  ----------------------------------------------}} -->
    <div class="flex justify-center items-center">
        <div class="text-center justify-center">
            <div class="">
                <!-- {{-- Searches for license plate using an API --}} -->
                <form action="/searchForLicenseplate" method="GET">
                    <input type="text" name="query" placeholder="License plate..." class="bg-gray-200 rounded-md py-2 px-4 focus:outline-none focus:ring focus:border-blue-300">
                    <br>
                    <!-- {{-- Button can be removed => if to be removed, remember to add JS so that the enter button registers a submit --}} -->
                    <button type="submit" class="mt-4 bg-green-700 hover:bg-green-900 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring focus:border-blue-300">Submit</button>
                </form>
            </div>
    
            {{-- doesnt work atm, change both dropdown menus to livewire instead of this --}}
            <div class="flex justify-center">
                <div class="p-4">
                    <select name="model" id="model" class="block py-2 px-4 rounded-md bg-white w-64">
                        <!-- Placeholder Car Brand -->
                        <option value="" disabled selected hidden>Car Model</option>
            
                        @foreach($models as $model)
                            <option value="{{ $model->name }}">{{ $model->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
    
            <div class="flex justify-center">
                <div class="p-4">
                    <select name="brand" id="brand" class="block py-2 px-4 rounded-md bg-white w-64">
                        <!-- Placeholder Car Brand -->
                        <option value="" disabled selected hidden>Car Brand</option>
            
                        @foreach($brands as $brand)
                            <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
        </div>
    </div>

</body>
</html>