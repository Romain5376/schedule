<html>
 <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Sailings</title>
    </head>
<?php
include("adm/db.php");
?>

<body>
	<nav class="navbar navbar-expand navbar-dark " style="display:none;">
   	    
	</nav>
<?php

$bdd=getdbx();

$plcrecipt="";
$plcdest="";
if(isset($_POST['receipt'])){
	$plcrecipt = $_POST['receipt'];
}
if(isset($_POST['destination'])){
	$plcdest = $_POST['destination'];
}
$reponse = $bdd->prepare("SELECT DISTINCT placeofreceipt FROM sailings WHERE portofloading like ? ORDER BY placeofreceipt ");
 $reponse->execute(array('%'.$plcdest.'%'));
 
$dest = $bdd->prepare("SELECT DISTINCT portofloading FROM sailings WHERE placeofreceipt like ? ORDER BY portofloading");
$dest->execute(array('%'.$plcrecipt.'%'));

$mailselect = $bdd->prepare("SELECT mail from entreprise");
$mailselect->execute();
$mailselectRow = $mailselect->fetch();
?>
<!-- <div class="container recherches" id="global_container_recherches"> -->
	<div class="row global">
        <div class="col-md-9 prtie_gauche " >
				 	<div class="card partieune">
				 		<div class="titres">
				 		<h3 class="card-title">Sailings filter</h3>
				 		<h6 class="card-title sous_titre_un">Search for a Place of Receipt or Destination to see results .</h6>
				 		</div>
				 		<div class="t_recherches">
						<form method="post" action="" >
							 	<div class="row">
						  			<div class="col-md-5" >
									 	<p>
									    	<label for="pays">Place of receipt :</label><br />
												<select name="receipt" autocomplete="on" onchange="this.form.submit()" class="form-control" >
													<option value=""autocomplete="on" selected></option></br>
													<?php	

													while ($donnees = $reponse->fetch())
													{

														?>
														<option value="<?php echo $donnees['placeofreceipt']; ?>" 
															<?php
															if ($donnees['placeofreceipt']==$plcrecipt) {
																echo "selected";
															}

															?>
															>
															<?php echo $donnees['placeofreceipt'] ?>
														</option>
														<?php 
													}
													
													$reponse->closeCursor();
													?>
												</select>
										</p>
									</div>
									<div class="col-md-2" >
									</div>

						      		<div class="col-md-5" >
										<p>
									    	<label for="pays">Port of loading  :</label><br />
												<select name="destination" autocomplete="on" class="form-control" onchange="this.form.submit()">
													<option value="" selected></option></br>
													<?php	

													while ($don = $dest->fetch())
													{

														?>
														<option value="<?php echo $don['portofloading']; ?>"
															<?php 
																if ( $don['portofloading']==$plcdest) {
																	echo "selected";
																}

															?>
															>
															<?php echo $don['portofloading'] ; ?>
														</option>
														<?php 
													}
													
													$dest->closeCursor();
													?>
												</select>
										</p>
									</div>
							 	</div>
						</form>
					</div>
				</div>
<!-- </div> -->
<!-- <div class="container resultats" id="global_container_resultats"> -->
			<div class="card partiedeux">
			 	<div class="card-body tableauresultats" style="overflow: auto;">
					<?php
					

					$limite = 20;
					$page = (!empty($_GET['page']) ? $_GET['page'] : 1);
					$debut = ($page - 1) * $limite;
					
/*ajoutour requete */$resultFoundRows = $bdd->prepare('SELECT count(id) as nbr FROM `sailings` WHERE placeofreceipt like ? AND portofloading like ?');
					$resultFoundRows->bindValue('debut', $debut, PDO::PARAM_INT);
					$resultFoundRows->bindValue('limite', $limite, PDO::PARAM_INT);
					$resultFoundRows->execute(array('%' . $plcrecipt . '%', '%' . $plcdest . '%'));
					$nombredElementsTotal = $resultFoundRows->fetchColumn();

					$debut = ($page - 1) * $limite;

					$reponse = $bdd->prepare('SELECT * FROM sailings WHERE placeofreceipt like ? AND portofloading like ? limit 20');


/*ajoutour requete */ $reponse->bindValue('debut', $debut, PDO::PARAM_INT);
					$reponse->bindValue('limite', $limite, PDO::PARAM_INT);

					$reponse->execute(array('%' . $plcrecipt . '%', '%' . $plcdest . '%'));
