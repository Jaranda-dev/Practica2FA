@extends('errors.custom')

@section('code', '419')
@section('message', 'Tu sesión ha expirado, por favor inicia sesión nuevamente')
@section('redirect', url('/login'))
