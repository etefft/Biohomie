   <?php 
   $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        require( "$root/Biohomie/config/config.php" );
    ?>

   <!DOCTYPE html>
   <html lang="en">

   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <meta http-equiv="X-UA-Compatible" content="ie=edge">
       <title>BioHomie</title>
       <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
           integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
       <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
           integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
       </script> -->
       <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
           integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
       </script>
       <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
           integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
       </script>
       <link rel="stylesheet" href="<?php echo APP_ROOT . '/style/magnific-popup.css'?>">
        <!-- Magnific Popup core JS file -->
        <script src="<?php echo APP_ROOT . '/js/jquery.magnific-popup.js'?>"></script>
       <link rel="stylesheet" href="<?php echo APP_ROOT . '/style/main.css' ?>">
       <link rel="icon" href="<?php echo APP_ROOT . '/favicon.ico' ?>" type="image/x-icon" />
   </head>

   <body>
       <?php
require((isset($_SESSION["level"]) ? "nav-logged.php" : "nav.php"));
?>