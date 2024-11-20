document.addEventListener('DOMContentLoaded', function() {
    let initialRoles = {};
    let currentPage = 1;

// Fonction pour initialiser les rôles
    function initializeRoles() {
        document.querySelectorAll('.role-dropdown').forEach(function(dropdown) {
            const hiddenInput = dropdown.closest('tr').querySelector('input[type="hidden"]');
            if (hiddenInput) {
                const usagerId = hiddenInput.value;
                initialRoles[usagerId] = dropdown.value;
            } else {
                console.error("Input caché non trouvé pour la ligne de rôle.");
            }
        });

        const saveRolesBtn = document.getElementById('save-roles-btn');

        if (saveRolesBtn) {
            const newSaveRolesBtn = saveRolesBtn.cloneNode(true);
            saveRolesBtn.parentNode.replaceChild(newSaveRolesBtn, saveRolesBtn);

            newSaveRolesBtn.addEventListener('click', function(e) {
                e.preventDefault();
                currentPage = getCurrentPage();

                axios.get('/usagers/count-admins')
                    .then(function(response) {
                        const existingAdminCount = response.data;

                        let hasChanges = false;
                        let formData = new FormData();
                        let overAdmin = false;

                        document.querySelectorAll('.role-dropdown').forEach(function(dropdown) {
                            const hiddenInput = dropdown.closest('tr').querySelector('input[type="hidden"]');
                            if (hiddenInput) {
                                const usagerId = hiddenInput.value;
                                const selectedRole = dropdown.value;

                                if (selectedRole !== initialRoles[usagerId]) {
                                    if (selectedRole === 'admin' && existingAdminCount >= 2) {
                                        dropdown.value = initialRoles[usagerId];
                                        overAdmin = true;
                                    } else {
                                        hasChanges = true;
                                        formData.append(`usagers[${usagerId}][id]`, usagerId);
                                        formData.append(`usagers[${usagerId}][role]`, selectedRole);
                                    }
                                }
                            } else {
                                console.error("Input caché non trouvé pour la ligne de rôle.");
                            }
                        });

                        if (overAdmin && !hasChanges) {
                            Swal.fire({
                                title: 'Attention!',
                                text: 'Vous ne pouvez pas avoir plus de 2 administrateurs.',
                                icon: 'info',
                                timer: 2000
                            });
                            return;
                        }

                        if (!hasChanges) {
                            Swal.fire({
                                title: 'Aucune modification',
                                text: 'Il n\'y a rien de modifié à enregistrer.',
                                icon: 'info',
                                timer: 2000
                            });
                            return;
                        }

                        axios.post('/usagers/update', formData)
                            .then(function(response) {
                                Swal.fire({
                                    title: 'Parfait!',
                                    text: 'La modification est enregistrée!',
                                    icon: 'success',
                                    timer: 2000,
                                    willClose: () => {
                                        updateCurrentPageData();
                                        if (overAdmin) {
                                            console.log("Trop d'admin.");
                                            return Swal.fire({
                                                title: 'Attention!',
                                                text: 'Vous ne pouvez pas avoir plus de 2 admins',
                                                icon: 'info',
                                                timer: 2000
                                            });
                                        }
                                    }
                                });
                            })
                            .catch(function(error) {
                                Swal.fire({
                                    title: 'Erreur',
                                    text: 'Une erreur est survenue lors de la sauvegarde des modifications.',
                                    icon: 'error',
                                    timer: 2000
                                });
                                console.error("Erreur lors de la sauvegarde des rôles:", error);
                            });
                    })
                    .catch(function(error) {
                        Swal.fire({
                            title: 'Erreur',
                            text: 'Impossible de vérifier le nombre d\'administrateurs.',
                            icon: 'error',
                            timer: 2000
                        });
                        console.error("Erreur lors de la récupération du nombre d'administrateurs:", error);
                    });
            });
        }
    }

    function getCurrentPage() {
        const activePageButton = document.querySelector('.pagination-button.active');
        if (activePageButton) {
            return parseInt(activePageButton.dataset.page);
        }
        return 1;
    }

    function updateCurrentPageData() {
        axios.get(`/usagers?page=${currentPage}`)
            .then(function(response) {
                updateTableWithNewData(response.data);
            })
            .catch(function(error) {
                console.error("Erreur lors de la récupération des usagers:", error);
            });
    }

    function updateTableWithNewData(data) {
        const tableBody = document.querySelector('#usagers-table tbody');
        tableBody.innerHTML = '';
        data.usagers.forEach(function(usager) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${usager.id}</td>
                <td>${usager.mail}</td>
                <td>
                    <select class="role-dropdown">
                        <option value="user" ${usager.role === 'user' ? 'selected' : ''}>Utilisateur</option>
                        <option value="admin" ${usager.role === 'admin' ? 'selected' : ''}>Administrateur</option>
                    </select>
                    <input type="hidden" value="${usager.id}">
                </td>
            `;
            tableBody.appendChild(row);
        });
        initializeRoles();
    }

    document.querySelectorAll('.pagination-button').forEach(function(button) {
        button.addEventListener('click', function() {
            const page = this.dataset.page;
            currentPage = parseInt(page);
            performSearch(currentPage);
        });
    });


    document.getElementById('create-user').addEventListener('click', function (e) {
        e.preventDefault();
    
        Swal.fire({
            title: 'Ajouter un utilisateur',
            html: `
                <input id="email" class="font-Alumni swal2-input border daltonien:border-black" placeholder="Courriel" required>
                <input id="password" type="password" class="font-Alumni swal2-input border daltonien:border-black" placeholder="Mot de passe" required>
                <input id="password_confirmation" type="password" class="font-Alumni swal2-input border daltonien:border-black" placeholder="Confirmer le mot de passe" required>
                <input id="nom" class="font-Alumni swal2-input border daltonien:border-black" placeholder="Nom" required>
                <input id="prenom" class="font-Alumni swal2-input border daltonien:border-black" placeholder="Prénom" required>
                <select id="role" class="font-Alumni swal2-select required>
                    <option value="">Sélectionnez un rôle</option>
                    <option value="commis">Commis</option>
                    <option value="responsable">Responsable</option>
                    <option value="admin">Admin</option>
                </select>
            `,
            focusConfirm: false,
            preConfirm: () => ({
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                password_confirmation: document.getElementById('password_confirmation').value,
                nom: document.getElementById('nom').value,
                prenom: document.getElementById('prenom').value,
                role: document.getElementById('role').value
            })
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.value.role === 'admin') {
                    checkAdminCount(result.value).then(canAdd => {
                        if (canAdd) {
                            axios.post('/storeusager', result.value)
                                .then(() => {
                                    Swal.fire({
                                        title: 'Succès!',
                                        text: 'Utilisateur ajouté avec succès.',
                                        icon: 'success',
                                        timer: 2000
                                    }).then(() => performSearch());
                                })
                                .catch(handleAxiosValidationError);
                        } else {
                            Swal.fire({
                                title: 'Erreur!',
                                text: 'Impossible d\'ajouter plus que 2 admin.',
                                icon: 'error',
                                timer: 5000
                            });
                        }
                    });
                } else {
                    axios.post('/storeusager', result.value)
                        .then(() => {
                            Swal.fire({
                                title: 'Succès!',
                                text: 'Utilisateur ajouté avec succès.',
                                icon: 'success',
                                timer: 2000
                            }).then(() => performSearch());
                        })
                        .catch(handleAxiosValidationError);
                }
            }
        });
    });
    
    function checkAdminCount(data) {
        return axios.get('/usagers/count-admins')
            .then(response => response.data < 2)
            .catch(() => true);
    }
    
    function handleAxiosValidationError(error) {
        const errData = error.response.data;
        let errorMessages = [];
    
        if (error.response.status === 422 && errData.errors) {
            for (const messages of Object.values(errData.errors)) {
                errorMessages.push(...messages);
            }
        }
    
        if (errorMessages.length > 0) {
            Swal.fire({
                title: 'Erreurs!',
                text: errorMessages.join('\n'),
                icon: 'error',
                timer: 5000
            });
        } else {
            Swal.fire({
                title: 'Erreur!',
                text: 'Une erreur s\'est produite.',
                icon: 'error',
                timer: 2000
            });
        }
    }
    
    // Fonction pour effectuer la recherche
    function performSearch(page = 1) {
        const query = document.getElementById('recherche').value.trim();
        axios.get('/usagers', { params: { recherche: query, page } })
            .then(response => {
                afficherResultats(response.data.data);
                afficherPagination(response.data);
            })
            .catch(error => console.error("Erreur lors de la recherche :", error));
    }

    // Fonction pour afficher les résultats de la recherche
    function afficherResultats(usagers) {
        const resultsContainer = document.getElementById('usagers');
        const tbody = resultsContainer.querySelector('tbody');
        tbody.innerHTML = '';

        if (usagers.length) {
            usagers.forEach(usager => {
                let tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="font-Alumni px-4 py-1 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                        ${usager.email}
                    </td>
                    <td class="font-Alumni px-4 py-1 text-center whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                        <input type="hidden" value="${usager.id}">
                        <select name="usagers[${usager.id}][role]" class="pr-2 role-dropdown dark:text-neutral-500 dark:bg-blueV3R">
                            <option value="admin" ${usager.role == 'admin' ? 'selected' : ''}>Admin</option>
                            <option value="responsable" ${usager.role == 'responsable' ? 'selected' : ''}>Responsable</option>
                            <option value="commis" ${usager.role == 'commis' ? 'selected' : ''}>Commis</option>
                        </select>
                    </td>
                    <td class="font-Alumni px-4 py-1 whitespace-nowrap text-sm cursor-default flex justify-center items-center flex-row">
                        <button type="button" 
                                class="delete-user flex items-center px-2 bg-red-500 hover:bg-red-600 text-gray-800 
                                       dark:text-neutral-200 rounded-lg shadow-md transition duration-200
                                       daltonien:bg-daltonienBleu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black" 
                                data-id="${usager.id}">
                            <span class="iconify size-10 lg:size-6 mr-1" data-icon="mdi:bin" data-inline="false" data-id="${usager.id}"></span>
                            <span class="delete-user hidden lg:block" data-id="${usager.id}">Supprimer</span>
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
            initializeRoles();
        } else {
            tbody.innerHTML = '<tr><td colspan="3" class="text-center">Aucun usager trouvé.</td></tr>';
        }
    }

    // Fonction pour afficher la pagination
    function afficherPagination(data) {
        const paginationContainer = document.getElementById('pagination');
        paginationContainer.innerHTML = paginationButtons(data);

        // Ajouter des écouteurs d'événements à chaque bouton de pagination
        paginationContainer.querySelectorAll('.pagination-btn').forEach(button => {
            button.addEventListener('click', function() {
                const page = button.getAttribute('data-page');
                if (page) {
                    performSearch(parseInt(page));
                }
            });
        });
    }

    // Générer les boutons de pagination
    function paginationButtons(data) {
        return `
            <button type="button"
                class="pagination-btn bg-gray-300 hover:bg-gray-400 daltonien:bg-daltonienBleu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black text-gray-800 font-bold py-2 px-2 md:px-4 rounded-l
                ${!data.prev_page_url ? 'cursor-not-allowed' : ''}"
                data-page="1" ${!data.prev_page_url ? 'disabled' : ''}>
                &lt;&lt;
            </button>
            <button type="button"
                class="pagination-btn bg-gray-300 hover:bg-gray-400 daltonien:bg-daltonienBleu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black text-gray-800 font-bold py-2 px-2 md:px-4
                ${!data.prev_page_url ? 'cursor-not-allowed' : ''}"
                data-page="${data.current_page - 1}" ${!data.prev_page_url ? 'disabled' : ''}>
                <span>&lt;</span>
                <span class="hidden md:inline">Précédente</span>
            </button>
            <span class="text-xs font-bold mx-2">Page ${data.current_page} sur ${data.last_page}</span>
            <button type="button"
                class="pagination-btn bg-gray-300 hover:bg-gray-400 daltonien:bg-daltonienBleu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black text-gray-800 font-bold py-2 px-2 md:px-4
                ${!data.next_page_url ? 'cursor-not-allowed' : ''}"
                data-page="${data.current_page + 1}" ${!data.next_page_url ? 'disabled' : ''}>
                <span>&gt;</span>
                <span class="hidden md:inline">Suivante</span>
            </button>
            <button type="button"
                class="pagination-btn bg-gray-300 hover:bg-gray-400 daltonien:bg-daltonienBleu daltonien:hover:bg-daltonienYellow daltonien:hover:text-black text-gray-800 font-bold py-2 px-2 md:px-4 rounded-r
                ${!data.next_page_url ? 'cursor-not-allowed' : ''}"
                data-page="${data.last_page}" ${!data.next_page_url ? 'disabled' : ''}>
                &gt;&gt;
            </button>
        `;
    }

    // Appel initial à performSearch après que toutes les fonctions sont définies
    performSearch();

    // Initialisation de l'événement de recherche
    const rechercheInput = document.getElementById('recherche');
    if (rechercheInput) {
        rechercheInput.addEventListener('input', () => {
            performSearch();
        });
    } else {
        console.error("L'élément avec l'ID 'recherche' n'a pas été trouvé.");
    }

    // SUPPRIMER
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-user')) {
            const userId = e.target.closest('.delete-user').getAttribute('data-id');

            Swal.fire({
                title: "Ê tes-vous sûr ?",
                text: "Vous ne pourrez pas revenir en arrière !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui, supprimez-le !"
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/admin/usager/${userId}`)
                        .then(response => {
                            Swal.fire({
                                title: "Supprimé !",
                                text: response.data.message,
                                icon: "success"
                            });
                            performSearch();
                        })
                        .catch(error => {
                            if (error.response && error.response.status === 403) {
                                Swal.fire({
                                    title: "Erreur !",
                                    text: 'Vous ne pouvez pas supprimer votre propre compte.',
                                    icon: "error"
                                });
                            } else {
                                Swal.fire({
                                    title: "Erreur !",
                                    text: 'Une erreur est survenue lors de la suppression.',
                                    icon: "error"
                                });
                            }
                        });
                }
            });
        }
    });
});
