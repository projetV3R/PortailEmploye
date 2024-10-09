@extends('layouts.app')

@section('title', 'Connexion Employer')

@section('contenu')
<div class="w-full p-2">
<div class="relative flex items-center justify-center w-full h-screen ">

    <div class="absolute inset-0">
        <img src="{{asset('images/Vector.png')}}" alt="" class="absolute w-1/2 right-0 z-0">
        <div class="relative hidden sm:block">
        <img src="{{asset('images/gifCollab.gif')}}" alt="" class="absolute top-0 right-20 z-0">
        </div>
        
    </div>
    <div class="w-full lg:w-3/4 xl:w-2/3 mx-auto lg:ml-4 xl:ml-8">
        <div class="relative flex flex-col items-center justify-left p-4 shadow-lg max-w-md mx-auto z-10">
            <div class="flex flex-col items-center justify-center p-4">
                <strong>
                    <h1 class="text-3xl md:text-5xl">Connexion</h1>
                </strong>
                <p class="text-base md:text-xl">
                    Connectez-vous pour avoir accès à votre compte employé !
                </p>
            </div>

            <div class="flex flex-col items-center justify-center p-4 md:p-10">
                <form action="{{ route('connexion') }}" method="POST" class="w-full">
                    <div class="p-4">
                        <label for="neq" class="form-label block mb-2"><strong>Adresse courriel professionel</strong></label>
                        <input type="text" name="neq" id="neq" autocomplete="neq" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-blue-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 p-2" placeholder="Votre adresse courriel">
                        <a class="text-blue-500 hover:underline text-xs md:text-sm" href="#">Adresse courriel oublié?</a>
                    </div>   

                    <div class="p-4">
                        <label for="password" class="form-label block mb-2"><strong>Votre mot de passe</strong></label>
                        <input type="password" name="password" id="password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-blue-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 p-2" placeholder="Votre mot de passe">
                        <a class="text-blue-500 hover:underline text-xs md:text-sm text-right" href="#">Mot de passe oublié?</a>
                    </div>
                    <div class="p-4">
                        <button type="submit" class="block w-full py-2 px-4 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                            <strong>Suivant</strong>
                        </button>
                        
                    </div>
                </form> 
            </div></div>
        </div>
    </div>
</div>
@endsection
