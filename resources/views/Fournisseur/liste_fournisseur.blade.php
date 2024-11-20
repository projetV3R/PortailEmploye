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

    <!-- Tableau de données dynamique -->
    <div class="relative overflow-x-auto shadow-md rounded-lg">
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
    const profilRoute = @json(route('profil', ['id' => ':id']));
    const etatStyles = @json($etatStyles);
    let selectedCompanies = [];
    let currentPage = 1;
    let perPage = 5;
    let totalPages = 1;

    document.addEventListener("DOMContentLoaded", fetchData);

    document.addEventListener("DOMContentLoaded", () => {
        fetchData();
        setTimeout(() => {
            selectedCompanies =
                @json($selectedCompanies); // charge les entreprises sélectionnées depuis la session

            selectedCompanies.forEach(company => {
                const checkbox = document.querySelector(
                    `.row-checkbox[data-id="${company.id}"]`);
                if (checkbox) checkbox.checked = true;
            });
            updateSelectedCompaniesDisplay();
        }, 500);
    });



    function updatePagination() {
        perPage = document.getElementById('items-per-page').value;
        currentPage = 1;
        fetchData();
    }

    function fetchData() {
        axios.get(`{{ route('fiches.index') }}?page=${currentPage}&perPage=${perPage}`)
            .then(response => {
                const data = response.data;
                document.getElementById('fiches-content').innerHTML = '';
                document.getElementById('total').textContent = data.total;
                document.getElementById('current-count').textContent = data.to;

                totalPages = data.last_page;

                data.data.forEach(fiche => {
                    const etatStyle = etatStyles[fiche.etat] || {
                        textColor: '',
                        icon: '',
                        text: fiche.etat
                    };
                    const row = document.createElement('tr');
                    row.classList.add('bg-white', 'border-b', 'hover:bg-gray-50', 'daltonien:hover:bg-gray-200', 'daltonien:text-black');
                    row.dataset.id = fiche.id;
                    row.dataset.name = fiche.nom_entreprise;
                    row.dataset.email = fiche.adresse_courriel;

                    // Vérifie si l'entreprise est déjà sélectionnée ou si "Tout sélectionner" est activé
                    const isChecked = selectedCompanies.some(item => item.id === fiche.id) || document
                        .getElementById('checkbox-all').checked;

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
                    document.getElementById('fiches-content').appendChild(row);

                    // Si "Tout sélectionner" est activé, ajoute l'entreprise à la sélection si elle ne l'est pas déjà
                    if (document.getElementById('checkbox-all').checked && !selectedCompanies.some(item =>
                            item.id === fiche.id)) {
                        selectedCompanies.push({
                            id: fiche.id,
                            name: fiche.nom_entreprise
                        });
                    }
                });

                // Met à jour l'affichage des entreprises sélectionnées et la pagination
                updateSelectedCompaniesDisplay();
                generatePageButtons(totalPages);
                sessionStorage.setItem('selectedCompanies', JSON.stringify(selectedCompanies));
                updateCheckboxAllState(); // Vérifie si toutes les cases de la page sont cochées
            })
            .catch(error => console.error('Erreur lors de la récupération des données :', error));
    }

    function toggleSelection(ficheId, companyName, email) {
        const index = selectedCompanies.findIndex(item => item.id === ficheId);
        if (index === -1) {
            selectedCompanies.push({
                id: ficheId,
                name: companyName,
                email: email
            });
        } else {
            selectedCompanies.splice(index, 1);
        }
        updateSelectedCompaniesDisplay();
        saveSelection(); // Sauvegarde en session après chaque modification
    }


    function saveSelection() {
        axios.post("{{ route('update.selection') }}", {
                selectedCompanies: selectedCompanies // Utilisez bien `selectedCompanies`
            })
            .then(response => console.log(response.data.message))
            .catch(error => console.error('Erreur de mise à jour de la sélection :', error));
    }



    /*function toggleSelectAll(checkbox) {
        selectedCompanies = [];
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(box => {
            const row = box.closest('tr');
            const ficheId = parseInt(row.dataset.id);
            const companyName = row.dataset.name;
            box.checked = checkbox.checked;
            if (checkbox.checked) {
                selectedCompanies.push({
                    id: ficheId,
                    name: companyName
                });
            }
        });
        updateSelectedCompaniesDisplay();
        saveSelection(); // Ajout pour sauvegarder la liste vide en session si tout est décoché
    }*/


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

        document.getElementById('counter').textContent = `Elements selectionnees (${selectedCompanies.length})`;
    }


    function removeCompany(index, companyId) {
        // Supprime l'entreprise sélectionnée à l'index spécifié
        selectedCompanies.splice(index, 1);

        // Met à jour l'affichage des entreprises sélectionnées
        updateSelectedCompaniesDisplay();

        // Décoche la case correspondante dans le tableau principal
        const checkbox = document.querySelector(`.row-checkbox[data-id="${companyId}"]`);
        if (checkbox) {
            checkbox.checked = false;
        }

        // Sauvegarde la sélection mise à jour
        saveSelection();
    }


    function generatePageButtons(totalPages) {
        const pageButtonsContainer = document.getElementById('page-buttons');
        const previousButton = document.querySelector('button[onclick="previousPage()"]');
        const nextButton = document.querySelector('button[onclick="nextPage()"]');
        pageButtonsContainer.innerHTML = '';

        // Active/Désactive le bouton "Précédent"
        if (currentPage === 1) {
            previousButton.classList.add('cursor-not-allowed', 'opacity-50');
            previousButton.disabled = true;
        } else {
            previousButton.classList.remove('cursor-not-allowed', 'opacity-50');
            previousButton.disabled = false;
        }

        // Active/Désactive le bouton "Suivant"
        if (currentPage === totalPages) {
            nextButton.classList.add('cursor-not-allowed', 'opacity-50');
            nextButton.disabled = true;
        } else {
            nextButton.classList.remove('cursor-not-allowed', 'opacity-50');
            nextButton.disabled = false;
        }

        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement('button');
            pageButton.textContent = i;
            pageButton.className =
                `px-3 py-1 font-Alumni ${i === currentPage ? 'bg-secondary-300 text-white' : ' hidden bg-primary-300 text-gray-700 hover:bg-secondary-300'}`;
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

    // Fonction pour vider la sélection
    function clearSelections() {
        selectedCompanies = [];
        document.querySelectorAll('.row-checkbox').forEach(box => box.checked = false);
        document.getElementById('checkbox-all').checked = false;
        updateSelectedCompaniesDisplay();
        saveSelection();
    }

    document.getElementById('counter').addEventListener

    // Fonctions pour les boutons d'action
    document.getElementById('outlook-button').addEventListener('click', () => {
        // Récupère le contenu de la zone de texte
        const selectedCompaniesText = document.getElementById('selected-companies').textContent;

        // Transforme le contenu en un tableau d'objets (si nécessaire)
        if (!selectedCompaniesText.trim()) {
            Swal.fire({
                icon: 'warning',
                title: 'Aucune sélection',
                text: 'Aucune entreprise sélectionnée.',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Crée un tableau des emails en extrayant les informations stockées dans `selectedCompanies`
        const emails = selectedCompanies.map(company => company.email).join(';');

        // Vérifie s'il y a des emails sélectionnés et ouvre le client de messagerie
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
        //getSelectedCompanies();
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

    function getSelectedCompanies() {
        selectedCompanies = [];
        document.querySelectorAll('.row-checkbox:checked').forEach(checkbox => {
            const row = checkbox.closest('tr');
            const email = row.dataset.email;
            const companyName = row.dataset.name;

            selectedCompanies.push({
                name: companyName,
                email: email,
            });
        });
    }

    window.addEventListener('pageshow', function(event) {
        if (sessionStorage.getItem('fromProfilePage')) {
            sessionStorage.removeItem(
                'fromProfilePage');
            location.reload();
        }
    });
</script>
@endsection