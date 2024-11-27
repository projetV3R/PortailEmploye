function initializeContactFormScript() {
    const confirmButton = document.getElementById('submitBtn');
    const form = document.getElementById('contactForm');

    document.querySelectorAll('[name^="contacts"][name$="[numeroTelephone]"]').forEach(function(input) {
        formatTel(input);
    });

    function formatTel(input) {
        input.addEventListener('input', function() {
            let value = input.value.replace(/\D/g, '');
            if (value.length > 3 && value.length <= 6) {
                value = value.slice(0, 3) + '-' + value.slice(3);
            } else if (value.length > 6) {
                value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
            }
            input.value = value;
        });
    }
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
        console.warn("Bouton ou formulaire introuvable.");
    }


    axios.get('/Contacts/getData')
        .then(response => {
            const contacts = response.data;

            if (contacts.length > 0) {
                remplirPremierContact(contacts[0]); // Remplir le premier contact
            }

        
            contacts.slice(1).forEach((contact, index) => {
                ajouterContactFields(index + 1, contact);
            });
        })
        .catch(error => {
            console.error("Erreur lors de la récupération des contacts :", error);
        });

  
    document.getElementById('addContactBtn').addEventListener('click', function() {
        const newIndex = document.querySelectorAll('#contactFieldsContainer > div').length; 
        ajouterContactFields(newIndex);
        document.querySelectorAll('[name^="contacts"][name$="[numeroTelephone]"]').forEach(function(input) {
            formatTel(input);
        });
    });
}

function remplirPremierContact(contact) {
    document.querySelector('input[name="contacts[0][prenom]"]').value = contact.prenom || '';
    document.querySelector('input[name="contacts[0][nom]"]').value = contact.nom || '';
    document.querySelector('input[name="contacts[0][fonction]"]').value = contact.fonction || '';
    document.querySelector('input[name="contacts[0][email]"]').value = contact.adresse_courriel || '';
    document.querySelector('input[name="contacts[0][id]"]').value = contact.id || ''; // ID du contact

    if (contact.telephone) {
        document.querySelector('input[name="contacts[0][telephone_id]"]').value = contact.telephone.id || ''; // ID du téléphone
        document.querySelector('select[name="contacts[0][type]"]').value = contact.telephone.type || 'Bureau';
        document.querySelector('input[name="contacts[0][numeroTelephone]"]').value = formatTelValue(contact.telephone.numero_telephone || '');
        document.querySelector('input[name="contacts[0][poste]"]').value = contact.telephone.poste || '';
    }
}

function ajouterContactFields(index, contact = {}) {
    const contactFieldsContainer = document.getElementById('contactFieldsContainer');
    const clone = contactFieldsContainer.children[1].cloneNode(true); 
    clone.querySelector('#addContactBtn')?.remove();
    clone.querySelector('#submitBtn')?.remove();


    clone.querySelector('input[name="contacts[0][prenom]"]').name = `contacts[${index}][prenom]`;
    clone.querySelector('input[name="contacts[0][nom]"]').name = `contacts[${index}][nom]`;
    clone.querySelector('input[name="contacts[0][fonction]"]').name = `contacts[${index}][fonction]`;
    clone.querySelector('input[name="contacts[0][email]"]').name = `contacts[${index}][email]`;
    clone.querySelector('input[name="contacts[0][id]"]').name = `contacts[${index}][id]`; // Gestion ID contact
    clone.querySelector('input[name="contacts[0][telephone_id]"]').name = `contacts[${index}][telephone_id]`; // Gestion ID téléphone
    clone.querySelector('select[name="contacts[0][type]"]').name = `contacts[${index}][type]`;
    clone.querySelector('input[name="contacts[0][numeroTelephone]"]').name = `contacts[${index}][numeroTelephone]`;
    clone.querySelector('input[name="contacts[0][poste]"]').name = `contacts[${index}][poste]`;

    // Remplir les valeurs des champs
    clone.querySelector(`input[name="contacts[${index}][prenom]"]`).value = contact.prenom || '';
    clone.querySelector(`input[name="contacts[${index}][nom]"]`).value = contact.nom || '';
    clone.querySelector(`input[name="contacts[${index}][fonction]"]`).value = contact.fonction || '';
    clone.querySelector(`input[name="contacts[${index}][email]"]`).value = contact.adresse_courriel || '';
    clone.querySelector(`input[name="contacts[${index}][id]"]`).value = contact.id || ''; // ID du contact
    clone.querySelector(`input[name="contacts[${index}][telephone_id]"]`).value = contact.telephone?.id || ''; // ID du téléphone

    if (contact.telephone) {
        clone.querySelector(`select[name="contacts[${index}][type]"]`).value = contact.telephone.type || 'Bureau';
        clone.querySelector(`input[name="contacts[${index}][numeroTelephone]"]`).value = formatTelValue(contact.telephone.numero_telephone || '');
        clone.querySelector(`input[name="contacts[${index}][poste]"]`).value = contact.telephone.poste || '';
    } else {
        clone.querySelector(`input[name="contacts[${index}][numeroTelephone]"]`).value = '';
        clone.querySelector(`input[name="contacts[${index}][poste]"]`).value = '';
    }

    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.classList.add('w-full', 'text-xl', 'flex', 'items-center', 'justify-center', 'text-white', 'bg-red-500', 'hover:bg-red-400', 'py-2.5', 'mt-2');
    deleteButton.innerHTML = '<span class="iconify size-10" data-icon="mdi:bin"></span> Supprimer';
    deleteButton.addEventListener('click', function() {
        clone.remove();
        reindexContacts();
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Suppression du contact réussie',
            showConfirmButton: false,
            timer: 1500
        });
    });

    clone.querySelector('.bg-secondary-100').appendChild(deleteButton);

    contactFieldsContainer.appendChild(clone);
}

function formatTelValue(value) {
    value = value.replace(/\D/g, '');
    if (value.length > 3 && value.length <= 6) {
        value = value.slice(0, 3) + '-' + value.slice(3);
    } else if (value.length > 6) {
        value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
    }
    return value;
}

function reindexContacts() {
    document.querySelectorAll('#contactFieldsContainer > div').forEach((contactDiv, index) => {
        contactDiv.querySelectorAll('input, select').forEach(input => {
            let name = input.getAttribute('name');
            if (name) {
                name = name.replace(/\[.*?\]/, `[${index}]`);
                input.setAttribute('name', name);
            }
        });
    });
}
