var quill;
var originalObjet = '';
var originalBody = '';

document.addEventListener('DOMContentLoaded', function () {
    chargerModeles();
    quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: {
                container: [
                    [{ 'header': [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'blockquote', 'code-block'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    ['clean'],
                    [{ 'variable': 'select' }] 
                ],
                handlers: {
                    'variable': function() {
                        insertVariable();
                    }
                }
            }
        }
    });

    document.querySelector('.bg-blue-300').addEventListener('click', function() {
        enregistrerModifications();
    });

    const variableSelect = document.createElement('select');
    variableSelect.id = 'variableSelect';
    variableSelect.className = 'ql-variable';  
    variableSelect.innerHTML = `
    <option value="">-- Insérer une variable --</option>
    <option value="{fiche_fournisseurs-&gt;nom_entreprise}">{Nom de l'entreprise}</option>
    <option value="{fiche_fournisseurs-&gt;neq}">{NEQ de l'entreprise}</option>
    <option value="{fiche_fournisseurs-&gt;etat}">{Statut du dossier}</option>
    <option value="{fiche_fournisseurs-&gt;raison_refus}">{Raison du refus}</option>
    <option value="{fiche_fournisseurs-&gt;finance-&gt;numero_tps}">{Numéro de TPS}</option>
    <option value="{fiche_fournisseurs-&gt;finance-&gt;numero_tvq}">{Numéro de TVQ}</option>
    <option value="{fiche_fournisseurs-&gt;finance-&gt;condition_paiement}">{Condition de paiement}</option>
    <option value="{fiche_fournisseurs-&gt;finance-&gt;devise}">{Devise}</option>
    <option value="{fiche_fournisseurs-&gt;finance-&gt;mode_communication}">{Mode de communication}</option>
    `;

    document.querySelector('.ql-toolbar').appendChild(variableSelect);

    variableSelect.addEventListener('change', function() {
        insertVariable();
    });
});

function insertVariable() {
    const variableSelect = document.getElementById('variableSelect');
    const selectedVariable = variableSelect.value;

    if (selectedVariable) {
        const range = quill.getSelection(); 
        if (range) {
            quill.insertText(range.index, selectedVariable);
        }
        variableSelect.value = '';  
    }
}

function chargerModeles() {
    axios.get('/modeles')
        .then(function (response) {
            const modeles = response.data;
            const selectElement = document.getElementById('modelesSelect');

            selectElement.innerHTML = '';

            modeles.forEach(modele => {
                let option = document.createElement('option');
                option.value = modele.id;
                option.text = modele.type;
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
            quill.clipboard.dangerouslyPasteHTML(modele.body);

           
            originalObjet = modele.objet;
            originalBody = quill.root.innerHTML;
        })
        .catch(function (error) {
            console.error('Erreur lors de l\'affichage du modèle:', error);
        });
}

function enregistrerModifications() {
    const modeleId = document.getElementById('modelesSelect').value;
    const updatedObjet = document.getElementById('modeleObjet').value;
    const updatedBody = quill.root.innerHTML;

//Verifier si une modification a etait faites 
    if (updatedObjet === originalObjet && updatedBody === originalBody) {
        Swal.fire({
            icon: "info",
            title: "Aucune modification",
            text: "Vous n'avez rien modifié."
        });
        return;  
    }


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

       
        originalObjet = updatedObjet;
        originalBody = updatedBody;

        afficherModeleParId(modeleId);
    })
    .catch(function (error) {
        let errorMessage = "Une erreur est survenue.";

        if (error.response && error.response.data && error.response.data.errors) {
            const errors = error.response.data.errors;
            errorMessage = Object.values(errors).map((errorMessages) => errorMessages.join('<br>')).join('<br>');
        } else if (error.message) {
            errorMessage = error.message;
        }

        Swal.fire({
            icon: "error",
            title: "Oops...",
            html: errorMessage 
        });
    });
}
