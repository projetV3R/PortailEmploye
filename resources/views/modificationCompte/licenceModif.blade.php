@extends('layouts.modif')

@section('title', 'LicencesAutorisations')

@section('contenu')
    <form action="{{ route('UpdateLicence') }}" method="post" id="licenceForm">
        @csrf
        @if(session('errorsLicence'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <strong class="font-bold">Erreur!</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach (session('errorsLicence')->all() as $error)
                    <li class="font-Alumni">{{ $error }}</li>
                @endforeach
            </ul>
        </div  
    @endif
        <div class="p-4 md:p-16 flex flex-col  w-full">
            <div class="flex w-full flex-col 2xl:flex-row gap-4 ">
                <div class="flex flex-col w-full">
                     <h6 class="font-Alumni font-bold text-3xl md:text-5xl">LICENCES ET AUTORISATIONS</h6>
                    <h1 class="font-Alumni font-semibold text-md md:text-lg mt-2">Parler nous des services que vous offrez</h1>
    
                    
                </div>
              
            </div>
            <div class="mt-4">
                <button type="button" id="deleteLicenceButton" class=" flex items-center p-4 px-2 text-white bg-red-500 hover:bg-red-400 py-2.5">
                    <span class="iconify" data-icon="material-symbols:close" style="font-size: 2.5rem;"></span>
                    <h1 class="font-Alumni font-bold text-lg md:text-2xl">Supprimer la licence</h1>
                </button>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 ">
            <!-- Première colonne -->
            <div>
              
                <div class="bg-primary-100 py-8 px-4 mt-8">
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Licence RBQ</h4>

                    <div class="mt-6 w-full max-w-md flex gap-4 columns-2">
                        <!-- Conteneur du numeroLicence -->
                        <div class="w-1/2">
                            <label for="numeroLicence" class="block font-Alumni text-md md:text-lg mb-2">Numero de licence</label>
                            <input type="text" id="numeroLicence" name="numeroLicence"
                                placeholder="Entrer votre numero de licence"
                                value=""  
                                class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">
                            @error('numeroLicence')
                                <span class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Conteneur du statut -->
                        <div class="w-1/2">
                            <label for="statut" class="block font-Alumni text-md md:text-lg mb-2">Statut</label>
                            <select name="statut" id="statut" class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-blackl">
                                <option value="" disabled selected>Choisir un statut</option>
                                <option value="active" >
                                    Active</option>
                                <option value="inactive"
                                  >Inactive</option>
                                <option value="valide">
                                    Valide</option>
                                <option value="valide avec restriction"
                                    >
                                    Valide avec restriction</option>
                                <option value="non valide"
                                    >Non valide
                                </option>
                                <option value="expirée">
                                    Expirée</option>
                                <option value="suspendue"
                                    >Suspendue</option>
                                <option value="révoquée"
                                    >Révoquée</option>
                                <option value="non renouvelée"
                                    >Non
                                    renouvelée</option>
                                <option value="annulée"
                                    >Annulée</option>
                            </select>
                            @error('statut')
                                <span class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Type de licence -->
                    <div class="mt-6 w-full max-w-md flex gap-4 columns-2">
                        <div class="w-full">
                            <label for="typeLicence" class="block font-Alumni text-md md:text-lg mb-2">Type de licence</label>
                            <select name="typeLicence" id="typeLicence" class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">
                                <option value="" disabled selected>Choisir un type de licence</option>
                                <option value="entrepreneur" >Entrepreneur</option>
                                <option value="Constructeur-propriétaire" >Constructeur-propriétaire</option>
                            </select>
                            @error('typeLicence')
                                <span class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
          
            <!-- Deuxième colonne -->
            <div>
           
                
                <div class="bg-secondary-100 py-8 px-4 mt-8" id="cadreCategorie">
                    <h6 class="font-Alumni  font-bold text-3xl md:text-5xl">Sous-catégories</h6>
                @error('sousCategorie')
                <span class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                    {{ $message }}
                </span>
            @enderror
                    <div id="checklistContainer" class="mt-6">
                        <p>Sélectionnez un type de licence pour voir les sous-catégories disponibles.</p>
                    </div>
                </div>

                <button type="button" class="mt-2 w-full text-white bg-tertiary-400 hover:bg-tertiary-300 py-2.5" id="confirmButton">
                    <h1 class="font-Alumni font-bold text-lg md:text-2xl">Enregistrer</h1>
                </button>
            </div>
        </div>
    </div>
    </form>
@endsection
@php
session()->forget('errorsLicence');
@endphp
