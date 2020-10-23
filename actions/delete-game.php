<?php

require_once '../utils/database-handler.php';

require_once '../models/Game.php';

$game = Game::fetchById($_POST['id']);
$game->delete();

header('Location: /');
