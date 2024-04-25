@extends('layouts.layout')

@php
    $user = session('authenticated_user');
@endphp

@section('content')
    @if (!$user)
        <div class="container">
            <div class="alert alert-danger" role="alert">
                You must be logged in to access this page. Please <a href="{{ route('login') }}">log in</a>.
            </div>
        </div>
    @else
        <div class="container">
            <div class="mb-4">
                <h1>username: {{ $user['name'] }}</h1>
            </div>
    
            <h2>Character Info</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Defence</th>
                        <th>Strength</th>
                        <th>Accuracy</th>
                        <th>Magic</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (auth()->user()->characters as $character)
                        <tr>
                            <td>{{ $character['name'] }}</td>
                            <td>{{ $character['defence'] }}</td>
                            <td>{{ $character['strength'] }}</td>
                            <td>{{ $character['accuracy'] }}</td>
                            <td>{{ $character['magic'] }}</td>
                            <td>
                                <a href="{{ route('character.detail', ['id' => $character['id']]) }}">View Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
       
        </div>
    @endif
@endsection
