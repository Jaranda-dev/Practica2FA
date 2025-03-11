@extends('errors.custom')

@section('code', '401')
@section('message', 'Debes iniciar sesión para acceder a esta página')
@section('redirect', url('/login'))
