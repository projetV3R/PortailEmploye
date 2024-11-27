function initializeCoordonneeFormScript() {
    // Supprime les espaces créés par l'utilisateur dans l'input de code postal
    document.getElementById('codePostale').addEventListener('input', function() {
        this.value = this.value.replace(/\s+/g, ''); 
    });

    let currentIndex = 0; // Initialiser l'index à 0
    document.getElementById('currentIndexInput').value = currentIndex;

    let coordonneeData = null;

    // Fonction pour charger les municipalités
    function chargerMunicipalites(region = '') {
        const municipaliteSelect = document.getElementById('municipaliteSelect');
        municipaliteSelect.innerHTML = '<option value="" disabled selected>Choisissez une municipalité</option>';

        axios.get('/municipalites-par-region', { params: { region: region } })
            .then(response => {
                response.data.forEach(muni => {
                    let option = new Option(muni.nom, muni.nom);
                    municipaliteSelect.add(option);
                });
                // Si on a la municipalité du coordonnée, on la sélectionne
                if (coordonneeData && coordonneeData.municipalite) {
                    municipaliteSelect.value = coordonneeData.municipalite;
                }
            })
            .catch(error => console.error('Erreur lors de la récupération des municipalités:', error));
    }

    document.getElementById('municipaliteSelect').addEventListener('change', function() {
        const municipalite = this.value;
        const regionAdministrativeSelect = document.getElementById('regionAdministrative');

        if (municipalite) {
            axios.get('/region-par-municipalite', { params: { municipalite: municipalite } })
                .then(response => {
                    const region = response.data.regionAdministrative;
                    if (region) {
                        regionAdministrativeSelect.value = region;
                    } else {
                        console.warn("La région n'a pas été trouvée pour cette municipalité.");
                    }
                })
                .catch(error => console.error('Erreur lors de la récupération de la région:', error));
        }
    });

    function tooglePosteInput(index) {
        const ligneSelect = document.getElementById(`ligne_${index}`);
        const posteDiv = document.getElementById(`poste_div_${index}`);
        const posteInput = document.getElementById(`poste_${index}`);

        function togglePoste() {
            if (ligneSelect.value !== "Bureau") {
                posteDiv.classList.add('hidden'); // Masque le champ "Poste"
                posteInput.value = ''; // Efface la valeur de l'input "Poste"
            } else {
                posteDiv.classList.remove('hidden'); // Affiche le champ "Poste"
            }
        }

        ligneSelect.addEventListener('change', togglePoste);

        // Appel initial pour définir l'état correct au chargement
        togglePoste();
    }

    // Charger les données de l'utilisateur connecté via une requête AJAX
    axios.get('/fournisseur/coordonnees/data') // Endpoint to get the user's coordonnee data
        .then(function(response) {
            coordonneeData = response.data.coordonnee || {};
            // Pre-fill the form fields
            prefillForm(coordonneeData);

            // Charger les municipalités avec la région sélectionnée
            if (coordonneeData.regionAdministrative) {
                document.getElementById('regionAdministrative').value = coordonneeData.regionAdministrative;
                chargerMunicipalites(coordonneeData.regionAdministrative);
            } else {
                chargerMunicipalites();
            }

            // Handle province and municipalité
            if (coordonneeData.province === 'Québec') {
                document.getElementById('province').dispatchEvent(new Event('change'));

                setTimeout(() => {
                    if (coordonneeData.municipalite) {
                        document.getElementById('municipaliteSelect').value = coordonneeData.municipalite;
                    }
                }, 600);
            } else {
                document.getElementById('province').dispatchEvent(new Event('change'));
                if (coordonneeData.municipaliteInput) {
                    document.getElementById('municipaliteInput').value = coordonneeData.municipaliteInput;
                }
            }

            // Pre-fill the telephone lines
            if (coordonneeData.ligne) {
                const lignes = coordonneeData.ligne;
                Object.keys(lignes).forEach(index => {
                    const ligne = lignes[index];
                    if (index == 0) {
                        if (ligne.type) document.getElementById('ligne_0').value = ligne.type;
                        if (ligne.numeroTelephone) document.getElementById('numeroTelephone_0').value = formatTelValue(ligne.numeroTelephone);
                        if (ligne.poste) document.getElementById('poste_0').value = ligne.poste;
                        if(ligne.id) document.getElementById('id_0').value=ligne.id;
                        tooglePosteInput(0);
                    } else {
                        ajouterNumeroTelephone(index, ligne);
                    }
                });
                currentIndex = Object.keys(lignes).length - 1;
                document.getElementById('currentIndexInput').value = currentIndex;
            } else {
                tooglePosteInput(0);
            }

            // Formater les champs de numéro de téléphone
            document.querySelectorAll('.numerotelephone').forEach(function(input) {
                formatTel(input);
            });

        })
        .catch(function(error) {
            console.error('Erreur lors de la récupération des données du coordonnée:', error);
            // Si erreur, on peut initialiser les champs vides
            tooglePosteInput(0);
            chargerMunicipalites();
        });

    function prefillForm(coordonnee) {
        const champs = ['numeroCivique', 'bureau', 'rue', 'codePostale', 'province', 'regionAdministrative', 'siteWeb'];

        champs.forEach(champ => {
            if (coordonnee[champ]) {
                document.getElementById(champ).value = coordonnee[champ];
            }
        });
    }

    // Ajout d'un numéro de téléphone
    document.getElementById('ajoutNumeroTelephone').addEventListener('click', function() {
        currentIndex++;
        ajouterNumeroTelephone(currentIndex);
        document.getElementById('currentIndexInput').value = currentIndex;
    });

    // Suppression d'un numéro de téléphone
    document.getElementById('cadreNumero').addEventListener('click', function(event) {
        const supbtn = event.target.closest('.remove-ligne');
        if (supbtn) {
            Swal.fire({
                title: "Êtes-vous sûr de vouloir supprimer ce numéro",
                text: "La suppression n'est pas réversible !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Supprimer",
                cancelButtonText: "Annuler",
            }).then((result) => {
                if (result.isConfirmed) {
                    supbtn.closest('.ligne-numeros').remove();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Suppression du numéro réussie',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            });
        }
    });

    function ajouterNumeroTelephone(index, ligne = {}) {
        const cadre = document.getElementById('cadreNumero');
        const type = ligne.type || '';
        const numeroTelephone = ligne.numeroTelephone || '';
        const poste = ligne.poste || '';
        const telephoneId = ligne.id || '';

        cadre.insertAdjacentHTML('beforeend', `
            <div class="mt-6 w-full flex justify-center md:gap-2 columns-2 ligne-numeros" data-index="${index}">
             <input type="hidden" name="ligne[${index}][id]" value="${telephoneId}">
                <div class="w-full">
                    <label for="ligne_${index}" class="flex justify-center font-Alumni text-md md:text-lg mb-2">Ligne</label>
                    <select id="ligne_${index}" name="ligne[${index}][type]" class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">
                        <option value="Bureau" ${type === 'Bureau' ? 'selected' : ''}>Bureau</option>
                        <option value="Télécopieur" ${type === 'Télécopieur' ? 'selected' : ''}>Télécopieur</option>
                        <option value="Cellulaire" ${type === 'Cellulaire' ? 'selected' : ''}>Cellulaire</option>
                    </select>
                </div>
                <div class="w-full">
                    <label for="numeroTelephone_${index}" class="block font-Alumni text-md md:text-lg mb-2 truncate">Numéro Téléphone</label>
                    <input type="phonenumber" id="numeroTelephone_${index}" name="ligne[${index}][numeroTelephone]" placeholder="514-453-9867"
                        value="${formatTelValue(numeroTelephone)}"
                        class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black numerotelephone">
                </div>
                <div class="w-full" id="poste_div_${index}">
                    <label for="poste_${index}" class="flex justify-center font-Alumni text-md md:text-lg mb-2">Poste</label>
                    <input type="text" id="poste_${index}" name="ligne[${index}][poste]" placeholder="9845"
                        value="${poste}"
                        class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">
                </div>
                <div class="w-full flex flex-row justify-start items-end pl-2">
                    <button type="button" class="remove-ligne cursor-pointer hover:bg-red-500 items-center flex justify-center bg-tertiary-400 text-white h-12 w-12" data-index="${index}">
                        <span class="iconify size-6 remove-ligne" data-icon="mdi:trash-can-outline"></span>
                    </button>
                </div>
            </div>
        `);

        tooglePosteInput(index);

        const nouvelInput = document.getElementById(`numeroTelephone_${index}`);
        if (nouvelInput) {
            formatTel(nouvelInput);
        }
    }

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

    function formatTelValue(value) {
        if (!value) return '';
        value = value.replace(/\D/g, '');
        if (value.length > 3 && value.length <= 6) {
            value = value.slice(0, 3) + '-' + value.slice(3);
        } else if (value.length > 6) {
            value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
        }
        return value;
    }

    // Cache le select de région administrative quand !Québec et affiche un input texte pour les municipalités
    document.getElementById('province').addEventListener('change', function() {
        const province = this.value;
        const regionAdministrativeSelect = document.getElementById('regionAdministrative');
        const municipaliteSelect = document.getElementById('municipaliteSelect');
        const municipaliteInput = document.getElementById('municipaliteInput');

        if (province === 'Québec') {
            regionAdministrativeSelect.parentElement.classList.remove('hidden');
            municipaliteSelect.classList.remove('hidden');
            municipaliteInput.classList.add('hidden');
            municipaliteInput.value = '';
        } else {
            regionAdministrativeSelect.parentElement.classList.add('hidden');
            municipaliteSelect.classList.add('hidden');
            municipaliteInput.classList.remove('hidden');
            regionAdministrativeSelect.value = '';
            municipaliteSelect.value = '';
        }
    });

    // Supprime les espaces dans le champ Code postal et validation du formulaire
    document.querySelector('form').addEventListener('submit', function(event) {
        const province = document.getElementById('province').value;
        const regionAdministrativeSelect = document.getElementById('regionAdministrative');
        const municipaliteSelect = document.getElementById('municipaliteSelect');
        const municipaliteInput = document.getElementById('municipaliteInput');

        if (province !== 'Québec') {
            regionAdministrativeSelect.value = '';
            municipaliteSelect.value = '';
        }
        if (province === 'Québec') {
            municipaliteInput.value = '';
        }
    });

    // Confirmation avant soumission du formulaire
    const confirmButton = document.getElementById('confirmButton');
    const form = document.getElementById('coordonneesForm');

    if (confirmButton && form) {
        confirmButton.addEventListener('click', function(event) {
            event.preventDefault();
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
    }
}
