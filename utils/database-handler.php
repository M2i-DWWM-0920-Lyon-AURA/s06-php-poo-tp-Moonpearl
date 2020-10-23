<?php

// Etablit une connexion avec la base de données
$databaseHandler = new PDO('mysql:host=localhost;dbname=videogames', 'root', 'root');
// Configure l'interface avec la base de données pour afficher toutes les erreurs
$databaseHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$databaseHandler->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
