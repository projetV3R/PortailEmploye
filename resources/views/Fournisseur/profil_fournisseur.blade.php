@extends('layouts.app')

@section('title', 'ProfilFourmisseur')

@section('contenu')
@php
    // Affichage des differents etats et leurs styles pour le statut de de la demande
    $etatStyles = [
        'En attente' => [
            'bgColor' => 'bg-yellow-100',
            'textColor' => 'text-yellow-500',
            'icon' => 'material-symbols:hourglass-top',
            'labelColor' => 'text-yellow-600',
            'text' => 'En attente'
        ],
        'accepter' => [
            'bgColor' => 'bg-green-100',
            'textColor' => 'text-green-500',
            'icon' => 'material-symbols:check-circle-outline',
            'labelColor' => 'text-green-600',
            'text' => 'Accepté'
        ],
        'refuser' => [
            'bgColor' => 'bg-red-100',
            'textColor' => 'text-red-500',
            'icon' => 'material-symbols:cancel',
            'labelColor' => 'text-red-600',
            'text' => 'Refusé'
        ],
        'a reviser' => [
            'bgColor' => 'bg-orange-100',
            'textColor' => 'text-orange-500',
            'icon' => 'material-symbols:edit',
            'labelColor' => 'text-orange-600',
            'text' => 'À réviser'
        ],
        'desactiver' => [
            'bgColor' => 'bg-red-100',
            'textColor' => 'text-red-500',
            'icon' => 'material-symbols:cancel',
            'labelColor' => 'text-red-600',
            'text' => 'Désactivée'
        ],
    ];
    $condition_paiementText=[
        'Z001' =>[
        'text' =>'Payable immédiatement sans déduction'
         ],
         'Z155' =>[
        'text' =>'Payable immédiatement sans déduction,Date de base au 15 du mois suivant'
         ],
         'Z152' =>[
         'text' =>'Dans les 15 jours 2% escpte, dans les 30 jours sans déduction'
        ],
        'Z153' =>[
         'text' =>'Après entrée facture jusqu\'au 15 du mois,jusqu\'au 15 du mois suivant 2%'
        ],
        'Z210' =>[
         'text' =>'Dans les 10 jours 2% escpte , dans les 30 jours sans déduction'
        ],
        
        'ZT15' =>[
            'text' =>'Dans les 15 jours sans déduction'
        ],
        'ZT30' =>[
         'text' =>'Dans les 30 jours sans déduction'
        ],
        'ZT45' =>[
         'text' =>'Dans les 45 jours sans déduction'
        ],
        'ZT60' =>[
         'text' =>'Dans les 60 jours sans déduction'
        ],
    
    
    ];

    $etat = $fournisseur->etat;
    $etatStyle = $etatStyles[$etat] ?? $etatStyles['En attente']; // Par défaut à 'En attente' si l'état n'est pas défini
    if($fournisseur->etat == 'accepter' && $fournisseur->finance){
   $condition=$fournisseur->finance->condition_paiement;
   $condition_paiementText=$condition_paiementText[$condition] ?? $condition_paiementText['aucune'];
    }
  
  
