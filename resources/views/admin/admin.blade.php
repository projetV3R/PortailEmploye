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
        </div>
    </div>
    
    <div class="flex flex-col justify-center w-full h-full lg:px-40 lg:py-10" id="usersDiv">
    <div class="relative hidden lg:block">
        <h2 class="text-align text-center text-2xl font-bold pt-1 pb-2">Liste Employer</h2>
    </div>
    <div class="flex flex-col w-full h-full px-4 mt-2">            
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="border rounded-lg divide-y divide-gray-200 dark:border-neutral-700 dark:divide-neutral-700">
                <div class="overflow-hidden">
                    <form id="update-roles-form">
                        @csrf 
                        <div class="flex justify-between items-center">
                            <div class="px-2 py-2">
                                <button type="button" id="#" class="bg-blueV3R text-white px-2 py-1 rounded">Ajouter</button>
                            </div>
                            <div class="relative block lg:hidden">
                            <h2 class="flex-grow text-center text-2xl font-bold">Liste Employer</h2>
                            </div>

                            <div class="px-2 py-2">
                                <button type="button" id="save-roles-btn" class="bg-blueV3R text-white px-2 py-1 rounded">Enregistrer</button>
                            </div>
                        </div>
                        
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                            <thead class="bg-gray-50 dark:bg-neutral-700">
                                <tr>
                                    <th scope="col" class="relative hidden lg:block px-2 py-1 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">ID</th>
                                    <th scope="col" class="px-2 py-1 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Mail</th>
                                    <th scope="col" class="px-2 py-1 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Role</th>
                                    <th scope="col" class="px-2 py-1 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500 flex justify-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                @foreach($usagers as $usager)
                                    <tr>
                                        
                                            <td class="relative hidden lg:block px-2 py-1 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                {{$usager->id}}
                                                <input type="hidden" name="usagers[{{ $usager->id }}][id]" value="{{ $usager->id }}">
                                            </td>
                                        
                                        <td class="px-2 py-1 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200 cursor-default">
                                            {{$usager->email}}
                                        </td>
                                        <td class="px-2 py-1 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                            <select name="usagers[{{ $usager->id }}][role]" class="role-dropdown dark:text-neutral-500 dark:bg-blueV3R">
                                                <option value="admin" {{ $usager->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="responsable" {{ $usager->role == 'responsable' ? 'selected' : '' }}>Responsable</option>
                                                <option value="commis" {{ $usager->role == 'commis' ? 'selected' : '' }}>Commis</option>
                                            </select>
                                        </td>
                                        <td class="px-2 py-1 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200 cursor-default flex justify-center">
                                            <div class="relative block lg:hidden">
                                                <button type="button" class="delete-user" data-id="{{ $usager->id }}">
                                                <span class="iconify h-10 w-10" data-icon="mdi:bin" data-inline="false"></span>
                                                </button>
                                            </div>    
                                            <div class="relative hidden lg:block">
                                                <button type="button" class="delete-user" data-id="{{ $usager->id }}">Supprimer employer</button>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                    <div class="py-1 px-4 flex justify-center">
                        {{ $usagers->links('pagination::tailwind') }}
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
            <script>
    var updateUsagerUrl = "{{ route('usagers.update') }}";
</script>
<script src="{{ asset('js/Admin/admin.js') }}"></script>

</div>

<script>

    document.getElementById('dropdownToggle').addEventListener('click', function() {
        var menu = document.getElementById('menuDropdown');
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
        } else {
            menu.classList.add('hidden');
        }
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

        element.classList.add('bg-gray-200');
        element.querySelector('.arrow').classList.remove('hidden');
        document.getElementById(targetId).classList.remove('hidden');
    }
</script>

@endsection
