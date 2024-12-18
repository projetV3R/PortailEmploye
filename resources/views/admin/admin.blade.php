@extends('layouts.app')

@section('title', 'Admin')

@section('contenu')

<div class="flex flex-col md:flex-row h-screen">


    <div class="md:hidden flex justify-center bg-gray-300 w-full">
        <button class="bg-gray-300 p-4" id="dropdownToggle">
            <span class="iconify text-xl w-8 daltonien:hover:bg-daltonienYellow daltonien:hover:text-black" data-icon="material-symbols:menu" data-inline="false"></span>
        </button>
    </div>


    <div class="hidden md:flex flex-col justify-center w-full md:w-64 h-1/2 md:h-full" id="menuDropdown">
        <div class="flex flex-col items-center bg-gray-300 w-full justify-center h-full">

            <div class="flex flex-row cursor-pointer hover:bg-gray-200 p-4 px-2 w-full justify-center md:justify-start items-center gap-3 menu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black" data-target="usersDiv" onclick="SelectedMenu(this)">
                <span class="iconify text-xl w-8" data-icon="material-symbols:format-list-bulleted" data-inline="false"></span>
                <span class="text-xl">Utilisateurs</span>
                <span class="iconify text-xl w-6  arrow" data-icon="material-symbols:arrow-forward-ios-rounded"></span>
            </div>


            <div class="flex flex-row cursor-pointer hover:bg-gray-200 p-4 px-2 w-full justify-center md:justify-start items-center gap-3 menu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black" data-target="settingsDiv" onclick="SelectedMenu(this)">
                <span class="iconify text-xl w-8" data-icon="material-symbols:display-settings-outline-rounded" data-inline="false"></span>
                <span class="text-xl">Paramètres</span>
                <span class="iconify text-xl w-6 hidden arrow" data-icon="material-symbols:arrow-forward-ios-rounded"></span>
            </div>
            <div class="flex flex-row cursor-pointer hover:bg-gray-200 p-4 px-2 w-full justify-center md:justify-start items-center gap-3 menu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black" data-target="courrielsDiv" onclick="SelectedMenu(this)">
                <span class="iconify text-xl w-8" data-icon="material-symbols:mail" data-inline="false"></span>
                <span class="text-xl">Courriels</span>
                <span class="iconify text-xl w-6 hidden arrow" data-icon="material-symbols:arrow-forward-ios-rounded"></span>
            </div>
        </div>
    </div>

    <div class="flex flex-col justify-center w-full h-full" id="usersDiv">
        <div class="relative pt-10 hidden lg:block">
            <h2 class="font-Alumni text-align text-center text-2xl font-bold pt-1">Gestion des utilisateurs</h2>
        </div>
        <div class="flex flex-col w-full h-full px-4 mt-2">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="border-2 rounded-lg shadow-lg divide-y divide-gray-200 dark:border-neutral-700 dark:divide-neutral-700 daltonien:border-black">
                        <div class="py-3 px-4">
                            <div class="relative max-w-xs">
                                <label class="sr-only block font-Alumni text-md md:text-lg mb-2">Recherche (mail ou role)</label>
                                <input type="text" id="recherche"
                                    class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-md rounded-lg text-sm focus:z-10 
                                     focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none 
                                     dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 
                                     dark:focus:ring-neutral-600 daltonien:bg-daltonienBleu daltonien:hover:bg-daltonienYellow">
                                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                    <svg class="size-4 text-gray-400 dark:text-neutral-50 0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.3-4.3"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-hidden">
                            <form id="update-roles-form">
                                @csrf
                                <div class="flex justify-between items-center">
                                    <div class="px-2 py-2">
                                        <button type="button" id="create-user"
                                            class="bg-blueV3R text-white px-2 py-1 rounded 
                                            daltonien:bg-daltonienBleu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black daltonien:text-black">
                                            Ajouter
                                        </button>
                                    </div>
                                    <div class="relative block lg:hidden">
                                        <h2 class="font-Alumni flex gap-y-2 text-center text-2xl font-bold">
                                            Gestion des utilisateurs
                                        </h2>
                                    </div>

                                    <div class="px-2 py-2">
                                        <button type="button" id="save-roles-btn" class="bg-blueV3R text-white px-2 py-1 rounded
                                            daltonien:bg-daltonienBleu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black daltonien:text-black">
                                            Enregistrer
                                        </button>
                                    </div>
                                </div>
                                <div id="usagers">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                        <thead class="bg-gray-50 dark:bg-neutral-700 daltonien:border border-black">
                                            <tr>
                                                <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase dark:text-neutral-500 daltonien:text-black">Courriel</th>
                                                <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase dark:text-neutral-500 daltonien:text-black">Rôle</th>
                                                <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase dark:text-neutral-500 flex justify-center daltonien:text-black">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700 daltonien:border border-black">
                                        </tbody>
                                    </table>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div id="pagination" class="mt-4 flex justify-center items-center gap-x-2"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col justify-center w-full h-full  hidden" id="settingsDiv">
        <div class="flex flex-col w-full h-full px-4 mt-10">
            <h1 class="text-2xl font-bold mb-6 flex justify-center">Gestion des paramètres</h1>

            <div class="border p-6 rounded-lg shadow-md daltonien:border-black">
                <form id="parametres-form">
                    @csrf

                    <div class="mb-4">
                        <label for="email_approvisionnement" class="block font-medium text-lg">Courriel de l'Approvisionnement</label>
                        <input type="email" name="email_approvisionnement" id="email_approvisionnement" required
                            class="w-full border rounded p-2 mt-1 daltonien:border-black">
                    </div>

                    <div class="mb-4">
                        <label for="mois_revision" class="block font-medium text-lg">Délai avant la révision (mois)</label>
                        <input type="number" name="mois_revision" id="mois_revision" min="1" max="36" required
                            class="w-full border rounded p-2 mt-1 daltonien:border-black">
                    </div>

                    <div class="mb-4">
                        <label for="taille_fichier" class="block font-medium text-lg">Taille maximale des fichiers joints (Mo)</label>
                        <input type="number" name="taille_fichier" id="taille_fichier" min="1" max="75" required
                            class="w-full border rounded p-2 mt-1 daltonien:border-black">
                    </div>

                    <div class="mb-4">
                        <label for="email_finances" class="block font-medium text-lg">Courriel des Finances</label>
                        <input type="email" name="finance_approvisionnement" id="finance_approvisionnement" required
                            class="w-full border rounded p-2 mt-1 daltonien:border-black">
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-500 text-white rounded p-2 hover:bg-blue-600 
                            daltonien:bg-daltonienBleu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black daltonien:text-black">
                        <b>Enregistrer</b>
                    </button>
                </form>

            </div>
        </div>
        <!-- Script gestion parametres systemes  -->
        <script src="{{ asset('js/Admin/parametres.js') }}"></script>
        <script src="{{ asset('js/Admin/admin.js') }}"></script>

    </div>
    <!-- Script gestion paramètres systèmes -->
    <script src="{{ asset('js/Admin/courriels.js') }}"></script>
    <div class="flex flex-col justify-center w-full p-4 lg:p-8 gap-y-4 hidden" id="courrielsDiv">
        <h2 class="text-2xl font-bold mb-6 flex justify-center">Gestion des modèles de courriels</h2>
        <div class="flex  gap-x-2 md:gap-x-4">
            <select id="modelesSelect" class="border-2  rounded-md shadow-sm" onchange="afficherModele()">

            </select>
           
        </div>


        <div id="contenuModele" class="flex flex-col w-full h-full border-2 rounded-lg shadow-lg p-4 gap-y-4 daltonien:border-black">

            <div class="flex flex-col">
                <label for="modeleObjet" class="font-bold mb-2">Objet du modèle</label>
                <input type="text" id="modeleObjet" class="border p-2 rounded-md daltonien:border-black" required>
            </div>

            <!-- Textarea pour le body -->
            <div class="flex flex-col h-full">
                <label for="modeleBody" class="font-bold mb-2">Contenu du modèle</label>
                <div id="editor" class="border p-2 rounded-md h-full max-h-96 overflow-auto daltonien:border-black"></div>
            </div>

        </div>


        <button class="bg-blue-300 rounded-md p-2 px-4 hover:bg-blue-500 hover:text-white daltonien:bg-daltonienBleu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black">
            Enregistrer les modifications
        </button>
    </div>


</div>

</div>



<script>
    function loadSelectedMenu() {
        const selectedMenu = localStorage.getItem('selectedMenu');
        if (selectedMenu) {

            const menuItem = document.querySelector(`.menu[data-target="${selectedMenu}"]`);
            if (menuItem) {
                SelectedMenu(menuItem);
            }
        }
    }

    document.getElementById('dropdownToggle').addEventListener('click', function() {
        var menu = document.getElementById('menuDropdown');
        menu.classList.toggle('hidden');
    });

    function SelectedMenu(element) {
        let items = document.querySelectorAll('.menu');
        let targetId = element.getAttribute('data-target');


        items.forEach(item => {
            item.classList.remove('bg-gray-200');
            item.querySelector('.arrow').classList.add('hidden');
        });

        let contentDivs = document.querySelectorAll('[id$="Div"]');
        contentDivs.forEach(div => {
            div.classList.add('hidden');
        });


        localStorage.setItem('selectedMenu', targetId);

        element.classList.add('bg-gray-200');
        element.querySelector('.arrow').classList.remove('hidden');
        document.getElementById(targetId).classList.remove('hidden');
    }

    window.onload = loadSelectedMenu;
</script>


@endsection