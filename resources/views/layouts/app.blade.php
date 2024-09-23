<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.iconify.design/3/3.0.0/iconify.min.js"></script>
  <link rel="icon" type="image/png" href="https://www.v3r.net/wp-content/uploads/2023/06/favicon.png" />
  @vite('resources/css/app.css')
</head>

<body class="flex flex-col h-screen w-full bg-white dark:bg-gray-900 text-black dark:text-white">
    <!-- HEADER -->

    <header>
      @yield('header')
      <div class="flex w-full bg-blueV3R h-32">
        <div class="flex p-4  w-full">
          <img class="bg-white flex lg:hidden" src="https://upload.wikimedia.org/wikipedia/fr/thumb/c/ce/Logo_de_Trois-Rivi%C3%A8res_2022.png/600px-Logo_de_Trois-Rivi%C3%A8res_2022.png?20220917132718" alt="">   
          <div class="flex items-end w-full gap-4 text-white">
            
               <!-- Lien Navigation -->
            <div class="flex justify-center w-full text-2xl items-end">     
      @role('admin')
     <a href="/admin" class="hover:bg-green-300 hover:text-black p-2 transition duration-300 ease-in-out transform hover:shadow-lg">Panneau Administration</a>
       @endrole
            </div>


   <!-- Deconnexion et darkMode -->
   @auth 
    <div class="flex space-x-4">
      <!-- Bouton pour deconnexion -->
 <form class="deconnexionBtn" action="{{ route('logout') }}" method="POST">
    @csrf

<div class="flex items-center space-x-4 hover:animate-bounce">
    <button class="ml-4 text-white">
      <span class="iconify size-10" data-icon="mdi:logout" data-inline="false"></span>
    </button>
</div>
  </form>
 
  @endauth

  <!-- Bouton pour dark mode -->
  <button id="dark-mode-toggle" class=" text-white hover:animate-pulse">
    <span class="iconify size-10" data-icon="circum:dark" data-inline="false"></span>
  </button>
</div>


      <div class="p-4 absolute top-5 left-20 hidden lg:flex cursor-pointer">
        <a href="/dashboard"> <img class="w-36 h-36 bg-white shadow-lg" src="https://upload.wikimedia.org/wikipedia/fr/thumb/c/ce/Logo_de_Trois-Rivi%C3%A8res_2022.png/600px-Logo_de_Trois-Rivi%C3%A8res_2022.png?20220917132718" alt=""></a>
      </div>

    
    </header>

    @yield('contenu')

    <script>
      // Fonction pour darkMode
      const toggleDarkMode = () => {
        const htmlElement = document.documentElement;
        if (htmlElement.classList.contains('dark')) {
          htmlElement.classList.remove('dark');
          localStorage.setItem('theme', 'light');
        } else {
          htmlElement.classList.add('dark');
          localStorage.setItem('theme', 'dark');
        }
      }

      document.getElementById('dark-mode-toggle').addEventListener('click', toggleDarkMode);
      const savedTheme = localStorage.getItem('theme');
      if (savedTheme && savedTheme === 'dark') {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    </script>
</body>
</html>
