<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <script src="https://code.iconify.design/3/3.0.0/iconify.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <link rel="shortcut icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/fr/thumb/c/ce/Logo_de_Trois-Rivi%C3%A8res_2022.png/600px-Logo_de_Trois-Rivi%C3%A8res_2022.png?20220917132718" />

</head>


<body class="flex flex-col h-screen  text-black ">
   

    <main class="flex-1 ">
        @yield('contenu')

    </main>


   
   

</body>

</html>
