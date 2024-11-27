@extends('layouts.modif')

@section('title', 'Identification')

@section('contenu')

    <form action="{{ route('UpdateIdentification') }}" method="post" id="identificationForm" >
        @csrf
        @if(session('errorsId'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <strong class="font-bold">Erreur!</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach (session('errorsId')->all() as $error)
                    <li class="font-Alumni">{{ $error }}</li>
                @endforeach
            </ul>
        </div  
    @endif

  
        <div class="p-4 md:p-16 flex flex-col w-full">
            <div class="flex w-full flex-col 2xl:flex-row gap-4">
                <div class="flex flex-col w-full">
                    <h6 class="font-Alumni font-bold text-3xl md:text-5xl">Merci de vous identifier !</h6>
                    <h1 class="font-Alumni font-semibold text-md md:text-lg mt-2">Dites-nous en plus sur vous</h1>
                </div>
          
            </div>
       
    
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- Première colonne -->
                <div>
                    <div class="bg-primary-100 py-8 px-4 mt-8">
                        <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Informations d’authentification</h4>

                        <div class="mt-6">
                            <label for="email" class="block font-Alumni text-md md:text-lg mb-2">
                                Adresse courriel
                            </label>
                            <input type="email" id="email" name="email" placeholder="Entrer votre email"
                                value="{{ old('email', $fournisseur->adresse_courriel) }}"
                                class="font-Alumni w-full max-w-md p-2 focus:outline-none focus:border-blue-500 border border-black">

                            @error('email')
                                <span
                                    class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="password" class="block font-Alumni text-md md:text-lg mb-2">
                                Choisir un mot de passe
                            </label>
                            <input type="password" id="password" name="password" placeholder="Entrer votre mot de passe"
                                class="font-Alumni w-full max-w-md p-2 focus:outline-none focus:border-blue-500 border border-black">

                            @error('password')
                                <span
                                    class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="password_confirmation" class="block font-Alumni text-md md:text-lg mb-2">
                                Ressaisir votre mot de passe
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                placeholder="Ressaisir votre mot de passe"
                                class="font-Alumni w-full max-w-md p-2 focus:outline-none focus:border-blue-500 border border-black">

                            @error('password_confirmation')
                                <span
                                    class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
          
                <!-- Deuxième colonne -->
                <div>
                    <div class="bg-secondary-100 py-8 px-4 mt-8">
                        <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Identification</h4>

                        <div class="mt-6">
                            <label for="numeroEntreprise" class="flex items-center font-Alumni text-md md:text-lg mb-2">
                                Numéro d’entreprise du Québec (NEQ)
                                <p class="italic text-sm ml-2">*Ce numéro n'est pas obligatoire</p>
                            </label>
                            <input disabled type="text" id="numeroEntreprise"
                                value="{{ old('numeroEntreprise',  $fournisseur->neq) }}"
                                placeholder="Entrer votre numéro d’entreprise du Québec"
                                class="font-Alumni w-full max-w-md p-2 focus:outline-none focus:border-blue-500 border border-black cursor-not-allowed">

                            @error('numeroEntreprise')
                                <span
                                    class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <label for="nomEntreprise" class="block font-Alumni text-md md:text-lg mb-2">
                                Nom de l’entreprise
                            </label>
                            <input type="text" id="nomEntreprise" name="nomEntreprise"
                                value="{{ old('nomEntreprise',  $fournisseur->nom_entreprise) }}"
                                placeholder="Entrer le nom de votre entreprise"
                                class="font-Alumni w-full max-w-md p-2 focus:outline-none focus:border-blue-500 border border-black">

                            @error('nomEntreprise')
                                <span
                                    class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <button type="button" class="mt-9 w-full text-white bg-tertiary-400 hover:bg-tertiary-300 py-2.5" id="confirmButton">
                            <h1 class="font-Alumni font-bold text-lg md:text-2xl">Enregistrer</h1>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
 
    <script src="{{ asset('js/modif/identificationModif.js') }}"></script>

    
@endsection
@php
session()->forget('errorsId');
@endphp
