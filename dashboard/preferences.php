<?php
$errorMsg = "";
if (isset($_GET['failure-code'])) {
    switch ($_GET['failure-code']) {
        case 1:
            $errorMsg = "File is not an image.";
            break;
        
        case 2:
            $errorMsg = "Sorry, file already exists.";
            break;
        
        case 3:
            $errorMsg = "Sorry, your file is too large.";
            break;
        
        case 4:
            $errorMsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            break;
        
        case 5:
            $errorMsg = "You need to fill out the subject and body of your post.";
        break;

        case 6:
            $errorMsg = "No image Selected.";
        break;

        default:
            $errorMsg = "Sorry, something went wrong please try later.";
            break;
    }
}

if (isset($_GET['success'])=== true) {
    $errorMsg = "Success, your profile was updated.";
}
?>

<div id="preferences">
    
    <h3>Preferences</h3>
    <h3><?php echo $errorMsg;?></h3>
    <img id="preferences-picture" src="<?php echo $_SESSION['profile-picture']; ?>" alt="">
    <h4>Change your profile picture</h4>
    <form action="<?php echo htmlspecialchars("../src/verify.php");?>" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="">
        <input type="hidden" name="profile-picture-upload">
        <button type="submit">Submit</button>
    </form>
    <form action="<?php echo htmlspecialchars("../src/verify.php");?>" method="post">
        <h4>Change Password</h4>
        Current Password
        <input type="password" name="current-password" id="">
        New Password
    <input type="password" name="password" id="sign-up-password" required>
    Confirm Password
    <input type="password" name="password-verify" id="sign-up-password-check" required>
    <input type="hidden" name="change-pass" id="change-pass" value="true">
    <p id="pass-match"></p>
    <button id="sign-up-submit" type="submit" name="sign-up-submit">Submit</button>
    </form>
    <form action="<?php echo htmlspecialchars("../src/verify.php");?>" method="post">
        <h4>Delete Account</h4>
        <button id="delete-accounnt" type="submit">Delete</button>
    </form>
</div>
<div id="myModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Woah!!!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete?</p>
      </div>
      <div class="modal-footer">
        <button id="confirm-delete" type="button" class="btn btn-primary">Delete</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>