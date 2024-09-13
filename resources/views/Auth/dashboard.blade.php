@extends('layouts.app')
 
@section('title', "Page d'acceuil employer")
 
@section('contenu')
@vite('resources/css/app.css') 

@auth
    <div class="w-full p-2 bg-cyan-400">
    @if(session('message'))
        <div class="alert alert-success center">
            {{ session('message') }}
        </div>
    @endif
    </div>
        <div>
            <h1>Connecter</h1>
        </div>
@endauth

@endsection