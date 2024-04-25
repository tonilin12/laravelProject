@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="text-center">
        <h1>
            @php
                $response = session('response', null);
                $character = session('character', null);
                $place = session('place', null);

            @endphp

            @if($response)
                {{ $response }}
            @else
               No response received.
            @endif
        </h1>
        
        @if ($place)
            <p>Place Name: {{ $place->name }}</p>
            @if (Str::startsWith($place->kep, 'http'))
                <!-- Image from external URL -->
                <img src="{{ $place->kep }}" alt="{{ $place->name }}" style="max-width: 100px; max-height: 100px;">
            @else
                <!-- Image stored locally -->
                <img src="{{ Storage::url($place->kep) }}" alt="{{ $place->name }}" style="max-width: 100px; max-height: 100px;">
            @endif
        @endif

        @if ($character)
        <div class="card" style="margin: 0 auto; max-width: 400px;">
            <div class="card-body">
                <h2 class="card-title">Character Details</h2>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Name:</strong> {{ $character->name }}</li>
                    <li class="list-group-item"><strong>Enemy:</strong> {{ $character->enemy ? 'Yes' : 'No' }}</li>
                    <li class="list-group-item"><strong>Defence:</strong> {{ $character->defence }}</li>
                    <li class="list-group-item"><strong>Strength:</strong> {{ $character->strength }}</li>
                    <li class="list-group-item"><strong>Accuracy:</strong> {{ $character->accuracy }}</li>
                    <li class="list-group-item"><strong>Magic:</strong> {{ $character->magic }}</li>
                    <li class="list-group-item"><strong>User ID:</strong> {{ $character->user_id }}</li>
                </ul>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
