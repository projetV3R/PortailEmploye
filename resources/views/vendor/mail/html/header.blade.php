@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="https://upload.wikimedia.org/wikipedia/fr/thumb/c/ce/Logo_de_Trois-Rivi%C3%A8res_2022.png/600px-Logo_de_Trois-Rivi%C3%A8res_2022.png?20220917132718" class="logo" alt="Logo Ville de Trois-Rivières" style="max-width: 1000px; height: auto;">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
