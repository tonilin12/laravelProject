@extends('layouts.layout')

@section('content')
@php
    use App\Models\Contest;
    use App\Models\User;
    use App\Models\Place;
    use App\Models\Character;
    use App\Models\CharacterContest;
    
    $places=Place::all();
@endphp

<div class="container">
    <div class="mb-3">
        <a href="{{ route('create.character') }}" class="btn btn-primary">Create New Character</a>

    </div>
    <h2>List of Places</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Image</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($places as $place)
            <tr>
                <td>{{ $place['name'] }}</td>
                <td>
                    @if (Str::startsWith($place->kep, 'http'))
                        <!-- Image from external URL -->
                        <img src="{{ $place->kep }}" alt="{{ $place->name }}" style="max-width: 100px; max-height: 100px;">
                    @else
                        <!-- Image stored locally -->
                        <img src="{{ Storage::url($place->kep) }}" alt="{{ $place->name }}" style="max-width: 100px; max-height: 100px;">
                    @endif
                </td>
                <td><a href="{{ route('place.edit', $place['id']) }}">Update</a></td>
                <td>
                    <form action="{{ route('place.destroy', $place['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection