function initializeLicenceFormScript() {
    const numeroLicenceInput = document.getElementById('numeroLicence');
    const statutSelect = document.getElementById('statut');
    const typeLicenceSelect = document.getElementById('typeLicence');
    const checklistContainer = document.getElementById('checklistContainer');
    let selectedSousCategories = [];

    // Récupérer les informations de la licence pour l'utilisateur connecté
    axios.get('/Licence/get-licence-data')
        .then(response => {
            const licenceData = response.data.licence;
            selectedSousCategories = response.data.selectedSousCategories || [];
            console.log( selectedSousCategories);
            
            if (licenceData) {
                
                numeroLicenceInput.value = formatLicence(licenceData.numero_licence_rbq);
                statutSelect.value = licenceData.statut;
                typeLicenceSelect.value = licenceData.type_licence;

              
                fetchSousCategories(licenceData.type_licence);
            }
        })
        .catch(error => console.error('Erreur lors de la récupération des données de licence:', error));

    // Formatage du numéro de licence en ####-####-##
    function formatLicence(value) {
        value = value.replace(/\D/g, ''); // Retirer les caractères non numériques

        if (value.length > 4 && value.length <= 8) {
            value = value.slice(0, 4) + '-' + value.slice(4);
        } else if (value.length > 8) {
            value = value.slice(0, 4) + '-' + value.slice(4, 8) + '-' + value.slice(8, 10);
        }

        return value;
    }

 
    numeroLicenceInput.addEventListener('input', function () {
        numeroLicenceInput.value = formatLicence(numeroLicenceInput.value);
    });

   
    typeLicenceSelect.addEventListener('change', function () {
        const selectedType = this.value;

        if (selectedType) {
            fetchSousCategories(selectedType);
        } else {
            checklistContainer.innerHTML = '<p>Sélectionnez un type de licence pour voir les sous-catégories disponibles.</p>';
        }
    });

   
    function fetchSousCategories(selectedType) {
        axios.get(`/sous-categories/${selectedType}`)
            .then(response => {
                console.log(response.data);
                renderChecklist(response.data, selectedSousCategories);
             
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des sous-catégories:', error);
            });
    }


    function renderChecklist(data, selectedSousCategories = []) {
        checklistContainer.innerHTML = ''; // Réinitialiser le conteneur
    
        if (!data || Object.keys(data).length === 0) {
            checklistContainer.innerHTML = '<p>Aucune sous-catégorie disponible pour ce type de licence.</p>';
            return;
        }
    
       
        Object.keys(data).forEach(type => {
          
         
        const groupTitle = document.createElement('h5');
        groupTitle.textContent = ` ${typeLicenceSelect.value } ${type} :`; 
        groupTitle.classList.add('font-bold', 'text-xl', 'mt-4', 'mb-2','capitalize');
        checklistContainer.appendChild(groupTitle);

    
          
            data[type].forEach(cat => {
                const checkboxWrapper = document.createElement('div');
                checkboxWrapper.classList.add('flex', 'items-center', 'mt-2', 'relative', 'group', 'bg-gray-300', 'rounded-md', 'p-2', 'px-2');
    
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'sousCategorie[]';
                checkbox.value = cat.id;
                checkbox.classList.add('mr-2');
    
          
                if (selectedSousCategories.includes(cat.id)) {
                    checkbox.checked = true;
                }
    
                const label = document.createElement('label');
                label.textContent = cat.code_sous_categorie;
    
                const tooltip = document.createElement('div');
                tooltip.classList.add(
                    'absolute', 'right-0', 'w-64', 'bg-gray-700', 'text-white',
                    'text-sm', 'p-2', 'rounded', 'hidden', 'group-hover:block',
                    'z-10', 'shadow-lg', 'mt-8'
                );
                tooltip.textContent = cat.travaux_permis || 'Aucun descriptif disponible';
    
                checkboxWrapper.appendChild(checkbox);
                checkboxWrapper.appendChild(label);
                checkboxWrapper.appendChild(tooltip);
    
                checklistContainer.appendChild(checkboxWrapper);
            });
        });
    }
    
    const confirmButton = document.getElementById('confirmButton');
    const form = document.getElementById('licenceForm');

    if (confirmButton && form) {
        confirmButton.addEventListener('click', function () {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Voulez-vous enregistrer ces informations ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, confirmer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    } else {
        console.warn("test.");
    }
    document.getElementById('deleteLicenceButton').addEventListener('click', function () {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cela supprimera définitivement votre licence et ses sous-catégories associées.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete('/licence/delete')
                    .then(response => {
                        Swal.fire(
                            'Supprimée !',
                            'Votre licence a été supprimée avec succès.',
                            'success'
                        ).then(() => {
                            location.reload(); 
                        });
                    })
                    .catch(error => {
                        Swal.fire(
                            'Erreur !',
                            'Une erreur est survenue lors de la suppression.',
                            'error'
                        );
                        console.error('Erreur lors de la suppression de la licence:', error);
                    });
            }
        });
    });
    
}