@endphp
           <!-- Modal pour l'édition d'identification -->
           @role('admin','responsable')
           <div id="identificationModal" class="fixed z-20 inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden overflow-auto">
            <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 w-full max-w-4xl mx-4 md:mx-8 lg:mx-12 lg:max-w-5xl relative max-h-screen overflow-y-auto">
                <h2 class="font-Alumni font-bold text-2xl md:text-3xl mb-4">Modifier les informations d'identification</h2>
                
                <!-- Bouton de fermeture -->
                <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-700 border-2 hover:text-white hover:bg-red-500 ">
                    <span class="iconify" data-icon="material-symbols:close" style="font-size: 2.5rem;"></span>
                </button>
        
                <!-- Contenu du formulaire d'identification -->
                <div id="identificationFormContainer" class="max-h-[80vh] overflow-y-auto">
                    <!-- Le formulaire sera chargé ici via AJAX -->
                </div>
            </div>
        </div>
        <div id="produitsServicesModal" class="fixed z-20 inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden overflow-auto">
            <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 w-full  mx-4 md:mx-8 lg:mx-12 lg:max-w-full relative max-h-screen overflow-y-auto">
                <h2 class="font-Alumni font-bold text-2xl md:text-3xl mb-4">Modifier les informations des Produits et Services</h2>
                
                <!-- Bouton de fermeture -->
                <button onclick="closeProduitsServicesModal()" class="absolute top-4 right-4 text-gray-700 border-2 hover:text-white hover:bg-red-500 ">
                    <span class="iconify" data-icon="material-symbols:close" style="font-size: 2.5rem;"></span>
                </button>
        
                <!-- Contenu du formulaire Produits et Services -->
                <div id="produitsServicesFormContainer" class="max-h-[80vh] overflow-y-auto">
                    <!-- Le formulaire sera chargé ici via AJAX -->
                </div>
            </div>
        </div>

        <div id="coordonneeModal" class="fixed z-20 inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden overflow-auto">
            <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 w-full  mx-4 md:mx-8 lg:mx-12 lg:max-w-full relative max-h-screen overflow-y-auto">
                <h2 class="font-Alumni font-bold text-2xl md:text-3xl mb-4">Modifier les infornations de coordonnée</h2>
                
                <!-- Bouton de fermeture -->
                <button onclick="closeCoordonneeModal()" class="absolute top-4 right-4 text-gray-700 border-2 hover:text-white hover:bg-red-500 ">
                    <span class="iconify" data-icon="material-symbols:close" style="font-size: 2.5rem;"></span>
                </button>
        
                <!-- Contenu du formulaire Produits et Services -->
                <div id="coordonneeFormContainer" class="max-h-[80vh] overflow-y-auto">
                    <!-- Le formulaire sera chargé ici via AJAX -->
                </div>
            </div>
        </div>

        <div id="docModal" class="fixed z-20 inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden overflow-auto">
            <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 w-full  mx-4 md:mx-8 lg:mx-12 lg:max-w-full relative max-h-screen overflow-y-auto">
                <h2 class="font-Alumni font-bold text-2xl md:text-3xl mb-4">Modifier les brochures & cartes d'affaires </h2>
                
                <!-- Bouton de fermeture -->
                <button onclick="closeDocModal()" class="absolute top-4 right-4 text-gray-700 border-2 hover:text-white hover:bg-red-500 ">
                    <span class="iconify" data-icon="material-symbols:close" style="font-size: 2.5rem;"></span>
                </button>
        
                <!-- Contenu du formulaire Produits et Services -->
                <div id="docFormContainer" class="max-h-[80vh] overflow-y-auto">
                    <!-- Le formulaire sera chargé ici via AJAX -->
                </div>
            </div>
        </div>

        <div id="licenceModal" class="fixed z-20 inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden overflow-auto">
            <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 w-full  mx-4 md:mx-8 lg:mx-12 lg:max-w-full relative max-h-screen overflow-y-auto">
                <h2 class="font-Alumni font-bold text-2xl md:text-3xl mb-4">Modifier votre licence RBQ </h2>
                
                <!-- Bouton de fermeture -->
                <button onclick="closeLicenceModal()" class="absolute top-4 right-4 text-gray-700 border-2 hover:text-white hover:bg-red-500 ">
                    <span class="iconify" data-icon="material-symbols:close" style="font-size: 2.5rem;"></span>
                </button>
        
                <!-- Contenu du formulaire Produits et Services -->
                <div id="licenceFormContainer" class="max-h-[80vh] overflow-y-auto">
                    <!-- Le formulaire sera chargé ici via AJAX -->
                </div>
            </div>
        </div>
        
        <div id="financeModal" class="fixed z-20 inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden overflow-auto">
            <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 w-full  mx-4 md:mx-8 lg:mx-12 lg:max-w-full relative max-h-screen overflow-y-auto">
                <h2 class="font-Alumni font-bold text-2xl md:text-3xl mb-4">Modifier vos renseignements financier </h2>
                
                <!-- Bouton de fermeture -->
                <button onclick="closeFinanceModal()" class="absolute top-4 right-4 text-gray-700 border-2 hover:text-white hover:bg-red-500 ">
                    <span class="iconify" data-icon="material-symbols:close" style="font-size: 2.5rem;"></span>
                </button>
        
                <!-- Contenu du formulaire Produits et Services -->
                <div id="financeFormContainer" class="max-h-[80vh] overflow-y-auto">
                    <!-- Le formulaire sera chargé ici via AJAX -->
                </div>
            </div>
        </div>

        <div id="contactModal" class="fixed z-20 inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden overflow-auto">
            <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 w-full  mx-4 md:mx-8 lg:mx-12 lg:max-w-full relative max-h-screen overflow-y-auto">
                <h2 class="font-Alumni font-bold text-2xl md:text-3xl mb-4">Modifier vos contacts </h2>
                
                <!-- Bouton de fermeture -->
                <button onclick="closeContactModal()" class="absolute top-4 right-4 text-gray-700 border-2 hover:text-white hover:bg-red-500 ">
                    <span class="iconify" data-icon="material-symbols:close" style="font-size: 2.5rem;"></span>
                </button>
        
                <!-- Contenu du formulaire Produits et Services -->
                <div id="contactFormContainer" class="max-h-[80vh] overflow-y-auto">
                    <!-- Le formulaire sera chargé ici via AJAX -->
                </div>
            </div>
        </div>
        @endrole
        
