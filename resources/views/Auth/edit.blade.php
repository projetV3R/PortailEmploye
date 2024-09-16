@extends('layouts.app')
 
@section('title', "Page modification employer")
 
@section('contenu')
@vite('resources/css/app.css') 

@if(auth()->user()->id == $usager->id || auth()->user()->role == 'admin')
@if(isset($usager))
<form method="post" action="{{route('usagers.update', [$usager])}}">
    @csrf 
    @method('PATCH')
    <div class="bg-green-200">
            <h1>Formulaire pour modifier un utilisateur</h1>
    </div>

    <div class="col-xl-4">
        <label class="form-label" for="email">Email de l'utilisateur</label>
        <input type="email" class="form-control bg-pink-200" placeholder="patate@hotmail.com" id="email" name="email" value="{{old('email', $usager->email)}}">
    </div>
    <div style="border-bottom-style: solid">
        <h3 class="form-label" >Remplir pour changer le mot de passe</h3>
    </div>

    <br>
    <div>
        <label class="form-label" for="password">Mot de passe actuel</label>
        <input type="text" class="form-control bg-pink-200" id="password" placeholder="" name="password" value="">
        <input type="text" id="password_old" name="password_old" value="{{$usager->password}}" style="display:none">
    </div>    

    <br>
    <div class="col-xl-6">
        <label class="form-label" for="password_new">Nouveau mot de passe</label>
        <input type="text" class="form-control" id="password_new" placeholder="" name="password_new" >
    </div>

    <br>
    <div class="col-xl-6">
        <label class="form-label" for="password_new_confirmation">Confirmation nouveau mot de passe</label>
        <input type="text" class="form-control" id="password_new_confirmation" placeholder="" name="password_new_confirmation" >
    </div>

    <div class="col-xl-4">
        <label class="form-label" for="nom">Nom de l'utilisateur</label>
        <input type="nom" class="form-control bg-pink-200" placeholder="nom" id="nom" name="nom" value="{{old('nom', $usager->nom)}}">
    </div>

    <div class="col-xl-4">
        <label class="form-label" for="prenom">Prenom de l'utilisateur</label>
        <input type="prenom" class="form-control bg-pink-200" placeholder="prenom" id="prenom" name="prenom" value="{{old('prenom', $usager->prenom)}}">
    </div>

    <div class="col-xl-2 p-3">
        <button  type="submit" class="btn btn-success">Modifier</button>
        </form>
    </div>
    <div class="col-xl-2">
        <form method="POST" action="{{route('usagers.destroy', [$usager->id])}}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Supprimer</button>
</form>
@else

<h1>Vous n'avez pas accès à cette Page...</h1>

@endif
@endrole
@endsection
