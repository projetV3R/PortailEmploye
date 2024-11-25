@extends('layouts.app')

@section('title', 'Connexion Employer')

@section('contenu')
    <div class="container mx-auto bg-[url('images/vector1.svg')] bg-no-repeat bg-right bg-cover p-4 md:p-8 lg:p-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-4">
            <div class="flex flex-col justify-center">
                <div class="mx-4 md:mx-8">
                  

                    <h1 class="font-Alumni font-bold text-2xl md:text-4xl lg:text-6xl">Bon retour !</h1>
                    <h6 class="font-Alumni text-lg md:text-xl lg:text-2xl mt-2">Connectez-vous pour avoir accès à votre
                        compte employé !</h6>

                    <!-- Formulaire de connexion -->
                    <form action="{{ route('connexion') }}" method="post" class="mt-6">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="block font-Alumni md:text-lg lg:text-xl mb-2">
                                Adresse courriel professionnel
                            </label>
                            <input type="text" id="email" name="email" autocomplete="email"
                                placeholder="Entrer votre adresse courriel"
                                class="font-Alumni w-full md:w-5/6 lg:w-2/3 p-2 focus:outline-none focus:border-blue-500 border border-black">
                            <div class="w-full md:w-5/6 lg:w-2/3">
                                @error('email')
                                    <span class="text-red-500 font-Alumni md:text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block font-Alumni md:text-lg lg:text-xl mb-2">
                                Mot de passe
                            </label>
                            <input type="password" id="password" name="password" autocomplete="password"
                                placeholder="Entrer votre mot de passe"
                                class="font-Alumni w-full md:w-5/6 lg:w-2/3 p-2 focus:outline-none focus:border-blue-500 border border-black">
                            <div class="w-full md:w-5/6 lg:w-2/3">
                                @error('password')
                                    <span class="text-red-500 font-Alumni md:text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="bg-red-500 w-full md:w-5/6 lg:w-2/3 mt-6 rounded">
                            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 py-2.5">
                                <h1 class="font-Alumni font-bold text-lg md:text-xl lg:text-2xl">Connexion</h1>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="hidden lg:flex items-center justify-center">
                <div class="w-full lg:w-3/4">
                    <img src="{{ asset('images/output-onlinegiftools.gif') }}" alt="GIF animé" class="w-full h-auto">
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            @endif
        });
        </script>
@endsection
