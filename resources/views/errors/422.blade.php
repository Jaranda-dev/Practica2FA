@extends('errors.custom')

@section('message', 'Hay errores en la validación de los datos')
@section('code', '422')

<ul>
    @foreach($errors as $field => $error)
        <li>{{ $field }}: {{ implode(', ', $error) }}</li>
    @endforeach
</ul>
