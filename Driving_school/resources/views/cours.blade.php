@extends('layouts.app')

@section('title', 'Cours de Code de la Route')

@section('content')
@extends('layouts.app')

@section('title', 'Définitions de Code de la Route')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Cours importantes du Code de la Route</h1>

    <div class="row row-cols-1 row-cols-md-2 g-4 mt-3">
        @foreach ($definitions as $def)
            <div class="col">
                <div class="card h-100 border-primary">
                    <div class="card-header bg-primary text-white">
                        {{ $def->terme }}
                    </div>
                    <div class="card-body">
                        <p class="card-text" style="white-space: pre-wrap;">{{ $def->definition }}</p>
                        @if ($def->chapitre && $def->chapitre !== 'non défini')
                            <small class="text-muted">Chapitre : {{ $def->chapitre }}</small>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
