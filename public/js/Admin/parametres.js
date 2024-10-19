document.addEventListener('DOMContentLoaded', function() {
    // Requête GET pour récupérer les paramètres
    axios.get('/parametres/')
        .then(function(response) {
            const data = response.data;
        
            document.getElementById('email_approvisionnement').value = data.email_approvisionnement;
            document.getElementById('mois_revision').value = data.mois_revision;
            document.getElementById('taille_fichier').value = data.taille_fichier;
            document.getElementById('finance_approvisionnement').value = data.finance_approvisionnement;
        })
        .catch(function(error) {
            alert('Erreur lors du chargement des paramètres.');
            console.error(error);
        });


    document.getElementById('parametres-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const csrfToken = document.querySelector('input[name="_token"]').value;

        const formData = [
            {
                '_token': csrfToken,
                'cle': 'email_approvisionnement',
                'valeur': document.getElementById('email_approvisionnement').value
            },
            {
                '_token': csrfToken,
                'cle': 'mois_revision',
                'valeur_numerique': document.getElementById('mois_revision').value
            },
            {
                '_token': csrfToken,
                'cle': 'taille_fichier',
                'valeur_numerique': document.getElementById('taille_fichier').value
            },
            {
                '_token': csrfToken,
                'cle': 'finance_approvisionnement',
                'valeur': document.getElementById('finance_approvisionnement').value
            }
        ];

        // Envoyer toutes les requêtes et attendre leur réponse
        const requests = formData.map(function(param) {
            return axios.post('/parametres/store', param);
        });

        Promise.all(requests)
            .then(function(responses) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Les modifications sont bien enregistrées",
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(function(error) {
                console.log(error.response);
            
                let errorMessage = "Une erreur s'est produite!";
                
                if (error.response && error.response.data && error.response.data.errors) {
                    const errors = error.response.data.errors;
            
                    // Récupére tous les messages d'erreur dans un seul message
                    errorMessage = Object.keys(errors)
                        .map(field => errors[field].join(", "))
                        .join("\n");
                }
            
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: errorMessage,
                });
            });
            
    });
});
