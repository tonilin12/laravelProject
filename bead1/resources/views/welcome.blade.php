@extends('layouts.layout')


@section('content')
    <div class="container">
        <h1 class="display-4 fw-bold">Jatek</h1>

        <p class="lead">
            A beadandó feladat során egy egyszerűsített egy játékos módú, körökre osztott, arcade típusú harcolós játékot kell elkészítened Laravel keretrendszer használatával.
        </p>
        
        <p>
            Number of characters: {{ $characters->count() }}<br>
            Number of matches: {{ $matches->count() }}
        </p>
      

    </div>
@endsection
