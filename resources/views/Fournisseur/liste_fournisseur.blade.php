@extends('layouts.app')

@section('title', 'Accueil')

@section('header')
@endsection

@section('contenu')
@php
$etatStyles = [
'En attente' => [
'bgColor' => 'bg-yellow-100',
'textColor' => 'text-yellow-500',
'icon' => 'material-symbols:hourglass-top',
'labelColor' => 'text-yellow-600',
'text' => 'En attente',
],
'accepter' => [
'bgColor' => 'bg-green-100',
'textColor' => 'text-green-500',
'icon' => 'material-symbols:check-circle-outline',
'labelColor' => 'text-green-600',
'text' => 'Accepté',
],
'refuser' => [
'bgColor' => 'bg-red-100',
'textColor' => 'text-red-500',
'icon' => 'material-symbols:cancel',
'labelColor' => 'text-red-600',
'text' => 'Refusé',
],
'a reviser' => [
'bgColor' => 'bg-orange-100',
'textColor' => 'text-orange-500',
'icon' => 'material-symbols:edit',
'labelColor' => 'text-orange-600',
'text' => 'À réviser',
],
];
@endphp

<div class="px-8 pt-16">
    <style>
        #selected-companies {

            height: 100px;
            padding: 8px;
            background-color: #f9fafb;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            overflow-y: auto;
            overflow-x: hidden;
            white-space: normal;
            word-break: break-word;
        }

        .cursor-not-allowed {
            cursor: not-allowed;
        }

        .opacity-50 {
            opacity: 0.5;
        }
    </style>

    <div id="action-buttons" class="mb-4 flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
        <!-- Grille de boutons avec disposition responsive -->
        <div class="grid grid-cols-2 gap-1 w-full md:flex md:space-x-4 md:w-auto">
            <button id="outlook-button"
                class="flex items-center justify-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 w-full md:w-auto
                       daltonien:bg-daltonienBleu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black daltonien:text-black">
                <span class="iconify" data-icon="mdi:email-sync-outline"></span>
                <span class="font-Alumni"><b>Outlook</b></span>
            </button>
            <button id="excel-button"
                class="flex items-center justify-center space-x-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 w-full md:w-auto
                       daltonien:bg-daltonienBleu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black daltonien:text-black">
                <span class="iconify" data-icon="mdi:file-excel"></span>
                <span class="font-Alumni"><b>Excel</b></span>
            </button>
            <button
                class="flex items-center justify-center space-x-2 px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 w-full md:w-auto 
                       daltonien:bg-daltonienBleu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black daltonien:text-black">
                <span class="iconify" data-icon="mdi:currency-usd"></span>
                <span class="font-Alumni"><b>Finances</b></span>
            </button>
            <button id="copy-button"
                class="flex items-center justify-center space-x-2 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 w-full md:w-auto
                       daltonien:bg-daltonienBleu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black daltonien:text-black">
                <span class="iconify" data-icon="mdi:email-multiple"></span>
                <span class="font-Alumni"><b>Copier</b></span>
            </button>
        </div>

        <div class="w-full md:w-auto mt-4 md:mt-0">
            <div class="flex justify-between items-center mb-1">
                <p class="font-Alumni text-lg font-semibold text-gray-500 daltonien:text-black" id="counter">Éléments sélectionnés
                    ({{ count($selectedCompanies) }})</p>

            </div>
            <button onclick="clearSelections()"
                class="text-sm font-Alumni text-blue-500 hover:underline daltonien:text-black daltonien:hover:bg-daltonienBleu">
                Désélectionner tout
            </button>
            <div id="selected-companies"
                class="text-sm text-gray-600 w-full md:w-60 h-16 p-2 bg-gray-100 border border-gray-300 rounded overflow-y-auto flex daltonien:text-black">
                <!-- Zone pour afficher les noms des entreprises sélectionnées -->
            </div>
        </div>
    </div>


    <!-- Options de sélection du nombre d'éléments par page -->
    <div class="mb-4">
        <label for="items-per-page" class="text-sm text-gray-600 font-Alumni md:text-lg daltonien:text-black">Afficher par :</label>
        <select id="items-per-page" class="border rounded px-2 py-1 font-Alumni md:text-lg"
            onchange="updatePagination()">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
    </div>
    <div id="filters" class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 border-4 p-4 mb-4">
        <div class="w-full lg:w-1/5">
            <div id="etat-filter-bubbles" class="flex flex-wrap gap-2 mb-2 w-full h-16 max-h-16 overflow-y-auto">
            </div>
            <h3 class="font-bold text-lg mb-2 mt-8">État de la fiche</h3>
            <div id="etat-checkboxes" class="space-y-2 max-h-48 overflow-y-auto border p-2 rounded">
                <label class="flex items-center">
                    <input type="checkbox" value="En attente" class="etat-filter mr-2">
                    <span class="iconify" data-icon="material-symbols:hourglass-top"></span>   En attente
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="accepter" class="etat-filter mr-2">
                    <span class="iconify" data-icon="material-symbols:check-circle-outline"></span>  Accepté
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="refuser" class="etat-filter mr-2">
                    <span class="iconify" data-icon="material-symbols:cancel"></span>  Refusé
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="A reviser" class="etat-filter mr-2">
                    <span class="iconify" data-icon="material-symbols:hourglass-top"></span>  À réviser
                </label>
            </div>
        </div>
         <!-- Filtres par région administrative -->
         <div class="w-full lg:w-1/5">
            <div id="region-filter-bubbles" class="flex flex-wrap gap-2 mb-2 w-full h-16 max-h-16 overflow-y-auto">
          
            </div>
            <h3 class="font-bold text-lg mb-2 mt-8">Régions Administratives</h3>
            <div id="region-checkboxes" class="space-y-2 max-h-72 overflow-y-auto border p-2 rounded ">
                <label class="flex items-center">
                    <input type="checkbox" value="Bas-Saint-Laurent (01)" class="region-filter mr-2">
                    Bas-Saint-Laurent (01)
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="Saguenay-Lac-Saint-Jean (02)" class="region-filter mr-2">
                    Saguenay-Lac-Saint-Jean (02)
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="Capitale-Nationale (03)" class="region-filter mr-2">
                    Capitale-Nationale (03)
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="Mauricie (04)" class="region-filter mr-2">
                    Mauricie (04)
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="Estrie (05)" class="region-filter mr-2">
                    Estrie (05)
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="Montréal (06)" class="region-filter mr-2">
                    Montréal (06)
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="Outaouais (07)" class="region-filter mr-2">
                    Outaouais (07)
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="Abitibi-Témiscamingue (08)" class="region-filter mr-2">
                    Abitibi-Témiscamingue (08)
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="Côte-Nord (09)" class="region-filter mr-2">
                    Côte-Nord (09)
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="Nord-du-Québec (10)" class="region-filter mr-2">
                    Nord-du-Québec (10)
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="Gaspésie-Îles-de-la-Madeleine (11)" class="region-filter mr-2">
                    Gaspésie-Îles-de-la-Madeleine (11)
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="Chaudière-Appalaches (12)" class="region-filter mr-2">
                    Chaudière-Appalaches (12)
                </label>  <label class="flex items-center">
                    <input type="checkbox" value="Laval (13)" class="region-filter mr-2">
                    Laval (13)
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="Lanaudière (14)" class="region-filter mr-2">
                    Lanaudière (14)
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="Laurentides (15)" class="region-filter mr-2">
                    Laurentides (15)
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="Montérégie (16)" class="region-filter mr-2">
                    Montérégie (16)
                </label>
                <label class="flex items-center">
                    <input type="checkbox" value="Centre-du-Québec (17)" class="region-filter mr-2">
                    Centre-du-Québec (17)
                </label>
            </div>
        </div>
         <!-- Filtres par ville -->
         <div class="w-full lg:w-1/5">
            <div id="ville-filter-bubbles" class="flex flex-wrap gap-2 mb-2 w-full h-16 max-h-16 overflow-y-auto ">
          
            </div>
            <h3 class="font-bold text-lg mb-2 mt-8">Villes</h3>
            <div id="ville-checkboxes" class="space-y-2 max-h-72 overflow-y-auto border p-2 rounded">
         
            </div>
        </div>
        <div class="w-full lg:w-1/5">
            <div id="produits-filter-bubbles" class="flex flex-wrap gap-2 mb-2 w-full h-16 max-h-16 overflow-y-auto ">
                <div id="scroll-trigger" class="h-1"></div>
            </div>
            <h3 class="font-bold text-lg mb-2 mt-8">Produits&Services</h3>
       
            <div>     <select id="categorie-select" class="border px-2 py-1 w-full rounded-t ">
                <option value="">Toutes les catégories</option>
                <!-- Les options seront ajoutées dynamiquement -->
            </select></div><div id="produits-checkboxes" class="space-y-2 max-h-64 overflow-y-auto border p-2 rounded-b">
         
            </div>
        </div>

        <div class="w-full lg:w-1/5">
            <div id="licence-filter-bubbles" class="flex flex-wrap gap-2 mb-2 w-full h-16 max-h-16 overflow-y-auto"></div>
            <h3 class="font-bold text-lg mb-2 mt-8">Sous-Catégories</h3>
            <div id="licence-checkboxes" class="space-y-2 max-h-72 overflow-y-auto border p-2 rounded">
               
            </div>
        </div>
        
       
    
       
    </div>
    
    
    
    <div class="flex items-center justify-end mb-4 w-full">
        <span class="iconify size-8" data-icon="material-symbols:search"></span>
 <input type="text" id="search-bar" class="border-4 rounded px-2 py-1 w-full md:w-1/2 daltonien:text-black daltonien:border-black" placeholder="Rechercher une entreprise, un courriel d'entreprise, un nom ou prénom d'un contact " 
 oninput="fetchData()"   />   
    </div>
    <!-- Tableau de données dynamique -->
    <div class="relative overflow-x-auto shadow-md border-2 rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 font-Alumni md:text-xl">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 daltonien:text-black daltonien:border border-black">
                <tr>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            <input id="checkbox-all" type="checkbox" onclick="toggleSelectAll(this)"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="checkbox-all" class="sr-only">checkbox</label>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 md:text-xl">Nom Entreprise</th>
                    <th scope="col" class="px-6 py-3 md:text-xl">Ville</th>
                    <th scope="col" class="px-6 py-3 md:text-xl">État</th>
                    <th scope="col" class="px-6 py-3 md:text-xl">Action</th>
                </tr>
            </thead>
            <tbody id="fiches-content">
                <!-- Contenu dynamique ajouté par JavaScript -->
            </tbody>
        </table>
    </div>

    <!-- Pagination Controls -->
    <div class="flex items-center justify-between mt-4">
        <div class="text-sm text-gray-600 font-Alumni md:text-lg daltonien:text-black">
            Affichage de <span id="current-count">0</span> sur <span id="total">0</span> éléments
        </div>
        <div class="flex space-x-2">
            <button onclick="previousPage()"
                class="font-Alumni md:text-lg bg-primary-300 text-gray-700 px-4 py-2 hover:bg-secondary-300
                       daltonien:bg-daltonienBleu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black">
                Précédent
            </button>

            <!-- delete? -->
            <div id="page-buttons" class="flex space-x-0 daltonien:bg-daltonienBleu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black">
                <!-- Les boutons de page seront insérés ici -->
            </div>

            <button onclick="nextPage()"
                class="font-Alumni md:text-lg bg-primary-300 text-gray-700 px-4 py-2 hover:bg-secondary-300
                       daltonien:bg-daltonienBleu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black">
                Suivant
            </button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
