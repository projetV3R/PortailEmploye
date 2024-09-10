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
  <link rel="stylesheet" href="{{ asset('style.css') }}">
  
</head>

<body>
    <!-- HEADER -->
    <header>      
    </header>

    @yield('contenu')

</body>
</html>
