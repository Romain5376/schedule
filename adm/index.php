<main class="page-content">
<?php

include('db.php');
include('header.php');

$db = getdbx();
if(isset($_GET['delete'])){  
   $reqSelect = $db->prepare("DELETE FROM `sailings` WHERE FileName=?");
   $reqSelect->execute(array($_GET['delete']));
   echo ('<div class="alert alert-success" role="alert"> File successfully deleted ! </div>');
   ?>
   <script>   
      window.location.href = "index.php"
   </script>
   <?php
}
if(isset($_FILES['file'])){
   $file_name = $_FILES['file']['name'];

   $file_size =$_FILES['file']['size'];

   $file_tmp =$_FILES['file']['tmp_name'];

   $file_type=$_FILES['file']['type'];

   $file_arr_ext = explode('.',$_FILES['file']['name']);
   
   $endFile=end($file_arr_ext);

   $file_ext=strtolower($endFile);

   $extensions= array("csv");
   
   if(in_array($file_ext,$extensions)=== false){
      $errors="extension not allowed, please choose a csv file.";
   }

   if($file_size > 11097152){
      $errors='File size must be excately 10 MB';
   }

   $reqSelectdata = $db->prepare("SELECT count(*) nbr FROM `sailings` WHERE FileName=?");
   $reqSelectdata->execute(array($file_name));
   $rowdata = $reqSelectdata->fetch();
   if($rowdata['nbr']>0){
      echo ('<div class="alert alert-danger" role="alert">File alerdy existe in database : '. $file_name . '</div>');
   }elseif(empty($errors)==true){

      if ($file_size > 0) {

         $file = fopen($file_tmp, "r");
         $data = array(); 

         $idx= 0 ;
         while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            if($idx!=0)
            {
               $data = "('$column[0]', '$column[1]', '$column[2]', '$column[3]', '$column[4]', '$column[5]', '$column[6]', '$column[7]', '$file_name')";
               $query = "INSERT INTO `sailings` (`placeofreceipt`, `portofloading`, `routingvia`, `vessel`, `cfscutoff`, `etd`, `eta`, `transittime`, `filename`)  VALUES " . $data ;
               $req = $db->prepare($query);
               $req->execute();
                   //echo $query;
               if (! empty($insertId)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
             } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
             }
          }
          $idx++;

       }
    }
    if( $_FILES['file']['error'] == 0)
    { echo ('<div class="alert alert-success" role="alert"> File successfully imported ! </div>');
    }else{
         echo ('<div class="alert alert-danger" role="alert"> File ERROR : ' .  $_FILES['file']['error'] . ' </div>');
    }
}else{
   echo ('<div class="alert alert-warning" role="alert">' . $errors . '</div>');
}
}
?>
<div id="loaddata">
   <script>
      function SetUpload(){
         var imgloaddata = document.getElementById('imgloaddata');
         var loaddata = document.getElementById('loaddata');
         loaddata.style.display="none";
         imgloaddata.style.display="";
      }
   </script>

   <form action="" method="POST" enctype="multipart/form-data" class="row">
    <div class="col-md-8">
      <input type="file" name="file" class="form-control btn btn-primary" style="background-color: #19488d" />
    </div>
    <div class="col-md-4">
      <input class="form-control btn btn-primary" type="submit" onclick="SetUpload()" style="height: 44px;background: #19488d" />
    </div>   
      
   </form>

   <table class="table">
      <thead>
         <tr>
            <th>File Name</th>
            <th>Number of Lines</th>
            <th>Delete</th>
         </tr>
      </thead>
      <tbody>
         <?php 
         $reqSelect = $db->prepare("SELECT DISTINCT(`filename`), COUNT(*) as nbr FROM `sailings` group by `filename`");
         $reqSelect->execute();

         while ($row = $reqSelect->fetch()){
            ?>
            <tr>
               <td><?= $row['filename']?></td>
               <td><?= $row['nbr']?></td>
               <td><a style="color: #19488d" href="index.php?delete=<?= $row['filename'] ?>">Delete</a></td>
            </tr>
            <?php
         }
         ?>
      </tbody>
   </table>
</div>
<div id="imgloaddata" style="text-align: center;margin-top: 250px;color: gray;display: none;">
   <h3 style="text-align: center;">Data is loading from CSV file</h3>
   <img src="load.gif"/>
</div>