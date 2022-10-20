<!-- page start-->

<?php require_once './modele/class.PdoJeux.inc.php' ?>
<div class="chat-room-head" width=10000px></div>
<div class="col-sm-16">
	<section panel >
		<div class="chat-room-head">
			<h3><i class="fa fa-angle-right" ></i> Gérer les Jeux</h3>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-advance table-hover">
			<thead>
			  <tr class="tableau-entete">
				<th><i class="fa fa-bullhorn"></i> Référence </th>
				<th><i class="fa fa-bookmark"></i> nom</th>
				<th><i class="fa fa-bookmark"></i> Age Limite</th>
				<th><i class="fa fa-bookmark"></i> Genre</th>
				<th><i class="fa fa-bookmark"></i> Marque</th>
				<th><i class="fa fa-bookmark"></i> Plateforme de jeux</th>
				<th><i class="fa fa-bookmark"></i> Prix</th>
				<th><i class="fa fa-bookmark"></i> Date de Parution</th>
				<th></th>
				</div >
			  </tr>
			</thead>
			

			<tbody>
			<!-- formulaire pour ajouter un nouveau genre-->
			<tr>
			<form action="index.php?uc=gererJeux" method="post">
				<td>
					<input type="text" id="txtrefjeu" name="txtrefjeu" size="11" required minlength="10"  maxlength="16"  placeholder="refJeu " title="De 10 à 16 caractères"  />
				</td>
				<td>
					
					<input type="text" id="txtNom" name="txtNom" size="20"  minlength="1"  maxlength="100"  placeholder="Nom de jeu" title="De 10 à 100 caractères"  required/>

				</td>
				<td>
				<?php 
						$db->afficherListe($db->getLesPegis(),"lstIdPegi", 1, 1);
					?>
				</td>
				<td>
					<?php 
						$db->afficherListe($db->getLesGenres(),"lstIdGenre", 1, 1);
					?>
				</td>
				<td>
				<?php 
						$db->afficherListe($db->getLesMarques(),"lstIdMarque", 1, 1)
					?>
				</td>
				<td>
				<?php 
						$db->afficherListe($db->getLesPlateformes(),"lstIdPlateforme", 1, 1); 
					?>
				</td>
				<td>
					<input type="number" id="txtPrix" name="txtPrix"  min="0" step="0.01" placeholder="0" required  />
				</td>
				<td>
					<input type="date" id="txtDateParution" name="txtDateParution" value="2022-10-02"/>
				</td>
				<td> 
					<button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="ajouterNouveauJeu" title="Enregistrer nouveau jeu"><i class="fa fa-save"></i></button>
					<button class="btn btn-info btn-xs" type="reset" title="Effacer la saisie"><i class="fa fa-eraser"></i></button>	
				</td>
			</form>
			</tr>
				
			<?php
			foreach ($tbJeux as $jeu) { 
			?>
			  <tr>
			  
				<!-- formulaire pour modifier et supprimer les Jeux-->
				<form action="index.php?uc=gererJeux" method="post">
				<td><?php echo $jeu->identifiant; ?><input type="hidden"  name="txtrefjeu" value="<?php echo $jeu->identifiant; ?>" /></td>
				<?php 
					if ($jeu->identifiant != $refjeuModif) { ?>
						<td> 
							<?php echo $jeu-> nom; ?>
						</td>
						<td>
                       		<?php echo $jeu->ageLimite; ?>
                        </td>
						<td>
                       		<?php echo $jeu->libGenre; ?>
                        </td>
						<td>
                       		<?php echo $jeu->nomMarque; ?>
                        </td>
						<td>
                       		<?php echo $jeu->libPlateforme; ?>
                        </td>
						<td>
                       		<?php echo $jeu->prix; ?>
                        </td>
						<td>
                       		<?php echo $jeu->dateParution; ?>
                        </td>
						<td>
							<?php if ($notification != 'rien' && $jeu->identifiant == $refjeuNotif) {  
								echo '<button class="btn btn-success btn-xs"><i class="fa fa-check"></i>' . $notification . '</button>';
							} 
							 ?>
							<button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="demanderModifierJeu" title="Modifier"><i class="fa fa-pencil"></i></button>
							<button class="btn btn-danger btn-xs" type="submit" name="cmdAction" value="supprimerJeu" title="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce jeu?');"><i class="fa fa-trash-o "></i></button>
						</td>
					<?php
					}
					else {
						?>	<td>		
							<input type="text" id="txtNom" name="txtNom" size="40"  minlength="1"  maxlength="100" value="<?php echo $jeu->nom; ?>" required  />
						</td><td>			
						<?php $db->afficherListe($db->getLesPegis(),"lstIdPegi", 1, $jeu->idPegi); ?>
						</td><td>
						<?php $db->afficherListe($db->getLesGenres(),"lstIdGenre", 1, $jeu->idGenre); ?>
						</td><td>
						<?php $db->afficherListe($db->getLesMarques(),"lstIdMarque", 1, $jeu->idMarque); ?>
						</td><td>
						<?php $db->afficherListe($db->getLesPlateformes(),"lstIdPlateforme", 1, $jeu->idPlateforme); ?>
						</td><td>
							<input type="number" id="txtPrix" name="txtPrix"  min="0" step="0.01"  value="<?php echo $jeu->prix; ?>" required  />     
						</td><td>
							<input type="date" id="txtDateParution" name="txtDateParution"   value="<?php echo $jeu->dateParution; ?>" required/>     
						</td>
						<td>		 
							<button class="btn btn-primary btn-xs" type="submit" name="cmdAction" value="validerModifierJeu" title="Enregistrer"><i class="fa fa-save"></i></button>
							<button class="btn btn-info btn-xs" type="reset" title="Effacer la saisie"><i class="fa fa-eraser"></i></button>				
							<button class="btn btn-warning btn-xs" type="submit" name="cmdAction" value="annulerModifierJeu" title="Annuler"><i class="fa fa-undo"></i></button>
						</td>				
					<?php
					}				
					?>
				</form>
				
			  </tr>  
			<?php
			}
			?>
			</tbody>
		  </table>
			  	  
		</div><!-- fin div panel-body-->
    </section><!-- fin section Jeux-->
</div><!--fin div col-sm-6-->