<script>
    let loadedProduitIds = []; 
    const profilRoute = @json(route('profil', ['id' => ':id']));
    const etatStyles = @json($etatStyles);
    let selectedCompanies = @json($selectedCompanies); 
    let currentPage = 1;
    let perPage = 5;
    let totalPages = 1;

    document.addEventListener("DOMContentLoaded", async () => {
        await restoreFilters();
        await fetchData();
        await populateCategorieSelect(); 
        await updateSousCategoriesFilters();
        updateSelectedCompaniesDisplay();
        
    });

    function updatePagination() {
        perPage = document.getElementById('items-per-page').value;
        currentPage = 1;
        fetchData();
    }

   
    document.querySelectorAll('.region-filter').forEach(checkbox => {
        checkbox.addEventListener('change', async () => {
            currentPage = 1;
            saveFilters();
            await updateCityFilters();
            await updateProduitsFilters();
            await fetchData();
            await populateCategorieSelect();
        });
    });

    async function updateCityFilters(selectedVilles = []) {
    const regions = Array.from(document.querySelectorAll('.region-filter:checked')).map(el => el.value);
    const produits = Array.from(document.querySelectorAll('.produits-filter:checked')).map(el => el.value);

    try {
        const response = await axios.get('{{ route('get.villes') }}', {
            params: { regions, produits }
        });

        const villes = response.data.villesDisponibles || [];
        const villeCheckboxesContainer = document.getElementById('ville-checkboxes');
        villeCheckboxesContainer.innerHTML = '';

        selectedVilles = selectedVilles.filter(ville => villes.includes(ville));
        localStorage.setItem('selectedVilles', JSON.stringify(selectedVilles));

        villes.forEach(ville => {
            const label = document.createElement('label');
            label.classList.add('flex', 'items-center');
            label.innerHTML = `
                <input type="checkbox" value="${ville}" class="ville-filter mr-2">
                ${ville}
            `;
            villeCheckboxesContainer.appendChild(label);
        });

        document.querySelectorAll('.ville-filter').forEach(checkbox => {
            if (selectedVilles.includes(checkbox.value)) {
                checkbox.checked = true;
            }
            checkbox.addEventListener('change', async () => {
                saveFilters();
                await populateCategorieSelect(); 
                await updateProduitsFilters();
                await fetchData(); 
            });
        });

        updateFilterBubbles();
    } catch (error) {
        console.error('Erreur lors de la récupération des villes :', error);
    }
}

