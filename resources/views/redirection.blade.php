@extends('layouts.app')

@section('title', 'Redirection')

@section('contenu')

<div class="w-full p-6">
    <a href="/" class="w-auto relative z-10">
        <span class="iconify size-10" data-icon="ion:arrow-undo" data-inline="false"></span>
    </a>
    <div class="flex flex-row">
        <div class="relative">
            <div class="w-full lg:w-3/5 md:w-3/4 sm:w-2/3 lg:text-2xl md:text-xl sm:text-md lg:ml-40 md:ml-20 sm:ml-10 sm:mt-10">
                <h1 class="relative z-10 text-center p-10 mt-6">
                    <b>Vous n'avez pas accès à cette page veuillez retourner au menu principal.</b>
                </h1>
            </div>
        </div>
        <div class="absolute inset-0">
            <div class="w-full lg:w-3/4 md:w-2/3 sm:w-1/2">
                <img src="{{asset('images/Vector.png')}}" alt="" class="absolute h-auto right-0 z-0">
            </div>
            <div class="w-auto">
                <img src="{{asset('images/gifCollab.gif')}}" alt="" class="absolute top-0 right-0 z-0 h-lvh">
            </div>
        </div>
    </div>
</div>


@endsection