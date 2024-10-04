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
    
    <div class="flex flex-col justify-center w-full h-full" id="usersDiv">
    <div class="relative hidden lg:block">
        <h2 class="text-align text-center text-2xl font-bold pt-1 pb-2">Liste Employer</h2>
    </div>
    <div class="flex flex-col w-full h-full px-4 mt-2">            
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="border rounded-lg divide-y divide-gray-200 dark:border-neutral-700 dark:divide-neutral-700">
            <div class="py-3 px-4">
                <div class="relative max-w-xs">
                    <label class="sr-only">Search</label>
                    <input type="text" name="hs-table-with-pagination-search" id="hs-table-with-pagination-search" class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Search for items">
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                    <svg class="size-4 text-gray-400 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                                <button type="button" id="create-user" class="bg-blueV3R text-white px-2 py-1 rounded">Ajouter</button>
                            </div>
                            <div class="relative block lg:hidden">
                            <h2 class="flex gap-y-2 text-center text-2xl font-bold">Liste Employer</h2>
                            </div>

                            <div class="px-2 py-2">
                                <button type="button" id="save-roles-btn" class="bg-blueV3R text-white px-2 py-1 rounded">Enregistrer</button>
                            </div>
                        </div>
                        
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                            <thead class="bg-gray-50 dark:bg-neutral-700">
                                <tr>
                                    <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Mail</th>
                                    <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Role</th>
                                    <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase dark:text-neutral-500 flex justify-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                @foreach($usagers as $usager)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200 cursor-default">
                                            {{$usager->email}}
                                        </td>
                                        <td class="px-4 py-2 text-center whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                        <input type="hidden" name="usagers[{{ $usager->id }}][id]" value="{{ $usager->id }}">
                                            <select name="usagers[{{ $usager->id }}][role]" class="role-dropdown dark:text-neutral-500 dark:bg-blueV3R">
                                                <option value="admin" {{ $usager->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="responsable" {{ $usager->role == 'responsable' ? 'selected' : '' }}>Responsable</option>
                                                <option value="commis" {{ $usager->role == 'commis' ? 'selected' : '' }}>Commis</option>
                                            </select>
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200 cursor-default flex justify-center items-center flex-row">
                                                <button type="button" class="delete-user px-2 flex items-center bg-gray-300" data-id="{{ $usager->id }}">
                                                    <span class="iconify size-10 lg:size-6" data-icon="mdi:bin" data-inline="false"></span>
                                                    <span class="delete-user relative hidden lg:block" data-id="{{ $usager->id }}">Supprimer employer</span>
                                                </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                    <div class="flex justify-center">
                        <nav class="flex items-center gap-x-1" aria-label="Pagination">
                        <button type="button" class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Previous" id="prevButton" onclick="goToPage(currentPage - 1)" {{ $usagers->onFirstPage() ? 'disabled' : '' }}>
                            <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6"></path>
                            </svg>
                            <span class="sr-only">Previous</span>
                        </button>

                        <div class="flex items-center gap-x-1">
                            @for ($i = 1; $i <= $usagers->lastPage(); $i++)
                            <button type="button" class="min-h-[38px] min-w-[38px] flex justify-center items-center {{ $i == $usagers->currentPage() ? 'bg-gray-200 text-gray-800' : 'text-gray-800 hover:bg-gray-100' }} py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-300" onclick="goToPage({{ $i }})">
                                {{ $i }}
                            </button>
                            @endfor
                        </div>

                        <button type="button" class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" aria-label="Next" id="nextButton" onclick="goToPage(currentPage + 1)" {{ $usagers->hasMorePages() ? '' : 'disabled' }}>
                            <span class="sr-only">Next</span>
                            <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6"></path>
                            </svg>
                        </button>
                        </nav>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="flex flex-col justify-center w-full h-full bg-yellow-500 hidden" id="suppliersDiv"></div>
    <div class="flex flex-col justify-center w-full h-full  hidden" id="settingsDiv">
        <div class="flex flex-col w-full h-full px-4 mt-10">
            <h1 class="text-2xl font-bold mb-6 flex justify-center">Gestion des paramètres</h1>
        
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
            <script>var updateUsagerUrl = "{{ route('usagers.update') }}";</script>
            <script src="{{ asset('js/Admin/admin.js') }}"></script>

</div>
<!-- Script gestion paramètres systèmes -->
<script src="{{ asset('js/Admin/courriels.js') }}"></script>
<div class="flex flex-col justify-center w-full p-4 lg:p-8 gap-y-4" id="courrielsDiv">
    <h2 class="text-2xl font-bold mb-6 flex justify-center">Gestion des modèles de courriels</h2>
    <div class="flex  gap-x-2 md:gap-x-4">
        <select id="modelesSelect" class="border-2  rounded-md shadow-sm" onchange="afficherModele()">
        
        </select>
        <button class="bg-green-300 rounded-md p-2 px-2 hover:text-white hover:bg-green-700"><span class=" hidden md:block">Ajouter</span>  <span class="block md:hidden iconify size-6" data-icon="material-symbols-light:post-add" data-inline="false"></span></button>
        <button class="bg-red-300 rounded-md p-2 px-2 hover:text-white hover:bg-red-700"><span class="hidden md:block">Supprimer</span> <span class="block md:hidden iconify size-6" data-icon="mdi:bin" data-inline="false"></button>
    </div>

 
    <div id="contenuModele" class="flex flex-col w-full h-full border-2  rounded-lg shadow-lg p-4 gap-y-4">
 
        <div class="flex flex-col">
            <label for="modeleObjet" class="font-bold mb-2">Objet du modèle</label>
            <input type="text" id="modeleObjet" class="border p-2 rounded-md" required>
        </div>

        <!-- Textarea pour le body -->
        <div class="flex flex-col h-full">
            <label for="modeleBody" class="font-bold mb-2">Contenu du modèle</label>
            <div id="editor" class="border p-2 rounded-md h-full max-h-96 overflow-auto"></div>
        </div>
        
    </div>

 
    <button class="bg-blue-300 rounded-md p-2 px-4 hover:bg-blue-500 hover:text-white">Enregistrer les modifications</button>
</div> 


</div>

    </div>

<script>
  let currentPage = {{ $usagers->currentPage() }};

  function goToPage(page) {
    if (page < 1 || page > {{ $usagers->lastPage() }}) return;

    window.location.href = `{{ url()->current() }}?page=${page}`;
  }
</script>

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
