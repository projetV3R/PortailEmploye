@extends('layouts.app')

@section('title', 'Redirection')

@section('contenu')

<div class="w-full p-6">
    <a href="/" class="relative z-10 basis-1/6">
        <span class="iconify size-10" data-icon="ion:arrow-undo" data-inline="false"></span>
    </a>
    <div class="flex flex-row">
        <b>
            <h1 class="relative z-10 w-1/2 m-40 text-center text-2xl">Vous n'avez pas accès à cette page veuillez retourner au menu principal.</h1>
        </b>
        <div class="absolute inset-0">
            <img src="{{asset('images/Vector.png')}}" alt="" class="absolute w-3/4 h-auto right-0 z-0">
            <img src="{{asset('images/gifCollab.gif')}}" alt="" class="absolute top-0 right-0 h-auto z-0">
        </div>
    </div>

</div>


@endsection