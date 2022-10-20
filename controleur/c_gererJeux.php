<?php
// si le paramètre action n'est pas positionné alors
//        si aucun bouton "action" n'a été envoyé alors par défaut on affiche les Jeux
//        sinon l'action est celle indiquée par le bouton

if (!isset($_POST['cmdAction'])) {
    $action = 'afficherJeux';
} else {
    // par défaut
    $action = $_POST['cmdAction'];
}

$refjeuModif = -1; // positionné si demande de modification
$notification = 'rien'; // pour notifier la mise à jour dans la vue

// selon l'action demandée on réalise l'action
switch ($action) {

    case 'ajouterNouveauJeu':{
            if (!empty($_POST['txtrefjeu'])) {
				$jeu = (object)[ 
					'ref' => $_POST['txtrefjeu'],
					'nom' => $_POST['txtNom'],
					'plateforme'=> $_POST['lstIdPlateforme'],
					'pegi' =>$_POST['lstIdPegi'],
					'genre'=>$_POST['lstIdGenre'],
					'marque' =>$_POST['lstIdMarque'],
					'prix' => $_POST['txtPrix'],
					'txtDateParution' =>  date('Y-m-d', strtotime($_POST['txtDateParution']))
				];
                 $db->ajouterJeu($jeu);
                 $refjeuNotif = $_POST['txtrefjeu'];
                // $refjeuNotif est l'refjeu du Jeux ajouté
                $notification = 'Ajouté'; // sert à afficher l'ajout réalisé dans la vue
            }
            break;
        }

    case 'demanderModifierJeu':{
            $refjeuModif = $_POST['txtrefjeu']; // sert à créer un formulaire de modification pour ce Jeux
            break;
        }

    case 'validerModifierJeu':{
        $jeu = (object)[ 
            'ref' => $_POST['txtrefjeu'],
            'nom' => $_POST['txtNom'],
            'plateforme'=> $_POST['lstIdPlateforme'],
            'pegi' =>$_POST['lstIdPegi'],
            'genre'=>$_POST['lstIdGenre'],
            'marque' =>$_POST['lstIdMarque'],
            'prix' => $_POST['txtPrix'],
            'txtDateParution' =>  date('Y-m-d', strtotime($_POST['txtDateParution']))
        ];
            $db->modifierJeu($jeu);
            $refjeuNotif = $_POST['txtrefjeu']; // $refjeuNotif est l'refjeu du Jeux modifié
            $notification = 'Modifié'; // sert à afficher la modification réalisée dans la vue
            break;
        }

    case 'supprimerJeu':{
            $refjeu = $_POST['txtrefjeu'];
            $db->supprimerJeu($refjeu); //  à compléter, voir quelle méthode appeler dans le modèle
            break;
        }
}

// l' affichage des Jeux se fait dans tous les cas
$tbJeux = $db->getLesJeux();
require 'vue/v_lesJeux.php';