document.querySelectorAll('.etat-filter').forEach(checkbox => {
            checkbox.addEventListener('change', async () => {
                saveFilters();
                await fetchData();
            });
        });

        async function updateSousCategoriesFilters() {
    const regions = Array.from(document.querySelectorAll('.region-filter:checked')).map(el => el.value);
    const villes = Array.from(document.querySelectorAll('.ville-filter:checked')).map(el => el.value);

    try {
        const response = await axios.get('{{ route('get.sousCategoriesFilter') }}', {
            params: { regions, villes }
        });

        const sousCategories = response.data.sousCategories || [];
        const sousCategorieCheckboxesContainer = document.getElementById('licence-checkboxes');
        sousCategorieCheckboxesContainer.innerHTML = '';

   
        const selectedLicences = JSON.parse(localStorage.getItem('selectedLicences')) || [];

        sousCategories.forEach(sousCategorie => {
            const isChecked = selectedLicences.some(
                licence => licence.id === sousCategorie.id.toString() 
            );

            const label = document.createElement('label');
            label.classList.add('flex', 'items-center', 'ml-4');
            label.innerHTML = `
                <input type="checkbox" value="${sousCategorie.id}" class="sous-categorie-filter mr-2" ${
                isChecked ? 'checked' : ''
            }>
                ${sousCategorie.code_sous_categorie}
            `;
            sousCategorieCheckboxesContainer.appendChild(label);
        });

        document.querySelectorAll('.sous-categorie-filter').forEach(checkbox => {
            checkbox.addEventListener('change', async () => {
                saveFilters();
                await fetchData();
            });
        });
    } catch (error) {
        console.error('Erreur lors du chargement des sous-catégories :', error);
    }
}


