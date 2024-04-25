@extends('layouts.layout')

@section('content')
    <div class="container">
        <h2>Character Details</h2>

        @if(isset($character))
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $character->name }}</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Defence:</strong> {{ $character->defence }}</li>
                        <li class="list-group-item"><strong>Strength:</strong> {{ $character->strength }}</li>
                        <li class="list-group-item"><strong>Accuracy:</strong> {{ $character->accuracy }}</li>
                        <li class="list-group-item"><strong>Magic:</strong> {{ $character->magic }}</li>
                    </ul>
                    <a href="{{ route('characters.edit', ['id' => $character->id]) }}" class="btn btn-link">Edit</a>
                    <a href="#" class="btn btn-link" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this character?')) { document.getElementById('delete-form-{{ $character->id }}').submit(); }">Delete</a>
                    <form id="delete-form-{{ $character->id }}" action="{{ route('characters.destroy', ['id' => $character->id]) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>

            <h3>Contests</h3>
            <div class="card">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @php
                            $matches0 = $character->getCompetitions()->get();
                        @endphp

                        @foreach ($matches0 as $match)
                            @php
                                $contest0 = $match->contest;
                                $place0 = $contest0->place;
                                $enemy0 = $match->enemy;
                            @endphp
                            <li class="list-group-item">
                                <strong>place:</strong>
                                <?php
                                    if(isset($place0)) {
                                        echo " {$place0->name}";
                                    } else {
                                        echo "--";
                                    }
                                ?>
                            </li>
                            <li class="list-group-item">
                                <strong>enemy:</strong>
                                <?php
                                    if(isset($enemy0)) {
                                        echo " {$enemy0->name}";
                                    } else {
                                        echo "--";
                                    }
                                ?>
                            </li>                         
                            <hr>
                        @endforeach
                        @if (!$character->enemy)
                            <a href="#" onclick="event.preventDefault(); document.getElementById('generate-contest-form').submit();">New Contest</a>

                            <form id="generate-contest-form" method="POST" action="{{ route('contest.generate') }}">
                                @csrf <!-- CSRF protection -->
                                <input type="hidden" name="character_id" value="{{ $character->id }}">
                            </form>
                        @endif
                    </ul>
                </div>
            </div>

        @else
            <div class="alert alert-danger" role="alert">
                Character not found.
            </div>
        @endif
    </div>
@endsection
