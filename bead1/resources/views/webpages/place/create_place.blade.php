@extends('layouts.layout')

@section('content')
@php
    use App\Models\Contest;
    use App\Models\User;
    use App\Models\Place;
    use App\Models\Character;
    use App\Models\CharacterContest;
    use Illuminate\Support\Facades\Storage;


    $places = Place::all();
    $title = $place0 ? 'Update Place' : 'New Place';
@endphp
<div class="container mt-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ $place0 ? route('update.place', ['id' => $place0->id]) : route('store.place') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        @if($place0)
            @method('PUT')
        @endif
        <!-- Add dynamic title -->
        <h2>{{ $title }}</h2>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Place Name:</label>
            <div class="col-sm-10">
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $place0 ? $place0->name : '') }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="image" class="col-sm-2 col-form-label">Place Image:</label>
            <div class="col-sm-10">
                <input type="file" name="image" id="image" class="form-control-file">
            </div>
        </div>
        @if($place0)
            <input type="hidden" name="place_id" value="{{ $place0->id }}">
        @endif
        <br>
        <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary">{{ $title }}</button>
            </div>
        </div>
    </form>
    
</div>
@endsection