document.querySelectorAll('.region-filter, .ville-filter').forEach(checkbox => {
    checkbox.addEventListener('change', updateSousCategoriesFilters);
});

    async function updateProduitsFilters(selectedProduits = []) {
    produitsPage = 1; 
    loadedProduitIds = []; 
    const regions = Array.from(document.querySelectorAll('.region-filter:checked')).map(el => el.value);
    const villes = Array.from(document.querySelectorAll('.ville-filter:checked')).map(el => el.value);
    const selectedCategorie = document.getElementById('categorie-select').value; 

    try {
        const response = await axios.get('{{ route('get.produits') }}', {
            params: { regions, villes, categorie: selectedCategorie }
        });

        const produits = response.data.produitsDisponibles || [];
        const produitsCheckboxesContainer = document.getElementById('produits-checkboxes');

        produitsCheckboxesContainer.innerHTML = ''; 
       
       if (produits.length === 0) {
            produitsCheckboxesContainer.innerHTML = `
                <p class="text-gray-500 text-center font-Alumni mt-4">
                    Pas de produits ou services disponibles avec les filtres appliqués.
                </p>`;
            return;
        }
        produits.forEach(produit => {
            if (!loadedProduitIds.includes(produit.id)) {
                loadedProduitIds.push(produit.id); 

                const label = document.createElement('label');
                label.classList.add('flex', 'items-center');
                label.innerHTML = `
                    <input type="checkbox" value="${produit.id}" class="produits-filter mr-2">
                    ${produit.description}
                `;
                produitsCheckboxesContainer.appendChild(label);
            }
        });

        
        document.querySelectorAll('.produits-filter').forEach(checkbox => {
            if (selectedProduits.some(p => p.id === checkbox.value)) {
                checkbox.checked = true;
            }
            checkbox.addEventListener('change', async () => {
                saveFilters();
                await fetchData();
            });
        });

    } catch (error) {
        console.error('Erreur lors de la récupération des produits :', error);
    }
}

async function populateCategorieSelect() {
    const regions = Array.from(document.querySelectorAll('.region-filter:checked')).map(el => el.value) || [];
    const villes = Array.from(document.querySelectorAll('.ville-filter:checked')).map(el => el.value) || [];

    try {
        const response = await axios.get('{{ route('get.categories') }}', {
            params: {
                regions,
                villes
            }
        });

        const categories = response.data.categories || [];
        const categorieSelect = document.getElementById('categorie-select');

       
        categorieSelect.innerHTML = '<option value="">Toutes les catégories</option>';

     
        categories.forEach(categorie => {
            const option = document.createElement('option');
            option.value = categorie;
            option.textContent = categorie;
            categorieSelect.appendChild(option);
        });

        console.log('Catégories mises à jour:', categories);
    } catch (error) {
        console.error('Erreur lors du peuplage des catégories :', error);
    }
}


document.getElementById('categorie-select').addEventListener('change', async () => {
    await updateProduitsFilters(); 
});

let produitsLoading = false;
let produitsPage = 1; 
const produitsCheckboxesContainer = document.getElementById('produits-checkboxes');


