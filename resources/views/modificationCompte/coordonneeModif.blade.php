
@extends('layouts.modif')

@section('title', 'Coordonnees')

@section('contenu')

    <form action="{{ route('UpdateCoordonnee') }}" method="post">
        @csrf
        @if(session('errorsCoordonnees'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <strong class="font-bold">Erreur!</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach (session('errorsCoordonnees')->all() as $error)
                    <li class="font-Alumni">{{ $error }}</li>
                @endforeach
            </ul>
        </div  
    @endif
        <div class="p-4 md:p-16 flex flex-col  w-full">
            <div class="flex w-full flex-col 2xl:flex-row gap-4 ">
                <div class="flex flex-col w-full">
                    <h6 class="font-Alumni font-bold text-3xl md:text-5xl">COORDONNEES</h6>
                <h1 class="font-Alumni font-semibold text-md md:text-lg mt-2">Ou vous situez vous ?</h1>
                    
                </div>

            </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 ">
            <!-- Première colonne -->
            <div>
                

                <div class="bg-primary-100 py-8 px-4 mt-8 ">
                    <div class="flex items-center gap-0.5">
                    <span class="iconify  size-4 md:size-6" data-icon="material-symbols:home-outline"></span>
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Adresse physique</h4>
                   
                    </div>

                    <div class="mt-6 w-full max-w-md flex gap-4 columns-2 ">

                        <div class="w-1/4">
                            <label for="numeroCivique" class="block font-Alumni text-md md:text-lg mb-2">
                                N Civique
                            </label>
                            <input type="text" id="numeroCivique" name="numeroCivique" placeholder="1077"
                                class="font-Alumni w-full p-2 h-12 h-12focus:outline-none focus:border-blue-500 border border-black">

                            @error('numeroCivique')
                                <span
                                    class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="w-1/2">
                            <label for="rue" class="block font-Alumni text-md md:text-lg mb-2">
                                Rue
                            </label>
                            <input type="text" id="rue" name="rue" placeholder="Rue marguerite bourgoeys"
                                class="font-Alumni w-full p-2 h-12 h-12focus:outline-none focus:border-blue-500 border border-black">
                            @error('rue')
                                <span
                                    class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="w-1/4">
                            <label for="bureau" class="block font-Alumni text-md md:text-lg mb-2">
                                Bureau
                            </label>
                            <input type="text" id="bureau" name="bureau" placeholder="2867"
                                class="font-Alumni w-full p-2 h-12 h-12focus:outline-none focus:border-blue-500 border border-black">

                            @error('bureau')
                                <span
                                    class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 w-full max-w-md flex gap-4 columns-2 ">

                        <div class="w-full">
                            <label for="rue" class="block font-Alumni text-md md:text-lg mb-2">
                                Code postale
                            </label>
                            <input type="text" id="codePostale" name="codePostale" placeholder="G8Z 3T2"
                                class="font-Alumni w-full p-2 h-12 h-12focus:outline-none focus:border-blue-500 border border-black">

                            @error('codePostale')
                                <span
                                    class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 w-full max-w-md">
                        <label for="province" class="block font-Alumni text-md md:text-lg mb-2">
                            Provinces
                        </label>
                   
                        <select name="province" id="province"
                 
                            class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">
                            <option value="" disabled selected>Choisissez une province</option>
                            <option value="Alberta">Alberta</option>
                            <option value="Saskatchewan">Saskatchewan</option>
                            <option value="Manitoba">Manitoba</option>
                            <option value="Ontario">Ontario</option>
                            <option value="Québec" selected>Québec</option>
                            <option value="Nouveau_Brunswick">Nouveau-Brunswick</option>
                            <option value="Île_du_Prince_Édouard">Île-du-Prince-Édouard</option>
                            <option value="Nouvelle_Écosse">Nouvelle-Écosse</option>
                            <option value="Terre_Neuve_et_Labrador">Terre-Neuve-et-Labrador</option>
                            <option value="Labrador">Labrador</option>
                            <option value="Yukon">Yukon</option>
                            <option value="Territoires_du_Nord_Ouest">Territoires du Nord-Ouest</option>
                            <option value="Nunavut">Nunavut</option>
                        </select>

                        @error('province')
                            <span
                                class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                {{ $message }}
                            </span>
                        @enderror
    
                    </div>
                    <div class="mt-4 w-full max-w-md">
                        <label for="regionAdministrative" class="block font-Alumni text-md md:text-lg mb-2">
                            Régions Administratives
                        </label>
                   
                        <select name="regionAdministrative" id="regionAdministrative"
                    
                            class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">
                            <option value="" disabled selected>Choisissez une région administrative</option>
                            <option value="Bas-Saint-Laurent (01)"  >Bas-Saint-Laurent (01)</option>
                            <option value="Saguenay-Lac-Saint-Jean (02)">Saguenay-Lac-Saint-Jean (02)</option>
                            <option value="Capitale-Nationale (03)">Capitale-Nationale (03)</option>
                            <option value="Mauricie (04)">Mauricie (04)</option>
                            <option value="Estrie (05)">Estrie (05)</option>
                            <option value="Montréal (06)">Montréal (06)</option>
                            <option value="Outaouais (07)">Outaouais (07)</option>
                            <option value="Abitibi-Témiscamingue (08)">Abitibi-Témiscamingue (08)</option>
                            <option value="Côte-Nord (09)">Côte-Nord (09)</option>
                            <option value="Nord-du-Québec (10)">Nord-du-Québec (10)</option>
                            <option value="Gaspésie-Îles-de-la-Madeleine (11)">Gaspésie-Îles-de-la-Madeleine (11)</option>
                            <option value="Chaudière-Appalaches (12)">Chaudière-Appalaches (12)</option>
                            <option value="Laval (13)">Laval (13)</option>
                            <option value="Lanaudière (14)">Lanaudière (14)</option>
                            <option value="Laurentides (15)">Laurentides (15)</option>
                            <option value="Montérégie (16)">Montérégie (16)</option>
                            <option value="Centre-du-Québec (17)">Centre-du-Québec (17)</option>

                        </select>

                        @error('regionAdministrative')
                            <span
                                class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                {{ $message }}
                            </span>
                        @enderror
                   
                    </div>

                    <div class="mt-4 w-full max-w-md">
                        <label for="municipaliteSelect" class="block font-Alumni text-md md:text-lg mb-2">
                            Municipalités
                        </label>
                        <select name="municipalite" id="municipaliteSelect" class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">
                            <option value="" disabled selected>Choisissez une municipalité</option>
                            <option>Rouyn-Noranda</option>
                            <option>Val-d'Or</option>
                            <!-- Ajoutez les autres options -->
                        </select>
                        <input type="text" name="municipaliteInput" id="municipaliteInput" placeholder="Entrez votre municipalité"
                            class="w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black hidden">
              
                        @error('municipalite')
                            <span
                                class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                {{ $message }}
                            </span>
                        @enderror
                        @error('municipaliteInput')
                         <span class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                             {{ $message }}
                            </span>
                        @enderror
              
                    </div>
                </div>
            </div>

            <!-- Deuxième colonne -->
            <div>
             
                </h1>

                <div class="bg-secondary-100 py-8 px-4 mt-8" id="cadreNumero">
                    <div class="flex items-center gap-1">
                    <span class="iconify  size-4 md:size-6" data-icon="material-symbols:contact-phone-outline"></span>
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Adresse en ligne</h4>
                    </div>
                    <div class="mt-6 w-full max-w-md flex gap-4 columns-2 ">

                        <div class="w-full">
                            <label for="siteWeb" class="block font-Alumni text-md md:text-lg mb-2">
                                Site web
                            </label>

                            <input type="text" id="siteWeb" name="siteWeb" placeholder="https://www.abc.com"
                                class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">

                            @error('siteWeb')
                                <span
                                    class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>
                    </div>

                    <div class="mt-6 w-full max-w-md flex gap-4 columns-2 ">

                        <div class="w-full">
                            <label for="ligne" class="block font-Alumni text-md md:text-lg mb-2">
                                Ligne
                            </label>
                            <input type="hidden" name="ligne[0][id]" id="id_0" >
                                <select  id="ligne_0" name="ligne[0][type]" class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">
                                    <option value="Bureau">Bureau</option>
                                    <option value="Télécopieur">Télécopieur</option>
                                    <option value="Cellulaire">Cellulaire</option>
                                </select>

                            @error('ligne.0.type')
                                <span
                                    class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>
                        <div class="w-full">
                            <label for="numeroTelephone" class="block font-Alumni text-md md:text-lg mb-2 truncate">
                                Numero Telephone
                            </label>

                            <input type="phonenumber" id="numeroTelephone_0" name="ligne[0][numeroTelephone]"
                                placeholder="514-453-9867"
                                class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black numerotelephone">

                            @error('ligne.0.numeroTelephone')
                                <span
                                    class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        <div class="w-full"  id="poste_div_0">
                            <label for="poste" class="block font-Alumni text-md md:text-lg mb-2">
                                Poste
                            </label>

                            <input type="text" id="poste_0" name="ligne[0][poste]" placeholder="9845"
                                class="font-Alumni w-full p-2 h-12 focus:outline-none focus:border-blue-500 border border-black">

                            @error('ligne.0.poste')
                                <span
                                    class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>
                    </div>
                </div>
                <input type="hidden" id="currentIndexInput" name="currentIndex" >
                <button type="button" id="ajoutNumeroTelephone"
                    class="mt-4 w-full text-white bg-secondary-400 hover:bg-tertiary-300 py-2.5">
                    <h1 class="font-Alumni font-bold text-lg md:text-2xl">Ajouter un numero</h1>
                </button>

                <button type="submit" class="mt-4 w-full text-white bg-tertiary-400 hover:bg-tertiary-300 py-2.5">
                    <h1 class="font-Alumni font-bold text-lg md:text-2xl">Suivant</h1>
                </button>

            </div>
        </div>
    </div>
    </form>

@endsection
@php
session()->forget('errorsCoordonnees');
@endphp


