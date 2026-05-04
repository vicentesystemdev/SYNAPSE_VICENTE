<x-mail::message>
    <style>
        body {
            font-family: "Roboto", sans-serif;
            background-color: #161616; /* Fondo oscuro */
            color: #ffffff; /* Texto blanco por defecto */
        }
        .header {
            background-color: #161616; /* Fondo oscuro para el encabezado */
            padding: 20px;
            text-align: center;
        }
        .header img {
            max-width: 150px;
        }
        .content {
            background-color: #2a2a2a; /* Un gris oscuro para el contenido */
            padding: 20px;
            border-radius: 8px;
            color: #ffffff;
        }
        .button {
            background-color: rgb(255, 119, 0); /* Naranja */
            color: #ffffff; /* Texto del botón blanco */
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        .button:hover {
            background-color: rgb(246, 121, 19); /* Naranja más oscuro al pasar el ratón */
        }
        .footer {
            background-color: #161616; /* Fondo oscuro para el pie de página */
            padding: 20px;
            text-align: center;
            font-size: 0.8em;
            color: #cccccc;
        }
        a {
            color: rgb(255, 119, 0); /* Enlaces en naranja */
            text-decoration: none;
        }
    </style>

{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('¡Ups!')
@else
# @lang('¡Hola!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Saludos,')<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "Si tienes problemas para hacer clic en el botón \":actionText\", copia y pega la siguiente URL\n".
    'en tu navegador web:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
