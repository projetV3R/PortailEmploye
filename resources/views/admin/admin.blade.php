@extends('layouts.app')

@section('title', 'Admin')

@section('contenu')

<div class="flex flex-col h-screen">

    <div class="flex flex-col justify-center h-full w-72 ">
    <div id="arrow-icon" class="absolute  left-72 transition-all duration-300 hover:animate-bounce-horizontal cursor-pointer">
        <span class="iconify text-3xl" data-icon="material-symbols:arrow-forward-ios-rounded" data-inline="false"></span>
    </div>
        <div class="flex flex-col items-center bg-gray-300 rounded-md shadow-md w-full ">

            <div class="flex flex-row cursor-pointer hover:bg-gray-200  p-4 px-2 w-full justify-start items-center gap-3 menu" onclick="SelectedMenu(this)">
                <span class="iconify text-3xl w-8" data-icon="material-symbols:format-list-bulleted" data-inline="false"></span>
                <span class="text-xl">Utilisateurs</span>
                <span class="iconify text-3xl w-6 hidden arrow" data-icon="material-symbols:arrow-forward-ios-rounded"></span>
            </div>

            <div class="flex flex-row cursor-pointer hover:bg-gray-200  p-4 px-2 w-full justify-start items-center gap-3 menu" onclick="SelectedMenu(this)">  
                <span class="iconify text-3xl w-8" data-icon="material-symbols:box-outline-rounded" data-inline="false"></span>
                <span class="text-xl">Fournisseurs</span>
                <span class="iconify text-3xl w-6 hidden arrow" data-icon="material-symbols:arrow-forward-ios-rounded"></span>
            </div>

            <div class="flex flex-row cursor-pointer hover:bg-gray-200 p-4 px-2 w-full justify-start items-center gap-3 menu" onclick="SelectedMenu(this)">
                <span class="iconify text-3xl w-8" data-icon="material-symbols:display-settings-outline-rounded" data-inline="false"></span>
                <span class="text-xl">Paramètres</span>
                <span class="iconify text-3xl w-6 hidden arrow " data-icon="material-symbols:arrow-forward-ios-rounded"></span>
            </div>
        </div>

    </div>

</div>

<script>
    function SelectedMenu(element) {
        let items = document.querySelectorAll('.menu');
        items.forEach(item => {
            item.classList.remove('bg-gray-200');
            item.querySelector('.arrow').classList.add('hidden');
        });
        element.classList.add('bg-gray-200');
        element.querySelector('.arrow').classList.remove('hidden');
    }
</script>

@endsection
