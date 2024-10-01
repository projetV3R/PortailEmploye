document.addEventListener('DOMContentLoaded', function () {
    chargerModeles();
});


function chargerModeles() {
    axios.get('/modeles')
        .then(function (response) {
            const modeles = response.data;
            const selectElement = document.getElementById('modelesSelect');


            selectElement.innerHTML = '';

            modeles.forEach(modele => {
                let option = document.createElement('option');
                option.value = modele.id;
                option.text = modele.objet;
                selectElement.appendChild(option);
            });

            if (modeles.length > 0) {
                afficherModeleParId(modeles[0].id);
            }
        })
        .catch(function (error) {
            console.error('Erreur lors du chargement des modèles:', error);
        });
}


function afficherModele() {
    const modeleId = document.getElementById('modelesSelect').value;
    afficherModeleParId(modeleId);
}

function afficherModeleParId(modeleId) {
    axios.get(`/modeles/${modeleId}`)
        .then(function (response) {
            const modele = response.data;

       
            document.getElementById('modeleObjet').value = modele.objet;
            document.getElementById('modeleBody').value = modele.body;
        })
        .catch(function (error) {
            console.error('Erreur lors de l\'affichage du modèle:', error);
        });
}


function enregistrerModifications() {
    const modeleId = document.getElementById('modelesSelect').value;
    const updatedObjet = document.getElementById('modeleObjet').value;
    const updatedBody = document.getElementById('modeleBody').value;

    axios.put(`/modeles/${modeleId}`, {
        objet: updatedObjet,
        body: updatedBody
    })
    .then(function (response) {
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Modèle mis à jour avec succès",
            showConfirmButton: false,
            timer: 1500
          });
        
    
        chargerModeles();
    })
    .catch(function (error) {
        console.error('Erreur lors de la mise à jour du modèle:', error);
        alert('Erreur lors de la mise à jour du modèle');
    });
}

document.querySelector('.bg-blue-300').addEventListener('click', enregistrerModifications);
