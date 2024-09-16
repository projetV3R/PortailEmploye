@extends('layouts.app')

@section('title', 'Redirection')

@section('contenu')

<div class="">
    <div class="absolute left-0 top-0">
        <div class="relative inset-x-0 z-10">
            <a href="/" class="">
                <span class="iconify size-10" data-icon="ion:arrow-undo" data-inline="false"></span>
            </a>
            <h1 class="m-20 text-2xl text-center">
                <b>Vous n'avez pas accès à cette page.</b>
            </h1>
        </div>
    </div>
    <div class="inset-0">
        <div class="w-full">
            <img src="{{ asset('images/Vector.png') }}" alt="" class="absolute h-screen right-0">
            <div class="flex items-center h-screen">
                <img src="{{ asset('images/403_Error_Forbidden.gif') }}" alt="imageErreur403" class="absolute h-auto right-0">
            </div>
        </div>
    </div>
</div>


@endsection