//$nombredElementsTotal = $reponse->fetchColumn();
echo $nombredElementsTotal . ' Rows data.';
					?>
				<table class="table">
			        <thead class="  xxx">
			          <tr>
					           <th>Place of Receipt</th>
					           <th>Port of Loading</th>
					           <th>Routing via</th>
					           <th>Vessel</th>
					           <th>CFS cut-off</th>
					           <th>ETD</th>
					           <th>ETA</th>
					           <th>Transit time</th>
					       </tr>
					   </thead>
					 
					   <tbody> <!-- Corps du tableau -->
							<?php
							while ($donnees = $reponse->fetch())
							{
							?>
							<tr>
							   <td><?php echo $donnees['placeofreceipt']; ?></td>
							   <td><?php echo $donnees['portofloading']; ?></td> <!-- ajouté -->
							   <td><?php echo $donnees['routingvia']; ?></td>				  
							   <td><?php echo $donnees['vessel']; ?></td>
							   <td><?php echo $donnees['cfscutoff']; ?></td>
							   <td><?php echo $donnees['etd']; ?></td>
							   <td><?php echo $donnees['eta']; ?></td>
							   <td><?php echo $donnees['transittime']; ?></td>
							</tr>    
							<?php
							}
							$reponse->closeCursor(); // Termine le traitement de la requête
							?>
					   </tbody>
					</table>
				</div>
			</div>
			<div class="card partietrois">
			 	<div class="card-body pagination">
					<?php
					$nombreDePages = ceil($nombredElementsTotal / $limite);
					 if ($page > 1):
					    ?><a href="?page=<?php echo $page - 1; ?>" classe="gauche" ><i class="fas fa-chevron-left "></i></a> <?php
					endif;
					echo $page  . ' of ' . $nombreDePages . ' pages';
					/*for ($i = 1; $i <= $nombreDePages; $i++):
					    ?><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a> <?php
					endfor;*/
					if ($page < $nombreDePages):
					    ?> <a href="?page=<?php echo $page + 1; ?>" classe="droite" ><i class="fas fa-chevron-right "></i></a><?php
					endif;?>
				</div>
			</div>



	</div>
	
		<div class="col-md-3 ">
			<div class="card partieune">
				<h3 class="card-title book">Booking request</h3>
				<div class="card-body ">
					<form action="" method="post">
						<div class="form-group">
					    	<label for="expediteur">Sender :</label>
					    	<input type="text" name="expediteur" class="form-control" id="expediteur" required>
					  	</div>
					  	<div class="form-group">
					    	<label for="Navire">Vessel :</label>
					    	<input type="text" name="Navire" class="form-control" id="Navire" required>
					  	</div>
					  	<div class="form-group">
					    	<label for="datea">Expected arrival date :</label>
					    	<input type="date" name="datea" class="form-control" id="datea" required>
					  	</div>
					  	<div class="form-group">
					    	<label for="portchargement">Loading port :</label>
					    	<input type="text" name="portchargement" class="form-control" id="portchargement" required>
					  	</div>
					  	<div class="form-group">
					    	<label for="portdechargement">Unloading port :</label>
					    	<input type="text" name="portdechargement" class="form-control" id="portdechargement" required>
					  	</div>
					  	<div class="form-group">
					    	<label for="colis">Parcel :</label>
					    	<input type="text" name="colis" class="form-control" id="colis" required>
					  	</div>
					  	<div class="form-group">
					    	<label for="poids">Weight :</label>
					    	<input type="text" name="poids" class="form-control" id="poids" required>
					  	</div>
					  	<div class="form-group">
					    	<label for="volume">Volume :</label>
					    	<input type="text" name="volume" class="form-control" id="volume" required>
					  	</div>
					  		<label >Dangerous ?</label>
					  	<div class="form-check form-check-inline">

						<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Yes" required>
						<label class="form-check-label" for="inlineRadio1">Yes</label>
						</div>
						<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="No" required>
						<label class="form-check-label" for="inlineRadio2">No</label>
						</div>
					    <div class="form-group">
					    	<label for="mail">Mail address :</label>
					    	<input type="email" name="mail" class="form-control" id="mail" aria-describedby="emailHelp" required>
					  	</div>	
					  	<div class="form-group">
					    	<label for="tel">Phone number :</label>
					    	<input type="tel" name="tel" class="form-control" id="tel" required>
					  	</div>
					  	<button type="submit" class="btn btn-info form-control" name="demande">Send</button>
					</form>
				</div>
			</div>
		</div>
	</div>
<!-- </div> -->
  <?php
    if(isset($_POST['demande'])){
        $entete  = 'MIME-Version: 1.0' . "\r\n";
        $entete .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $entete .= 'From: contact@rmarcadet.com' . "\r\n";
        
        $message = '<h3>Demande of booking</h3>';
        $message .= '<p> <b>Email : </b>' . $_POST['mail'] . '</p>';
        $message .= '<p> <b>Phone number : </b>' . $_POST['tel'] . '</p>';
        $message .= '<p> <b>Sender : </b>' . $_POST['expediteur'] . '</p>';
        $message .= '<p> <b>Ship : </b>' . $_POST['Navire'] . '</p>';
        $message .= '<p> <b>Expected arrival date : </b>' . $_POST['data'] . '</p>';
        $message .= '<p> <b>Ship : </b>' . $_POST['Navire'] . '</p>';
        $message .= '<p> <b>Loading port : </b>' . $_POST['portchargement'] . '</p>';
        $message .= '<p> <b>Unloading port : </b>' . $_POST['portdechargement'] . '</p>';
        $message .= '<p> <b>Parcel : </b>' . $_POST['colis'] . '</p>';
        $message .= '<p> <b>Weight : </b>' . $_POST['poids'] . '</p>';
        $message .= '<p> <b>Volume : </b>' . $_POST['volume'] . '</p>';        
        $message .= '<p> <b>Dangerous : </b>' . $_POST['inlineRadioOptions'] . '</p>';           
        $retour = mail($mailselectRow['mail'], 'Sailing Contact Page', $message, $entete);
        if($retour) {
            echo '<p>Votre message a bien été envoyé.</p>';
        }
    }
    ?>
</body>
</html>
