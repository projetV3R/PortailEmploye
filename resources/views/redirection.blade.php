@extends('layouts.app')

@section('title', 'Redirection')

@section('contenu')

<div class="flex flex-row h-lvh">
    <div class="absolute left-0 top-0">
        <div class="relative inset-x-0 z-10">
            <a href="/" class="">
                <span class="iconify size-10" data-icon="ion:arrow-undo" data-inline="false"></span>
            </a>
        </div>
        <div class="w-full relative inset-x-0 z-10 text-2xl m-20">
            <h1 class="text-center p-6">
                <b>Vous n'avez pas accès à cette page.</b>
            </h1>
        </div>
    </div>
    <div class="absolute inset-0 hidden md:block">
        <div class="w-full lg:w-3/4 md:w-2/3 sm:w-1/2">
            <img src="{{asset('images/Vector.png')}}" alt="" class="absolute h-auto right-0 z-0">
        </div>
        <div class="w-full lg:w-3/4 md:w-2/3 sm:w-1/2">
            <img src="{{asset('images/403_Error_Forbidden.gif')}}" alt="imageErreur403" class="absolute top-0 right-0 z-0 h-vhl">
        </div>
    </div>
    <div class="absolute inset-0">
        <div class="w-full lg:w-3/4 md:w-2/3 sm:w-1/2">
            <img src="{{ asset('images/Vector.png') }}" alt="" class="absolute h-screen right-0 z-0 lg:hidden">
        </div>
        <div class="w-full lg:w-3/4 md:w-2/3 sm:w-2/3 flex items-center justify-center h-screen">
            <img src="{{ asset('images/403_Error_Forbidden.gif') }}" alt="imageErreur403" class="absolute right-0 z-0 lg:hidden">
        </div>
    </div>

</div>


@endsection