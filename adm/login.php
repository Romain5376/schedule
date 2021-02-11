<!DOCTYPE html>
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
        <link rel="stylesheet" type="text/css" href="public/css/style.css">
        <script type="text/javascript" src="public/js/function.js"></script>
    </head>
<?php
if(session_status()!=2)
{
	session_start();
}
include("db.php");
$error = "";
if(isset($_SESSION['user']) && isset($_SESSION['user']['id'])){

    ?>
    <script type="text/javascript">
        window.location.replace('index.php');
    </script>
    <?php
}
if(isset($_POST['connexion'])){
    if(!empty($_POST['username']) AND !empty($_POST['password']) ){
        $username = trim(htmlspecialchars($_POST['username']));
        $password = htmlspecialchars($_POST['password']);
 
        $db= getdbx();
        $req = $db->prepare("SELECT * FROM entreprise WHERE mail=? AND password=?" );
        $req->execute(array($username,$password));
        if($req->rowCount() == 1){
            $user = $req->fetch();
            $_SESSION['user']= $user;            
            ?>
            <script type="text/javascript">
                window.location.replace('index.php');
            </script>
            <?php
        }else{
            $error="L'identifiant ou le mot de passe est incorrect";
        }
        
    }else{
        $error="Merci de remplir tous les champs";
    }
}
?>
<body class="content">
    <div id="main">
       <?php   if(isset($error) AND !empty($error)){
        echo '<div style="text-align:center;" class="alert alert-danger" role="alert">' . $error . '</div>';
    }?>

    <div style="width: 400px;margin: auto;margin-top: 20px;background: #19488d;">

	    <h2 style="text-align: center;color: white;">Login</h2>
	    <form method="POST" action="">
	        <table class="table" >

	            <tr>
	                <td><input style="border: 0;" type="mail" placeholder="E-mail" name="username"class="form-control" required=""/></td>
	            </tr>
	            <tr>
	                <td><input style="border: 0;" type="password" placeholder="Password" name="password"class="form-control" required=""/></td>
	            </tr>
	            <tr>

	                <td style="text-align: left;"><input style="background-color: #aebac5;" type="submit"  name="connexion" class="btn btn-light form-control" value="Connexion "/></td>
	            </tr>
	        </table>
	        
	    </form>
	</div>
</div>
</body>
