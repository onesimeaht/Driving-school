<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Driving School - Accueil</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #2196f3;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- NAVBAR --- */
        nav {
            background-color: #1976d2;
            display: flex;
            justify-content: center;
            gap: 40px;
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }

        nav a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #bbdefb;
        }

        /* --- HEADER --- */
        header {
            background-color: #e3f2fd;
            color: #0d47a1;
            padding: 30px 20px;
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            border-bottom: 1px solid #90caf9;
        }

        /* --- MAIN --- */
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .home-box {
            background-color: #e0e0e0;
            padding: 40px 30px;
            border-radius: 16px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
            text-align: center;
        }

        .home-box h1 {
            color: #1976d2;
            margin-bottom: 30px;
            font-size: 26px;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .buttons a {
            display: inline-block;
            padding: 14px;
            background-color: #2196f3;
            color: white;
            font-weight: bold;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .buttons a:hover {
            background-color: #1565c0;
        }

        /* --- FOOTER --- */
        footer {
            background-color: #f5f5f5;
            color: #555;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            border-top: 1px solid #ccc;
        }
    </style>
</head>
<body>

@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="container mt-4"> <div class="text-center mb-5"> <h1 class="display-5 fw-bold text-primary">Bienvenue au Driving School !</h1> <p class="lead">Prêt(e) à tester tes connaissances ?</p> </div>
<div class="d-flex flex-column align-items-center gap-4">
    <a href="{{ route('quiz.start') }}" class="btn btn-lg btn-quiz px-5 py-3">
        🎯 Commencer le Quiz
    </a>
    <a href="#" class="btn btn-outline-secondary px-4 py-2">
        📊 Voir les Scores
    </a>
</div>
<br><br><br><br><br><br><br>

</html>
 </div> @endsection 