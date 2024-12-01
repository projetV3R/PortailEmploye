function initializeDocFormScript() {
    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');
    const uploadedFileList = document.getElementById('uploadedFileList');
    const totalFileSizeDisplay = document.getElementById('totalFileSize');
    const messageContainer = document.getElementById('messageContainer');
    const uploadButton = document.getElementById('uploadButton');
    const fichiersASupprimerContainer = document.getElementById('fichiersASupprimerContainer');
    const fournisseurId = localStorage.getItem('fournisseurId');

    let MAX_TOTAL_SIZE_MB = 0;
    let brochuresFromSession = [];
    let indicesFichiersASupprimer = [];
    let totalSizeExistingFiles = 0;
    let totalSizeNewFiles = 0;
    let totalSize = 0;

  
    axios.get(`/fournisseur/${fournisseurId}/get-documents`)
        .then(response => {
            brochuresFromSession = response.data.brochures;
            MAX_TOTAL_SIZE_MB = response.data.maxFileSize;
            afficherFichiersDejaTeleverses();
            updateTotalSizeAndUI();
        })
        .catch(error => console.error("Erreur lors du chargement des documents :", error));

    function afficherFichiersDejaTeleverses() {
        if (!uploadedFileList) return;

        totalSizeExistingFiles = 0; 
        uploadedFileList.innerHTML = '';
        fichiersASupprimerContainer.innerHTML = '';

        brochuresFromSession.forEach((brochure) => {
            if (!indicesFichiersASupprimer.includes(brochure.id)) {
                totalSizeExistingFiles += brochure.taille / (1024 * 1024); 
                const listItem = document.createElement('li');
                listItem.textContent = `${brochure.nom} - ${(brochure.taille / (1024 * 1024)).toFixed(2)} Mo`;

                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.textContent = 'Supprimer';
                deleteButton.className = 'text-red-500 ml-2';
                deleteButton.addEventListener('click', () => {
                    indicesFichiersASupprimer.push(brochure.id);
                    afficherFichiersDejaTeleverses();
                    updateTotalSizeAndUI();
                });

                listItem.appendChild(deleteButton);
                uploadedFileList.appendChild(listItem);
            }
        });

    
        indicesFichiersASupprimer.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'fichiers_a_supprimer[]';
            input.value = id;
            fichiersASupprimerContainer.appendChild(input);
        });
    }

    function updateTotalSizeAndUI() {
        totalSize = totalSizeExistingFiles + totalSizeNewFiles;
        updateUI();
    }

    function updateUI() {
        totalFileSizeDisplay.textContent = `Taille totale : ${totalSize.toFixed(2)} Mo / ${MAX_TOTAL_SIZE_MB} Mo`;

        if (totalSize > MAX_TOTAL_SIZE_MB) {
            messageContainer.innerHTML = `<p>La taille totale dépasse la limite de ${MAX_TOTAL_SIZE_MB} Mo. Veuillez retirer des fichiers pour vous conformer à la taille maximum.</p>`;
            uploadButton.disabled = true;
            uploadButton.classList.add('bg-gray-400', 'cursor-not-allowed');
            uploadButton.classList.remove('bg-blue-500', 'hover:bg-blue-400');
        } else {
            messageContainer.innerHTML = '';
            uploadButton.disabled = false;
            uploadButton.classList.add('bg-blue-500', 'hover:bg-blue-400');
            uploadButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
        }
    }

    fileInput.addEventListener('change', function () {
        messageContainer.innerHTML = '';
        fileList.innerHTML = '';

        totalSizeNewFiles = 0; 
        const files = Array.from(fileInput.files);

        files.forEach(file => {
            totalSizeNewFiles += file.size / (1024 * 1024);
            const listItem = document.createElement('li');
            listItem.textContent = `${file.name} - ${(file.size / (1024 * 1024)).toFixed(2)} Mo`;
            fileList.appendChild(listItem);
        });

        updateTotalSizeAndUI();
    });

    const confirmButton = document.getElementById('uploadButton');
    const form = document.getElementById('fileUploadForm');

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
}
