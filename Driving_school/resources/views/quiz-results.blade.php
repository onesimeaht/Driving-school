@extends('layouts.app')

@section('title', 'Résultats du Quiz')

@push('styles')
<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
    .container { background: #f9f9f9; padding: 30px; border-radius: 10px; }
    h2 { color: #333; }
    .result { font-size: 18px; font-weight: bold; margin: 20px 0; }
    .correct { color: #155724; }
    .incorrect { color: #721c24; }
    .actions { margin-top: 20px; }
    .secondary-link { display: inline-block; margin-left: 10px; background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    .secondary-link:hover { background: #5a6268; }
</style>
@endpush

@section('content')
<div class="container">
    <h2>Résultats du Quiz</h2>
    <div class="result">
        Votre score : {{ $quiz_score }} / 20<br>
        Pourcentage : {{ $pourcentage }}%
    </div>

    <div class="actions">
        <a href="{{ route('quiz.start') }}" class="secondary-link">
            🔄 Recommencer le quiz
        </a>
    </div>
</div>
@endsection