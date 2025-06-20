@extends('layouts.app')
@section('title', 'Cours de Code de la Route')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Cours importantes du Code de la Route</h1>
    
    <div class="row row-cols-1 row-cols-md-2 g-4 mt-3">
        @if(isset($definitions) && count($definitions) > 0)
            @foreach ($definitions as $def)
                <div class="col">
                    <div class="card h-100 border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">{{ $def->terme }}</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text" style="white-space: pre-wrap;">{{ $def->definition }}</p>
                            @if ($def->chapitre && $def->chapitre !== 'non défini')
                                <small class="text-muted">
                                    <i class="fas fa-book me-1"></i>Chapitre : {{ $def->chapitre }}
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h4><i class="fas fa-info-circle me-2"></i>Aucun cours disponible</h4>
                    <p>Il n'y a pas encore de définitions dans la base de données.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection