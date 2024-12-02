@extends('layouts.app')

@section('title', 'Profil')

@section('contenu')
<div class="max-w-3xl w-full mx-auto mt-10 bg-white p-8 rounded-lg border-2 shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Profil Utilisateur</h1>
    <div class="mb-6">
        <p class="text-sm font-medium text-gray-700">Adresse email</p>
        <p class="mt-2 text-lg text-gray-800 bg-gray-100 p-4 rounded-md">{{ $usager->email }}</p>
    </div>
    <div class="mb-6">
        <p class="text-sm font-medium text-gray-700">Rôle</p>
        <div class="flex items-center mt-2 bg-gray-100 p-4 rounded-md">
      
            @if ($usager->role === 'admin')
                <span class="iconify text-red-500 mr-2 size-6" data-icon="mdi:shield-account"></span>
            @elseif ($usager->role === 'responsable')
                <span class="iconify text-blue-500 mr-2 size-6" data-icon="mdi:account-cog"></span>
            @elseif ($usager->role === 'commis')
                <span class="iconify text-green-500 mr-2 size-6" data-icon="mdi:account"></span>
            @endif
            <span class="text-lg text-gray-800">{{ $usager->role }}</span>
        </div>
    </div>
</div>
@endsection
