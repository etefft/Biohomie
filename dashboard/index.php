<?php
    require("../src/dashboard.php");
    require("../includes/header.php");
?>
<section id="user-main">
    <?php require("dashboard-nav.php"); ?>
    <?php
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

<?php
require("../includes/footer.php");

?>