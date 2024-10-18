document.addEventListener('DOMContentLoaded', function() {
    loadUsers();

//SUPPRIMER
document.addEventListener('click', function(e) {
    if (e.target.closest('.delete-user')) {
        const userId = e.target.closest('.delete-user').getAttribute('data-id');

        Swal.fire({
            title: "Êtes-vous sûr ?",
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
                        loadUsers();
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

// AFFICHAGE
function loadUsers(page = 1) {
    axios.get(`/usagers?page=${page}`)
        .then(response => {
            const usagers = response.data.data;
            const totalPages = response.data.last_page;
            const currentPage = response.data.current_page;

            let tbody = document.querySelector('#usagers tbody');
            tbody.innerHTML = '';

            usagers.forEach(usager => {
                let tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="px-4 py-1 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                        ${usager.email}
                    </td>
                    <td class="px-4 py-1 text-center whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                        <input type="hidden" value="${usager.id}"> <!-- Ajout de l'input caché -->
                        <select name="usagers[${usager.id}][role]" class="pr-2 role-dropdown dark:text-neutral-500 dark:bg-blueV3R">
                            <option value="admin" ${usager.role == 'admin' ? 'selected' : ''}>Admin</option>
                            <option value="responsable" ${usager.role == 'responsable' ? 'selected' : ''}>Responsable</option>
                            <option value="commis" ${usager.role == 'commis' ? 'selected' : ''}>Commis</option>
                        </select>
                    </td>
                    <td class="px-4 py-1 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200 cursor-default flex justify-center items-center flex-row">
                        <button type="button" class="delete-user px-2 flex items-center bg-red-300" data-id="${usager.id}">
                            <span class="iconify size-10 lg:size-6" data-icon="mdi:bin" data-inline="false"></span>
                            <span class="delete-user relative hidden lg:block" data-id="${usager.id}">Supprimer employé</span>
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            updatePagination(totalPages, currentPage);
            initializeRoles();
        })
        .catch(error => {
            console.error("Il y a eu un problème avec la requête Axios", error);
        });
}

// MODIFICATION ROLE
let initialRoles = {};

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

    // Supprimer tous les écouteurs d'événements précédents
    const newSaveRolesBtn = saveRolesBtn.cloneNode(true);
    saveRolesBtn.parentNode.replaceChild(newSaveRolesBtn, saveRolesBtn);

    // Ajouter l'écouteur sur le nouveau bouton sans accumulation
    newSaveRolesBtn.addEventListener('click', function(e) {
        e.preventDefault();

        let hasChanges = false;
        let formData = new FormData();

        document.querySelectorAll('.role-dropdown').forEach(function(dropdown) {
            const hiddenInput = dropdown.closest('tr').querySelector('input[type="hidden"]');
            if (hiddenInput) {
                const usagerId = hiddenInput.value;
                const selectedRole = dropdown.value;

                if (selectedRole !== initialRoles[usagerId]) {
                    hasChanges = true;
                    formData.append(`usagers[${usagerId}][id]`, usagerId);
                    formData.append(`usagers[${usagerId}][role]`, selectedRole);
                }
            } else {
                console.error("Input caché non trouvé pour la ligne de rôle.");
            }
        });

        if (!hasChanges) {
            console.log("Aucune modification détectée.");
            Swal.fire({
                title: 'Aucune modification',
                text: 'Il n\'y a rien de modifié à enregistrer.',
                icon: 'info',
                timer: 2000
            });
            return;
        }

        // Vérifier le nombre d'administrateurs existants
        const newAdminCount = Array.from(document.querySelectorAll('.role-dropdown')).filter(dropdown => dropdown.value === 'admin').length;

        if (newAdminCount > 2) {
            Swal.fire({
                title: 'Erreur!',
                text: 'Impossible d\'ajouter plus que 2 administrateurs.',
                icon: 'error',
                timer: 5000
            }).then(() => loadUsers());
            console.log('pa 2');
            return;
        }

        axios.post('/usagers/update', formData)
            .then(function(response) {
                Swal.fire({
                    title: 'Parfait!',
                    text: 'La modification est enregistrée!',
                    icon: 'success',
                    timer: 2000
                });
                loadUsers();
                console.log('pa 1');
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
    });
}


    
// CREATION
document.getElementById('create-user').addEventListener('click', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Ajouter un utilisateur',
        html: `
            <input id="email" class="swal2-input" placeholder="Email" required>
            <input id="password" type="password" class="swal2-input" placeholder="Mot de passe" required>
            <input id="password_confirmation" type="password" class="swal2-input" placeholder="Confirmer le mot de passe" required>
            <input id="nom" class="swal2-input" placeholder="Nom" required>
            <input id="prenom" class="swal2-input" placeholder="Prénom" required>
            <select id="role" class="swal2-select" required>
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
                        if (validateUserData(result.value)) {
                            axios.post('/storeusager', result.value)
                                .then(() => {
                                    Swal.fire({
                                        title: 'Succès!',
                                        text: 'Utilisateur ajouté avec succès.',
                                        icon: 'success',
                                        timer: 2000
                                    }).then(() => loadUsers());
                                })
                                .catch(handleAxiosValidationError);
                        }
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
                if (validateUserData(result.value)) {
                    axios.post('/storeusager', result.value)
                        .then(() => {
                            Swal.fire({
                                title: 'Succès!',
                                text: 'Utilisateur ajouté avec succès.',
                                icon: 'success',
                                timer: 2000
                            }).then(() => loadUsers());
                        })
                        .catch(handleAxiosValidationError);
                }
            }
        }
    });
});

function checkAdminCount(data) {
    return axios.get('/usagers/count-admins')
        .then(response => response.data < 2)
        .catch(() => true);
}

function validateUserData(data) {
    const errors = [];

    if (!data.email) {
        errors.push("Le champ email est obligatoire.");
    } else if (!/\S+@\S+\.\S+/.test(data.email)) {
        errors.push("L'email est invalide.");
    }

    if (!data.password) {
        errors.push("Le champ mot de passe est obligatoire.");
    } else if (data.password.length < 6) {
        errors.push("Le mot de passe doit contenir au moins 6 caractères.");
    }

    if (!data.nom) {
        errors.push("Le champ nom est obligatoire.");
    } else if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(data.nom)) {
        errors.push("Le nom ne peut contenir que des lettres.");
    }

    if (!data.prenom) {
        errors.push("Le champ prénom est obligatoire.");
    } else if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(data.prenom)) {
        errors.push("Le prénom ne peut contenir que des lettres.");
    }

    if (!data.role) {
        errors.push("Le champ rôle est obligatoire.");
    }

    if (errors.length > 0) {
        Swal.fire({
            title: 'Erreurs de validation!',
            text: errors.join('\n'),
            icon: 'error',
            timer: 5000
        });
        return false;
    }

    return true;
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

//PAGINATION
function updatePagination(totalPages, currentPage) {
    const pagination = document.querySelector('nav[aria-label="Pagination"]');
    pagination.innerHTML = '';

    for (let i = 1; i <= totalPages; i++) {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = `min-h-[38px] min-w-[38px] flex justify-center items-center py-2 px-3 text-sm rounded-lg ${i == currentPage ? 'bg-gray-200 text-gray-800' : 'text-gray-800 hover:bg-gray-100'}`;
        button.textContent = i;
        button.onclick = () => loadUsers(i);
        pagination.appendChild(button);
    }
}

//RECHERCHE
document.getElementById('hs-table-with-pagination-search').addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('table tbody tr');

    rows.forEach(row => {
        const email = row.cells[0].textContent.toLowerCase();
        const role = row.cells[1].querySelector('select').options[row.cells[1].querySelector('select').selectedIndex].text.toLowerCase();
        row.style.display = (email.includes(searchValue) || role.includes(searchValue)) ? '' : 'none';
    });
});
