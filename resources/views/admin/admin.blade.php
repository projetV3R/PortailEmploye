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


    <div class="flex flex-col justify-center" id="usersDiv">
    <div class="flex flex-col">
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
    
    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
        <thead class="bg-gray-50 dark:bg-neutral-700">
            <tr>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">ID</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Mail</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Role</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
            @foreach($usagers as $usager)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                        {{$usager->id}}
                        <input type="hidden" name="usagers[{{ $usager->id }}][id]" value="{{ $usager->id }}">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                        {{$usager->email}}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                        <select name="usagers[{{ $usager->id }}][role]" class="role-dropdown">
                            <option value="admin" {{ $usager->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="responsable" {{ $usager->role == 'responsable' ? 'selected' : '' }}>Responsable</option>
                            <option value="commis" {{ $usager->role == 'commis' ? 'selected' : '' }}>Commis</option>
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="py-4">
        <button type="button" id="save-roles-btn" class="bg-blue-500 text-white px-4 py-2 rounded">Enregistrer toutes les modifications</button>
    </div>
</form>


            <div class="py-1 px-4">
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
            <h2 class="text-2xl font-bold mb-6 flex justify-center">Gestion des paramètres</h2>
        
            <div class="border p-6 rounded-lg shadow-md">
                <form id="parametres-form">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email_approvisionnement" class="block font-medium text-lg">Courriel de l'Approvisionnement</label>
                        <input type="email" name="email_approvisionnement" id="email_approvisionnement"
                            class="w-full border rounded p-2 mt-1">
                    </div>
        
                    <div class="mb-4">
                        <label for="mois_revision" class="block font-medium text-lg">Délai avant la révision (mois)</label>
                        <input type="number" name="mois_revision" id="mois_revision" min="1" max="36"
                            class="w-full border rounded p-2 mt-1">
                    </div>
        
                    <div class="mb-4">
                        <label for="taille_fichier" class="block font-medium text-lg">Taille maximale des fichiers joints (Mo)</label>
                        <input type="number" name="taille_fichier" id="taille_fichier" min="1" max="75"
                            class="w-full border rounded p-2 mt-1">
                    </div>
        
                    <div class="mb-4">
                        <label for="email_finances" class="block font-medium text-lg">Courriel des Finances</label>
                        <input type="email" name="email_finances" id="email_finances"
                            class="w-full border rounded p-2 mt-1">
                    </div>
        
                    <button type="submit" class="w-full bg-blue-500 text-white rounded p-2 hover:bg-blue-600">Enregistrer</button>
                </form>
            </div>
        </div>
        <!-- Script gestion parametres systemes  -->
            <script src="{{ asset('js/Admin/parametres.js') }}"></script>
      

</div>

<script>
$(document).ready(function() {
    $('#save-roles-btn').click(function(e) {
        e.preventDefault(); // Empêche le rechargement de la page

        let formData = $('#update-roles-form').serialize(); // Sérialise les données du formulaire
        
        $.ajax({
            url: "{{ route('usagers.update') }}", // Route définie pour le contrôleur
            type: "POST",
            data: formData,
            success: function(response) {
                if(response.success) {
                    alert('Modifications enregistrées avec succès.');
                } else {
                    alert('Une erreur est survenue.');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); // Affiche l'erreur dans la console pour débogage
                alert('Une erreur est survenue.');
            }
        });
    });
});




// Gestion de la pagination avec Ajax
$(document).on('click', '.pagination a', function(event) {
    event.preventDefault();
    let page = $(this).attr('href').split('page=')[1];
    fetch_data(page);
});

function fetch_data(page) {
    $.ajax({
        url: "/admin?page=" + page,
        success: function(data) {
            $('tbody').html(data);  // Recharge le tableau avec les nouvelles données
        }
    });
}

</script>

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
