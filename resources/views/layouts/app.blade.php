<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.iconify.design/3/3.0.0/iconify.min.js"></script>
  <link rel="icon" type="image/png" href="https://www.v3r.net/wp-content/uploads/2023/06/favicon.png" />
  @vite('resources/css/app.css') 
  
</head>

<body class="flex flex-col h-screen w-full ">
    <!-- HEADER -->
    <header>
      @yield('header')
      <div class="flex  w-full bg-blueV3R h-32">
        
      </div>
      <div class="flex p-4 absolute top-5 left-20">
        <img class="w-36 h-36 bg-white shadow-lg" src="https://upload.wikimedia.org/wikipedia/fr/thumb/c/ce/Logo_de_Trois-Rivi%C3%A8res_2022.png/600px-Logo_de_Trois-Rivi%C3%A8res_2022.png?20220917132718" alt="">
        </div>
    </header>
    @yield('contenu')
</body>
</html>