async function loadMoreProduits() {
    if (produitsLoading) return; 
    produitsLoading = true;

    const regions = Array.from(document.querySelectorAll('.region-filter:checked')).map(el => el.value);
    const villes = Array.from(document.querySelectorAll('.ville-filter:checked')).map(el => el.value);
    const selectedCategorie = document.getElementById('categorie-select').value; 

    try {
        const response = await axios.get('{{ route('get.produits') }}', {
            params: { 
                regions, 
                villes, 
                categorie: selectedCategorie, 
                page: produitsPage, 
                perPage: 100
            },
        });

        const produits = response.data.produitsDisponibles || [];
        const currentPage = response.data.current_page;
        const lastPage = response.data.last_page;

       
        if (currentPage >= lastPage || produits.length === 0) {
            console.log('Aucun produit supplémentaire disponible.');
            produitsLoading = false; // Stoppe le lazy loading
            return;
        }

        produitsPage++; 

        produits.forEach(produit => {
            // Vérifiez si le produit est déjà chargé
            if (!loadedProduitIds.includes(produit.id)) {
                loadedProduitIds.push(produit.id); 

                const label = document.createElement('label');
                label.classList.add('flex', 'items-center');
                label.innerHTML = `
                    <input type="checkbox" value="${produit.id}" class="produits-filter mr-2">
                    ${produit.description}
                `;
                produitsCheckboxesContainer.appendChild(label);
            }
        });

 
        document.querySelectorAll('.produits-filter').forEach(checkbox => {
            checkbox.addEventListener('change', async () => {
                saveFilters();
                await fetchData();
            });
        });

    } catch (error) {
        console.error('Erreur lors du chargement des produits :', error);
    } finally {
        produitsLoading = false;
    }
}





