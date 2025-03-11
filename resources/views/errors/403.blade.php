@extends('errors.custom')

@section('code', '403')
@section('message', 'No tienes permiso para acceder a esta página')
@section('redirect', url('/'))
