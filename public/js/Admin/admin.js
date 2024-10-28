document.addEventListener('DOMContentLoaded', function() {
    performSearch();

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

    const newSaveRolesBtn = saveRolesBtn.cloneNode(true);
    saveRolesBtn.parentNode.replaceChild(newSaveRolesBtn, saveRolesBtn);

    newSaveRolesBtn.addEventListener('click', function(e) {
        e.preventDefault();

        let hasChanges = false;
        let formData = new FormData();
        let overAdmin = false;

        const existingAdminCount = Array.from(document.querySelectorAll('.role-dropdown')).filter(dropdown => dropdown.value === 'admin').length;

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
            console.log("Aucune modification détectée.");
            Swal.fire({
                title: 'Attention!',
                text: 'Vous ne pouvez pas avois plus que 2 admin',
                icon: 'info',
                timer: 2000
            });
            return;
        }

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

        axios.post('/usagers/update', formData)
            .then(function(response) {
                Swal.fire({
                    title: 'Parfait!',
                    text: 'La modification est enregistrée!',
                    icon: 'success',
                    timer: 2000,
                    willClose: () => {
                        performSearch();
                        if (overAdmin) {
                            console.log("Trop d'admin.");
                            return Swal.fire({
                                title: 'Attention!',
                                text: 'Vous ne pouvez pas avois plus que 2 admin',
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
    });
}

// CREATION
document.getElementById('create-user').addEventListener('click', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Ajouter un utilisateur',
        html: `
            <input id="email" class="swal2-input" placeholder="Courriel" required>
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
                                    }).then(() => performSearch());
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
                            }).then(() => performSearch());
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

async function validateUserData(data) {
    const errors = [];

    if (!data.email) {
        errors.push("Le champ email est obligatoire.");
    } else if (!/\S+@\S+\.\S+/.test(data.email)) {
        errors.push("L'email est invalide.");
    }else {
        // Vérifie l'unicité de l'email
        const isEmailUnique = await checkEmailUniqueness(data.email);
        if (!isEmailUnique) {
            errors.push("Cet email est déjà utilisé.");
        }
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

//RECHERCHE et PAGINATION

function performSearch(page = 1) {
    const query = document.getElementById('recherche').value.trim();
    axios.get('/usagers', { params: { recherche: query, page } })
        .then(response => {
            afficherResultats(response.data.data);
            afficherPagination(response.data);
        })
        .catch(error => console.error("Erreur lors de la recherche :", error));
}

function afficherResultats(usagers) {
    const resultsContainer = document.getElementById('usagers');
    const tbody = resultsContainer.querySelector('tbody');
    tbody.innerHTML = '';

    if (usagers.length) {
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
                <td class="px-4 py-1 whitespace-nowrap text-sm cursor-default flex justify-center items-center flex-row">
                    <button type="button" class="delete-user flex items-center px-3 py-2 bg-red-500 hover:bg-red-600 text-gray-800 dark:text-neutral-200 rounded-lg shadow-md transition duration-200" data-id="${usager.id}">
                        <span class="iconify size-10 lg:size-6 mr-1" data-icon="mdi:bin" data-inline="false"></span>
                        <span class="delete-user hidden lg:block">Supprimer</span>
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
            <span>&lt;</span>
            <span class="hidden md:inline">Précédente</span>
        </button>
        <span class="text-xs font-bold mx-2">Page ${data.current_page} sur ${data.last_page}</span>
        <button type="button"
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-2 md:px-4
            ${!data.next_page_url ? 'cursor-not-allowed' : ''}"
            onclick="${functionName}(${data.current_page + 1})" ${!data.next_page_url ? 'disabled' : ''}>
            <span>&gt;</span>
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

document.addEventListener('DOMContentLoaded', () => {
    const rechercheInput = document.getElementById('recherche');
    if (rechercheInput) {
        rechercheInput.addEventListener('input', () => {
            performSearch();
        });
    } else {
        console.error("L'élément avec l'ID 'recherche' n'a pas été trouvé.");
    }
});

