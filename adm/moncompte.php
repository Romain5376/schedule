<main class="page-content">
	<?php
	include('db.php');
	include('header.php');

	function updateParaMail($id)
	{
		$bdd = getdbx();
		$req = $bdd->prepare('UPDATE entreprise SET name = :nvname, login = :nvlogin,  password = :nvpassword, mail = :nvmail WHERE id = :nvid ');
		$req->execute(array(
			'nvname' => $_POST['name'],
			'nvlogin' => $_POST['login'],
			'nvpassword' => $_POST['password'],
			'nvmail' => $_POST['mail'],
			'nvid' => $id
		));
	}
	/*try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=projets_pro_mk;charset=utf8', 'root', '');
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}*/
	// 7imaya 
	if (isset($_POST['name'])) {
		$_POST['name'] = htmlspecialchars($_POST['name']);
	}


	if (isset($_POST['login'])) {
		$_POST['login'] = htmlspecialchars($_POST['login']);
	}
	if (isset($_POST['password'])) {
		$_POST['password'] = htmlspecialchars($_POST['password']);
	}
	if (isset($_POST['mail'])) {
		$_POST['mail'] = htmlspecialchars($_POST['mail']);
	}
	if (isset($_POST['btnUpdatemail'])) {
		//echo $_POST['id'];
		updateParaMail($_POST['id']);
	}


	function getParamMail()
	{
		$bdd = getdbx();
		$req = $bdd->prepare('SELECT * FROM entreprise ');
		$req->execute();
		$row = $req->fetch();
		return $row;
	}

	$paramEmail = getParamMail();
	?>


	<form action="" method="post">
		<input type="hidden" name="id" value="<?php echo $paramEmail['id'] ?>" />
		<h1>Gestion du compte:</h1>
		<div class="row">
			<div class="col-md-12">
				<label for="mail">Mail address:</label>
				<input type="email" name="mail" class="form-control" id="mail" aria-describedby="emailHelp" value="<?php echo $paramEmail['mail'] ?>" required>
			</div>
			<div class="col-md-12">
				<label for="Password">Password:</label>
				<input type="password" name="password" class="form-control" id="Password" value="<?php echo $paramEmail['password'] ?>" required>
			</div>
			<div class="col-md-3 ml-auto mr-auto ">
				<button type="submit" class="btn valid" name="btnUpdatemail">Mettre à jour</button>
			</div>
		</div>
	</form>
</main>