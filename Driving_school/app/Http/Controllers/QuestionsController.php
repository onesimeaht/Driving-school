<?php
namespace App\Http\Controllers;

use App\Models\Questions;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Démarrer un nouveau quiz
     */
    public function startQuiz()
    {
        // Récupérer 20 questions aléatoires et les stocker en session
        $questions = Questions::inRandomOrder()->limit(20)->get();
        
        session([
            'quiz_questions' => $questions->pluck('id')->toArray(),
            'quiz_answers' => [],
            'quiz_score' => 0,
            'current_question' => 1
        ]);
        
        return redirect()->route('quiz', ['q' => 1]);
    }
    
    /**
     * Afficher une question du quiz
     */
    public function quiz(Request $request)
    {
        $question_actuelle = (int) $request->get('q', 1);
        
        // Vérifier si le quiz a été initialisé
        if (!session('quiz_questions')) {
            return redirect()->route('quiz.start');
        }
        
        $questions_ids = session('quiz_questions');
        
        // S'assurer que le numéro de question est valide
        if ($question_actuelle < 1 || $question_actuelle > 20) {
            return redirect()->route('quiz', ['q' => 1]);
        }
        
        // Récupérer la question spécifique
        $question_id = $questions_ids[$question_actuelle - 1];
        $question = Questions::find($question_id);
        
        if (!$question) {
            return redirect()->route('quiz.start')->with('error', 'Question non trouvée');
        }
        
        // Récupérer la réponse déjà donnée si elle existe
        $quiz_answers = session('quiz_answers', []);
        $reponse_utilisateur = isset($quiz_answers[$question_actuelle]) ? $quiz_answers[$question_actuelle] : null;
        
        $resultat = null;
        if ($reponse_utilisateur) {
            // Gérer les réponses multiples (ex: "b-c")
            $bonnes_reponses = explode('-', $question->bonne_reponse);
            $reponse_correcte = in_array($reponse_utilisateur, $bonnes_reponses) || 
                               $reponse_utilisateur === $question->bonne_reponse;
            
            $resultat = $reponse_correcte ? "Bonne réponse !" : "Mauvaise réponse.";
        }
        
        return view('quiz', compact('question', 'question_actuelle', 'resultat', 'reponse_utilisateur'));
    }
    
    /**
     * Soumettre une réponse
     */
    public function submitAnswer(Request $request)
    {
        $question_actuelle = (int) $request->get('q', 1);
        $reponse_utilisateur = $request->input('reponse');
        
        if (!session('quiz_questions')) {
            return redirect()->route('quiz.start');
        }
        
        // Validation de base
        if (!$reponse_utilisateur) {
            return redirect()->route('quiz', ['q' => $question_actuelle])
                ->with('error', 'Veuillez sélectionner une réponse');
        }
        
        // Récupérer la question
        $questions_ids = session('quiz_questions');
        $question_id = $questions_ids[$question_actuelle - 1];
        $question = Questions::find($question_id);
        
        if (!$question) {
            return redirect()->route('quiz.start');
        }
        
        // Sauvegarder la réponse
        $quiz_answers = session('quiz_answers', []);
        
        // Si c'est la première fois qu'on répond à cette question
        if (!isset($quiz_answers[$question_actuelle])) {
            $quiz_answers[$question_actuelle] = $reponse_utilisateur;
            
            // Mettre à jour le score si c'est correct
            $bonnes_reponses = explode('-', $question->bonne_reponse);
            $reponse_correcte = in_array($reponse_utilisateur, $bonnes_reponses) || 
                               $reponse_utilisateur === $question->bonne_reponse;
                               
            if ($reponse_correcte) {
                session(['quiz_score' => session('quiz_score', 0) + 1]);
            }
            
            session(['quiz_answers' => $quiz_answers]);
        }
        
        // Rediriger vers la même question pour afficher le résultat
        return redirect()->route('quiz', ['q' => $question_actuelle]);
    }
    
    /**
     * Passer à la question suivante
     */
    public function nextQuestion(Request $request)
    {
        $question_actuelle = (int) $request->get('q', 1);
        
        if (!session('quiz_questions')) {
            return redirect()->route('quiz.start');
        }
        
        // Si c'est la dernière question, aller aux résultats
        if ($question_actuelle >= 20) {
            return redirect()->route('quiz.results');
        }
        
        // Sinon, aller à la question suivante
        return redirect()->route('quiz', ['q' => $question_actuelle + 1]);
    }
    
    /**
     * Afficher les résultats finaux
     */
    public function results()
    {
        if (!session('quiz_questions')) {
            return redirect()->route('quiz.start');
        }
        
        $questions_ids = session('quiz_questions');
        $quiz_answers = session('quiz_answers', []);
        $quiz_score = session('quiz_score', 0);
        
        // Récupérer toutes les questions avec les réponses
        $questions = Questions::whereIn('id', $questions_ids)->get()->keyBy('id');
        
        // Organiser les résultats
        $resultats = [];
        foreach ($questions_ids as $index => $question_id) {
            $question_numero = $index + 1;
            $question = $questions[$question_id];
            $reponse_utilisateur = isset($quiz_answers[$question_numero]) ? $quiz_answers[$question_numero] : null;
            
            $resultats[] = [
                'numero' => $question_numero,
                'question' => $question->question,
                'reponse_utilisateur' => $reponse_utilisateur,
                'bonne_reponse' => $question->bonne_reponse,
                'reponses' => $question->reponses,
                'correct' => $this->isCorrectAnswer($reponse_utilisateur, $question->bonne_reponse)
            ];
        }
        
        $pourcentage = round(($quiz_score / 20) * 100);
        
        return view('quiz-results', compact('resultats', 'quiz_score', 'pourcentage'));
    }
    
    /**
     * Réinitialiser le quiz
     */
    public function resetQuiz()
    {
        session()->forget(['quiz_questions', 'quiz_answers', 'quiz_score', 'current_question']);
        return redirect()->route('quiz.start');
    }

    /**
     * Vérifier si une réponse est correcte (gère les réponses multiples)
     */
    private function isCorrectAnswer($reponse_utilisateur, $bonne_reponse)
    {
        if ($reponse_utilisateur === $bonne_reponse) {
            return true;
        }
        
        // Gérer les réponses multiples (ex: "b-c")
        $bonnes_reponses = explode('-', $bonne_reponse);
        return in_array($reponse_utilisateur, $bonnes_reponses);
    }
}