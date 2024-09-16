@extends('layouts.app')
 
 @section('title', "Page index de l'employer")
  
 @section('contenu')
 @vite('resources/css/app.css')
 @if(session('message'))
    <div class="alert alert-success center">
        {{ session('message') }}
    </div>
@endif
 <h1 id="">Liste d'utilisateurs</h1>

    <div class="box">
                    @if(count($usagers))
                    @foreach($usagers as $usager)
    <a href="{{route('usager.show', [$usager])}}">
    <h3>{{$usager->nom}}</h3>
    </a>
                    @endforeach
                    @else
    <h3>Il n'y a pas d'usagers</h3>
                    @endif
    </div>

 
 @endsection