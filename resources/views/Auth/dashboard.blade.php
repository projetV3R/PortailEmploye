@extends('layouts.app')
 
@section('title', "Accueil")
 
@section('contenu')

@auth
<div class="flex w-full h-full p-4 lg:p-16 ">
<div class="flex w-full h-3/4 gap-4">
<div class="flex w-1/2  "><div class="flex w-full justify-center border-2 border-dashed ">HIGHCHARTS INSCRIPTION </div> </div>
<div class="flex w-1/2 "> <div class="flex w-full border-2 border-dashed justify-center   ">HIGHCHARTS CATEGORIE INSCRIPTION </div </div>

</div>
    

@endauth

@endsection