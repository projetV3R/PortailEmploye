@extends('layouts.app')
 
@section('title', "Page d'acceuil employer")
 
@section('contenu')
@vite('resources/css/app.css') 

@auth

<h1>Connecter</h1>
@endauth

@endsection