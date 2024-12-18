<!DOCTYPE html>
<html lang="fr" class="dark daltonien">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.iconify.design/3/3.0.0/iconify.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment/locale/fr.js"></script>

    <link rel="icon" type="image/png" href="https://www.v3r.net/wp-content/uploads/2023/06/favicon.png" />
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>


<body class="flex flex-col h-screen w-full text-black bg-white dark:bg-gray-800 dark:text-white daltonien:bg-black-400">
    <!-- HEADER -->
    <header>

        @yield('header')
        <div class="flex w-full bg-blueV3R h-32 items-center justify-between p-4 relative ">
            <div class="flex items-center">
                <a href="/dashboard">
                    <img class="bg-white w-24 h-20 lg:hidden cursor-pointer daltonien:hover:bg-daltonienYellow daltonien:hover:text-black"
                        src="https://upload.wikimedia.org/wikipedia/fr/thumb/c/ce/Logo_de_Trois-Rivi%C3%A8res_2022.png/600px-Logo_de_Trois-Rivi%C3%A8res_2022.png?20220917132718"
                        alt="Logo Trois-Rivières">
                </a>
            </div>

            <!-- Burger menu sm-->

            <div class="md:hidden flex items-center text-white gap-2">
                @auth
                <div>
                    <button id="menu-toggle" class="daltonien:hover:bg-daltonienYellow daltonien:hover:text-black">
                        <span class="iconify size-10 hover:animate-bounce " data-icon="mdi:menu"
                            data-inline="false"></span>
                    </button>
                </div>
                @endauth
                <div>
                    <button id="dark-mode-toggle" class=" hover:animate-pulse daltonien:hover:bg-daltonienYellow daltonien:hover:text-black">
                        <span class="iconify size-10 " data-icon="circum:dark" data-inline="false"></span>
                    </button>
                </div>
                <div>
                    <button id="daltonien-mode-toggle" class="text-white hover:bg-green-300 hover:text-black daltonien:bg-daltonienYellow daltonien:text-black">
                        <span class="iconify size-10" data-icon="material-symbols:contrast" data-inline="false"></span>
                    </button>
                </div>

            </div>


            <!-- Liens de navigation pour tablette minimum a revoir -->
            @auth
            <nav
                class="hidden md:flex justify-center w-full text-lg xl:text-2xl items-center gap-4 text-white dark:text-white">
                <a href="/dashboard"
                    class="hover:bg-green-300 hover:text-black p-2 transition duration-300 ease-in-out transform hover:shadow-lg daltonien:hover:bg-daltonienYellow daltonien:hover:text-black">
                    Accueil
                </a>
                |
                @role('admin')
                <a href="/admin"
                    class="hover:bg-green-300 hover:text-black p-2 transition duration-300 ease-in-out transform hover:shadow-lg daltonien:hover:bg-daltonienYellow daltonien:hover:text-black">
                    Panneau
                    Administration
                </a> 
                |
                @endrole
                <a href="{{ route('fiches.index') }}"
                    class="hover:bg-green-300 hover:text-black p-2 transition duration-300 ease-in-out transform hover:shadow-lg daltonien:hover:bg-daltonienYellow daltonien:hover:text-black">
                    Fournisseurs
                </a>
                |
                <a href="/pageProfil"
                    class="hover:bg-green-300 hover:text-black p-2 transition duration-300 ease-in-out transform hover:shadow-lg daltonien:hover:bg-daltonienYellow daltonien:hover:text-black">
                    Profil
                </a>
            </nav>
            @endauth

            <!-- Deconnexion et Dark Mode desktop-->
            <div class="hidden md:flex space-x-4 items-center">
                @auth
                <form class="deconnexionBtn" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <div class="flex items-center space-x-4 hover:animate-bounce daltonien:hover:bg-daltonienYellow daltonien:hover:text-black">
                        <button class="ml-4 text-white">
                            <span class="iconify size-8 lg:size-10" data-icon="mdi:logout" data-inline="false"
                                onclick="removeItemsLocalStorage()"></span>
                        </button>
                    </div>
                </form>
                @endauth

                <button id="dark-mode-toggle-desktop" class="text-white hover:animate-pulse daltonien:hover:bg-daltonienYellow daltonien:hover:text-black">
                    <span class="iconify size-8 lg:size-10" data-icon="circum:dark" data-inline="false"></span>
                </button>
                <button id="daltonien-mode-toggle-desktop" class="text-white hover:bg-green-300 hover:text-black daltonien:bg-daltonienYellow daltonien:text-black">
                    <span class="iconify size-8 lg:size-10" data-icon="material-symbols:contrast" data-inline="false"></span>
                </button>
            </div>


            <div class="hidden lg:flex absolute top-5 left-20 ">
                <a href="/dashboard">
                    <img class="w-36 h-36 bg-white shadow-lg daltonien:hover:bg-daltonienYellow daltonien:hover:text-black"
                        src="https://upload.wikimedia.org/wikipedia/fr/thumb/c/ce/Logo_de_Trois-Rivi%C3%A8res_2022.png/600px-Logo_de_Trois-Rivi%C3%A8res_2022.png?20220917132718"
                        alt="Logo Trois-Rivières Desktop">
                </a>
            </div>
        </div>


        <div id="mobile-menu"
            class="fixed inset-0 z-50 bg-blueV3R transform -translate-x-full transition-transform duration-300 md:hidden ">
            <div class="p-4 flex w-full h-full flex-col">

                <div class="flex items-center w-full">
                    <div class="flex justify-start w-full">
                        <a href="/dashboard">
                            <img class="bg-white w-28 h-28 cursor-pointer daltonien:hover:bg-daltonienYellow daltonien:hover:text-black"
                                src="https://upload.wikimedia.org/wikipedia/fr/thumb/c/ce/Logo_de_Trois-Rivi%C3%A8res_2022.png/600px-Logo_de_Trois-Rivi%C3%A8res_2022.png?20220917132718"
                                alt="Logo Trois-Rivières">
                        </a>
                    </div>
                    <!-- Bouton pour fermer le menu mobile -->
                    <div class="flex justify-end w-full">
                        <button id="close-menu" class="text-white justify-end">
                            <span class="iconify size-10 hover:bg-green-300 daltonien:hover:bg-daltonienYellow daltonien:hover:text-black" data-icon="mdi:close"
                                data-inline="false"></span>
                        </button>
                    </div>
                </div>
                <!-- Liens de navigation pour mobile -->
                <nav class="space-y-4 mt-4 text-white text-xl flex flex-col h-full">
                    <a href="/dashboard" class="block flex items-center w-full hover:bg-green-300 p-2 transition duration-300 daltonien:hover:bg-daltonienYellow daltonien:hover:text-black">
                        <span class="iconify size-10 hover:bg-green-300 daltonien:hover:bg-daltonienYellow daltonien:hover:text-black" data-icon="mdi:home" data-inline="false"></span>   Accueil 
                    </a>
                    @role('admin')
                    <a href="/admin" class="block flex items-center w-full hover:bg-green-300 p-2 transition duration-300 daltonien:hover:bg-daltonienYellow daltonien:hover:text-black">
                        <span class="iconify size-10 hover:bg-green-300 daltonien:hover:bg-daltonienYellow daltonien:hover:text-black" data-icon="material-symbols:display-settings-outline-rounded" data-inline="false"></span>   Panneau
                        Administration
                    </a>
                    @endrole
                    <a href="{{ route('fiches.index') }}" class="block  flex items-center w-full hover:bg-green-300 p-2 transition duration-300 daltonien:hover:bg-daltonienYellow daltonien:hover:text-black">
                        <span class="iconify size-10 hover:bg-green-300 daltonien:hover:bg-daltonienYellow daltonien:hover:text-black" data-icon="material-symbols:box-outline-rounded" data-inline="false"></span>   Fournisseurs
                    </a>
                    <a href="/pageProfil" class="block flex items-center w-full hover:bg-green-300 p-2 transition duration-300 daltonien:hover:bg-daltonienYellow daltonien:hover:text-black">
                        <span class="iconify size-10 hover:bg-green-300 daltonien:hover:bg-daltonienYellow daltonien:hover:text-black" data-icon="lucide:user-round" data-inline="false"></span>   Profil
                    </a>

                    <!-- Bouton deconnexion pour mobile -->
                    @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="block flex items-center w-full text-white hover:bg-red-600 p-2 transition duration-300 daltonien:hover:bg-daltonienYellow daltonien:hover:text-black">
                            <span class="iconify size-10" data-icon="mdi:logout" data-inline="false"></span> Déconnexion
                        </button>
                    </form>
                    @endauth
                    <div class="flex h-full justify-center">
                        <div class="flex items-end text-xl">
                            <span>© Ville de Trois-Rivières. Tous droits réservés.</span>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

    </header>


    @yield('contenu')

    <script>
         moment.locale('fr');
        @auth
        // Toogle menu mobile
        document.getElementById('menu-toggle').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.remove('-translate-x-full');
        });

        document.getElementById('close-menu').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.add('-translate-x-full');
        });
        @endauth

        // Fonction pour les deux boutons darkMode
        const toggleDarkMode = () => {
            const htmlElement = document.documentElement;
            if (htmlElement.classList.contains('dark')) {
                htmlElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                htmlElement.classList.remove('daltonien');
                htmlElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        };

        const toggleDaltonienMode = () => {
            const htmlElement = document.documentElement;
            if (htmlElement.classList.contains('daltonien')) {
                htmlElement.classList.remove('daltonien');
                localStorage.setItem('theme', 'light');
            } else {
                htmlElement.classList.remove('dark');
                htmlElement.classList.add('daltonien');
                localStorage.setItem('theme', 'daltonien');
            }
        };

        //mode dark
        document.getElementById('dark-mode-toggle').addEventListener('click', toggleDarkMode);
        document.getElementById('dark-mode-toggle-desktop').addEventListener('click', toggleDarkMode);

        // mode daltonien
        document.getElementById('daltonien-mode-toggle').addEventListener('click', toggleDaltonienMode);
        document.getElementById('daltonien-mode-toggle-desktop').addEventListener('click', toggleDaltonienMode);

        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('daltonien');
        } else {
            document.documentElement.classList.remove('dark');
        }
        if (savedTheme === 'daltonien') {
            document.documentElement.classList.add('daltonien');
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.remove('daltonien');
        }

        function removeItemsLocalStorage() {
            localStorage.removeItem('selectedMenu');
        }
    </script>

</body>

</html>