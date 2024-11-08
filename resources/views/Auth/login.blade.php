@extends('layouts.app')

@section('title', 'Connexion Employer')

@section('contenu')
    <div class="container mx-auto bg-[url('images/vector1.svg')] bg-no-repeat bg-right bg-cover p-8 md:p-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
            <div class="flex flex-col justify-center">
                <div class="mx-4">
                    @if (session('status'))
                        <div id="alert-box"
                            class="alert alert-success w-full md:w-2/3 bg-green-100 border border-green-400 text-green-700 px-4 py-3 my-2 rounded relative"
                            role="alert">
                            {{ session('status') }}
                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="closeAlert()">
                                <svg class="fill-current h-6 w-6 text-green-500" role="button"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <title>Close</title>
                                    <path
                                        d="M14.348 5.652a.5.5 0 010 .707l-4.693 4.693 4.693 4.693a.5.5 0 01-.707.707l-4.693-4.693-4.693 4.693a.5.5 0 01-.707-.707l4.693-4.693-4.693-4.693a.5.5 0 11.707-.707l4.693 4.693 4.693-4.693a.5.5 0 01.707 0z" />
                                </svg>
                            </span>
                        </div>

                        <script>
                            function closeAlert() {
                                document.getElementById('alert-box').style.display = 'none';
                            }
                        </script>
                    @endif


                    <h1 class="font-Alumni font-bold text-3xl md:text-6xl">Bon retour !</h1>
                    <h6 class="font-Alumni md:text-xl mt-2">Connectez-vous pour avoir accès à votre compte employé !</h6>

                    <!-- Formulaire de connexion -->
                    <form action="{{ route('connexion') }}" method="post" class="mt-6">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="block font-Alumni md:text-lg mb-2">
                                Adresse courriel professionnel
                            </label>
                            <input type="text" id="email" name="email" autocomplete="email"
                                placeholder="Entrer votre adresse courriel"
                                class="font-Alumni w-full md:w-2/3 p-2 focus:outline-none focus:border-blue-500 border border-black">
                            <div class="w-full md:w-2/3">
                                @error('email')
                                    <span class="text-red-500 font-Alumni md:text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block font-Alumni md:text-lg mb-2">
                                Mot de passe
                            </label>
                            <input type="password" id="password" name="password" autocomplete="password"
                                placeholder="Entrer votre mot de passe"
                                class="font-Alumni w-full md:w-2/3 p-2 focus:outline-none focus:border-blue-500 border border-black">
                            <div class="w-full md:w-2/3">
                                @error('password')
                                    <span class="text-red-500 font-Alumni md:text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="bg-red-500 w-full md:w-2/3 mt-6 rounded">
                            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 py-2.5">
                                <h1 class="font-Alumni font-bold text-lg md:text-2xl">Connexion</h1>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="hidden md:flex items-center justify-center">
                <div class="w-full md:w-3/4">
                    <img src="{{ asset('images/output-onlinegiftools.gif') }}" alt="GIF animé" class="w-full h-auto">
                </div>
            </div>
        </div>
    </div>
@endsection
