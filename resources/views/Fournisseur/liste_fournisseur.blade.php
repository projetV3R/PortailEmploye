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
            /* Style pour le rectangle d'affichage des entreprises sélectionnées */
            #selected-companies {
                width: 300px;
                /* Largeur fixe du rectangle */
                height: 100px;
                /* Hauteur fixe du rectangle */
                padding: 8px;
                background-color: #f9fafb;
                /* Fond gris clair */
                border: 1px solid #d1d5db;
                /* Bordure grise */
                border-radius: 8px;
                /* Coins arrondis */
                overflow-y: auto;
                /* Défilement vertical si le contenu dépasse */
                overflow-x: hidden;
                /* Masquer le défilement horizontal */
                white-space: normal;
                /* Permettre le retour à la ligne du texte */
                word-break: break-word;
                /* Couper les mots trop longs pour éviter le débordement */
            }
        </style>

        <div id="action-buttons" class="mb-4 flex justify-between items-center">
            <!-- Boutons alignés à gauche -->
            <div class="flex space-x-4">
                <button id="outlook-button"
                    class="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    <span class="iconify" data-icon="mdi:email-sync-outline"></span>
                    <span class="font-Alumni">Outlook</span>
                </button>
                <button id="excel-button"
                    class="flex items-center space-x-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    <span class="iconify" data-icon="mdi:file-excel"></span>
                    <span class="font-Alumni">Excel</span>
                </button>
                <button class="flex items-center space-x-2 px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                    <span class="iconify" data-icon="mdi:currency-usd"></span>
                    <span class="font-Alumni">Finances</span>
                </button>
                <button id="copy-button"
                    class="flex items-center space-x-2 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    <span class="iconify" data-icon="mdi:email-multiple"></span>
                    <span class="font-Alumni">Copier</span>
                </button>
            </div>

            <!-- Cadre aligné à droite -->
            <div id="selected-companies"
                class="text-sm text-gray-600 w-52 h-16 p-2 bg-gray-100 border border-gray-300 rounded overflow-y-auto">
                <p class="text-xs font-semibold text-gray-500 mb-1">Éléments sélectionnés</p>
                <!-- Zone pour afficher les noms des entreprises sélectionnées -->
            </div>
        </div>



        <!-- Options de sélection du nombre d'éléments par page -->
        <div class="mb-4">
            <label for="items-per-page" class="text-sm text-gray-600 font-Alumni md:text-lg">Afficher par :</label>
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
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
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
            <div class="text-sm text-gray-600 font-Alumni md:text-lg">
                Affichage de <span id="current-count">0</span> sur <span id="total">0</span> éléments
            </div>
            <div class="flex space-x-2">
                <button onclick="previousPage()"
                    class="font-Alumni md:text-lg bg-primary-300 text-gray-700 px-4 py-2 hover:bg-secondary-300">
                    Précédent
                </button>
                <div id="page-buttons" class="flex space-x-0">
                    <!-- Les boutons de page seront insérés ici -->
                </div>
                <button onclick="nextPage()"
                    class="font-Alumni md:text-lg bg-primary-300 text-gray-700 px-4 py-2 hover:bg-secondary-300">
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

        document.addEventListener("DOMContentLoaded", fetchData);

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

                    data.data.forEach(fiche => {
                        const etatStyle = etatStyles[fiche.etat] || {
                            textColor: '',
                            icon: '',
                            text: fiche.etat
                        };
                        const row = document.createElement('tr');
                        row.classList.add('bg-white', 'border-b', 'hover:bg-gray-50');
                        row.dataset.id = fiche.id;
                        row.dataset.name = fiche.nom_entreprise;
                        row.dataset.email = fiche.adresse_courriel;

                        const isChecked = selectedCompanies.some(item => item.id === fiche.id);

                        row.innerHTML = `
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           class="row-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                           onclick="toggleSelection(${fiche.id}, '${fiche.nom_entreprise}')"
                                           ${isChecked ? 'checked' : ''}>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">${fiche.nom_entreprise}</td>
                            <td class="px-6 py-4">${fiche.coordonnees?.ville || ''}</td>
                            <td class="px-6 py-4 ${etatStyle.textColor}">
                                <span class="flex items-center">
                                    <span class="iconify mr-1" data-icon="${etatStyle.icon}"></span>
                                    <span>${etatStyle.text}</span>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="${profilRoute.replace(':id', fiche.id)}" class="font-medium text-blue-600 hover:underline">Ouvrir</a>
                            </td>
                        `;
                        document.getElementById('fiches-content').appendChild(row);
                    });

                    generatePageButtons(data.last_page);
                })
                .catch(error => console.error('Erreur lors de la récupération des données :', error));
        }

        function toggleSelection(ficheId, companyName) {
            const index = selectedCompanies.findIndex(item => item.id === ficheId);
            if (index === -1) {
                selectedCompanies.push({
                    id: ficheId,
                    name: companyName
                });
            } else {
                selectedCompanies.splice(index, 1);
            }
            updateSelectedCompaniesDisplay();
        }

        function toggleSelectAll(checkbox) {
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
        }

        function updateSelectedCompaniesDisplay() {
            const selectedNames = selectedCompanies.map(company => company.name).join(', ');
            document.getElementById('selected-companies').textContent = selectedNames;
        }

        function generatePageButtons(totalPages) {
            const pageButtonsContainer = document.getElementById('page-buttons');
            pageButtonsContainer.innerHTML = '';

            for (let i = 1; i <= totalPages; i++) {
                const pageButton = document.createElement('button');
                pageButton.textContent = i;
                pageButton.className =
                    `px-3 py-1 font-Alumni ${i === currentPage ? 'bg-secondary-300 text-white' : 'bg-primary-300 text-gray-700 hover:bg-secondary-300'}`;
                pageButton.onclick = () => {
                    currentPage = i;
                    fetchData();
                };
                pageButtonsContainer.appendChild(pageButton);
            }
        }

        function nextPage() {
            currentPage++;
            fetchData();
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
        }

        // Fonctions pour les boutons d'action
        document.getElementById('outlook-button').addEventListener('click', () => {
            getSelectedCompanies();
            const emails = selectedCompanies.map(company => company.email).join(';');
            if (!emails) {
                alert("Aucune entreprise sélectionnée.");
                return;
            }
            window.location.href = `mailto:${emails}`;
            clearSelections();
        });

        document.getElementById('excel-button').addEventListener('click', () => {
            getSelectedCompanies();
            if (selectedCompanies.length === 0) {
                alert("Aucune entreprise sélectionnée.");
                return;
            }

            // Préparez les données de manière structurée
            const worksheetData = selectedCompanies.map(company => ({
                Nom: company.name,
                Email: company.email,
            }));

            // Créer le fichier Excel
            const worksheet = XLSX.utils.json_to_sheet(worksheetData);
            const workbook = XLSX.utils.book_new();

            // Ajouter la feuille au classeur
            XLSX.utils.book_append_sheet(workbook, worksheet, "Entreprises");

            // Générer le fichier avec le bon encodage et format
            try {
                XLSX.writeFile(workbook, "entreprises.xlsx", {
                    bookType: 'xlsx',
                    type: 'binary'
                });
                alert("Fichier Excel téléchargé avec succès.");
            } catch (error) {
                console.error("Erreur lors de la génération du fichier Excel :", error);
                alert("Une erreur s'est produite lors de la création du fichier Excel.");
            }
            clearSelections();
        });

        document.getElementById('copy-button').addEventListener('click', () => {
            getSelectedCompanies();
            const emails = selectedCompanies.map(company => company.email).join('; ');
            if (!emails) {
                alert("Aucune entreprise sélectionnée.");
                return;
            }
            navigator.clipboard.writeText(emails).then(() => {
                alert("Emails copiés dans le presse-papiers.");
            }).catch(() => {
                alert("Erreur lors de la copie des emails.");
            });
            clearSelections();
        });

        // Fonction pour récupérer les entreprises sélectionnées
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
    </script>
@endsection
