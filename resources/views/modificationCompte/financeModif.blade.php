@vite(['resources/css/app.css', 'resources/js/app.js'])

@extends('layouts.modif')

@section('title', 'Finances')

@section('contenu')
    <form action="{{ route('UpdateFinance') }}" method="post" id="financeForm">
        @csrf
        @if(session('errorsFinance'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <strong class="font-bold">Erreur!</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach (session('errorsFinance')->all() as $error)
                    <li class="font-Alumni">{{ $error }}</li>
                @endforeach
            </ul>
        </div  
    @endif
        <div class="p-4 md:p-16 flex flex-col  w-full">
            <div class="flex w-full flex-col 2xl:flex-row gap-4 ">
                <div class="flex flex-col w-full">
                    <h6 class="font-Alumni font-bold text-3xl md:text-5xl">FINANCES</h6>
                    <h1 class="font-Alumni font-semibold text-md md:text-lg mt-2">Les bons comptes font les bons amis ! 
                    </h1>
                </div>
      
            </div>
       
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 ">
            <!-- Première colonne -->
            <div>
           

                <div class="bg-primary-100 py-8 px-4 mt-8 ">
                    <div class="flex items-center gap-0.5">
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl ">Taxes et paiement</h4>
                    <span class="iconify  size-4 md:size-6" data-icon="material-symbols:account-balance-outline"></span>
                </div>
                    <div class="mt-6 w-full max-w-md flex gap-4 columns-2 ">
                        <div class="w-full">
                            <label for="numeroTPS" class="block font-Alumni text-md md:text-lg mb-2">
                                Numero TPS
                            </label>
                            <input type="text" id="numeroTPS" name="numeroTPS" placeholder="123456789"
                                class="font-Alumni w-full p-2 h-12 h-12focus:outline-none focus:border-blue-500 border border-black"  value="{{ old('numeroTVQ', $fournisseur->finance->numero_tps) }}">

                            @error('numeroTPS')
                                <span
                                    class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 w-full max-w-md">
                        <label for="numeroTVQ" class="block font-Alumni text-md md:text-lg mb-2">
                            Numero TVQ
                        </label>

                        <input type="text" id="numeroTVQ" name="numeroTVQ" placeholder="1234567890"
                            class="font-Alumni w-full p-2 h-12 h-12focus:outline-none focus:border-blue-500 border border-black"  value="{{ old('numeroTVQ', $fournisseur->finance->numero_tvq) }}">

                        @error('numeroTVQ')
                            <span
                                class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="mt-4 w-full max-w-md">
                        <label for="conditionDePaiement" class="block font-Alumni text-md md:text-lg mb-2">
                            Condition de paiement
                        </label>
                        <!-- Select -->
                        <select name="conditionDePaiement" id="conditionDePaiement" class="font form-select w-full">
                            <option value="" disabled selected  class="font-Alumni">Condition de paiement</option>
                            <option value="Z001"{{ old('conditionDePaiement', $fournisseur->finance->condition_paiement) === 'Z001' ? 'selected' : '' }} >Payable immédiatement sans déduction</option>
                            <option value="Z155"{{ old('conditionDePaiement', $fournisseur->finance->condition_paiement) === 'Z155' ? 'selected' : '' }}>Payable immédiatement sans déduction,Date de base au 15 du mois suivant</option>
                            <option value="Z152" {{ old('conditionDePaiement', $fournisseur->finance->condition_paiement) === 'Z152' ? 'selected' : '' }}>Dans les 15 jours 2% escpte, dans les 30 jours sans déduction</option>
                            <option value="Z153"{{ old('conditionDePaiement', $fournisseur->finance->condition_paiement) === 'Z153' ? 'selected' : '' }}>Après entrée facture jusqu'au 15 du mois,jusqu'au 15 du mois suivant 2%</option>
                            <option value="Z210"{{ old('conditionDePaiement', $fournisseur->finance->condition_paiement) === 'Z210' ? 'selected' : '' }}>Dans les 10 jours 2% escpte , dans les 30 jours sans déduction</option>
                            <option value="ZT15"{{ old('conditionDePaiement', $fournisseur->finance->condition_paiement) === 'ZT15' ? 'selected' : '' }}>Dans les 15 jours sans déduction</option>
                            <option value="ZT30"{{ old('conditionDePaiement', $fournisseur->finance->condition_paiement) === 'ZT30' ? 'selected' : '' }}>Dans les 30 jours sans déduction</option>
                            <option value="ZT45"{{ old('conditionDePaiement', $fournisseur->finance->condition_paiement) === 'ZT45' ? 'selected' : '' }}>Dans les 45 jours sans déduction</option>
                            <option value="ZT60"{{ old('conditionDePaiement', $fournisseur->finance->condition_paiement) === 'ZT60' ? 'selected' : '' }}>Dans les 60 jours sans déduction</option>
                        </select>

                        @error('conditionDePaiement')
                            <span
                                class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                {{ $message }}
                            </span>
                        @enderror
                        <!-- End Select -->
                    </div>

                </div>
            </div>

            <!-- Deuxième colonne -->
            <div>
              
                <div class="bg-secondary-100 py-8 px-4 mt-8">
                    <div class="flex items-center">
                    <h4 class="font-Alumni font-bold text-lg md:text-2xl ">Options de facturation</h4>
                    <span class="iconify  size-4 md:size-6" data-icon="material-symbols:attach-money"></span>
                </div>
                    <div class="mt-6 w-full md:max-w-full flex flex-col md:flex-row  gap-4 columns-2 ">
                  
                        <!-- Conteneur du segment -->
                        <div class="w-1/2">
                            <label for="devise" class="block font-Alumni text-md md:text-lg mb-2">
                                Devise
                            </label>
                            <!-- Select -->
                            <select name="devise" id="devise" class="font-Alumni form-select w-full">
                                <option value="" disabled selected class="font-Alumni">Choisir une devise</option>
                                <option value="CAD" {{ old('devise', $fournisseur->finance->devise) === 'CAD' ? 'selected' : '' }}>CAD</option>
                                <option value="USD" {{ old('devise', $fournisseur->finance->devise) === 'USD' ? 'selected' : '' }}>USD</option>
                            </select>

                            <!-- End Select -->

                            @error('devise')
                                <span
                                    class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Conteneur du segment -->
                        <div class="w-1/2">
                            <label for="modeCommunication" class="block font-Alumni text-md md:text-lg mb-2">
                                Mode de Communication
                            </label>
                            <!-- Select -->
                            <select name="modeCommunication" id="modeCommunication" class="form-select font-Alumni">
                                <option value=""  disabled selected  class="font-Alumni">Mode de communication</option>
                                <option value="courriel" {{ old('modeCommunication', $fournisseur->finance->mode_communication) === 'courriel' ? 'selected' : '' }}>Courriel</option>
                                <option value="courrier" {{ old('modeCommunication', $fournisseur->finance->mode_communication) === 'courrier' ? 'selected' : '' }}>Courrier régulier</option>
                            </select>

                            <!-- End Select -->

                            @error('modeCommunication')
                                <span
                                    class="font-Alumni text-lg flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="button" class="mt-4 w-full text-white bg-tertiary-400 hover:bg-tertiary-300 py-2.5 rounded transition duration-300 ease-in-out" id="confirmButton">
                    <h1 class="font-Alumni font-bold text-lg md:text-2xl">Enregistrer mes informations </h1>
                </button>
              

            </div>
        </div>
    </div>
    </form>

@endsection
@php
session()->forget('errorsFinance');
@endphp