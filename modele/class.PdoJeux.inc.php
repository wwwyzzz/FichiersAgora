<?php

/**
 *  AGORA
 * 	©  Logma, 2019
 * @package default
 * @author MD
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 * 
 * Classe d'accès aux données. 
 * Utilise les services de la classe PDO
 * pour l'application AGORA
 * Les attributs sont tous statiques,
 * $monPdo de type PDO 
 * $monPdoJeux qui contiendra l'unique instance de la classe
 */
class PdoJeux {

    private static $monPdo;
    private static $monPdoJeux = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct() {
		// A) >>>>>>>>>>>>>>>   Connexion au serveur et à la base
		try {   
			// encodage
			$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''); 
			// Crée une instance (un objet) PDO qui représente une connexion à la base
			PdoJeux::$monPdo = new PDO(DSN,DB_USER,DB_PWD, $options);
			// configure l'attribut ATTR_ERRMODE pour définir le mode de rapport d'erreurs 
			// PDO::ERRMODE_EXCEPTION: émet une exception 
			PdoJeux::$monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// configure l'attribut ATTR_DEFAULT_FETCH_MODE pour définir le mode de récupération par défaut 
			// PDO::FETCH_OBJ: retourne un objet anonyme avec les noms de propriétés 
			//     qui correspondent aux noms des colonnes retournés dans le jeu de résultats
			PdoJeux::$monPdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		}
		catch (PDOException $e)	{	// $e est un objet de la classe PDOException, il expose la description du problème
			die('<section id="main-content"><section class="wrapper"><div class = "erreur">Erreur de connexion à la base de données !<p>'
				.$e->getmessage().'</p></div></section></section>');
		}
    }
	
    /**
     * Destructeur, supprime l'instance de PDO  
     */
    public function _destruct() {
        PdoJeux::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoJeux = PdoJeux::getPdoJeux();
     * 
     * @return l'unique objet de la classe PdoJeux
     */
    public static function getPdoJeux() {
        if (PdoJeux::$monPdoJeux == null) {
            PdoJeux::$monPdoJeux = new PdoJeux();
        }
        return PdoJeux::$monPdoJeux;
    }

	//==============================================================================
	//
	//	METHODES POUR LA GESTION DES GENRES
	//
	//==============================================================================
	
    /**
     * Retourne tous les genres sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Genre)
     */
    public function getLesGenres(): array {
  		$requete =  'SELECT idGenre as identifiant, libGenre as libelle 
						FROM genre 
						ORDER BY libGenre';
		try	{	 
			$resultat = PdoJeux::$monPdo->query($requete);
			$tbGenres  = $resultat->fetchAll();	
			return $tbGenres;		
		}
		catch (PDOException $e)	{  
			die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
		}
    }

	
	/**
	 * Ajoute un nouveau genre avec le libellé donné en paramètre
	 * 
	 * @param string $libGenre : le libelle du genre à ajouter
	 * @return int l'identifiant du genre crée
	 */
    public function ajouterGenre(string $libGenre): int {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO genre "
                    . "(idGenre, libGenre) "
                    . "VALUES (0, :unLibGenre) ");
            $requete_prepare->bindParam(':unLibGenre', $libGenre, PDO::PARAM_STR);
            $requete_prepare->execute();
			// récupérer l'identifiant crée
			return PdoJeux::$monPdo->lastInsertId(); 
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }
	
	
	 /**
     * Modifie le libellé du genre donné en paramètre
     * 
     * @param int $idGenre : l'identifiant du genre à modifier  
     * @param string $libGenre : le libellé modifié
     */
    public function modifierGenre(int $idGenre, string $libGenre): void {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE genre "
                    . "SET libGenre = :unLibGenre "
                    . "WHERE genre.idGenre = :unIdGenre");
            $requete_prepare->bindParam(':unIdGenre', $idGenre, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unLibGenre', $libGenre, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }
	
	
	/**
     * Supprime le genre donné en paramètre
     * 
     * @param int $idGenre :l'identifiant du genre à supprimer 
     */
    public function supprimerGenre(int $idGenre): void {
       try {
            $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM genre "
                    . "WHERE genre.idGenre = :unIdGenre");
            $requete_prepare->bindParam(':unIdGenre', $idGenre, PDO::PARAM_INT);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }
	
//==============================================================================
	//
	//	METHODES POUR LA GESTION DES MARQUES
	//
	//==============================================================================
	
    /**
     * Retourne tous les marques sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Marque)
     */
    public function getLesMarques(): array {
  		$requete =  'SELECT idMarque as identifiant, nomMarque as libelle 
						FROM marque 
						ORDER BY nomMarque';
		try	{	 
			$resultat = PdoJeux::$monPdo->query($requete);
			$tbMarques  = $resultat->fetchAll();	
			return $tbMarques;		
		}
		catch (PDOException $e)	{  
			die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
		}
    }

	
	/**
	 * Ajoute un nouveau Marque avec le libellé donné en paramètre
	 * 
	 * @param string $nomMarque : le libelle du Marque à ajouter
	 * @return int l'identifiant du Marque crée
	 */
    public function ajouterMarque(string $nomMarque): int {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO marque "
                    . "(idMarque, nomMarque) "
                    . "VALUES (0, :unnomMarque) ");
            $requete_prepare->bindParam(':unnomMarque', $nomMarque, PDO::PARAM_STR);
            $requete_prepare->execute();
			// récupérer l'identifiant crée
			return PdoJeux::$monPdo->lastInsertId(); 
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }
	
	
	 /**
     * Modifie le libellé du Marque donné en paramètre
     * 
     * @param int $idMarque : l'identifiant du Marque à modifier  
     * @param string $nomMarque : le libellé modifié
     */
    public function modifierMarque(int $idMarque, string $nomMarque): void {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE marque "
                    . "SET nomMarque = :unnomMarque "
                    . "WHERE marque.idMarque = :unIdMarque");
            $requete_prepare->bindParam(':unIdMarque', $idMarque, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unnomMarque', $nomMarque, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }
	
	
	/**
     * Supprime le Marque donné en paramètre
     * 
     * @param int $idMarque :l'identifiant du Marque à supprimer 
     */
    public function supprimerMarque(int $idMarque): void {
       try {
            $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM marque "
                    . "WHERE marque.idMarque = :unIdMarque");
            $requete_prepare->bindParam(':unIdMarque', $idMarque, PDO::PARAM_INT);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }

    //==============================================================================
	//
	//	METHODES POUR LA GESTION DES PlateformeS
	//
	//==============================================================================
	
    /**
     * Retourne tous les Plateformes sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Plateforme)
     */
    public function getLesPlateformes(): array {
  		$requete =  'SELECT idPlateforme as identifiant, libPlateforme as libelle 
						FROM plateforme
						ORDER BY libPlateforme';
		try	{	 
			$resultat = PdoJeux::$monPdo->query($requete);
			$tbPlateformes  = $resultat->fetchAll();	
			return $tbPlateformes;		
		}
		catch (PDOException $e)	{  
			die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
		}
    }

	
	/**
	 * Ajoute un nouveau Plateforme avec le libellé donné en paramètre
	 * 
	 * @param string $libPlateforme : le libelle du Plateforme à ajouter
	 * @return int l'identifiant du Plateforme crée
	 */
    public function ajouterPlateforme(string $libPlateforme): int {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO plateforme "
                    . "(idPlateforme, libPlateforme) "
                    . "VALUES (0, :unlibPlateforme) ");
            $requete_prepare->bindParam(':unlibPlateforme', $libPlateforme, PDO::PARAM_STR);
            $requete_prepare->execute();
			// récupérer l'identifiant crée
			return PdoJeux::$monPdo->lastInsertId(); 
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }
	
	
	 /**
     * Modifie le libellé du Plateforme donné en paramètre
     * 
     * @param int $idPlateforme : l'identifiant du Plateforme à modifier  
     * @param string $libPlateforme : le libellé modifié
     */
    public function modifierPlateforme(int $idPlateforme, string $libPlateforme): void {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE plateforme "
                    . "SET libPlateforme = :unlibPlateforme "
                    . "WHERE plateforme.idPlateforme = :unIdPlateforme");
            $requete_prepare->bindParam(':unIdPlateforme', $idPlateforme, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unlibPlateforme', $libPlateforme, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }
	
	
	/**
     * Supprime le Plateforme donné en paramètre
     * 
     * @param int $idPlateforme :l'identifiant du Plateforme à supprimer 
     */
    public function supprimerPlateforme(int $idPlateforme): void {
       try {
            $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM plateforme "
                    . "WHERE plateforme.idPlateforme = :unIdPlateforme");
            $requete_prepare->bindParam(':unIdPlateforme', $idPlateforme, PDO::PARAM_INT);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }

//==============================================================================
	//
	//	METHODES POUR LA GESTION DES PegiS
	//
	//==============================================================================
	
    /**
     * Retourne tous les Pegis sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Pegi)
     */
    public function getLesPegis(): array {
        $requete =  'SELECT idPegi as identifiant, ageLimite as libelle, descPegi  
                      FROM pegi
                      ORDER BY idPegi';
      try	{	 
          $resultat = PdoJeux::$monPdo->query($requete);
          $tbPegis  = $resultat->fetchAll();	
          return $tbPegis;		
      }
      catch (PDOException $e)	{  
          die('<div class = "erreur">Erreur dans la requête !<p>'
              .$e->getmessage().'</p></div>');
      }
  }

  
  /**
   * Ajoute un nouveau Pegi avec le libellé donné en paramètre
   * 
   * @param string $libPegi : le libelle du Pegi à ajouter
   * @return int l'identifiant du Pegi crée
   */
  public function ajouterPegi(int $ageLimite, string $descPegi): int {
      try {
          $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO pegi "
                  . "(idPegi, ageLimite, descPegi) "
                  . "VALUES (0, :unageLimite, :undescPegi) ");
          $requete_prepare->bindParam(':unageLimite', $ageLimite, PDO::PARAM_INT);
          $requete_prepare->bindParam(':undescPegi', $descPegi, PDO::PARAM_STR);
          $requete_prepare->execute();
          // récupérer l'identifiant crée
          return PdoJeux::$monPdo->lastInsertId(); 
      } catch (Exception $e) {
          die('<div class = "erreur">Erreur dans la requête !<p>'
              .$e->getmessage().'</p></div>');
      }
  }
  
  
   /**
   * Modifie le libellé du pegi donné en paramètre
   * 
   * @param int $idpegi : l'identifiant du pegi à modifier  
   * @param string $libpegi : le libellé modifié
   */
  public function modifierPegi(int $idPegi, int $ageLimite, string $descPegi): void {
      try {
          $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE pegi "
                  . "SET descPegi = :undescPegi, ageLimite = :unageLimite  "
                  . "WHERE pegi.idPegi = :unidPegi");
          $requete_prepare->bindParam(':unidPegi', $idPegi, PDO::PARAM_INT);
          $requete_prepare->bindParam(':unageLimite', $ageLimite, PDO::PARAM_INT);
          $requete_prepare->bindParam(':undescPegi', $descPegi, PDO::PARAM_STR);
          $requete_prepare->execute();
      } catch (Exception $e) {
          die('<div class = "erreur">Erreur dans la requête !<p>'
              .$e->getmessage().'</p></div>');
      }
  }
  
  
  /**
   * Supprime le Pegi donné en paramètre
   * 
   * @param int $idPegi :l'identifiant du Pegi à supprimer 
   */
  public function supprimerPegi(int $idPegi): void {
     try {
          $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM pegi "
                  . "WHERE pegi.idPegi = :unIdPegi");
          $requete_prepare->bindParam(':unIdPegi', $idPegi, PDO::PARAM_INT);
          $requete_prepare->execute();
      } catch (Exception $e) {
          die('<div class = "erreur">Erreur dans la requête !<p>'
              .$e->getmessage().'</p></div>');
      }
  }
   //==============================================================================
	//
	//	METHODES POUR LA GESTION DES Jeux
	//
	//==============================================================================
	
    /**
     * Retourne tous les Jeux sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Jeu)
     */
    public function getLesJeux(): array {
        $requete =  'SELECT J.refJeu as identifiant, j.idPlateforme, j.idPegi, j.idGenre, j.idMarque, PF.libPlateforme,P.ageLimite, P.descPegi, G.libGenre, M.nomMarque, nom, prix, dateParution FROM jeu_video J 
            JOIN plateforme PF
            ON J.idPlateforme = PF.idPlateforme
            JOIN pegi P
            ON j.idPegi = P.idPegi
            JOIN genre G
            ON j.idGenre = G.idGenre 
            JOIN marque M
            ON J.idMarque = M.idMarque
            ORDER BY J.refJeu';
      try	{	 
          $resultat = PdoJeux::$monPdo->query($requete);
          $tbJeux  = $resultat->fetchAll();	
          return $tbJeux;		
      }
      catch (PDOException $e)	{  
          die('<div class = "erreur">Erreur dans la requête !<p>'
              .$e->getmessage().'</p></div>');
      }
  }

  
  /**
   * Ajoute un nouveau Jeu avec le libellé donné en paramètre
   * 
   * @param string $libJeu : le libelle du Jeu à ajouter
   * @return int l'identifiant du Jeu crée
   */



  public function ajouterJeu(object $jeu): void {
      try {
          $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO jeu_video "
                  . "(refJeu, idPlateforme, idPegi, idGenre, idMarque, nom, prix, dateParution) "
                  . "VALUES (:unrefJeu, :unidPlateforme, :unidPegi, :unidGenre, :unidMarque, :unnom, :unprix, :undateParution) ");
          $requete_prepare->bindParam(':unrefJeu', $jeu->ref, PDO::PARAM_STR);
          $requete_prepare->bindParam(':unidPlateforme', $jeu->plateforme, PDO::PARAM_INT);
          $requete_prepare->bindParam(':unidPegi', $jeu->pegi, PDO::PARAM_INT);
          $requete_prepare->bindParam(':unidGenre', $jeu->genre, PDO::PARAM_INT);
          $requete_prepare->bindParam(':unidMarque', $jeu->marque, PDO::PARAM_INT);
          $requete_prepare->bindParam(':unnom', $jeu->nom, PDO::PARAM_STR);
          $requete_prepare->bindParam(':unprix', $jeu->prix, PDO::PARAM_STR);
          $requete_prepare->bindParam(':undateParution', $jeu->txtDateParution, PDO::PARAM_STR);
          $requete_prepare->execute();
          // récupérer l'identifiant crée 
      } catch (Exception $e) {
          die('<div class = "erreur">Erreur dans la requête !<p>'
              .$e->getmessage().'</p></div>');
      }
  }
  
  
   /**
   * Modifie le libellé du jeu donné en paramètre
   * 
   * @param int $idjeu : l'identifiant du jeu à modifier  
   * @param string $libjeu : le libellé modifié
   */
  public function modifierJeu(object $jeu): void {
      try {
        $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE jeu_video "
        . "SET idPlateforme = :unidPlateforme, idPegi = :unidPegi, idGenre = :unidGenre, idMarque = :unidMarque, nom = :unnom, prix = :unprix, dateParution = :undateParution "
        . "WHERE jeu_video.refJeu = :unrefJeu");      
        $requete_prepare->bindParam(':unrefJeu', $jeu->ref, PDO::PARAM_STR);
        $requete_prepare->bindParam(':unidPlateforme', $jeu->plateforme, PDO::PARAM_INT);
        $requete_prepare->bindParam(':unidPegi', $jeu->pegi, PDO::PARAM_INT);
        $requete_prepare->bindParam(':unidGenre', $jeu->genre, PDO::PARAM_INT);
        $requete_prepare->bindParam(':unidMarque', $jeu->marque, PDO::PARAM_INT);
        $requete_prepare->bindParam(':unnom', $jeu->nom, PDO::PARAM_STR);
        $requete_prepare->bindParam(':unprix', $jeu->prix, PDO::PARAM_STR);
        $requete_prepare->bindParam(':undateParution', $jeu->txtDateParution, PDO::PARAM_STR);
        $requete_prepare->execute();

      } catch (Exception $e) {
          die('<div class = "erreur">Erreur dans la requête !<p>'
              .$e->getmessage().'</p></div>');
      }
  }
  
  
  /**
   * Supprime le Pegi donné en paramètre
   * 
   * @param String $idJeu :l'identifiant du Jeu à supprimer 
   */
  public function supprimerJeu(string $refJeu): void {
     try {
          $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM jeu_video "
                  . "WHERE jeu_video.refJeu = :unrefJeu");
          $requete_prepare->bindParam(':unrefJeu', $refJeu, PDO::PARAM_STR);
          $requete_prepare->execute();
      } catch (Exception $e) {
          die('<div class = "erreur">Erreur dans la requête !<p>'
              .$e->getmessage().'</p></div>');
      }
  }

  // -----------------------------------------------------------------------------
