$(document).ready(function() {
    // Configuration AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // MAJ des rôles
    $('#save-roles-btn').click(function(e) {
        e.preventDefault();
        let formData = $('#update-roles-form').serialize();

        $.ajax({
            url: updateUsagerUrl,
            type: "POST",
            data: formData,
            success: function(response) {
                Swal.fire({
                    title: 'Parfait!',
                    text: 'La modification est enregistrée!',
                    icon: 'success',
                    timer: 2000
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: 'Erreur',
                    text: 'La modification ne fonctionne pas.',
                    icon: 'error',
                    timer: 2000
                });
            }
        });
    });

    // Suppression user
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
                        if (xhr.status === 419) {
                            Swal.fire('Session expirée', 'Veuillez recharger la page et réessayer.', 'error');
                        } else {
                            Swal.fire('Erreur', 'Une erreur est survenue lors de la suppression.', 'error');
                        }
                    }
                });
            }
        });
    });

    // CREATION USAGER
    document.getElementById('create-user').addEventListener('click', function() {
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
            preConfirm: () => {
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const nom = document.getElementById('nom').value;
                const prenom = document.getElementById('prenom').value;
                const role = document.getElementById('role').value;
    
                if (!email || !password || !nom || !prenom || !role) {
                    Swal.showValidationMessage('Tous les champs doivent être remplis!');
                    return false;
                }
    
                return { email, password, nom, prenom, role };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/usagers', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify(result.value)
                })
                .then(response => {
                    if (response.ok) {
                        Swal.fire('Succès!', 'Utilisateur ajouté avec succès.', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        return response.json().then(errData => {
                            // Vérifie si l'erreur concerne l'email unique
                            if (errData.errors?.email) {
                                const emailError = errData.errors.email[0];
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erreur!',
                                    text: emailError.includes('Cet email est déjà utilisé.') ? 'Cet email est déjà utilisé.' : emailError,
                                });
                            } else {
                                Swal.fire('Erreur!', 'Une erreur s\'est produite.', 'error');
                            }
                        });
                    }
                })
                .catch(() => {
                    Swal.fire('Erreur!', 'Erreur de connexion.', 'error');
                });
            }
        });
    });
    
    
 
    

    document.getElementById('hs-table-with-pagination-search').addEventListener('input', function() {
        let searchValue = this.value.toLowerCase();
        let rows = document.querySelectorAll('table tbody tr');

        rows.forEach(row => {
            let email = row.cells[0].textContent.toLowerCase();
            let role = row.cells[1].querySelector('select').value.toLowerCase();

            if (email.includes(searchValue) || role.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    function fetch_data(page) {
        $.ajax({
            url: "/admin?page=" + page,
            success: function(data) {
                $('tbody').html(data);
            }
        });
    }
});
