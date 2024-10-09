$(document).ready(function() {
    // Configuration AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Sauvegarde des rôles
    let initialRoles = {};
    $('.role-dropdown').each(function() {
        const usagerId = $(this).siblings('input[type="hidden"]').val();
        initialRoles[usagerId] = $(this).val();
    });

    $('#save-roles-btn').click(function(e) {
        e.preventDefault();
        const formData = $('#update-roles-form').serialize();
        let hasChanges = false;

        $('.role-dropdown').each(function() {
            const usagerId = $(this).siblings('input[type="hidden"]').val();
            if ($(this).val() !== initialRoles[usagerId]) {
                hasChanges = true;
            }
        });

        if (!hasChanges) {
            Swal.fire({
                title: 'Aucune modification',
                text: 'Il n\'y a rien de modifié à enregistrer.',
                icon: 'info',
                timer: 2000
            });
            return;
        }

        $.ajax({
            url: updateUsagerUrl,
            type: "POST",
            data: formData,
            success: function() {
                Swal.fire({
                    title: 'Parfait!',
                    text: 'La modification est enregistrée!',
                    icon: 'success',
                    timer: 2000
                }).then(() => location.reload());
            },
            error: function(xhr) {
                handleAjaxError(xhr, 'La modification ne fonctionne pas.');
            }
        });
    });

// Suppression d'un utilisateur
$(document).on('click', '.delete-user', function() {
    const userId = $(this).data('id');

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
            $.ajax({
                url: `/admin/usager/${userId}`,
                type: 'DELETE',
                success: function(response) {
                    Swal.fire({
                        title: "Supprimé !",
                        text: response.message,
                        icon: "success"
                    });
                    $(this).closest('tr').remove();
                }.bind(this),
                error: function(xhr) {
                    if (xhr.status === 403) {
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
                }
            });
        }
    });
});

    // Création d'un utilisateur
    $('#create-user').click(function(e) { 
        e.preventDefault();
    
        Swal.fire({
            title: 'Ajouter un utilisateur',
            html: `
                <input id="email" class="swal2-input" placeholder="Email" required>
                <input id="password" type="password" class="swal2-input" placeholder="Mot de passe" required>
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
                email: $('#email').val(),
                password: $('#password').val(),
                nom: $('#nom').val(),
                prenom: $('#prenom').val(),
                role: $('#role').val()
            })
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.value.role === 'admin') {
                    checkAdminCount(result.value).then(canAdd => {
                        if (canAdd) {
                            if (validateUserData(result.value)) {
                                $.ajax({
                                    url: '/usagers',
                                    type: 'POST',
                                    data: result.value,
                                    success: function() {
                                        Swal.fire({
                                            title: 'Succès!',
                                            text: 'Utilisateur ajouté avec succès.',
                                            icon: 'success',
                                            timer: 2000
                                        }).then(() => location.reload());
                                    },
                                    error: function(xhr) {
                                        handleAjaxValidationError(xhr);
                                    }
                                });
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
                        $.ajax({
                            url: '/usagers',
                            type: 'POST',
                            data: result.value,
                            success: function() {
                                Swal.fire({
                                    title: 'Succès!',
                                    text: 'Utilisateur ajouté avec succès.',
                                    icon: 'success',
                                    timer: 2000
                                }).then(() => location.reload());
                            },
                            error: function(xhr) {
                                handleAjaxValidationError(xhr);
                            }
                        });
                    }
                }
            }
        });
    });
    
    function checkAdminCount(data) {
        return new Promise((resolve) => {
            $.ajax({
                url: '/usagers/count-admins',
                type: 'GET',
                success: function(count) {
                    resolve(count < 2); 
                },
                error: function() {
                    resolve(true); 
                }
            });
        });
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
    
    function handleAjaxValidationError(xhr) {
        const errData = xhr.responseJSON;
        let errorMessages = [];
    
        if (xhr.status === 422 && errData.errors) {
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
    
    
    // Recherche dans le tableau
    document.getElementById('hs-table-with-pagination-search').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('table tbody tr');

        rows.forEach(row => {
            const email = row.cells[0].textContent.toLowerCase();
            const role = row.cells[1].querySelector('select').value.toLowerCase();

            row.style.display = (email.includes(searchValue) || role.includes(searchValue)) ? '' : 'none';
        });
    });
});
