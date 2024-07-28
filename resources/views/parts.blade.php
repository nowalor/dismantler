<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Currus - Car Parts</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    {{-- <link rel="shortcut icon" type="image/png" href="{{ asset('logo/currus.jpg') }}"> --}}
</head>
{{-------------- comment out the the second jpgg for it to work ----------}}
<body class="bg-cover bg-center" style="background-image: url('engine.jpg')"> 
    <div class="flex h-full">

        {{-- LEFT SIDE MENU BAR // PARTS NAVIGATION BAR  1/4 --}}
        @include('components.navbar')

            {{-- Social div --}}
            <div class="flex justify-start ml-4 mt-36">
                <ul class="flex text-white text-3xl">
                    <a class="mx-6 fab fa-instagram" rel="noopener noreferrer" target="_blank" href="https://www.instagram.com/"></a>
                    <a class="mx-6 fab fa-facebook" rel="noopener noreferrer" target="_blank" href="https://www.facebook.com/"></a>
                    <a class="mx-6 fab fa-twitter" rel="noopener noreferrer" target="_blank" href="https://twitter.com/?lang=da"></a>
                </ul>    
            </div>
        </div>

        {{-- MIDDLE AND RIGHT SIDE 3/4 --}}
        <div class="flex-1 bg-[#0c0c14] opacity-85">
            {{-- PARTS TITLE --}}
            <div class="w-full text-center mt-96 text-5xl">
                <h1 class="text-white font-bold mx-4 mb-2">
                    ECO-FRIENDLY
                </h1>
                <h1 class="text-white font-bold mb-2">
                    JOURNEYS START WITH
                </h1>
                <h1 class="text-white font-bold mb-2">
                    CURRUS CONNECT
                </h1>
            </div>
        </div>

    </div>
</body>

</html>