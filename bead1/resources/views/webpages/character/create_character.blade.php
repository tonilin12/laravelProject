@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ isset($character) ? 'Update' : 'Create' }} Character</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="alert alert-info">
                        Welcome, {{ auth()->user()->name }}
                    </div>

                    <form method="POST" action="{{ isset($character) ? route('characters.update', ['id' => $character->id]) : route('character.store') }}">
                        @csrf

                        @if (isset($character))
                            @method('PUT')
                        @endif

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                            <div class="col-md-6">
                                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? (isset($character) ? $character->name : '') }}" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="strength" class="col-md-4 col-form-label text-md-right">Strength</label>
                            <div class="col-md-6">
                                <input id="strength" name="strength" type="text" class="form-control @error('strength') is-invalid @enderror" value="{{ old('strength') ?? (isset($character) ? $character->strength : '') }}" autofocus>
                            </div>
                        </div>
                        
                        <!-- Other form fields -->
                        
                        <div class="form-group row">
                            <label for="defence" class="col-md-4 col-form-label text-md-right">Defence</label>
                            <div class="col-md-6">
                                <input id="defence" name="defence" type="text" class="form-control @error('defence') is-invalid @enderror" value="{{ old('defence') ?? (isset($character) ? $character->defence : '') }}" autofocus>
                            </div>
                        
                        <!-- Magic Power -->
                        <div class="form-group row">
                            <label for="magic" class="col-md-4 col-form-label text-md-right">Magic Power</label>
                            <div class="col-md-6">
                                <input id="magic" name="magic" type="text" class="form-control @error('magic') is-invalid @enderror" value="{{ old('magic') ?? (isset($character) ? $character->magic : '') }}" autofocus>
                            </div>
                        </div>
                        
                        <!-- Accuracy -->
                        <div class="form-group row">
                            <label for="accuracy" class="col-md-4 col-form-label text-md-right">Accuracy</label>
                            <div class="col-md-6">
                                <input id="accuracy" name="accuracy" type="text" class="form-control @error('accuracy') is-invalid @enderror" value="{{ old('accuracy') ?? (isset($character) ? $character->accuracy : '') }}" autofocus>
                            </div>
                        </div>

                        @if (auth()->user()->admin)
                      
                         <div class="form-group row">
                            <label for="enemy" class="col-md-4 col-form-label text-md-right">Enemy</label>
                                <div class="col-md-6">
                                    <select id="enemy" name="enemy" class="form-control">
                                        <option value="0" {{ isset($character) && !$character->enemy ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ isset($character) && $character->enemy ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <br>
                                @if(!isset($character))
                                    <button type="submit" class="btn btn-primary">
                                        Create Character
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-primary">
                                        Update Character
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
