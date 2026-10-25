<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Sederhana - Modular PHP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f4f6f9;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        /* Header & Nav */
        header {
            background-color: #2c3e50;
            color: white;
            padding: 25px 20px;
            text-align: center;
        }
        header h1 {
            margin-bottom: 8px;
        }
        nav {
            margin-top: 15px;
        }
        nav a {
            color: #ecf0f1;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }
        nav a:hover {
            color: #3498db;
        }
        /* Kontainer Utama */
        .container {
            flex: 1;
            max-width: 800px;
            margin: 30px auto;
            padding: 25px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        /* Footer */
        footer {
            background-color: #2c3e50;
            color: #bdc3c7;
            text-align: center;
            padding: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <header>
        <h1>Portal Informasi Web</h1>
        <p>Praktikum Modularisasi PHP</p>
        <nav>
            <a href="#">Beranda</a>
            <a href="#">Artikel</a>
            <a href="#">Tentang</a>
            <a href="#">Kontak</a>
        </nav>
    </header>