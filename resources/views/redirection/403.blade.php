<script src="https://code.iconify.design/3/3.0.0/iconify.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="icon" type="image/png" href="https://www.v3r.net/wp-content/uploads/2023/06/favicon.png" />
<title>Erreur 403 - Page non-autorisée</title>
<div class="w-full">
    <div class="absolute inset-x-0 z-10">
        <a href="/dashboard" class="">
            <span class="iconify size-10" data-icon="ion:arrow-undo" data-inline="false"></span>
        </a>
        <h1 class="m-10 text-4xl text-center font-Alumni">
            <b>Vous n'avez pas accès à cette page.</b>
        </h1>
    </div>
    <div class="relative h-screen flex items-center justify-center overflow-hidden">
        <img src="{{ asset('images/bg_redirection1.png') }}" alt="imagebackground" class="absolute inset-0 object-cover h-full w-full">
        <img src="{{ asset('images/403_Error_Forbidden.gif') }}" alt="imageErreur403" class="relative z-10 h-auto max-w-full">
    </div>

</div>




