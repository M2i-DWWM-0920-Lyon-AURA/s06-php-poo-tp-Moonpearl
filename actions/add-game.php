<?php

require_once '../utils/database-handler.php';

require_once '../exceptions/InvalidValueException.php';
require_once '../models/Game.php';

// Essaie de créer un nouveau jeu à partir des donneés du formulaire
try {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = null;
    }

    // Si la requête POST contient bien toutes les valeurs attendues dans le formulare
    if (isset($_POST['title'])
        && isset($_POST['release_date'])
        && isset($_POST['link'])
        && isset($_POST['platform'])
        && isset($_POST['developer'])
    ) {
        // Vérifie que le nom du jeu n'est pas vide
        if (empty($_POST['title'])) {
            throw new InvalidValueException('Game title cannot be empty.', 1);
        }

        // Vérifie que la date de sortie du jeu n'est pas vide
        if (empty($_POST['release_date'])) {
            throw new InvalidValueException('Game release date cannot be empty.', 2);
        }

        // Vérifie que l'ID du développeur est bien un nombre
        if (!is_numeric($_POST['developer'])) {
            throw new InvalidValueException('Game developer ID must be a number.', 3);
        }

        // Vérifie que l'ID de la plateforme est bien un nombre
        if (!is_numeric($_POST['platform'])) {
            throw new InvalidValueException('Game platform ID must be a number.', 4);
        }

        // Crée un nouvel objet Game à partir des données du formulaire
        $game = new Game(
            $id,
            $_POST['title'],
            new DateTime($_POST['release_date']),
            $_POST['link'],
            $_POST['developer'],
            $_POST['platform']
        );
        
        // Sauvegarde le nouveau jeu en base de données
        $game->save();

        if (is_null($id)) {
            $success = 1;
        } else {
            $success = 2;
        }

        header('Location: /?success=' . $success);
    // Sinon
    } else {
        throw new InvalidValueException('Form data is not valid.', 0);
    }
}
// Si jamais une erreur liée au contenu du formulaire est détectée
catch(InvalidValueException $exception) {
    //
    header('Location: /?error=' . $exception->getCode());
}
