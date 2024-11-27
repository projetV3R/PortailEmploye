@extends('layouts.modif')

@section('title', 'BrochuresCartesAffaires')

@section('contenu')
<div class="container mx-auto mt-10">
    <div class="mb-5">
 

    <form id="fileUploadForm" action="{{ route('UpdateDoc') }}" method="POST" enctype="multipart/form-data" >
        @csrf
        @if(session('errorsFichiers'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <strong class="font-bold">Erreur!</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach (session('errorsFichiers')->all() as $error)
                    <li class="font-Alumni">{{ $error }}</li>
                @endforeach
            </ul>
        </div  
    @endif
        <div class="bg-primary-100 py-8 px-4">
            <h4 class="font-Alumni font-bold text-lg md:text-2xl underline">Brochures et cartes d'affaires</h4>
     
            <!-- Input de fichiers -->
            <input type="file" id="fileInput" name="fichiers[]" multiple
                   accept=".doc,.docx,.pdf,.jpg,.jpeg,.xls,.xlsx"
                   class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none mt-4">

            <!-- Liste des fichiers sélectionnés -->
            <h5 class="mt-4 font-bold">Fichiers sélectionnés :</h5>
            <ul id="fileList" class="list-disc mt-2 ml-6 text-sm text-gray-700"></ul>

            <!-- Affichage des fichiers déjà téléversés -->
          
                <h5 class="mt-4 font-bold">Fichiers déjà téléversés :</h5>
                <ul id="uploadedFileList" class="list-disc mt-2 ml-6 text-sm text-gray-700"></ul>
      

            <!-- Taille totale -->
            <p id="totalFileSize" class="text-sm text-gray-500 mt-2">Taille totale : 0 Mo / {{ $maxFileSize }} Mo</p>

            <!-- Champ caché pour les fichiers à supprimer -->
            <div id="fichiersASupprimerContainer"></div>

            <!-- Message de validation -->
            <div id="messageContainer" class="mt-4 text-sm text-red-500"></div>

            <!-- Bouton de soumission -->
            <button type="button" id="uploadButton" class="mt-4 w-full text-white bg-blue-500 hover:bg-blue-400 py-2.5">
                <h1 class="font-Alumni font-bold text-lg md:text-2xl">Enregistrer</h1>
            </button>
        </div>
    </form>
</div>

@endsection
@php
session()->forget('errorsFichiers');
@endphp