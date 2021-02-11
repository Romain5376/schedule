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

    if(!isset($_SESSION['user'])){
        ?>
        <script type="text/javascript">
            window.location.href = "login.php";
        </script>
        <?php
    }?>

    <h1 style="margin-bottom: 50px;text-align: center;">Gestion des CSV</h1>
    <body class="container">
        
        <div class="page-wrapper chiller-theme">
          <a id="show-sidebar" class="btn btn-sm btn-dark" href="#"style="background-color: #19488d">
            <i class="fas fa-bars"></i>
          </a>
          <nav id="sidebar" class="sidebar-wrapper" style="background-color: #19488d">
            <div class="sidebar-content" >
              <div class="sidebar-brand">
                <a href="#">Gestion des CSV</a>
                <div id="close-sidebar">
                  <i class="fas fa-times" style="background-color: #19488d"></i>
                </div>
              </div>
              <div class="sidebar-header">
                <div class="user-info">
                  <span class="user-name">
                    <strong> <?= $_SESSION['user']['name']; ?></strong>
                  </span>
                  
                  <span class="user-status">
                    <i class="fa fa-circle"></i>
                    <span>Online</span>
                  </span>
                </div>
              </div>
          
              <div class="sidebar-menu">
                <ul>
                  <li class="">
                    <a href="../index.php">
                      <i class="fa fa-calendar" style="background-color: #19488d"></i>
                      <span>Schedule page</span>
                       <!--<span class="badge badge-pill badge-warning">New</span> -->
                    </a>               
                  </li>
                  <li class="">
                    <a href="index.php">
                      <i class="fa fa-tachometer-alt" style="background-color: #19488d"></i>
                      <span>Liste des CSVs</span>
                       <!--<span class="badge badge-pill badge-warning">New</span> -->
                    </a>               
                  </li>
                  <li class="" >
                    <a href="moncompte.php" >
                      <i class="fa fa-shopping-cart" style="background-color: #19488d"></i>
                      <span>Mon Compte</span>                      
                    </a>
                  </li>
                   <li class="">
                    <a href="logout.php">
                      <i class="fas fa-sign-out-alt" style="background-color: #19488d"></i>
                      <span>Deconexion</span>
                       <!--<span class="badge badge-pill badge-warning">New</span> -->
                    </a>               
                  </li>
                </ul>
              </div>
              <!-- sidebar-menu  -->
            </div>
            <!-- sidebar-content  -->
            
          </nav>
          <!-- sidebar-wrapper  -->
          <!-- page-content" -->
        </div>