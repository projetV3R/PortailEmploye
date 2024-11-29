

function initializeFinanceFormScript() {
    const confirmButton = document.getElementById('confirmButton');
    const form = document.getElementById('financeForm');

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
