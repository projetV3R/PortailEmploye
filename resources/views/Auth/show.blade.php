@extends('layouts.app')
 
@section('title', "Page show de l'employer")
 
@section('contenu')
@vite('resources/css/app.css') 

@auth()
    
    <h1>Utilisateur</h1>

    <div class="bg-red-500">
        
            <h3>Email: </h3>
            <p>{{$usager->email}}</p>
        <br>
        <br>
        <a href="{{route('usagers.edit', [$usager])}}" class="btn btn-danger">
                                Editer l'utilisateur
        </a>
    </div>
@endauth

@endsection