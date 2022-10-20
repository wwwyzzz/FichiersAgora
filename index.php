<?php
/**
 * Page d'accueil de l'application AgoraBo

 * Point d'entrée unique de l'application
 * @author MD
 * @package default
 */

// démarrer la session  !!!!!!!!  A FAIRE AVANT TOUT CODE HTML   !!!!!!!!
session_start();
//require 'vue/v_header.php';    // entête des pages HTML
require 'vue/v_headerTwig.html';   // balise <head> et styles
// inclure les bibliothèques de fonctions
require_once 'app/_config.inc.php';
require_once 'modele/class.PdoJeux.inc.php';

// *** pour twig ***
// la directive "require 'vendor/autoload.php';" est ajoutée au début de l'application
// elle permet de charger le script  "autoload.php".
// Ce script a été crée par composer et permet de charger les dépendances une à une dans le projet
require_once 'vendor/autoload.php';

// la classe FileSystemLoader permet de charger des fichiers contenus dans le dossier indiqué en paramètre
$loader = new \Twig\Loader\FilesystemLoader('vue');

// la classe Environment permet de stocker la configuration de l'environnement
//  en phase de développement (debug) nous n'utilisons pas le cache
$twig = new \Twig\Environment($loader, array(
    'cache' => TWIG_CACHE,
    'debug' => TWIG_DEBUG
)); 
// pour que twig connaisse la variable globale de session
$twig->addGlobal('session', $_SESSION);
// *** twig ***

// Connexion au serveur et à la base (A)
$db = PdoJeux::getPdoJeux();
// Si aucun utilisateur connecté, on considère que la page demandée est la page de connexion
//   $_SESSION['idUtilisateur']  est crée lorsqu'un utilisateur autorisé se connecte (dans c_connexion.php)
if (!isset($_SESSION['idUtilisateur'])){
	require 'controleur/c_connexion.php';
 } else {
 

// Récupère l'identifiant de la page passé via l'URL
// Si non défini, on considère que la page demandée est la page d'accueil
if (!isset($_GET['uc'])){
    $_GET['uc'] = 'index';
}
$uc = $_GET['uc'];
// selon la valeur du use case demandé(uc) on inclut le contrôleur secondaire
switch($uc){
	case 'index' : {
		/*$menuActif = '';
		require 'vue/v_menu.php';
		require 'vue/v_accueil.php';; break;*/
		echo $twig->render('accueil.html.twig');
	}
    case 'gererGenres' : {
		/*$menuActif = 'Jeux';	// pour garder le menu correspondant ouvert
		require 'vue/v_menu.php';*/
		// à compléter
		require 'controleur/c_gererGenres.php'; break;
    }  
	case 'gererMarques' : {
		$menuActif = 'Jeux';	// pour garder le menu correspondant ouvert
		require 'vue/v_menu.php';
		// à compléter
		require 'controleur/c_gererMarques.php'; break;
    }  
	case 'gererJeux' : {
		$menuActif = 'Jeux';	// pour garder le menu correspondant ouvert
		require 'vue/v_menu.php';
		// à compléter
		require 'controleur/c_gererJeux.php'; break;
    }  
	case 'gererPlateformes' : {
		$menuActif = 'Jeux';	// pour garder le menu correspondant ouvert
		require 'vue/v_menu.php';
		// à compléter
		require 'controleur/c_gererPlateformes.php'; break;
    }  
		case 'gererPegis' : {
		$menuActif = 'Jeux';	// pour garder le menu correspondant ouvert
		require 'vue/v_menu.php';
		// à compléter
		require 'controleur/c_gererPegis.php'; break;
    }  
	case 'deconnexion' :
		{
		   require 'controleur/c_deconnexion.php';
		   break;
		}
	 }
  }
  

// Fermeture de la connexion (C)
$db = null;	

// pied de page
//require("vue/v_footer.html") ;	
?>

