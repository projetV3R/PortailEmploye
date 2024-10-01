@extends('layouts.app')

@section('title', 'Admin')

@section('contenu')

<div class="flex flex-col md:flex-row h-screen">


    <div class="md:hidden flex justify-center bg-gray-300 w-full">
        <button class="bg-gray-300 p-4" id="dropdownToggle">
            <span class="iconify text-xl w-8" data-icon="material-symbols:menu" data-inline="false"></span>
        </button>
    </div>

  
    <div class="hidden md:flex flex-col justify-center w-full md:w-64 h-1/2 md:h-full" id="menuDropdown">
        <div class="flex flex-col items-center bg-gray-300 w-full justify-center h-full">

            <div class="flex flex-row cursor-pointer hover:bg-gray-200 p-4 px-2 w-full justify-center md:justify-start items-center gap-3 menu" data-target="usersDiv" onclick="SelectedMenu(this)">
                <span class="iconify text-xl w-8" data-icon="material-symbols:format-list-bulleted" data-inline="false"></span>
                <span class="text-xl">Utilisateurs</span>
                <span class="iconify text-xl w-6  arrow" data-icon="material-symbols:arrow-forward-ios-rounded"></span>
            </div>

            <div class="flex flex-row cursor-pointer hover:bg-gray-200 p-4 px-2 w-full justify-center md:justify-start items-center gap-3 menu" data-target="suppliersDiv" onclick="SelectedMenu(this)">
                <span class="iconify text-xl w-8" data-icon="material-symbols:box-outline-rounded" data-inline="false"></span>
                <span class="text-xl">Fournisseurs</span>
                <span class="iconify text-xl w-6 hidden arrow" data-icon="material-symbols:arrow-forward-ios-rounded"></span>
            </div>

            <div class="flex flex-row cursor-pointer hover:bg-gray-200 p-4 px-2 w-full justify-center md:justify-start items-center gap-3 menu" data-target="settingsDiv" onclick="SelectedMenu(this)">
                <span class="iconify text-xl w-8" data-icon="material-symbols:display-settings-outline-rounded" data-inline="false"></span>
                <span class="text-xl">Paramètres</span>
                <span class="iconify text-xl w-6 hidden arrow" data-icon="material-symbols:arrow-forward-ios-rounded"></span>
            </div>
            <div class="flex flex-row cursor-pointer hover:bg-gray-200 p-4 px-2 w-full justify-center md:justify-start items-center gap-3 menu" data-target="courrielsDiv" onclick="SelectedMenu(this)">
                <span class="iconify text-xl w-8" data-icon="material-symbols:mail" data-inline="false"></span>
                <span class="text-xl">Courriels</span>
                <span class="iconify text-xl w-6 hidden arrow" data-icon="material-symbols:arrow-forward-ios-rounded"></span>
            </div>
        </div>
    </div>


    <div class="flex flex-col justify-center w-full h-full bg-red-500" id="usersDiv"></div>
    <div class="flex flex-col justify-center w-full h-full bg-yellow-500 hidden" id="suppliersDiv"></div>
    <div class="flex flex-col justify-center w-full h-full  hidden" id="settingsDiv">
        <div class="flex flex-col w-full h-full px-4 mt-10">
            <h2 class="text-2xl font-bold mb-6 flex justify-center">Gestion des paramètres</h2>
        
            <div class="border p-6 rounded-lg shadow-md">
                <form id="parametres-form">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email_approvisionnement" class="block font-medium text-lg">Courriel de l'Approvisionnement</label>
                        <input type="email" name="email_approvisionnement" id="email_approvisionnement" required
                            class="w-full border rounded p-2 mt-1">
                    </div>
        
                    <div class="mb-4">
                        <label for="mois_revision" class="block font-medium text-lg">Délai avant la révision (mois)</label>
                        <input type="number" name="mois_revision" id="mois_revision" min="1" max="36" required
                            class="w-full border rounded p-2 mt-1">
                    </div>
        
                    <div class="mb-4">
                        <label for="taille_fichier" class="block font-medium text-lg">Taille maximale des fichiers joints (Mo)</label>
                        <input type="number" name="taille_fichier" id="taille_fichier" min="1" max="75" required
                            class="w-full border rounded p-2 mt-1">
                    </div>
        
                    <div class="mb-4">
                        <label for="email_finances" class="block font-medium text-lg">Courriel des Finances</label>
                        <input type="email" name="finance_approvisionnement" id="finance_approvisionnement" required
                            class="w-full border rounded p-2 mt-1">
                    </div>
                    <button type="submit" class="w-full bg-blue-500 text-white rounded p-2 hover:bg-blue-600">Enregistrer</button>
                </form>
            </div>
        </div>
        <!-- Script gestion parametres systemes  -->
            <script src="{{ asset('js/Admin/parametres.js') }}"></script>
      

</div>

<div class="flex flex-col justify-center w-full p-4 lg:p-8 gap-y-4" id="courrielsDiv">
    <!-- Select pour choisir le modèle d'email -->
    <div class="flex gap-x-4">
        <select id="modelesSelect" class="border p-2" onchange="afficherModele()">
            <!-- Les options seront générées dynamiquement avec Axios -->
        </select>
        <button class="bg-green-300 rounded-md p-2 px-4">Ajouter</button>
        <button class="bg-red-300 rounded-md p-2 px-4">Supprimer</button>
    </div>

    <!-- Div pour afficher l'objet et le contenu du modèle sélectionné -->
    <div id="contenuModele" class="flex flex-col w-full h-full border-2 border-dashed p-4 gap-y-4">
 
        <div class="flex flex-col">
            <label for="modeleObjet" class="font-bold mb-2">Objet du modèle</label>
            <input type="text" id="modeleObjet" class="border p-2 rounded-md">
        </div>

        <!-- Textarea pour le body -->
        <div class="flex flex-col  h-full ">
            <label for="modeleBody" class="font-bold mb-2">Contenu du modèle</label>
            <textarea id="modeleBody" rows="5" class="border p-2 rounded-md  h-full"></textarea>
        </div>
    </div>

 
    <button class="bg-blue-300 rounded-md p-2 px-4">Enregistrer les modifications</button>
</div>

<!-- Script gestion paramètres systèmes -->
<script src="{{ asset('js/Admin/courriels.js') }}"></script>



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
