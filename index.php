<?php

require_once './utils/database-handler.php';

require_once './models/Developer.php';
require_once './models/Platform.php';
require_once './models/Game.php';

$games = Game::fetchAll();
$developers = Developer::fetchAll();
$platforms = Platform::fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet" />
<body>
    <div class="container">
        <div class="card text-center">
            <img src="images/data-original.jpg" class="card-img-top" alt="Retro gaming banner">
            <div class="card-header">
                <h1 class="mt-4 mb-4">My beautiful video games</h1>
            </div>

            <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                Nouveau jeu ajouté avec succès!
            </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php 

                switch ($_GET['error']) {
                    case 1:
                        echo 'Veuillez saisir un nom pour le nouveau jeu.';
                        break;
                    case 2:
                        echo 'Veuillez saisir une date de sortie pour le nouveau jeu.';
                        break;
                    case 5:
                        echo 'Veuillez saisir une URL valide pour le lien du nouveau jeu.';
                        break;                    
                    default:
                        echo 'Une erreur est survenue dans l\'envoi de votre requête. Veuillez réessayer.';
                        break;
                }

                ?>
            </div>
            <?php endif; ?>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"># <i class="fas fa-sort-down"></i></th>
                        <th scope="col">Title <i class="fas fa-sort-down"></i></th>
                        <th scope="col">Release date <i class="fas fa-sort-down"></i></th>
                        <th scope="col">Developer <i class="fas fa-sort-down"></i></th>
                        <th scope="col">Platform <i class="fas fa-sort-down"></i></th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach($games as $game): ?>
                    <tr>
                        <th scope="row"><?= $game->getId() ?></th>
                        <td>
                            <a href="<?= $game->getLink() ?>" target="_blank"><?= $game->getTitle() ?></a>
                        </td>
                        <td><?= $game->getReleaseDate()->format('d M Y') ?></td>
                        <td>
                            <a href="<?= $game->getDeveloper()->getLink() ?>" target="_blank"><?= $game->getDeveloper()->getName() ?></a>
                        </td>
                        <td>
                            <a href="<?= $game->getPlatform()->getLink() ?>" target="_blank"><?= $game->getPlatform()->getName() ?></a>
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                        <td>
                            <form method="post" action="actions/delete-game.php">
                                <input type="hidden" name="id" value="<?= $game->getId() ?>" />
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <form method="post" action="actions/add-game.php">
                        <tr>
                            <th scope="row"></th>
                            <td>
                                <input type="text" name="title" placeholder="Title" />
                                <br />
                                <input type="text" name="link" placeholder="External link" />
                            </td>
                            <td>
                                <input type="date" name="release_date" />
                            </td>
                            <td>
                                <select name="developer">

                                    <?php foreach ($developers as $developer): ?>
                                    <option value="<?= $developer->getId() ?>"><?= $developer->getName() ?></option>
                                    <?php endforeach; ?>

                                </select>
                            </td>
                            <td>
                                <select name="platform">

                                    <?php foreach ($platforms as $platform): ?>
                                    <option value="<?= $platform->getId() ?>"><?= $platform->getName() ?></option>
                                    <?php endforeach; ?>

                                </select>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </td>
                            <td></td>
                        </tr>
                    </form>
                </tbody>
            </table>
            <div class="card-body">
                <p class="card-text">This interface lets you sort and organize your video games!</p>
                <p class="card-text">Let us know what you think and give us some love! 🥰</p>
            </div>
            <div class="card-footer text-muted">
                Created by <a href="https://github.com/M2i-DWWM-0920-Lyon-AURA">DWWM Lyon</a> &copy; 2020
            </div>
        </div>
    </div>
</body>
</html>