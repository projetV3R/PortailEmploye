$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
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
                        text: 'La modification est enregistré!',
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
    });
    

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
});

// Gestion de la pagination avec Ajax
$(document).on('click', '.pagination a', function(event) {
    event.preventDefault();
    let page = $(this).attr('href').split('page=')[1];
    fetch_data(page);
});

function fetch_data(page) {
    $.ajax({
        url: "/admin?page=" + page,
        success: function(data) {
            $('tbody').html(data);
        }
    });
}