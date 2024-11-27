function initializeProduitsServicesFormScript() {
let selectedProductIds = [];
let selectedProducts = [];
const itemsPerPageSelected = 10; // 2 colonnes x 5 lignes
let currentPageSelected = 1;

    axios.get('/produits-services/multiple')
        .then(response => {
            selectedProducts = response.data;
            selectedProductIds = selectedProducts.map(produit => produit.id);
            updateHiddenInput();
            afficherProduitsSelectionnes();
            updateSelectedCount();

            // Initialiser les écouteurs d'événements
            initEventListeners();
        })
        .catch(error => {
            console.error("Erreur lors de la récupération des produits :", error);
        });


function initEventListeners() {
    const searchInput = document.getElementById('recherche');
    const selectCategorie = document.getElementById('selectCategorie');

    searchInput.addEventListener('input', () => {
        if (searchInput.value.length >= 3 || searchInput.value === '') {
            performSearch();
        }
    });

    selectCategorie.addEventListener('change', () => {
        performSearch();
    });

    // Appeler la fonction pour récupérer les catégories au chargement de la page
    getCategories();
    performSearch();

    const unspscButton = document.getElementById('unspscButton');

    unspscButton.addEventListener('click', () => {
        Swal.fire({
            title: 'Petit guide des codes UNSPSC',
            html: `
                <div class="text-left">
                    <p class="font-bold mb-2">Qu'est-ce qu'un code UNSPSC ?</p>
                    <p>Le code UNSPSC (United Nations Standard Products and Services Code) est un système de classification mondial qui attribue des codes uniques à des produits et services. Cet outil de recherche vous permet de trier les produits et services selon leur code UNSPSC, la nature, le code de catégorie, ou un élément de la description.</p>
                    <p class="font-bold mt-4 mb-2">Différentes catégories exemple :</p>
                    <ul class="list-disc pl-5">
                        <li><strong>C01</strong> - Bâtiments : Cette catégorie comprend tous les types de bâtiments, allant des maisons aux bâtiments commerciaux, et couvre une large gamme de constructions.</li>
                        <li><strong>C02</strong> - Ouvrages de génie civil : Cela inclut les infrastructures telles que les ponts, les routes, et autres travaux d'ingénierie civile.</li>
                        <li><strong>G10</strong> - Produits électriques et électroniques : Cette catégorie regroupe les équipements électriques et électroniques, tels que les circuits et les composants électriques.</li>
                        <li><strong>G15</strong> - Alimentation : Comprend les produits alimentaires, y compris les matières premières et les produits préparés.</li>
                        <li><strong>S18</strong> - Location à bail / Location d'équipement : Cette catégorie se rapporte à la location d'équipement pour divers besoins, tels que la construction ou l'industrie.</li>
                        <!-- Ajouter d'autres catégories selon les besoins -->
                    </ul>
                    <p class="font-bold mt-4 mb-2">Attributs disponibles pour la recherche :</p>
                    <ul class="list-disc pl-5">
                        <li><strong>Code UNSPSC</strong> : Un code unique qui identifie un produit ou un service composé uniquement de 8 chiffres. Exemple : "12345678" pour un équipement spécifique.</li>
                        <li><strong>Nature</strong> : Catégorie générale du produit ou service. Exemple : "Travaux de construction".</li>
                        <li><strong>Code de catégorie</strong> : Code qui correspond à un ensemble de produits ou services liés. Exemple : "C01" pour des bâtiments.</li>
                        <li><strong>Description</strong> : Une description textuelle qui permet de rechercher par mots-clés. Exemple : "Cafétéria" ou "Stationnement".</li>
                    </ul>
                </div>
            `,
            icon: 'info',
            confirmButtonText: 'Compris'
        });
    });
}

function performSearch(page = 1) {
    const query = document.getElementById('recherche').value.trim();
    const selectedCategory = document.getElementById('selectCategorie').value || null;

    axios.get('/search', {
        params: {
            recherche: query,
            categorie: selectedCategory,
            page
        }
    })
    .then(response => {
        afficherResultats(response.data.data);
        afficherPagination(response.data);
    })
    .catch(error => console.error("Erreur lors de la recherche :", error));
}

function afficherResultats(produits) {
    const resultsContainer = document.getElementById('toutLesProduitsServices');
    resultsContainer.innerHTML = produits.length
        ? produits.map(createProduitHTML).join('')
        : '<p class="font-Alumni text-md text-gray-600">Aucun produit ou service trouvé.</p>';
    assignClickEventsToProducts();
}

function afficherPagination(data) {
    const paginationContainer = document.getElementById('pagination');
    paginationContainer.innerHTML = `
        ${paginationButtons(data, 'performSearch')}
    `;
}

function paginationButtons(data, functionName) {
    return `
        <button type="button"
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-2 md:px-4 rounded-l
            ${!data.prev_page_url ? 'cursor-not-allowed' : ''}"
            onclick="${functionName}(1)" ${!data.prev_page_url ? 'disabled' : ''}>
            &lt;&lt;
        </button>
        <button type="button"
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-2 md:px-4
            ${!data.prev_page_url ? 'cursor-not-allowed' : ''}"
            onclick="${functionName}(${data.current_page - 1})" ${!data.prev_page_url ? 'disabled' : ''}>
            <span class="md:hidden">&lt;</span>
            <span class="hidden md:inline">Précédente</span>
        </button>
        <span class="text-xs font-bold mx-2">Page ${data.current_page} sur ${data.last_page}</span>
        <button type="button"
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-2 md:px-4
            ${!data.next_page_url ? 'cursor-not-allowed' : ''}"
            onclick="${functionName}(${data.current_page + 1})" ${!data.next_page_url ? 'disabled' : ''}>
            <span class="md:hidden">&gt;</span>
            <span class="hidden md:inline">Suivante</span>
        </button>
        <button type="button"
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-2 md:px-4 rounded-r
            ${!data.next_page_url ? 'cursor-not-allowed' : ''}"
            onclick="${functionName}(${data.last_page})" ${!data.next_page_url ? 'disabled' : ''}>
            &gt;&gt;
        </button>
    `;
}

function createProduitHTML(produit) {
    const isSelected = selectedProductIds.includes(produit.id);
    const iconHtml = isSelected
        ? '<span class="iconify size-4 md:size-8 lg:size-10 text-green-500" data-icon="material-symbols:check-circle"></span>'
        : '<span class="iconify size-4 md:size-8 lg:size-10 text-white" data-icon="material-symbols:add"></span>';

    return `
        <div class="bg-white cursor-pointer px-4 py-2 w-full flex flex-row produitService hover:bg-green-500"
            data-index="${produit.id}" data-unspsc="${produit.code_unspsc}">
            <div class="flex flex-col w-full">
                <h6 class="font-Alumni text-xs font-bold md:text-3xl">${produit.nature || 'Nature non disponible'}</h6>
                <h4 class="font-Alumni text-xs md:text-xl mt-2">${produit.code_categorie || ''}</h4>
                <h1 class="font-Alumni text-xs italic md:text-lg">${produit.code_unspsc || ''} - ${produit.description || ''}</h1>
            </div>
            <div class="flex flex-col items-end justify-start w-full">
                <div class="flex items-center justify-center bg-tertiary-400 md:p-2 rounded-full">
                    ${iconHtml}
                </div>
            </div>
        </div>`;
}

function assignClickEventsToProducts() {
    document.querySelectorAll('.produitService').forEach(item => {
        item.addEventListener('click', () => cloneProduit(item));
    });
}

function cloneProduit(item) {
    const productId = parseInt(item.getAttribute('data-index'), 10);

    if (selectedProductIds.includes(productId)) {
        afficherMessage("Ce produit est déjà dans la liste sélectionnée.");
        return;
    }

    selectedProductIds.push(productId);
    updateHiddenInput();

    const produit = {
        id: productId,
        nature: item.querySelector('h6').textContent,
        code_categorie: item.querySelector('h4').textContent,
        code_unspsc: item.getAttribute('data-unspsc'),
        description: item.querySelector('h1').textContent,
    };
    ajouterProduitSelectionneVisuellement(produit);

    const iconElement = item.querySelector('.iconify');
    if (iconElement) {
        iconElement.setAttribute('data-icon', 'material-symbols:check-circle');
        iconElement.classList.remove('text-white');
        iconElement.classList.add('text-green-500');
    }
}

function ajouterProduitSelectionneVisuellement(produit) {
    selectedProducts.push(produit);
    afficherProduitsSelectionnes();
    updateSelectedCount();
}

function afficherProduitsSelectionnes() {
    const produitsServicesSelectionnees = document.getElementById('produitsServicesSelectionnees');

    if (selectedProducts.length === 0) {
        produitsServicesSelectionnees.innerHTML = '<p class="font-Alumni text-md text-gray-600">Aucun produit ou service sélectionné.</p>';
        document.getElementById('paginationSelected').innerHTML = '';
        return;
    }

    // S'assurer que currentPageSelected est au moins 1
    currentPageSelected = Math.max(currentPageSelected, 1);

    const startIndex = (currentPageSelected - 1) * itemsPerPageSelected;
    const endIndex = startIndex + itemsPerPageSelected;
    const produitsPage = selectedProducts.slice(startIndex, endIndex);

    produitsServicesSelectionnees.innerHTML = produitsPage.map(produit => createProduitSelectionneHTML(produit)).join('');
    assignClickEventsToSelectedProducts();

    afficherPaginationSelected();
}

function createProduitSelectionneHTML(produit) {
    return `
        <div class="bg-white cursor-pointer px-4 py-2 w-full flex flex-row produitSelectionne hover:bg-red-500"
            data-index="${produit.id}">
            <div class="flex flex-col w-full">
                <h1 class="font-Alumni text-xs italic md:text-lg">${produit.code_unspsc || ''} - ${produit.description || ''}</h1>
            </div>
            <div class="flex flex-col items-end justify-start w-full">
                <div class="flex items-center justify-center bg-tertiary-400 md:p-2 rounded-full">
                    <span class="iconify size-4 md:size-8 lg:size-10 text-white" data-icon="material-symbols:delete"></span>
                </div>
            </div>
        </div>`;
}

function assignClickEventsToSelectedProducts() {
    document.querySelectorAll('.produitSelectionne').forEach(item => {
        item.addEventListener('click', (e) => {
            e.stopImmediatePropagation();
            const productId = parseInt(item.getAttribute('data-index'), 10);
            removeSelectedProduct(productId);
        });
    });
}

function afficherPaginationSelected() {
    const totalPages = Math.ceil(selectedProducts.length / itemsPerPageSelected);
    if (totalPages > 1) {
        const data = {
            current_page: currentPageSelected,
            last_page: totalPages,
            prev_page_url: currentPageSelected > 1 ? true : null,
            next_page_url: currentPageSelected < totalPages ? true : null
        };
        const paginationContainer = document.getElementById('paginationSelected');
        paginationContainer.innerHTML = `
            ${paginationButtons(data, 'changePageSelected')}
        `;
    } else {
        document.getElementById('paginationSelected').innerHTML = '';
    }
}

function changePageSelected(page) {
    currentPageSelected = page;
    afficherProduitsSelectionnes();
}

function removeSelectedProduct(productId) {
    selectedProductIds = selectedProductIds.filter(id => id !== productId);
    selectedProducts = selectedProducts.filter(produit => produit.id !== productId);
    updateHiddenInput();

    // Mettre à jour l'icône dans la liste des produits
    const productItem = document.querySelector(`.produitService[data-index="${productId}"]`);
    if (productItem) {
        const iconElement = productItem.querySelector('.iconify');
        if (iconElement) {
            iconElement.setAttribute('data-icon', 'material-symbols:add');
            iconElement.classList.remove('text-green-500');
            iconElement.classList.add('text-white');
        }
    }

    const totalPages = Math.ceil(selectedProducts.length / itemsPerPageSelected);
    currentPageSelected = totalPages > 0 ? Math.min(currentPageSelected, totalPages) : 1;

    afficherProduitsSelectionnes();
    updateSelectedCount();
}

function updateHiddenInput() {
    // Supprimer les inputs cachés existants
    const existingInputs = document.querySelectorAll('input[name="produits_services[]"]');
    existingInputs.forEach(input => input.remove());

    // Ajouter les nouveaux inputs cachés
    const form = document.getElementById('produitsServicesForm');
    selectedProductIds.forEach(id => {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'produits_services[]';
        hiddenInput.value = id;
        form.appendChild(hiddenInput);
    });
}

function afficherMessage(message) {
    const messageContainer = document.createElement('p');
    messageContainer.className = 'text-red-500 mt-2';
    messageContainer.textContent = message;
    document.getElementById('produitsServicesSelectionnees').appendChild(messageContainer);
    setTimeout(() => messageContainer.remove(), 3000);
}

function updateSelectedCount() {
    const countElement = document.getElementById('selectedCount');
    countElement.textContent = `Nombre de produits sélectionnés : ${selectedProducts.length}`;
}

function getCategories() {
    const selectCategorie = document.getElementById('selectCategorie');

    axios.get('/categories')
        .then(response => {
            const categories = response.data;

            selectCategorie.innerHTML = '<option value="" disabled selected>Choisissez une catégorie pour filtrer les produits et services</option><option value="">Toutes les catégories</option>';

            categories.forEach(categorie => {
                const option = document.createElement('option');
                option.value = categorie;
                option.textContent = categorie;
                selectCategorie.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des catégories :', error);
        });
}
window.performSearch = performSearch;
window.changePageSelected = changePageSelected;
const confirmButton = document.getElementById('confirmButton');
const form = document.getElementById('produitsServicesForm');

if (confirmButton && form) {
    confirmButton.addEventListener('click', function () {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Voulez-vous enregistrer ces informations ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, confirmer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
} else {
    console.warn("test.");
}
}
