<?php
  $user = Auth::user();
?>
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

<body>
    <!-- HEADER -->
    <header>
    @role('admin')
          <form method="post" action="{{route('logout')}}">
            @csrf
            <button type="submit" class="block py-2 px-4 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm">
            <strong>Deconnexion</strong>
            </button>
          </form>
    @endrole
    </header>
    @yield('contenu')
</body>
</html>
