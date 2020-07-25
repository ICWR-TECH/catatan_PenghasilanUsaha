<?php
error_reporting(0);
session_start();
include 'config.php';
 ?>
 <!doctype html>
 <html lang="en">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
     <title>Catatan | Login</title>
   </head>
   <body class="container">
     <form class="form-group mt-5" action="" method="post">
       <label for="username"> <strong>Username</strong> </label>
       <input type="text" name="username" value="" placeholder="username" class="form-control" id="username" required>
       <br>
       <label for="password"> <strong>Password</strong> </label>
       <input type="password" name="password" value="" placeholder="password" class="form-control" id="password" required>
       <br>
       <input type="submit" name="submit" value="Submit" class="btn btn-primary">
     </form>
     <?php
     $user=mysqli_real_escape_string($conn,$_POST['username']);
     $pass=md5($_POST['password']);
     $q=mysqli_query($conn,"SELECT * FROM admin where BINARY username='$user' AND password='$pass'");
     if($_POST){
       if(mysqli_num_rows($q)<1){
         echo "Anda bukan admin!";
       }else {
         $_SESSION['status']=$user;
         header("location:dash.php");
       }
     }
      ?>
     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
   </body>
 </html>
