@extends('layouts.app')

@section('title', 'Quiz - Question ' . ($question_actuelle ?? 1))

@push('styles')
<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
    .container { background: #f9f9f9; padding: 30px; border-radius: 10px; }
    h2 { color: #333; }
    .question { font-size: 18px; margin-bottom: 20px; font-weight: bold; }
    .reponse { margin: 10px 0; padding: 10px; background: white; border-radius: 5px; transition: all 0.3s ease; cursor: pointer; }
    .reponse label { cursor: pointer; display: block; }
    .reponse:hover { background: #f0f0f0; }
    .reponse.correct { background: #d4edda; border: 2px solid #28a745; }
    .reponse.incorrect { background: #f8d7da; border: 2px solid #dc3545; }
    .reponse.disabled { cursor: not-allowed; opacity: 0.7; }
    .reponse.disabled:hover { background: white; }
    button { background: #007cba; color: white; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin-top: 15px; }
    button:hover { background: #005a87; }
    button:disabled { background: #ccc; cursor: not-allowed; }
    .result { font-size: 18px; font-weight: bold; margin: 20px 0; padding: 15px; border-radius: 5px; }
    .result.success { color: #155724; background: #d4edda; border: 1px solid #c3e6cb; }
    .result.error { color: #721c24; background: #f8d7da; border: 1px solid #f5c6cb; }
    .next-link { display: inline-block; margin-top: 15px; background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold; }
    .next-link:hover { background: #218838; }
    .progress { background: #e0e0e0; height: 10px; border-radius: 5px; margin-bottom: 20px; }
    .progress-bar { background: #007cba; height: 100%; border-radius: 5px; transition: width 0.3s ease; }
    .quiz-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .score-info { font-size: 14px; color: #666; }
    .actions { margin-top: 20px; }
    .secondary-link { display: inline-block; margin-left: 10px; background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    .secondary-link:hover { background: #5a6268; }
</style>
@endpush

@push('scripts')
<script>
    // Colorer les réponses après validation
    @if(isset($reponse_utilisateur))
        document.addEventListener('DOMContentLoaded', function() {
            const reponses = document.querySelectorAll('.reponse');
            const bonneReponse = '{{ $question->bonne_reponse }}';
            const reponseUtilisateur = '{{ $reponse_utilisateur }}';
           
            reponses.forEach(function(reponse) {
                const lettre = reponse.getAttribute('data-lettre');
               
                if (lettre === bonneReponse) {
                    reponse.classList.add('correct');
                } else if (lettre === reponseUtilisateur && lettre !== bonneReponse) {
                    reponse.classList.add('incorrect');
                }
            });
        });
    @endif
   
    // Empêcher la soumission multiple et désactiver les clics sur les réponses
    @if(!isset($reponse_utilisateur))
        document.getElementById('quizForm').addEventListener('submit', function() {
            const btn = document.getElementById('validateBtn');
            if (btn) {
                btn.disabled = true;
                btn.textContent = 'Validation en cours...';
            }
        });
    @else
        // Désactiver les clics sur les réponses après validation
        document.addEventListener('DOMContentLoaded', function() {
            const reponses = document.querySelectorAll('.reponse');
            reponses.forEach(function(reponse) {
                reponse.style.pointerEvents = 'none';
            });
        });
    @endif
</script>
@endpush

@section('content')
<div class="container">
    <div class="quiz-header">
        <h2>Question {{ $question_actuelle }} / 20</h2>
        <div class="score-info">
            Score actuel: {{ session('quiz_score', 0) }} / {{ $question_actuelle - (isset($reponse_utilisateur) ? 0 : 1) }}
        </div>
    </div>
   
    <div class="progress">
        <div class="progress-bar" style="width: {{ ($question_actuelle / 20) * 100 }}%"></div>
    </div>
   
    <div class="question">{{ $question->question }}</div>
   
    <form method="POST" id="quizForm" action="{{ route('quiz.submit', ['q' => $question_actuelle]) }}">
        @csrf
        @foreach($question->reponses as $lettre => $texte)
            <div class="reponse {{ isset($reponse_utilisateur) ? 'disabled' : '' }}" data-lettre="{{ $lettre }}">
                <label>
                    <input type="radio" name="reponse" value="{{ $lettre }}" required
                           @if(isset($reponse_utilisateur)) disabled @endif
                           @if(isset($reponse_utilisateur) && $reponse_utilisateur == $lettre) checked @endif>
                    {{ strtoupper($lettre) }} : {{ $texte }}
                </label>
            </div>
        @endforeach
       
        @if(!isset($reponse_utilisateur))
            <button type="submit" id="validateBtn">
                Valider ma réponse
            </button>
        @endif
    </form>
   
    @if(isset($resultat))
        <div class="result {{ $resultat == 'Bonne réponse !' ? 'success' : 'error' }}">
            {{ $resultat }}
            @if($resultat != 'Bonne réponse !')
                <br><strong>La bonne réponse était : {{ strtoupper($question->bonne_reponse) }} - {{ $question->reponses[$question->bonne_reponse] }}</strong>
            @endif
        </div>
       
        <div class="actions">
            @if($question_actuelle < 20)
                <a class="next-link" href="{{ route('quiz.next', ['q' => $question_actuelle]) }}">
                    ➡ Question suivante ({{ $question_actuelle + 1 }}/20)
                </a>
            @else
                <a class="next-link" href="{{ route('quiz.results') }}">
                    🏆 Voir les résultats finaux
                </a>
            @endif
           
            <a href="{{ route('quiz.start') }}" class="secondary-link">
                🔄 Recommencer le quiz
            </a>
        </div>
    @endif
</div>
@endsection