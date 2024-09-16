@extends('layouts.app')

@section('title', 'Redirection')

@section('contenu')

<div class="w-full">
    <div class="absolute inset-x-0 z-10">
        <a href="/" class="">
            <span class="iconify size-10" data-icon="ion:arrow-undo" data-inline="false"></span>
        </a>
        <h1 class="m-10 text-2xl text-center">
            <b>Vous n'avez pas accès à cette page.</b>
        </h1>
    </div>
    <div class="relative h-screen flex items-center justify-center overflow-hidden">
        <img src="{{ asset('images/bg_redirection1.png') }}" alt="imagebackground" class="absolute inset-0 object-cover h-full w-full">
        <img src="{{ asset('images/403_Error_Forbidden.gif') }}" alt="imageErreur403" class="relative z-10 h-auto max-w-full">
    </div>

</div>




@endsection