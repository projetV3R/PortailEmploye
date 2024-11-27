@vite(['resources/css/app.css', 'resources/js/app.js'])

@extends('layouts.modif')

@section('title', 'Contacts')

@section('contenu')

    <form action="{{ route('UpdateContact') }}" method="post" id="contactForm">
        @csrf
        @if(session('errorsContact'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <strong class="font-bold">Erreur!</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach (session('errorsContact')->all() as $error)
                    <li class="font-Alumni">{{ $error }}</li>
                @endforeach
            </ul>
        </div  
    @endif
        <div class="flex w-full lg:flex-col flex-col gap-4 p-8 lg:p-16" id="contactFieldsContainer">
            <div class="flex w-full flex-col">
                <h6 class="font-Alumni font-bold text-3xl md:text-5xl">CONTACTS</h6>
                <h1 class="font-Alumni font-semibold text-md md:text-lg mt-2">Pour rester plus proches de vous !</h1>
            </div>

            <div class="flex w-full gap-x-4 flex-col lg:flex-row">
                <div class="flex flex-col w-full lg:1/2 ">
                    <div class="bg-primary-100 py-8 px-4 mt-8">
                        <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Information generale</h4>

                        <div class="mt-6 w-full max-w-md flex gap-4 columns-2">
                            <div class="w-full">
                                <label for="prenom" class="block font-Alumni text-md md:text-lg mb-2">
                                    Prenom
                                </label>
                                <input type="text" id="prenom" name="contacts[0][prenom]" placeholder="Doe"
                                    class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">
                                @error('contacts.0.prenom')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4 w-full max-w-md">
                            <label for="nom" class="block font-Alumni text-md md:text-lg mb-2">
                                Nom
                            </label>
                            <input type="text" id="nom" name="contacts[0][nom]" placeholder="John"
                                class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">
                            @error('contacts.0.nom')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4 w-full max-w-md flex gap-4 columns-2">
                            <div class="w-full">
                                <label for="fonction" class="block font-Alumni text-md md:text-lg mb-2">
                                    Fonction
                                </label>
                                <input type="text" id="fonction" name="contacts[0][fonction]" placeholder="Comptable"
                                    class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">
                                @error('contacts.0.fonction')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4 w-full max-w-md flex gap-4 columns-2">
                            <div class="w-full">
                                <label for="email" class="block font-Alumni text-md md:text-lg mb-2">
                                    Email
                                </label>
                                <input type="text" id="email" name="contacts[0][email]" placeholder="johndoe@gmail.com"
                                    class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">
                                @error('contacts.0.email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="contacts[0][telephone_id]" value="">
                <input type="hidden" name="contacts[0][id]" value=""> 

                <!-- Deuxième colonne -->
                <div class="bg-secondary-100 lg:py-10 mt-8 w-full lg:max-w-4xl flex flex-col h-fit">
                    <div class="bg-secondary-100 lg:py-8 lg:px-4 px-2 flex flex-col">
                        <div class="w-full flex">
                            <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Numero de telephone</h4>
                        </div>
                        <div class="mt-6 w-full max-w-md flex gap-4 lg:flex-row flex-col">
                            <div class="w-full">
                                <label for="ligne" class="block font-Alumni text-md md:text-lg mb-2">
                                    Ligne
                                </label>
                                <select id="type" name="contacts[0][type]"
                                    class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">
                                    <option value="Bureau">Bureau</option>
                                    <option value="Télécopieur">Télécopieur</option>
                                    <option value="Cellulaire">Cellulaire</option>
                                </select>
                                @error('contacts.0.type')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label for="numeroTelephone" class="block font-Alumni text-md md:text-lg mb-2 truncate">
                                    Numero Telephone
                                </label>
                                <input type="text" id="numeroTelephone" name="contacts[0][numeroTelephone]"
                                    placeholder="514-453-9867"
                                    class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">
                                @error('contacts.0.numeroTelephone')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label for="poste" class="block font-Alumni text-md md:text-lg mb-2">
                                    Poste
                                </label>
                                <input type="text" id="poste" name="contacts[0][poste]" placeholder="9845"
                                    class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">
                                @error('contacts.0.poste')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col px-2 lg:px-4">
                        <button type="button"
                            class="w-full text-white bg-tertiary-400 hover:bg-tertiary-300 py-2.5 mt-2" id="submitBtn">
                            <h1 class="font-Alumni font-bold text-lg md:text-2xl">Enregistrer</h1>
                        </button>
                        <button id="addContactBtn" type="button"
                            class="w-full text-white bg-blue-500 hover:bg-blue-400 py-2.5 mt-2">
                            <h1 class="font-Alumni font-bold text-lg md:text-2xl">Ajouter un autre contact</h1>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
@php
session()->forget('errorsContact');
@endphp