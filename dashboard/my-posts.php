<div class="dash-left">
<div class="post">
    <?php
    
        if (isset($post)) {
            if ($post) {
                echo 'Your post was successfully created!';
            } else {
                echo 'Their was an issue with your post.';
            }
        }
        
     ?>
</div>

</div>