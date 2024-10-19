$(document).ready(function() {
    $.ajax({
        url: "/parametres/",
        method: 'GET',
        success: function(data) {
            $('#email_approvisionnement').val(data.email_approvisionnement);
            $('#mois_revision').val(data.mois_revision);
            $('#taille_fichier').val(data.taille_fichier);
            $('#email_finances').val(data.finance_approvisionnement);
        },
        error: function() {
            alert('Erreur lors du chargement des paramètres.');
        }
    });

    
    $('#parametres-form').on('submit', function(event) {
        event.preventDefault();
        
        let formData = [
            {
                //Important token pour valider le crsf
                //.val sert a recupere la valeur a l'interieur de l'input
                '_token': $('input[name="_token"]').val(),
                'cle': 'email_approvisionnement',
                'valeur': $('#email_approvisionnement').val()
            },
            {
                '_token': $('input[name="_token"]').val(),
                'cle': 'mois_revision',
                'valeur_numerique': $('#mois_revision').val()
            },
            {
                '_token': $('input[name="_token"]').val(),
                'cle': 'taille_fichier',
                'valeur_numerique': $('#taille_fichier').val()
            },
            {
                '_token': $('input[name="_token"]').val(),
                'cle': 'finance_approvisionnement',
                'valeur': $('#email_finances').val()
            }
        ];

        formData.forEach(function(param) {
            $.ajax({
                url: "/parametres/store",
                method: 'POST',
                data: param,
                success: function(response) {
                    console.log(response.message);
                },
                error: function(response) {
                    alert('Erreur lors de l\'enregistrement des paramètres.');
                }
            });
        });
    });
});