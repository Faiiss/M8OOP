<?php
require __DIR__. '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader( __DIR__ . '/templates');
$twig = new Environment($loader);

// echo __DIR__ . '/templates';
echo $twig->render('first-twig-html.twig' , ['naam' => 'Faiss', 'beroep' => 'docent']);