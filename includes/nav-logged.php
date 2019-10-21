   <!-- PAGE INFO -->

   <!-- This page is for any code contained in the navbar -->

   <nav class="navbar navbar-expand-lg navbar-light bg-light">
     <a class="navbar-brand" href="#">Biohomie</a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
       aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
       <span class="navbar-toggler-icon"></span>
     </button>

     <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <ul class="navbar-nav mr-auto">
         <!-- <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li> -->
         <li class="nav-item dropdown">
           <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
             aria-haspopup="true" aria-expanded="false">
             Actions
           </a>
           <div class="dropdown-menu" aria-labelledby="navbarDropdown">
             <a class="dropdown-item" href="#">Preferences</a>
             <a class="dropdown-item" href="#">Creat New Post</a>
             <div class="dropdown-divider"></div>
             <form id="logged-nav" class="form-inline my-2 my-lg-0" method="post"
               action="<?php echo htmlspecialchars("../src/verify.php");?>">
               <input type="hidden" name="logout">
               <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Log Out</button>
             </form>
           </div>
         </li>
       </ul>
       <?php echo $_SESSION["username"]; ?>

     </div>
   </nav>