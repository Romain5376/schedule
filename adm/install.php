<?php
if(isset($_POST['submit'])){
$srv =  'mysql:host=' . $_POST['server'] . ';dbname=' . $_POST['database'] . ';charset=utf8';//, "'" . $_POST['userdb'] . "'", "'" . $_POST['passworddb'] . "'";

$db = new PDO( $srv ,  $_POST['userdb'] , $_POST['passworddb'] );

$reqcreate="DROP TABLE IF EXISTS `sailings`;
CREATE TABLE `sailings` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `placeofreceipt` varchar(250) DEFAULT NULL,
  `portofloading` varchar(250) DEFAULT NULL,
  `routingvia` varchar(50) DEFAULT NULL,
  `vessel` varchar(50) DEFAULT NULL,
  `cfscutoff` varchar(20) DEFAULT NULL,
  `etd` varchar(20) DEFAULT NULL,
  `eta` varchar(20) DEFAULT NULL,
  `transittime` varchar(24) DEFAULT NULL,
  `filename` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
);
DROP TABLE IF EXISTS `entreprise`;
CREATE TABLE `entreprise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200)  NULL,
  `login` varchar(200)  NULL,
  `password` varchar(200) NOT NULL,
  `mail` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
);
INSERT INTO `entreprise` (`mail`,`password`) VALUES ('". $_POST['email'] . "','" . $_POST['password'] . "'); ";

$reqSelect = $db->prepare($reqcreate);
$reqSelect->execute();

file_put_contents('config', $srv . "####" .  $_POST['userdb'] . "####" . $_POST['passworddb']);

$to      = $_POST['email'];
$subject = 'Sailings identifiers';
$message = 'Mail:' . $_POST['email'] . '\n Password: ' . $_POST['password'];
$headers = array(
    'From' => $_POST['email'],
    'X-Mailer' => 'PHP/' . phpversion()
);

mail($to, $subject, $message, $headers);

    ?>
    <script type="text/javascript">
        window.location.href = "login.php";
    </script>
    <?php
}
?>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
</head>
<body class="container">
	<h2>Installation</h2>
	<form action="" method="POST">
		<h3>Data Base Information</h3>
		<div class="form-group">
			<label for="server">Server Name</label>
			<input type="text" class="form-control" id="server" name="server" aria-describedby="emailHelp" placeholder="Enter Server Name" required>
		</div>
		<div class="form-group">
			<label for="database">DataBase Name</label>
			<input type="text" class="form-control" id="database" name="database" aria-describedby="emailHelp" placeholder="Enter DB Name" required>
		</div>
		<div class="form-group">
			<label for="userdb">DataBase UserName</label>
			<input type="text" class="form-control" id="userdb" name="userdb" aria-describedby="emailHelp" placeholder="Enter DB User Name" required>
		</div>
		<div class="form-group">
			<label for="passworddb">DataBase Password</label>
			<input type="text" class="form-control" id="passworddb" name="passworddb" aria-describedby="emailHelp" placeholder="Enter DB Password ">
		</div>
		<h3>Account Information</h3>
		<div class="form-group">
			<label for="exampleInputEmail1">Email Address to Login</label>
			<input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email">
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Your Password to Login</label>
			<input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Enter Password">
		</div>
		<button type="submit" class="btn btn-primary form-control" name="submit">Install</button>
	</form>
</body>
</html>