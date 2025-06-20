<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Code de la Route')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Styles personnalisés -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.4rem;
        }
        .navbar-nav .nav-link {
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .navbar-nav .nav-link:hover {
            color: #fff !important;
            transform: translateY(-1px);
        }
        .card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }
        .quiz-progress {
            background: linear-gradient(90deg, #007cba, #28a745);
            height: 8px;
            border-radius: 4px;
            transition: width 0.4s ease;
        }
        .btn-quiz {
            background: linear-gradient(135deg, #007cba, #0056b3);
            border: none;
            transition: all 0.3s ease;
        }
        .btn-quiz:hover {
            background: linear-gradient(135deg, #0056b3, #004085);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 123, 186, 0.3);
        }
        .quiz-badge {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .footer-gradient {
            background: linear-gradient(135deg, #343a40, #495057);
        }
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.2rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-car me-2"></i>Code de la Route
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                                <i class="fas fa-home me-1"></i>Accueil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('cours*') ? 'active' : '' }}" href="{{ route('cours.index') }}">
                                <i class="fas fa-book me-1"></i>Cours
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('quiz*') ? 'active' : '' }}" href="{{ route('quiz.start') }}">
                                <i class="fas fa-brain me-1"></i>Quiz
                                @if(session('quiz_in_progress'))
                                    <span class="quiz-badge ms-1">En cours</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Quiz Progress Indicator (visible when quiz is active) -->
                    @if(session('quiz_in_progress') && session('quiz_current_question'))
                        <div class="d-none d-lg-flex align-items-center me-3">
                            <small class="text-white me-2">Progression:</small>
                            <div class="bg-dark rounded" style="width: 100px; height: 6px;">
                                <div class="quiz-progress rounded" style="width: {{ (session('quiz_current_question', 1) / 20) * 100 }}%"></div>
                            </div>
                            <small class="text-white ms-2">{{ session('quiz_current_question', 1) }}/20</small>
                        </div>
                    @endif
                    

                </div>
            </div>
        </nav>

        <!-- Breadcrumb (optionnel) -->
        @if(View::hasSection('breadcrumb'))
            <nav aria-label="breadcrumb" class="bg-light py-2">
                <div class="container">
                    @yield('breadcrumb')
                </div>
            </nav>
        @endif

        <!-- Messages Flash -->
        @if(session('success') || session('error') || session('warning') || session('info'))
            <div class="container mt-3">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        @endif

        <!-- Main Content -->
        <main class="py-4">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="footer-gradient text-white text-center py-4 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-car me-2"></i>Code de la Route</h6>
                        <p class="mb-0 small">Apprenez le code de la route facilement</p>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-center justify-content-md-end align-items-center">
                            <small>&copy; {{ date('Y') }} Tous droits réservés</small>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts personnalisés -->
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>