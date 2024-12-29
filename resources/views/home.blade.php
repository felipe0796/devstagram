@extends('layouts.app')

@section('titulo')
    Página principal
@endsection

@section('contenido')
    {{-- Aplicar componente de laravel --}}
    <x-listar-post :posts="$posts" />

    {{-- OTRA MANERA DE VALIDAR SI UN ARREGLO VIENE CON DATOS --}}
    {{-- @forelse ($posts as $post)
        <h1>{{ $post->titulo }}</h1>
    @empty
        <p>No hay posts</p>
    @endforelse --}}
@endsection