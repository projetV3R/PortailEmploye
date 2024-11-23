@extends('layouts.app')

@section('title', 'ProfilFournisseur')

@section('contenu')
    @php
        // Affichage des differents etats et leurs styles pour le statut de la demande
        $etatStyles = [
            'En attente' => [
                'bgColor' => 'bg-yellow-100',
                'textColor' => 'text-yellow-500',
                'icon' => 'material-symbols:hourglass-top',
                'labelColor' => 'text-yellow-600',
                'text' => 'En attente',
            ],
            'accepter' => [
                'bgColor' => 'bg-green-100',
                'textColor' => 'text-green-500',
                'icon' => 'material-symbols:check-circle-outline',
                'labelColor' => 'text-green-600',
                'text' => 'Accepté',
            ],
            'refuser' => [
                'bgColor' => 'bg-red-100',
                'textColor' => 'text-red-500',
                'icon' => 'material-symbols:cancel',
                'labelColor' => 'text-red-600',
                'text' => 'Refusé',
            ],
            'a reviser' => [
                'bgColor' => 'bg-orange-100',
                'textColor' => 'text-orange-500',
                'icon' => 'material-symbols:edit',
                'labelColor' => 'text-orange-600',
                'text' => 'À réviser',
            ],
        ];

        $etat = $fournisseur->etat;
        $etatStyle = $etatStyles[$etat] ?? $etatStyles['En attente']; // Par défaut à 'En attente' si l'état n'est pas défini
    @endphp

    <div class="p-4 md:p-16">
        <div class="flex flex-col md:flex-row w-full">
            <div class="flex flex-col w-full md:w-1/2">
                <h6 class="font-Alumni font-bold text-3xl md:text-5xl">{{ $fournisseur->nom_entreprise }}</h6>

            </div>

            <div class="{{ $etatStyle['bgColor'] }} mt-4 md:mt-0 md:ml-2 w-full md:w-1/2 py-4 px-6 flex items-center">
                <div class="{{ $etatStyle['textColor'] }}">
                    <span class="iconify" data-icon="{{ $etatStyle['icon'] }}" data-inline="false"
                        style="font-size: 2rem;"></span>
                </div>
                <div class="ml-4">
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl">Statut de la demande :
                        <span class="{{ $etatStyle['labelColor'] }} block mt-1 text-lg md:text-xl font-semibold">
                            {{ $etatStyle['text'] }}
                        </span>
                    </h4>
                </div>
                <div class="ml-4 flex gap-2 justify-center">
                @if ($etat == 'En attente' || $etat == 'refuser')
                    <button type="button"
                        class="hidden md:inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded"
                        id="approveButton">
                        Approuver
                    </button>
                    <button type="button"
                        class="md:hidden bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded flex items-center justify-center"
                        id="approveButtonIcon">
                        <span class="iconify" data-icon="material-symbols:check-circle-outline" style="font-size: 1.5rem;"></span>
                    </button>
                    @endif

                    @if ($etat == 'En attente')
                    <button type="button"
                        class="hidden md:inline-block bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded"
                        id="rejectButton">
                        Refuser
                    </button>
                    <button type="button"
                        class="md:hidden bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded flex items-center justify-center"
                        id="rejectButtonIcon">
                        <span class="iconify" data-icon="material-symbols:cancel" style="font-size: 1.5rem;"></span>
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Première colonne -->
            <div>
                <div class="bg-primary-100 py-8 px-4 mt-8 relative">
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Informations d’authentification</h4>
                    <div class="absolute right-4 top-4">
                        <button type="button" class="text-tertiary-400 hover:text-tertiary-300">
                            <span class="iconify" data-icon="material-symbols:edit" data-inline="false"
                                style="font-size: 1.5rem;"></span>
                        </button>
                    </div>
                    <div class="mt-6">
                        <p class="font-Alumni text-md md:text-lg"><strong>Email :</strong>
                            {{ $fournisseur->adresse_courriel ?? 'Non disponible' }}</p>
                    </div>
                    <div class="mt-4">
                        <p class="font-Alumni text-md md:text-lg"><strong>Mot de passe :</strong> ••••••••</p>
                    </div>
                </div>

                <div class="mt-8 px-4 py-8 bg-primary-100 relative">
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Coordonnées</h4>
                    <div class="absolute right-4 top-4">
                        <button type="button" class="text-tertiary-400 hover:text-tertiary-300">
                            <span class="iconify" data-icon="material-symbols:edit" data-inline="false"
                                style="font-size: 1.5rem;"></span>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="font-Alumni md:text-lg"><strong>Numéro Civique:</strong>
                                {{ $fournisseur->coordonnee->numero_civique ?? 'N/A' }}</p>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Rue:</strong>
                                {{ $fournisseur->coordonnee->rue ?? 'N/A' }}</p>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Bureau:</strong>
                                {{ $fournisseur->coordonnee->bureau ?? 'N/A' }}</p>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Municipalité:</strong>
                                {{ $fournisseur->coordonnee->ville ?? 'N/A' }}</p>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Code postal:</strong>
                                {{ $fournisseur->coordonnee->code_postal ?? 'N/A' }}</p>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Région Administrative:</strong>
                                {{ $fournisseur->coordonnee->region_administrative ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Coordonnées en ligne</h4>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Site web:</strong>
                                {{ $fournisseur->coordonnee->site_web ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline mt-6">Numéros de téléphone</h4>
                    <div class="max-h-48 overflow-y-auto mt-2">
                        @forelse($fournisseur->coordonnee->telephones ?? [] as $telephone)
                            <p class="mt-2 font-Alumni md:text-lg  gap-0.5">
                                <strong>Ligne {{ $loop->iteration }} :</strong> {{ $telephone->numero_telephone }} -
                                Poste: {{ $telephone->poste }} -
                                <strong>Type:</strong> {{ $telephone->type }}
                            </p>
                        @empty
                            <p class="font-Alumni text-md md:text-lg">Aucun numéro de téléphone disponible.</p>
                        @endforelse
                    </div>
                </div>

                <div class="mt-8 bg-primary-100 p-4 relative">
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Documents téléchargés</h4>
                    <div class="overflow-auto max-h-48 mt-4">
                        <div class="absolute right-4 top-4">
                            <button type="button" class="text-tertiary-400 hover:text-tertiary-300">
                                <span class="iconify" data-icon="material-symbols:edit" data-inline="false"
                                    style="font-size: 1.5rem;"></span>
                            </button>
                        </div>
                        @forelse($fournisseur->brochuresCarte ?? [] as $brochure)
                            <div class="bg-white shadow-md rounded p-4 mb-2 relative">
                                <h6 class="font-Alumni font-semibold text-md md:text-lg">{{ $brochure->nom }}</h6>
                                <p class="font-Alumni text-md"><strong>Type de fichier:</strong>
                                    {{ $brochure->type_de_fichier }}</p>
                                <p class="font-Alumni text-md"><strong>Taille:</strong>
                                    {{ number_format($brochure->taille / 1048576, 2) }} MB</p>
                            </div>
                        @empty
                            <p class="font-Alumni text-md md:text-lg">Aucun document disponible.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-primary-100 py-8 px-4 mt-8 relative">
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Licences</h4>
                    <div class="absolute right-4 top-4">
                        <button type="button" class="text-tertiary-400 hover:text-tertiary-300">
                            <span class="iconify" data-icon="material-symbols:edit" data-inline="false"
                                style="font-size: 1.5rem;"></span>
                        </button>
                    </div>
                    @if ($licence)
                        <div class="mt-6 w-full max-w-md">
                            <h5 class="font-Alumni font-semibold text-md md:text-lg underline">Informations sur la Licence
                            </h5>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Numéro de Licence RBQ:</strong>
                                {{ $licence->numero_licence_rbq }}</p>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Statut:</strong> {{ $licence->statut }}</p>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Type de Licence:</strong>
                                {{ $licence->type_licence }}</p>
                        </div>
                        <div class="mt-6">
                            <h5 class="font-Alumni font-bold text-md md:text-lg underline">Sous-catégories de Licence</h5>
                            <div class="overflow-auto max-h-48">
                                @forelse($licence->sousCategories ?? [] as $sousCategorie)
                                    <div class="bg-white shadow-md rounded p-4 mb-2">
                                        <h6 class="font-Alumni font-semibold text-md md:text-lg underline">Sous-catégorie
                                            {{ $loop->iteration }}</h6>
                                        <p class="mt-2 font-Alumni md:text-lg"><strong>Catégorie:</strong>
                                            {{ $sousCategorie->categorie->categorie ?? 'N/A' }}</p>
                                        <p class="mt-2 font-Alumni md:text-lg"><strong>Code de sous-catégorie:</strong>
                                            {{ $sousCategorie->categorie->code_sous_categorie ?? 'N/A' }}</p>
                                    </div>
                                @empty
                                    <p class="font-Alumni text-md md:text-lg">Aucune sous-catégorie de licence disponible.
                                    </p>
                                @endforelse
                            </div>
                        </div>
                    @else
                        <p class="font-Alumni mt-4 text-md md:text-lg">Aucune licence disponible.</p>
                    @endif
                </div>
            </div>

            <!-- Deuxième colonne : Progression -->
            <div>
                <!-- Informations de l’entreprise -->
                <div class="bg-primary-100 py-8 px-4 mt-8 relative">
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Informations de l’entreprise</h4>
                    <div class="absolute right-4 top-4">
                        <button type="button" class="text-tertiary-400 hover:text-tertiary-300">
                            <span class="iconify" data-icon="material-symbols:edit" data-inline="false"
                                style="font-size: 1.5rem;"></span>
                        </button>
                    </div>
                    <div class="mt-6">
                        <p class="font-Alumni text-md md:text-lg"><strong>Numéro d’entreprise du Québec (NEQ) :</strong>
                            {{ $fournisseur->neq ?? 'N/A' }}</p>
                    </div>
                    <div class="mt-4">
                        <p class="font-Alumni text-md md:text-lg"><strong>Nom de l’entreprise :</strong>
                            {{ $fournisseur->nom_entreprise ?? 'N/A' }}</p>
                    </div>
                    <p class="font-Alumni text-md md:text-lg mt-2"><strong>Date de l'inscription :</strong>
                        {{ optional($fournisseur->created_at)->format('d/m/Y à H:i') ?? 'Non disponible' }}</p>
                </div>

                <!-- Produits et services -->
                <div class="bg-primary-100 py-8 px-4 mt-8 relative">
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Produits et services</h4>
                    <div class="absolute right-4 top-4">
                        <button type="button" class="text-tertiary-400 hover:text-tertiary-300">
                            <span class="iconify" data-icon="material-symbols:edit" data-inline="false"
                                style="font-size: 1.5rem;"></span>
                        </button>
                    </div>
                    <div id="produitsServicesResumes"
                        class="max-h-64 mt-8 overflow-y-auto custom-scrollbar grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($fournisseur->produitsServices ?? [] as $produitService)
                            <div class="bg-white shadow-md rounded p-4 mb-2">
                                <h6 class="font-Alumni font-semibold text-md md:text-lg">
                                    {{ $produitService->nature ?? 'N/A' }}</h6>
                                <p class="font-Alumni text-md"><strong>Code Catégorie:</strong>
                                    {{ $produitService->code_categorie ?? 'N/A' }}</p>
                                <p class="font-Alumni text-md"><strong>Code UNSPSC:</strong>
                                    {{ $produitService->code_unspsc ?? 'N/A' }}</p>
                                <p class="font-Alumni text-md"><strong>Description:</strong>
                                    {{ $produitService->description ?? 'N/A' }}</p>
                            </div>
                        @empty
                            <p class="font-Alumni text-md md:text-lg">Aucun produit ou service disponible.</p>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        <label for="details" class="block font-Alumni text-md md:text-lg mb-2">Détails
                            supplémentaires</label>
                        <textarea disabled id="details" name="details" placeholder="Entrer des détails supplémentaires"
                            class="font-Alumni w-full max-w-md p-2 h-28 focus:outline-none focus:border-blue-500 border border-black">{{ $fournisseur->details_specifications ?? '' }}</textarea>

                        @error('details')
                            <span
                                class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Contacts -->
                <div class="bg-primary-100 py-8 px-4 mt-8 relative">
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Contacts</h4>
                    <div class="absolute right-4 top-4">
                        <button type="button" class="text-tertiary-400 hover:text-tertiary-300">
                            <span class="iconify" data-icon="material-symbols:edit" data-inline="false"
                                style="font-size: 1.5rem;"></span>
                        </button>
                    </div>
                    <div id="contactsContainer"
                        class="max-h-64 overflow-y-auto grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        @forelse($fournisseur->contacts ?? [] as $contact)
                            <div class="bg-white p-4 shadow-md rounded mb-2">
                                <div class="flex flex-col sm:flex-row justify-between">
                                    <div class="sm:w-1/2 pr-2">
                                        <h5 class="font-Alumni font-semibold text-md md:text-lg underline">Information
                                            générale</h5>
                                        <p class="mt-2 font-Alumni md:text-lg"><strong>Prénom:</strong>
                                            {{ $contact->prenom ?? 'N/A' }}</p>
                                        <p class="mt-2 font-Alumni md:text-lg"><strong>Nom:</strong>
                                            {{ $contact->nom ?? 'N/A' }}</p>
                                        <p class="mt-2 font-Alumni md:text-lg"><strong>Fonction:</strong>
                                            {{ $contact->fonction ?? 'N/A' }}</p>
                                        <p class="mt-2 font-Alumni md:text-lg"><strong>Email:</strong>
                                            {{ $contact->adresse_courriel ?? 'N/A' }}</p>
                                    </div>
                                    <div class="sm:w-1/2 lg:pl-2">
                                        <h5 class="font-Alumni font-semibold text-md md:text-lg underline">Coordonnées</h5>
                                        <p class="mt-2 font-Alumni md:text-lg"><strong>Numéro de téléphone:</strong>
                                            {{ $contact->telephone->numero_telephone ?? 'N/A' }}</p>
                                        <p class="mt-2 font-Alumni md:text-lg"><strong>Poste:</strong>
                                            {{ $contact->telephone->poste ?? 'N/A' }}</p>
                                        <p class="mt-2 font-Alumni md:text-lg"><strong>Type:</strong>
                                            {{ $contact->telephone->type ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="font-Alumni text-md md:text-lg">Aucun contact disponible.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Finances (si état accepté) -->
                @if ($fournisseur->etat == 'accepter' && $fournisseur->finance)
                    <div class="bg-primary-100 py-8 px-4 mt-8 relative">
                        <div class="absolute right-4 top-4">
                            <button type="button" class="text-tertiary-400 hover:text-tertiary-300">
                                <span class="iconify" data-icon="material-symbols:edit" data-inline="false"
                                    style="font-size: 1.5rem;"></span>
                            </button>
                        </div>
                        <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Finances</h4>
                        <div class="mt-6 w-full max-w-md">
                            <h5 class="font-Alumni font-semibold text-md md:text-lg underline">Informations Fiscales</h5>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Numéro TPS:</strong>
                                {{ $fournisseur->finance->numero_tps ?? 'N/A' }}</p>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Numéro TVQ:</strong>
                                {{ $fournisseur->finance->numero_tvq ?? 'N/A' }}</p>
                            <h5 class="font-Alumni font-semibold text-md md:text-lg mt-4 underline">Conditions de Paiement
                            </h5>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Condition de Paiement:</strong>
                                {{ $fournisseur->finance->condition_paiement ?? 'N/A' }}</p>
                            <h5 class="font-Alumni font-semibold text-md md:text-lg mt-4 underline">Configuration</h5>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Devise:</strong>
                                {{ $fournisseur->finance->devise ?? 'N/A' }}</p>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Mode de Communication:</strong>
                                {{ $fournisseur->finance->mode_communication ?? 'N/A' }}</p>
                        </div>
                    </div>
                @else
                    <p class="font-Alumni mt-4 text-md md:text-lg">Aucune information financière disponible.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        sessionStorage.setItem('fromProfilePage', 'true');
    
    document.getElementById('approveButton').addEventListener('click', function() {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Voulez-vous vraiment approuver cette demande ?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, approuver',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                approuverDemande();
            }
        });
    });

    document.getElementById('rejectButton').addEventListener('click', function() {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Voulez-vous vraiment refuser cette demande ?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Refuser',
            cancelButtonText: 'Annuler',
        }).then((result) => {
            if (result.isConfirmed) {
                refuserDemande();
            }
        });
    });

    function approuverDemande() {
        axios.post('{{ route('fiches.approve', ['id' => $fournisseur->id]) }}')
            .then(response => {
                Swal.fire('Approuvé!', 'La demande a été approuvée.', 'success')
                    .then(() => location.reload());
            })
            .catch(error => {
                Swal.fire('Erreur!', "Une erreur s'est produite.", 'error');
            });
    }

    function refuserDemande(reasons) {
        axios.post('{{ route('fiches.reject', ['id' => $fournisseur->id]) }}', {
            reasons: reasons
        })
            .then(response => {
                Swal.fire('Refusé!', 'La demande a été refusée.', 'success')
                    .then(() => location.reload());
            })
            .catch(error => {
                Swal.fire('Erreur!', "Une erreur s'est produite.", 'error');
            });
    }
</script>

@endsection
