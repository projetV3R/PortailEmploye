@extends('layouts.app')

@section('title', 'Connexion Employer')

@section('contenu')
@vite('resources/css/app.css') 

<div class="flex flex-col md:flex-row gap-10 p-4 md:p-10">
    <div class="flex-1 max-w-full md:max-w-[50%]">
        <div class="pt-10 pl-4 md:pl-10">
            <strong>
                <h1 class="text-3xl md:text-4xl">Bon Retour!</h1>
            </strong>
            <p class="text-base md:text-lg">
                Connectez-vous pour avoir accès à votre fiche !
            </p>
        </div>

        <div class="bg-cyan-50">
            <form action="">
                <div class="p-4 md:p-10">
                    <label for="neq" class="form-label block mb-2"><strong>Numéro d'entreprise du Québec (NEQ)</strong></label>
                    <input type="text" name="neq" id="neq" autocomplete="neq" class="block w-full md:w-1/2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-blue-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre NEQ">
                    <a class="text-blue-500 hover:underline text-xs" href="#">Pas de NEQ?</a>
                </div>   

                <div class="p-4 md:p-10">
                    <label for="password" class="form-label block mb-2"><strong>Votre mot de passe</strong></label>
                    <input type="password" name="password" id="password" autocomplete="password" class="block w-full md:w-1/2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-blue-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre mot de passe">
                        <a class="text-blue-500 hover:underline text-xs text-right" href="#">Mot de passe oublié?</a>
                </div>
            </form> 
        </div>
    </div>

    <div class="relative w-full max-w-md mx-auto mr-0 bg-transparent p-4 md:p-0">
        <div class="absolute right-2">
            <img src="{{asset('images/Vector.png')}}" alt="" class="w-full h-auto block">
            <img src="{{asset('images/gifCollab.gif')}}" alt="" class="absolute top-0 left-0 h-auto">
        </div>
    </div>
</div>

@endsection
