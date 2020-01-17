<?php
    require("../src/dashboard.php");
    require("../includes/header.php");
?>
<section id="user-main">
    <?php require("dashboard-nav.php"); 
    if (isset($_GET['dash'])) {
        switch ($_GET['dash']) {
            case 'forum':
                require("forum.php");
                break;

            case 'post':
                require('create-post.php');
                break; 

            case 'my-posts':
                require('my-posts.php');
                break;
            
            case 'settings':
                require('settings.php');
                break;

            case 'post-success':
                $post = true;
                require('my-posts.php');
            break;

            case 'post-failure':
                $post = false;
                require('my-posts.php');
            break;                

            default:
                require("forum.php");
                break;
        }
    } elseif (isset($_GET['post'])) {
        require('post.php');
    } else {
        require("forum.php"); 
    }
    
    
    ?>
</section>
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
<?php
require("../includes/footer.php");

?>