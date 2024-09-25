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
                <span class="iconify text-xl w-6 hidden arrow" data-icon="material-symbols:arrow-forward-ios-rounded"></span>
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


    <div class="flex flex-col justify-center w-full h-full bg-red-500" id="usersDiv">
    <div class="container mx-auto px-4">
        <h1 class="">Liste des Usagers</h1>
        
        <div class="grid grid-cols-3 gap-3">
            <table class="">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="">Email</th>
                        <th class="">Role</th>
                        <th class="">Modifier</th>
                        <th class="">Supprimer</th>
                    </tr>
                </thead>
                <tbody id="usagers-table" class="bg-white divide-y divide-gray-200">
                    <!-- Les Usagers seront chargés ici via Ajax -->
                </tbody>
            </table>
        </div>

        <div id="pagination-links" class="mt-4">
            <!-- Les liens de pagination seront affichés ici via Ajax -->
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            function loadUsagers(page = 1) {
                $.ajax({
                    url: "{{ route('admin.admin') }}?page=" + page,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        var usagerRows = '';
                        $.each(data.data, function(index, usager) {
                            usagerRows += `
                                <tr>
                                    <td class="">${usager.email}</td>
                                    <td class="">${usager.role}</td>
                                    <td class="">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                    </td>
                                    <td class="">
                                        <a href="#" class="text-red-600 hover:text-red-900">Supprimer</a>
                                    </td>
                                </tr>
                            `;
                        });
                        $('#usagers-table').html(usagerRows);

                        // Gérer les liens de pagination
                        var paginationLinks = '';
                        $.each(data.links, function(index, link) {
                            paginationLinks += `
                                <a href="#" class="px-2 py-1 ${link.active ? 'bg-blue-500 text-white' : 'bg-gray-200'}" data-page="${link.label}">
                                    ${link.label}
                                </a>
                            `;
                        });
                        $('#pagination-links').html(paginationLinks);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }

            // Charger la première page des Usagers
            loadUsagers();

            // Gestion des clics sur les liens de pagination
            $(document).on('click', '#pagination-links a', function(e) {
                e.preventDefault();
                var page = $(this).data('page');
                loadUsagers(page);
            });
        });
    </script>
    </div>
    <div class="flex flex-col justify-center w-full h-full bg-yellow-500 hidden" id="suppliersDiv"></div>
    <div class="flex flex-col justify-center w-full h-full bg-blue-500 hidden" id="settingsDiv"></div>

</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="crf-token"]').attr('content')
        }
    });
</script>
<script>
    $(document).ready(function()
    {
        
    });
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
