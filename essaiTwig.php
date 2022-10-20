<?php
/**
 * Essai twig
 *    voir  https://twig.symfony.com/doc/2.x/api.html
 */

// la directive "require 'vendor/autoload.php';" est ajoutée au début de l'application
// elle permet de charger le script  "autoload.php".
// Ce script a été crée par composer et permet de charger les dépendances une à une dans le projet
require_once 'vendor/autoload.php';

// la classe FileSystemLoader permet de charger des fichiers contenus dans le dossier indiqué en paramètre
$loader = new \Twig\Loader\FilesystemLoader('vue');

// la classe Environment permet de stocker la configuration de l'environnement
//  en phase de développement (debug) nous n'utilisons pas le cache
$twig = new \Twig\Environment($loader, array(
   'cache' => false,
   'debug' => true
));

// la méthode render charge le template donné en premier argument et le restitue avec les variables passées en second argument
echo $twig->render('essai.html.twig', ['name' => 'Marianne']);

?>