<div class="p-4 md:p-16">
    <div class="flex flex-col md:flex-row w-full">
        <div class="flex flex-col w-full md:w-1/2">
            <h6 class="font-Alumni font-bold text-3xl md:text-5xl truncate"> Fournisseur: {{ $fournisseur->nom_entreprise }}</h6>
            <button class="flex items-center rounded-full w-fit py-2 text-xl font-semibold underline text-blue-600 hover:text-blue-800  transition duration-300 ease-in-out">
                Historique Fiche
                
            </button>
            
              
        </div>

        @if (session('success'))
        <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative" role="alert">
            <strong class="font-bold">Succès!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
 
        </div>
    @endif


        <div class="{{ $etatStyle['bgColor'] }} mt-4 md:mt-0 md:ml-2 w-full md:w-1/2 py-4 px-6 flex items-center">
            <div class="{{ $etatStyle['textColor'] }}">
                <span class="iconify" data-icon="{{ $etatStyle['icon'] }}" data-inline="false" style="font-size: 2rem;"></span>
            </div>
            <div class="ml-4">
                <h4 class="font-Alumni font-bold text-lg md:text-2xl">Statut du dossier : 
                    <span class="{{ $etatStyle['labelColor'] }}">
                        {{ $etatStyle['text'] }}
                    </span>
                </h4>
            </div>
        </div>
    </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            <!-- Première colonne -->
            <div>
                <!-- Cadre 1 : Informations d’authentification -->
                <div class="bg-primary-100 py-8 px-4 mt-8 relative">
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Informations d’authentification</h4>

                    <!-- Bouton "modifier" ajouté en haut à droite du cadre -->
                    @role('admin','responsable')
                    <div class="absolute right-4 top-4">
                        <button type="button" class="text-tertiary-400 hover:text-tertiary-300" onclick="openIdentificationModal()">
                            <span class="iconify" data-icon="material-symbols:edit" data-inline="false"
                                style="font-size: 1.5rem;"></span>
                        </button>
                    </div>
                    @endrole

                    <div class="mt-6">
                        <p class="font-Alumni text-md md:text-lg"><strong>Email :</strong> {{ $fournisseur->adresse_courriel }}</p>
                    </div>

                    <div class="mt-4">
                        <p class="font-Alumni text-md md:text-lg"><strong>Mot de passe :</strong> ••••••••</p>
                        <!-- Placeholder for security reasons -->
                    </div>

                </div>

                <div class="mt-8 px-4 py-8 bg-primary-100 relative">
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Coordonnées</h4>

                    <!-- Bouton "modifier" en haut à droite -->
                    @role('admin','responsable')
                    <div class="absolute right-4 top-4">
                        
                        <button type="button" class="text-tertiary-400 hover:text-tertiary-300" onclick="openCoordonneeModal()">
                            <span class="iconify" data-icon="material-symbols:edit" data-inline="false"
                                style="font-size: 1.5rem;"></span>
                        </button>
                    </div>
                    @endrole
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="font-Alumni md:text-lg"><strong>Numéro Civique:</strong> {{ $fournisseur->coordonnee->numero_civique }}</p>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Rue:</strong> {{ $fournisseur->coordonnee->rue }}</p>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Bureau:</strong>  {{ $fournisseur->coordonnee->bureau }}</p>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Municipalité:</strong> {{ $fournisseur->coordonnee->ville }}</p>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Code postal:</strong> {{ $fournisseur->coordonnee->code_postal }}</p>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Région Administrative:</strong> {{ $fournisseur->coordonnee->region_administrative }}</p>
                        </div>

                        <div>
                            <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Coordonnées en ligne</h4>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Site web:</strong>{{ $fournisseur->coordonnee->site_web }}</p>
                        </div>
                    </div>

                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline mt-6">Numéros de téléphone</h4>
                    <div class="max-h-48 overflow-y-auto mt-2">
                        @foreach($fournisseur->coordonnee->telephones as $telephone)
                        <p class="mt-2 font-Alumni md:text-lg  gap-0.5">
                            <strong>Ligne {{ $loop->iteration }} :</strong> <span class="phones-numberP"> {{ $telephone->numero_telephone }} </span> - 
                            Poste: {{ $telephone->poste }} - 
                            <strong>Type:</strong> {{ $telephone->type }}
                        </p>
                    @endforeach
                       
                    </div>
                </div>

                <!-- Résumé des documents téléversés -->
                 <!-- Liste des fichiers téléversés -->
    <div class="mt-8 bg-primary-100 p-4 relative">
        <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Documents téléchargés</h4>
        <div class="overflow-auto max-h-48 mt-4">
            @role('admin','responsable')
            <div class="absolute right-4 top-4">
                <button type="button" class="text-tertiary-400 hover:text-tertiary-300"  onclick="openDocModal()">
                    <span class="iconify" data-icon="material-symbols:edit" data-inline="false" style="font-size: 1.5rem;"></span>
                </button>
            </div>
            @endrole
            @forelse($fournisseur->brochuresCarte as $brochure)
                <div class="bg-white shadow-md rounded p-4 mb-2 relative">
                    <h6 class="font-Alumni font-semibold text-md md:text-lg">{{ $brochure->nom }}</h6>
                    <p class="font-Alumni text-md"><strong>Type de fichier:</strong> {{ $brochure->type_de_fichier }}</p>
                    <p class="font-Alumni text-md"><strong>Taille:</strong> {{ number_format($brochure->taille / 1048576, 2) }} MB</p>
        <!-- TODO A Retravailer le telechargement ne fonctionne pas ici    <p class="font-Alumni text-md"><a href="{{ asset($brochure->chemin) }}" class="text-tertiary-400 underline">Télécharger</a></p>-->    
                </div>
            @empty
                <p class="font-Alumni text-md md:text-lg">Aucun document disponible.</p>
            @endforelse
        </div>
    </div>

                <div class="bg-primary-100 py-8 px-4 mt-8 relative">
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Licences</h4>
                    @role('admin','responsable')
                    <div class="absolute right-4 top-4">
                        <button type="button" class="text-tertiary-400 hover:text-tertiary-300">
                            <span class="iconify" data-icon="material-symbols:edit" data-inline="false" style="font-size: 1.5rem;" onclick="openLicenceModal()"></span>
                        </button>
                    </div>
                    @endrole
                    @if($licence)
                        <div class="mt-6 w-full max-w-md">
                            <h5 class="font-Alumni font-semibold text-md md:text-lg underline">Informations sur la Licence</h5>
                            <p class="mt-2 font-Alumni md:text-lg ">   <strong >Numéro de Licence RBQ:</strong> <span class="rbq-number"> {{ $licence->numero_licence_rbq }}</span></p>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Statut:</strong> {{ $licence->statut }}</p>
                            <p class="mt-2 font-Alumni md:text-lg"><strong>Type de Licence:</strong> {{ $licence->type_licence }}</p>
                        </div>
                
                        <div class="mt-6">
                            <h5 class="font-Alumni font-bold text-md md:text-lg underline">Sous-catégories de Licence</h5>
                            <div class="overflow-auto max-h-48">
                                @foreach($licence->sousCategories as $sousCategorie)
                                    <div class="bg-white shadow-md rounded p-4 mb-2">
                                        <h6 class="font-Alumni font-semibold text-md md:text-lg underline">Sous-catégorie {{ $loop->iteration }}</h6>
                                        <p class="mt-2 font-Alumni md:text-lg"><strong>Catégorie:</strong> {{ $sousCategorie->categorie->type }}</p>
                                        <p class="mt-2 font-Alumni md:text-lg"><strong>Code de sous-catégorie:</strong> {{ $sousCategorie->categorie->code_sous_categorie }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>                  
                    @else
                        <p class="font-Alumni mt-4 text-md md:text-lg">Aucune licence disponible.</p>
                    @endif
                </div>
                


            </div>

            <!-- Deuxième colonne : Progression -->
            <div>
                <div class="bg-primary-100 py-8 px-4 mt-8 relative">
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Informations de l’entreprise</h4>

                    <!-- Bouton "modifier" en haut à droite -->
                    @role('admin','responsable')
                    <div class="absolute right-4 top-4">
                        <button type="button" class="text-tertiary-400 hover:text-tertiary-300" onclick="openIdentificationModal()">
                            <span class="iconify" data-icon="material-symbols:edit" data-inline="false"
                                style="font-size: 1.5rem;"></span>
                        </button>
                    </div>
                    @endrole
                    <div class="mt-6">
                        <p class="font-Alumni text-md md:text-lg"><strong>Numéro d’entreprise du Québec (NEQ) :</strong>
                            {{ $fournisseur->neq,'N/A' }}</p>
                    </div>
                    <div class="mt-4">
                        <p class="font-Alumni text-md md:text-lg"><strong>Nom de l’entreprise :</strong>
                            {{ $fournisseur->nom_entreprise }}</p>
                    </div>
                    <p class="font-Alumni text-md md:text-lg mt-2"><strong>Date de l'inscription  :</strong> {{ $fournisseur->created_at->format('d/m/Y à H:i') }}</p>
                </div>

                <div class="bg-primary-100 py-8 px-4 mt-8 relative">
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Produits et services</h4>

                    <!-- Bouton "modifier" en haut à droite -->
                    @role('admin','responsable')
                    <div class="absolute right-4 top-4">
                        <button type="button" class="text-tertiary-400 hover:text-tertiary-300"  onclick="openProduitsServicesModal()">
                            <span class="iconify" data-icon="material-symbols:edit" data-inline="false"
                                style="font-size: 1.5rem;"></span>
                        </button>
                    </div>
                    @endrole

                    <div id="produitsServicesResumes" class="max-h-64 mt-8 overflow-y-auto custom-scrollbar grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($fournisseur->produitsServices as $produitService)
                            <div class="bg-white shadow-md rounded p-4 mb-2">
                                <h6 class="font-Alumni font-semibold text-md md:text-lg">{{ $produitService->nature }}</h6>
                                <p class="font-Alumni text-md"><strong>Code Catégorie:</strong> {{ $produitService->code_categorie }}</p>
                                <p class="font-Alumni text-md"><strong>Code UNSPSC:</strong> {{ $produitService->code_unspsc }}</p>
                                <p class="font-Alumni text-md"><strong>Description:</strong> {{ $produitService->description }}</p>
                            </div>
                        @empty
                            <p class="font-Alumni text-md md:text-lg">Aucun produit ou service disponible.</p>
                        @endforelse
                    </div>
                    
                    <div class="mt-6">
                        <label for="details" class="block font-Alumni text-md md:text-lg mb-2">Détails
                            supplémentaires</label>
                        <textarea disabled id="details" name="details" placeholder="Entrer des détails supplémentaires" 
                            class="font-Alumni w-full max-w-md p-2 h-28 focus:outline-none focus:border-blue-500 border border-black"> {{ $fournisseur->details_specifications }}</textarea>

                        @error('details')
                            <span
                                class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Cadre résumé des contacts -->
              <!-- Cadre résumé des contacts -->
<div class="bg-primary-100 py-8 px-4 mt-8 relative">
    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Contacts</h4>

    <!-- Bouton "modifier" en haut à droite -->
    @role('admin','responsable')
    <div class="absolute right-4 top-4">
        <button type="button" class="text-tertiary-400 hover:text-tertiary-300">
            <span class="iconify" data-icon="material-symbols:edit" data-inline="false" style="font-size: 1.5rem;"  onclick="openContactModal()"></span>
        </button>
    </div>
    @endrole

    <!-- Section scrollable pour afficher plusieurs contacts -->
    <div id="contactContainer" class="max-h-64 overflow-y-auto grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
        @forelse($fournisseur->contacts as $contact)
            <div class="bg-white p-4 shadow-md rounded mb-2">
                <div class="flex flex-col sm:flex-row justify-between">
                    <div class="sm:w-1/2 pr-2">
                        <h5 class="font-Alumni font-semibold text-md md:text-lg underline">Information générale</h5>
                        <p class="mt-2 font-Alumni md:text-lg"><strong>Prénom:</strong> {{ $contact->prenom }}</p>
                        <p class="mt-2 font-Alumni md:text-lg"><strong>Nom:</strong> {{ $contact->nom }}</p>
                        <p class="mt-2 font-Alumni md:text-lg"><strong>Fonction:</strong> {{ $contact->fonction }}</p>
                        <p class="mt-2 font-Alumni md:text-lg"><strong>Email:</strong> {{ $contact->adresse_courriel }}</p>
                    </div>

                    <div class="sm:w-1/2 lg:pl-2">
                        <h5 class="font-Alumni font-semibold text-md md:text-lg underline">Coordonnées</h5>
                        <p class="mt-2 font-Alumni md:text-lg"><strong>Numéro de téléphone:</strong> <span class="phones-numberP"> {{ $contact->telephone->numero_telephone ?? 'N/A' }}</span></p>
                        <p class="mt-2 font-Alumni md:text-lg"><strong>Poste:</strong> {{ $contact->telephone->poste ?? 'N/A' }}</p>
                        <p class="mt-2 font-Alumni md:text-lg"><strong>Type:</strong> {{ $contact->telephone->type ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="font-Alumni text-md md:text-lg">Aucun contact disponible.</p>
        @endforelse
    </div>
</div>

                @if($fournisseur->etat == 'accepter')
                @if($fournisseur->finance)
                <div class="bg-primary-100 py-8 px-4 mt-8 relative">
                    <!-- Bouton "modifier" en haut à droite -->
                    @role('admin','responsable')
                    <div class="absolute right-4 top-4">
                        <button type="button" class="text-tertiary-400 hover:text-tertiary-300">
                            <span class="iconify" data-icon="material-symbols:edit" data-inline="false"  onclick="openFinanceModal()"
                                style="font-size: 1.5rem;"></span>
                        </button>
                    </div>
                    @endrole
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Finances</h4>

                    <div class="mt-6 w-full max-w-md">
                        <!-- Résumé des informations fiscales -->
                        <h5 class="font-Alumni font-semibold text-md md:text-lg underline">Informations Fiscales</h5>
                        <p class="mt-2 font-Alumni md:text-lg"><strong>Numéro TPS:</strong> {{ $fournisseur->finance->numero_tps }}
                        </p>
                        <p class="mt-2 font-Alumni md:text-lg"><strong>Numéro TVQ:</strong> {{ $fournisseur->finance->numero_tvq }}
                        </p>

                        <!-- Résumé des conditions de paiement -->
                        <h5 class="font-Alumni font-semibold text-md md:text-lg mt-4 underline">Conditions de Paiement</h5>
                        <p class="mt-2 font-Alumni md:text-lg"><strong>Condition de Paiement:</strong>
                            {{ $condition_paiementText['text'] }}</p>

                        <!-- Résumé des informations de configuration -->
                        <h5 class="font-Alumni font-semibold text-md md:text-lg mt-4 underline">Configuration</h5>
                        <p class="mt-2 font-Alumni md:text-lg"><strong>Devise:</strong>{{ $fournisseur->finance->devise }}</p>
                        <p class="mt-2 font-Alumni md:text-lg"><strong>Mode de Communication:</strong>
                            {{ $fournisseur->finance->mode_communication }}</p>
                    </div>
                </div>
                @else
                <div class="bg-primary-100 py-8 px-4 mt-8 relative">
                    @role('admin','responsable')
                    <div class="absolute right-4 top-4">
                    <button type="button" class="text-tertiary-400 hover:text-tertiary-300">
                        <span class="iconify" data-icon="material-symbols:edit" data-inline="false"  onclick="openFinanceModal()"
                            style="font-size: 1.5rem;"></span>
                    </button>
                </div>
                @endrole
            <p class="font-Alumni mt-4 text-md md:text-lg">Aucune information financière disponible.</p>
        </div>
        @endif
                @endif
                    <!-- Conteneurs pour les catégories avec défilement -->
               
            </div>
        </div>

    </div>


@endsection

<script>
        
    
    // Stocker l'ID dans le localStorage
   
    document.addEventListener('DOMContentLoaded', function() {
        const fournisseurId = {{ $fournisseur->id }};
        localStorage.setItem('fournisseurId', fournisseurId);
        console.log(fournisseurId);
        @if (session()->has('errorsId'))
            openIdentificationModal();
        @endif
        @if (session()->has('errorsPS'))
        openProduitsServicesModal();
        @endif
        @if (session()->has('errorsCoordonnees'))
        openCoordonneeModal();
        @endif
        @if (session()->has('errorsFichiers'))
        openDocModal();
        @endif
        @if (session()->has('errorsLicence'))
        openLicenceModal();
        @endif
        @if (session()->has('errorsFinance'))
        openFinanceModal();
        @endif
        @if (session()->has('errorsContact'))
        openContactModal();
        @endif

        
        var successMessage = document.getElementById('successMessage');
        if (successMessage) {
            Swal.fire({
  position: "top-end",
  icon: "success",
  title: successMessage,
  showConfirmButton: false,
  timer: 1500
});
        }
        //Formattage rbq et tel format canadien ###-###-####
    function formatPhoneNumber(number) {
        return number.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
    }


    function formatRBQ(number) {
        return number.replace(/(\d{4})(\d{4})(\d{2})/, '$1-$2-$3');
    }
    document.querySelectorAll('.phones-numberP').forEach(function (element) {
        element.textContent = formatPhoneNumber(element.textContent);
    });

 
    const rbqElement = document.querySelector('.rbq-number');
    if (rbqElement) {
        rbqElement.textContent = formatRBQ(rbqElement.textContent);
    }
    });

 
    function loadScript(src, callback) {
        const script = document.createElement('script');
        script.src = src;
        script.onload = function() {
            console.log(`Script ${src} chargé et exécuté`);
            if (callback) callback();
        };
        document.body.appendChild(script);
    }

function openDocModal() {
    const fournisseurId = localStorage.getItem('fournisseurId');
    if (etatFiche === 'desactiver') {
        Swal.fire({
            title: 'Fiche désactivée',
            text: 'Vous devez réactiver la fiche fournisseur pour pouvoir modifier ses informations.',
            icon: 'warning',
            confirmButtonText: 'Ok',
        });
        return; 
    }
    document.getElementById('docModal').classList.remove('hidden');

    axios.get(`/fournisseur/${fournisseurId}/edit-doc`) 
        .then(function (response) {
            document.getElementById('docFormContainer').innerHTML = response.data;

            loadScript('{{ asset('js/modif/docModif.js') }}', function() {
                setTimeout( initializeDocFormScript, 100);
            });
          
        })
        .catch(function (error) {
            console.error("Erreur lors du chargement de la page brochures et cartes affaires", error);
        });
}

function closeDocModal() {
    document.getElementById('docModal').classList.add('hidden');
}

function openIdentificationModal() {
    const fournisseurId = localStorage.getItem('fournisseurId');
        if (etatFiche === 'desactiver') {
        Swal.fire({
            title: 'Fiche désactivée',
            text: 'Vous devez réactiver la fiche fournisseur pour pouvoir modifier ses informations.',
            icon: 'warning',
            confirmButtonText: 'Ok',
        });
        return; 
    }
        document.getElementById('identificationModal').classList.remove('hidden');
    
        axios.get(`/Identification/${fournisseurId}/modif`)
            .then(function (response) {
          
                document.getElementById('identificationFormContainer').innerHTML = response.data;
    
              
                loadScript('{{ asset('js/modif/identificationModif.js') }}', function() {
                
                    setTimeout(initializeIdentificationFormScript, 100);
                });
            })
            .catch(function (error) {
                console.error("Erreur lors du chargement de la page d'identification:", error);
            });
    }
       
    function closeModal() {
        document.getElementById('identificationModal').classList.add('hidden');
    }

    function openProduitsServicesModal() {
        const fournisseurId = localStorage.getItem('fournisseurId');
        if (etatFiche === 'desactiver') {
        Swal.fire({
            title: 'Fiche désactivée',
            text: 'Vous devez réactiver la fiche fournisseur pour pouvoir modifier ses informations.',
            icon: 'warning',
            confirmButtonText: 'Ok',
        });
        return; 
    }
    document.getElementById('produitsServicesModal').classList.remove('hidden');

    axios.get(`/produits-services/${fournisseurId}}/modif/`) 
        .then(function (response) {
            document.getElementById('produitsServicesFormContainer').innerHTML = response.data;

           
            loadScript('{{ asset('js/modif/produitModif.js') }}', function() {
                setTimeout(initializeProduitsServicesFormScript, 100);
            });
        })
        .catch(function (error) {
            console.error("Erreur lors du chargement de la page Produits et Services:", error);
        });
}

function closeProduitsServicesModal() {
    document.getElementById('produitsServicesModal').classList.add('hidden');
}

function openLicenceModal() {
    const fournisseurId = localStorage.getItem('fournisseurId');
    if (etatFiche === 'desactiver') {
        Swal.fire({
            title: 'Fiche désactivée',
            text: 'Vous devez réactiver votre fiche fournisseur pour pouvoir modifier vos informations.',
            icon: 'warning',
            confirmButtonText: 'Ok',
        });
        return; 
    }
    document.getElementById('licenceModal').classList.remove('hidden');

    axios.get(`/Licences/${fournisseurId}/modif`) 
        .then(function (response) {
            document.getElementById('licenceFormContainer').innerHTML = response.data;

            loadScript('{{ asset('js/modif/licenceModif.js') }}', function() {
                setTimeout( initializeLicenceFormScript, 100);
            });
          
        })
        .catch(function (error) {
            console.error("Erreur lors du chargement de la page des licences RBQ", error);
        });
}

function closeLicenceModal() {
    document.getElementById('licenceModal').classList.add('hidden');
}

function openContactModal() {
    const fournisseurId = localStorage.getItem('fournisseurId');
    if (etatFiche === 'desactiver') {
        Swal.fire({
            title: 'Fiche désactivée',
            text: 'Vous devez réactiver votre fiche fournisseur pour pouvoir modifier vos informations.',
            icon: 'warning',
            confirmButtonText: 'Ok',
        });
        return; 
    }
    document.getElementById('contactModal').classList.remove('hidden');

    axios.get(`/Contacts/${fournisseurId}/modif`)
        .then(function (response) {
            document.getElementById('contactFormContainer').innerHTML = response.data;

            loadScript('{{ asset('js/modif/contactModif.js') }}', function() {
                setTimeout( initializeContactFormScript, 100);
            });
          
        })
        .catch(function (error) {
            console.error("Erreur lors du chargement de la page des contacts", error);
        });
}

function closeContactModal() {
    document.getElementById('contactModal').classList.add('hidden');
}

function openCoordonneeModal() {
    const fournisseurId = localStorage.getItem('fournisseurId');
    if (etatFiche === 'desactiver') {
        Swal.fire({
            title: 'Fiche désactivée',
            text: 'Vous devez réactiver votre fiche fournisseur pour pouvoir modifier vos informations.',
            icon: 'warning',
            confirmButtonText: 'Ok',
        });
        return; 
    }
    document.getElementById('coordonneeModal').classList.remove('hidden');

    axios.get(`/Coordonnees/${fournisseurId}/modif`) 
        .then(function (response) {
            document.getElementById('coordonneeFormContainer').innerHTML = response.data;

          
            loadScript('{{ asset('js/modif/coordonneeModif.js') }}', function() {
                setTimeout(initializeCoordonneeFormScript, 100);
            });
        })
        .catch(function (error) {
            console.error("Erreur lors du chargement de la page coordonnée", error);
        });
}

function closeCoordonneeModal() {
    document.getElementById('coordonneeModal').classList.add('hidden');
}

function openFinanceModal() {
    const fournisseurId = localStorage.getItem('fournisseurId');
    if (etatFiche === 'desactiver') {
        Swal.fire({
            title: 'Fiche désactivée',
            text: 'Vous devez réactiver votre fiche fournisseur pour pouvoir modifier vos informations.',
            icon: 'warning',
            confirmButtonText: 'Ok',
        });
        return; 
    }
    document.getElementById('financeModal').classList.remove('hidden');

    axios.get(`/Finances/${fournisseurId}/modif`) 
        .then(function (response) {
            document.getElementById('financeFormContainer').innerHTML = response.data;

            loadScript('{{ asset('js/modif/financeModif.js') }}', function() {
                setTimeout( initializeFinanceFormScript, 100);
            });
          
        })
        .catch(function (error) {
            console.error("Erreur lors du chargement de la page des finances", error);
        });
}

function closeFinanceModal() {
    document.getElementById('financeModal').classList.add('hidden');
}
const etatFiche = "{{ $fournisseur->etat }}"; 
    </script>
    
    
