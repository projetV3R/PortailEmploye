@extends('layouts.modif')

@section('title', 'ProduitService')

@section('contenu')

<form id="produitsServicesForm" action="{{ route('UpdateProduit') }}" method="post" id="produitForm">
    @csrf
    @if(session('errorsPS'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
        <strong class="font-bold">Erreur!</strong>
        <ul class="mt-2 list-disc list-inside">
            @foreach (session('errorsPS')->all() as $error)
                <li class="font-Alumni">{{ $error }}</li>
            @endforeach
        </ul>
    </div  
@endif
    <div class="flex w-full lg:flex-col flex-col gap-4 p-8 lg:p-16">
        <div class="flex w-full flex-col 2xl:flex-row gap-4 ">
        <div class="flex w-full flex-col">
            <h6 class="font-Alumni font-bold text-3xl md:text-5xl">Produits et services</h6>
            <h1 class="font-Alumni font-semibold text-md md:text-lg mt-2">
                Parlez-nous des services que vous offrez      
            </h1>
           
        </div>
    
    </div>
        <!-- Conteneur principal -->
        <div class="flex w-full lg:flex-row flex-col gap-x-4">
            <!-- Colonne des produits non sélectionnés -->
            <div class="flex flex-col ">
                @if (session('errors'))
                    <ul>
                        @foreach (session('errors')->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="bg-primary-100 py-8 px-2 md:px-4 mt-8  ">
                    <div class="flex w-full">
                        <div class="justify-start flex w-full">
                            <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Produits et services</h4>
                        </div>
                        <div class="flex justify-end items-end w-full font-bold">
                            <button type="button" id="unspscButton" class="flex items-center gap-x-1">
                                <span class="iconify size-6" data-icon="grommet-icons:help-book"></span>
                                <span class="hidden lg:block">UNSPSC</span>
                            </button>
                        </div> 
                    </div>
                    <div class="mt-6 w-full flex flex-col">
                        <label for="recherche" class="block font-Alumni text-md md:text-lg mb-2">
                            En peu de mots décrivez vos produits ou services, le secteur ou le code UNSPSC
                        </label>
                        <div class="flex flex-col">
                            <input type="text" id="recherche"
                                placeholder="En peu de mots décrivez vos produits ou services"
                                class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">
                                <select id="selectCategorie" class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">
                                    <option value="" disabled selected>Choisissez une catégorie pour filtrer les produits et services</option>
                                </select>
                        </div>
                        <div id="pagination" class="mt-4 flex justify-center items-center gap-x-2"></div>

                        <div id="toutLesProduitsServices" class="grid  grid-cols-2 gap-4 mt-4"></div>

                        @error('recherche')
                            <span class="font-Alumni text-lg text-red-500 mt-1 ml-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- Colonne des produits sélectionnés -->
            <div class="bg-secondary-100 py-10 px-8 mt-8 w-full lg:max-w-4xl mx-auto flex flex-col h-fit">
                <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Produits et services sélectionnés</h4>

                <!-- Ajout du compteur -->
                <p id="selectedCount" class="font-Alumni text-md md:text-lg mt-2">Nombre de produits sélectionnés : 0</p>

                <!-- Conteneur de pagination pour les produits sélectionnés -->
                <div id="paginationSelected" class="mt-4 flex justify-center items-center gap-x-2"></div>

                <!-- Conteneur des produits sélectionnés -->
                <div id="produitsServicesSelectionnees" class="grid grid-cols-1 2xl:grid-cols-2 gap-4 mt-4"></div>

                @error('produits_services[]')
                    <span class="font-Alumni text-lg text-red-500 mt-1 ml-1">{{ $message }}</span>
                @enderror
                <div class="mt-6">
                    <label for="details_specifications" class="block font-Alumni text-md md:text-lg mb-2">Détails</label>
                    <textarea id="details_specifications" name="details_specifications"
                        class="font-Alumni w-full max-w-md p-2 h-28 focus:outline-none focus:border-blue-500 border border-black"
                        placeholder="Entrer des détails supplémentaires">{{ old('details_specifications', $fournisseur->details_specifications) }}</textarea>

                    @error('details_specifications')
                        <span class="font-Alumni text-lg text-red-500 mt-1 ml-1">{{ $message }}</span>
                    @enderror
                </div>

                <button type="button" class="mt-4 w-full bg-tertiary-400 hover:bg-tertiary-300 py-3 text-white rounded-md" id="confirmButton">
                    <h1 class="font-Alumni font-bold text-lg md:text-2xl">Enregistrer</h1>
                </button>
            </div>
        </div>
    </div>

</form>

<script src="{{ asset('js/modif/produitModif.js') }}"></script>

@endsection
@php
session()->forget('errorsPS');
@endphp