/**
 * Affiche une liste de choix à partir d'un
 * tableau d'objets ayant les attributs (identifiant, libelle)
 * @param array $tbObjets : le tableau d'objets
 * @param string $name : les attributs name et id de la liste déroulante
 * @param int $size : l'attribut size de la liste déroulante
 * @param string $idSelect : l'identifiant de l'élément à présélectionner dans la liste
 */
function afficherListe($tbObjets, $name, $size, $idSelect)
{
// si $tbObjets est non vide et $idSelect est non vide
    if (count($tbObjets) && (empty($idSelect))) {
        $idSelect = $tbObjets[0]->identifiant; // alors $idSelect est l'identifiant du premier objet du tableau
    }
    echo "  <select  name='" . $name . "' id='" . $name . "' size='" . $size . "' style='height: 1.9em;width: auto;'>"; // à compléter
    foreach ($tbObjets as $objet) {
// l'élément en paramètre est présélectionné
        if ($objet->identifiant != $idSelect) { // si l'identifiant de l'objet n'est pas l'identifiant présélectionné echo '<option // à compléter
            echo "<option value='" . $objet->identifiant . "'>" . $objet->libelle . "</option>";
        } else {
            echo "<option selected value='" . $objet->identifiant . "'>" . $objet->libelle . "</option>"; // à compléter
        }
    }
    echo "</select>"; // à compléter
    return ($idSelect);
}

    //==============================================================================
    //
    //  METHODES POUR LA GESTION DES MEMBRES
    //
    //==============================================================================
   /**
     * Retourne l'identifiant, le nom et le prénom de l'utilisateur correspondant au compte et mdp
     *       
     * @param string $compte  le compte de l'utilisateur    
     * @param string $mdp  le mot de passe de l'utilisateur    
     * @return @return ?object  l'objet ou null si ce membre n'existe pas
     */
    public function getUnMembre(string $loginMembre, string $mdpMembre): ?object {
        try {   
            // préparer la requête
            $requete_prepare = PdoJeux::$monPdo->prepare(
                'SELECT idMembre, prenomMembre, nomMembre, mdpMembre, selMembre  
                 FROM membre 
                 WHERE loginMembre = :LoginMembre');
            // associer les valeurs aux paramètres
            $requete_prepare->bindParam(':LoginMembre', $loginMembre, PDO::PARAM_STR);
            // exécuter la requête
           $requete_prepare->execute();
            // récupérer l'objet   
            if ($utilisateur = $requete_prepare->fetch()) {
                // vérifier le mot de passe
                // le mot de passe transmis par le formulaire est le hash du mot de passe saisi
                // hash("SHA5123, $mdpMembre. $utilisatuer->selMembre)
                // le mot de passe enregistré dans la base doit correspondre au hash du (hash transmis concaténé au sel)
                $mdpHash = hash('SHA512',$mdpMembre . $utilisateur->selMembre);
                if($mdpHash == $utilisateur->mdpMembre){
                    return $utilisateur;
                }
            }
            return null;
        }
        catch (PDOException $e) {  
            die('<div class = "erreur">Erreur dans la requête !<p>'
                .$e->getmessage().'</p></div>');
        }
    }

/**
 * Retourne tous les genres sous forme d'un tableau d'objets
 *    avec également le nombre de jeux de ce genre
 *
 * @return le tableau d'objets  (Genre)
 */
public function getLesGenresComplet() {
    $requete =  'SELECT G.idGenre as identifiant, G.libGenre as libelle, G.idSpecialiste AS idSpecialiste, CONCAT(P.prenomPersonne, " ", P.nomPersonne)  AS nomSpecialiste, 
         (SELECT COUNT(refJeu) FROM jeu_video AS J WHERE J.idGenre = G.idGenre) AS nbJeux 
      FROM genre AS G
      LEFT OUTER JOIN personne  AS P ON G.idSpecialiste = P.idPersonne
      ORDER BY G.libGenre';
    try    {
        $resultat = PdoJeux::$monPdo->query($requete);
        $tbGenres  = $resultat->fetchAll();
        return $tbGenres;
    }
    catch (PDOException $e)    {
        die('<div class = "erreur">Erreur dans la requête !<p>'
            .$e->getmessage().'</p></div>');
    }
}

/**
 * Retourne l'identifiant et le nom complet de toutes les personnes sous forme d'un tableau d'objets 
 * 
 * @return le tableau d'objets   
 */
public function getLesPersonnes() {
    $requete =  'SELECT idPersonne as identifiant, CONCAT(prenomPersonne, " ", nomPersonne)  AS libelle 
            FROM personne 
            ORDER BY nomPersonne';
try    {   
   $resultat = PdoJeux::$monPdo->query($requete);
   $tbPersonnes  = $resultat->fetchAll(); 
   return $tbPersonnes;      
}
catch (PDOException $e)    {  
   die('<div class = "erreur">Erreur dans la requête !<p>'
      .$e->getmessage().'</p></div>');
}
  }


}

?>