produitsCheckboxesContainer.addEventListener('scroll', () => {
    if (
        produitsCheckboxesContainer.scrollTop + produitsCheckboxesContainer.clientHeight >= 
        produitsCheckboxesContainer.scrollHeight
    ) {
        if (!produitsLoading) {
            loadMoreProduits(); 
        }
    }
});




    async function fetchData() {
        const regions = Array.from(document.querySelectorAll('.region-filter:checked')).map(el => el.value);
        const villes = Array.from(document.querySelectorAll('.ville-filter:checked')).map(el => el.value);
        const licences = Array.from(document.querySelectorAll('.sous-categorie-filter:checked')).map(el => el.value);
        const produits = JSON.parse(localStorage.getItem('selectedProduits'))?.map(p => p.id) || [];
        const etats = Array.from(document.querySelectorAll('.etat-filter:checked')).map(el => el.value);
        const searchQuery = document.getElementById('search-bar').value;
        try {
            const response = await axios.get(`{{ route('fiches.index') }}`, {
                params: {
                    page: currentPage,
                    perPage: perPage,
                    regions: regions,
                    villes: villes,
                    produits: produits,
                    licences:licences,
                    etats: etats,
                    search:searchQuery,
                }
            });

            const data = response.data;
            const contentContainer =document.getElementById('fiches-content');
            document.getElementById('total').textContent = data.total;
            document.getElementById('current-count').textContent = data.to;
            contentContainer.innerHTML = '';
            totalPages = data.last_page;
            if (data.data.length === 0) {
       
            const noDataRow = document.createElement('tr');
            noDataRow.innerHTML = `
                <td colspan="5" class="text-center text-gray-500 font-Alumni py-4">
                    <span>Aucune fiche fournisseur trouvée avec les filtres appliqués.</span>
                </td>
            `;
            contentContainer.appendChild(noDataRow);
            return;
        }
            data.data.forEach(fiche => {
                const etatStyle = etatStyles[fiche.etat] || { textColor: '', icon: '', text: fiche.etat };
                const row = document.createElement('tr');
                row.classList.add('bg-white', 'border-b', 'hover:bg-gray-50', 'daltonien:hover:bg-gray-200', 'daltonien:text-black');
                row.dataset.id = fiche.id;
                row.dataset.name = fiche.nom_entreprise;
                row.dataset.email = fiche.adresse_courriel;

                const isChecked = selectedCompanies.some(item => item.id === fiche.id) || document.getElementById('checkbox-all').checked;

                row.innerHTML = `
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   class="row-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                   onclick="toggleSelection(${fiche.id}, '${fiche.nom_entreprise}', '${fiche.adresse_courriel}' )"
                                   ${isChecked ? 'checked' : ''} data-id="${fiche.id}">
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">${fiche.nom_entreprise}</td>
                    <td class="px-6 py-4">${fiche.coordonnees?.ville || ''}</td>
                    <td class="px-6 py-4 ${etatStyle.textColor} daltonien:text-black">
                        <span class="flex items-center">
                            <span class="iconify mr-1" data-icon="${etatStyle.icon}"></span>
                            <span>${etatStyle.text}</span>
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="${profilRoute.replace(':id', fiche.id)}" class="font-medium text-blue-600 hover:underline daltonien:text-black daltonien:hover:bg-daltonienBleu">Ouvrir</a>
                    </td>
                `;
                contentContainer.appendChild(row);

                if (document.getElementById('checkbox-all').checked && !selectedCompanies.some(item => item.id === fiche.id)) {
                    selectedCompanies.push({ id: fiche.id, name: fiche.nom_entreprise, email: fiche.adresse_courriel });
                }
            });

           
            selectedCompanies.forEach(company => {
                const checkbox = document.querySelector(`.row-checkbox[data-id="${company.id}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });

            updateSelectedCompaniesDisplay();
            generatePageButtons(totalPages);
            sessionStorage.setItem('selectedCompanies', JSON.stringify(selectedCompanies));
            updateCheckboxAllState();
        } catch (error) {
            console.error('Erreur lors de la récupération des données :', error);
        }
    }

    function toggleSelection(ficheId, companyName, email) {
        const index = selectedCompanies.findIndex(item => item.id === ficheId);
        if (index === -1) {
            selectedCompanies.push({ id: ficheId, name: companyName, email: email });
        } else {
            selectedCompanies.splice(index, 1);
        }
        updateSelectedCompaniesDisplay();
        saveSelection();
    }

    function saveSelection() {
        axios.post("{{ route('update.selection') }}", { selectedCompanies })
            .then(response => console.log(response.data.message))
            .catch(error => console.error('Erreur de mise à jour de la sélection :', error));
    }

    function updateSelectedCompaniesDisplay() {
        const selectedListItems = selectedCompanies
            .map((company, index) => `
                <li style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 5px;">
                    ${company.name}
                    <button onclick="removeCompany(${index}, ${company.id})" style="margin-left: 10px; cursor: pointer;">❌</button>
                </li>
            `)
            .join('');

        const selectedCompaniesContainer = document.getElementById('selected-companies');
        selectedCompaniesContainer.style.display = 'flex';
        selectedCompaniesContainer.style.flexDirection = 'column';
        selectedCompaniesContainer.innerHTML = selectedListItems;

        document.getElementById('counter').textContent = `Éléments sélectionnés (${selectedCompanies.length})`;
    }

    function removeCompany(index, companyId) {
        selectedCompanies.splice(index, 1);
        updateSelectedCompaniesDisplay();

        const checkbox = document.querySelector(`.row-checkbox[data-id="${companyId}"]`);
        if (checkbox) {
            checkbox.checked = false;
        }

        saveSelection();
    }

    function generatePageButtons(totalPages) {
        const pageButtonsContainer = document.getElementById('page-buttons');
        const previousButton = document.querySelector('button[onclick="previousPage()"]');
        const nextButton = document.querySelector('button[onclick="nextPage()"]');
        pageButtonsContainer.innerHTML = '';

        previousButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === totalPages;

        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement('button');
            pageButton.textContent = i;
            pageButton.className = `px-3 py-1 font-Alumni ${i === currentPage ? 'bg-secondary-300 text-white' : 'hidden bg-primary-300 text-gray-700 hover:bg-secondary-300'}`;
            pageButton.onclick = () => {
                currentPage = i;
                fetchData();
            };
            pageButtonsContainer.appendChild(pageButton);
        }
    }

    function nextPage() {
        if (currentPage < totalPages) {
            currentPage++;
            fetchData();
        }
    }

    function previousPage() {
        if (currentPage > 1) {
            currentPage--;
            fetchData();
        }
    }

    function clearSelections() {
        selectedCompanies = [];
        document.querySelectorAll('.row-checkbox').forEach(box => box.checked = false);
        document.getElementById('checkbox-all').checked = false;
        updateSelectedCompaniesDisplay();
        saveSelection();
    }

    // Boutons d'action
    document.getElementById('outlook-button').addEventListener('click', () => {
        if (selectedCompanies.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Aucune sélection',
                text: 'Aucune entreprise sélectionnée.',
                confirmButtonText: 'OK'
            });
            return;
        }

        const emails = selectedCompanies.map(company => company.email).join(';');

        if (emails) {
            window.location.href = `mailto:${emails}`;
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Erreur',
                text: 'Aucune adresse e-mail trouvée pour les entreprises sélectionnées.',
                confirmButtonText: 'OK'
            });
        }
    });

    document.getElementById('excel-button').addEventListener('click', () => {
            //getSelectedCompanies();
            if (selectedCompanies.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Aucune sélection',
                    text: 'Aucune entreprise sélectionnée.',
                    confirmButtonText: 'OK'
                });
                return;
            }
            const worksheetData = selectedCompanies.map(company => ({
                Nom: company.name,
                Email: company.email,
            }));
            const worksheet = XLSX.utils.json_to_sheet(worksheetData);
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Entreprises");
            try {
                XLSX.writeFile(workbook, "entreprises.xlsx", {
                    bookType: 'xlsx',
                    type: 'binary'
                });
                Swal.fire({
                    icon: 'success',
                    title: 'Téléchargement réussi',
                    text: 'Le fichier Excel a été téléchargé avec succès.',
                    confirmButtonText: 'OK'
                });
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Une erreur est survenue lors de la création du fichier Excel.',
                    confirmButtonText: 'OK'
                });
            }
        });
    document.getElementById('copy-button').addEventListener('click', () => {
        const emails = selectedCompanies.map(company => company.email).join('; ');
        if (!emails) {
            Swal.fire({
                icon: 'warning',
                title: 'Aucune sélection',
                text: 'Aucune entreprise sélectionnée.',
                confirmButtonText: 'OK'
            });
            return;
        }
        navigator.clipboard.writeText(emails).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Copie réussie',
                text: 'Les emails ont été copiés dans le presse-papiers.',
                confirmButtonText: 'OK'
            });
        }).catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Erreur de copie',
                text: 'Erreur lors de la copie des emails.',
                confirmButtonText: 'OK'
            });
        });
    });

    async function restoreFilters() {
    const selectedRegions = JSON.parse(localStorage.getItem('selectedRegions')) || [];
    const selectedVilles = JSON.parse(localStorage.getItem('selectedVilles')) || [];
    const selectedProduits = JSON.parse(localStorage.getItem('selectedProduits')) || [];
    const selectedLicences = JSON.parse(localStorage.getItem('selectedLicences')) || [];
    const selectedEtats = JSON.parse(localStorage.getItem('selectedEtats')) || [];
    loadedProduitIds = []; 


    selectedRegions.forEach(region => {
        document.querySelectorAll('.region-filter').forEach(checkbox => {
            if (checkbox.value === region) {
                checkbox.checked = true;
            }
        });
    });

    selectedEtats.forEach(etat => {
        document.querySelectorAll('.etat-filter').forEach(checkbox => {
            if (checkbox.value === etat) {
                checkbox.checked = true;
            }
        });
    });

   
    await updateCityFilters(selectedVilles);
    await populateCategorieSelect();
    await updateProduitsFilters(selectedProduits);
    await updateSousCategoriesFilters(selectedLicences);


    updateFilterBubbles();
}


    function saveFilters() {
        const selectedRegions = Array.from(document.querySelectorAll('.region-filter:checked')).map(el => el.value);
        const selectedVilles = Array.from(document.querySelectorAll('.ville-filter:checked')).map(el => el.value);
        const selectedProduits = Array.from(document.querySelectorAll('.produits-filter:checked')).map(el => {
    return {
        id: el.value,
        description: el.parentElement.textContent.trim()
    };
});
const selectedEtats = Array.from(document.querySelectorAll('.etat-filter:checked')).map(el => el.value); 
const selectedLicences = Array.from(document.querySelectorAll('.sous-categorie-filter:checked')).map(el => {
    return {
        id: el.value,
        code_sous_categorie: el.parentElement.textContent.trim()
    };
});

        localStorage.setItem('selectedRegions', JSON.stringify(selectedRegions));
        localStorage.setItem('selectedVilles', JSON.stringify(selectedVilles));
        localStorage.setItem('selectedProduits', JSON.stringify(selectedProduits));
        localStorage.setItem('selectedLicences',JSON.stringify(selectedLicences));
        localStorage.setItem('selectedEtats', JSON.stringify(selectedEtats));
        updateFilterBubbles();
    }

    function updateFilterBubbles() {
        const selectedRegions = JSON.parse(localStorage.getItem('selectedRegions')) || [];
        const selectedVilles = JSON.parse(localStorage.getItem('selectedVilles')) || [];
        const selectedProduits = JSON.parse(localStorage.getItem('selectedProduits')) || [];
        const selectedLicences = JSON.parse(localStorage.getItem('selectedLicences')) || [];
        const selectedEtats = JSON.parse(localStorage.getItem('selectedEtats')) || []
        updateRegionFilterBubbles(selectedRegions);
        updateVilleFilterBubbles(selectedVilles);
        updateProduitsFilterBubbles(selectedProduits);
        updateLicencesFilterBubbles(selectedLicences);
        updateEtatFilterBubbles(selectedEtats); 
    }


function updateEtatFilterBubbles(selectedEtats) {
    const etatBubblesContainer = document.getElementById('etat-filter-bubbles');
    etatBubblesContainer.innerHTML = '';

    selectedEtats.forEach(etat => {
        const bubble = document.createElement('span');
        bubble.classList.add('bg-blue-200', 'text-blue-800', 'text-sm', 'cursor-pointer', 'font-semibold', 'mr-2', 'px-2', 'py-1', 'rounded', 'flex', 'items-center', 'mb-2', 'hover:bg-red-500', 'hover:text-white', 'max-h-10');
        bubble.innerHTML = `
            ${etat}
            <span class="iconify w-4 h-4 ml-1" data-icon="material-symbols:close"></span>
        `;

        bubble.addEventListener('click', async () => {
            document.querySelectorAll('.etat-filter').forEach(checkbox => {
                if (checkbox.value === etat) {
                    checkbox.checked = false;
                }
            });
            saveFilters();
            await fetchData();
        });

        etatBubblesContainer.appendChild(bubble);
    });
}

    function updateRegionFilterBubbles(selectedRegions) {
        const regionBubblesContainer = document.getElementById('region-filter-bubbles');
        regionBubblesContainer.innerHTML = '';

        selectedRegions.forEach(region => {
            const bubble = document.createElement('span');
            bubble.classList.add('bg-blue-200', 'text-blue-800', 'text-sm', 'cursor-pointer', 'font-semibold', 'mr-2', 'px-2', 'py-1', 'rounded', 'flex', 'items-center', 'mb-2', 'hover:bg-red-500', 'hover:text-white', 'max-h-10','truncate');
            bubble.innerHTML = `
                ${region}
                <span class="iconify w-4 h-4 ml-1" data-icon="material-symbols:close"></span>
            `;

            bubble.addEventListener('click', async () => {
                document.querySelectorAll('.region-filter').forEach(checkbox => {
                    if (checkbox.value === region) {
                        checkbox.checked = false;
                    }
                });
                saveFilters();
                await updateCityFilters();
                await updateProduitsFilters();
                await populateCategorieSelect();
                await fetchData();
            });

            regionBubblesContainer.appendChild(bubble);
        });
    }
    function updateLicencesFilterBubbles(selectedLicences) {
        const licencesBubblesContainer = document.getElementById('licence-filter-bubbles');
        licencesBubblesContainer.innerHTML = '';

        selectedLicences.forEach(sousCategorie => {
            const bubble = document.createElement('span');
            bubble.classList.add('bg-blue-200', 'text-blue-800', 'text-sm', 'cursor-pointer', 'font-semibold', 'mr-2', 'px-2', 'py-1', 'rounded', 'flex', 'items-center', 'mb-2', 'hover:bg-red-500', 'hover:text-white', 'max-h-10');
            bubble.innerHTML = `
                 ${sousCategorie.code_sous_categorie}
                <span class="iconify w-4 h-4 ml-1" data-icon="material-symbols:close"></span>
            `;

            bubble.addEventListener('click', async () => {
                document.querySelectorAll('.sous-categorie-filter').forEach(checkbox => {
                    if (checkbox.value === sousCategorie.id) {
                        checkbox.checked = false;
                    }
                });
                saveFilters();
              await  updateSousCategoriesFilters();
                await fetchData();
            });

            licencesBubblesContainer.appendChild(bubble);
        });
    }

    function updateVilleFilterBubbles(selectedVilles) {
        const villeBubblesContainer = document.getElementById('ville-filter-bubbles');
        villeBubblesContainer.innerHTML = '';

        selectedVilles.forEach(ville => {
            const bubble = document.createElement('span');
            bubble.classList.add('bg-blue-200', 'text-blue-800', 'text-sm', 'cursor-pointer', 'font-semibold', 'mr-2', 'px-2', 'py-1', 'rounded', 'flex', 'items-center', 'mb-2', 'hover:bg-red-500', 'hover:text-white', 'max-h-10');
            bubble.innerHTML = `
                ${ville}
                <span class="iconify w-4 h-4 ml-1" data-icon="material-symbols:close"></span>
            `;

            bubble.addEventListener('click', async () => {
                document.querySelectorAll('.ville-filter').forEach(checkbox => {
                    if (checkbox.value === ville) {
                        checkbox.checked = false;
                    }
                });
                saveFilters();
                await updateProduitsFilters();
                await populateCategorieSelect();
                await fetchData();
            });

            villeBubblesContainer.appendChild(bubble);
        });
    }

    function updateProduitsFilterBubbles(selectedProduits) {
        const produitsBubblesContainer = document.getElementById('produits-filter-bubbles');
        produitsBubblesContainer.innerHTML = '';

        selectedProduits.forEach(produit => {
            const bubble = document.createElement('span');
            bubble.classList.add('bg-blue-200', 'text-blue-800', 'text-sm', 'cursor-pointer', 'font-semibold', 'mr-2', 'px-2', 'py-1', 'rounded', 'flex', 'items-center', 'mb-2', 'hover:bg-red-500', 'hover:text-white', 'max-h-10' );
            bubble.innerHTML = `
                ${produit.description}
                <span class="iconify w-4 h-4 ml-1" data-icon="material-symbols:close"></span>
            `;

            bubble.addEventListener('click', async () => {
                document.querySelectorAll('.produits-filter').forEach(checkbox => {
                    if (checkbox.value === produit.id) {
    checkbox.checked = false;
}

                });
                saveFilters();
                await fetchData();
            });

            produitsBubblesContainer.appendChild(bubble);
        });
    }

    function updateCheckboxAllState() {
        const allCheckboxes = document.querySelectorAll('.row-checkbox');
        const checkedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
        const selectAllCheckbox = document.getElementById('checkbox-all');

        if (allCheckboxes.length === checkedCheckboxes.length && allCheckboxes.length > 0) {
            selectAllCheckbox.checked = true;
            selectAllCheckbox.indeterminate = false;
        } else if (checkedCheckboxes.length > 0) {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = true;
        } else {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
        }
    }
</script>

@endsection