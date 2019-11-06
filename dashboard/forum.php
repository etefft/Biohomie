<?php
$containsPosts = false;

$retrievePosts = new Posting();
$retrievePosts->getPublicPosts(0, 100);
?>

<div id="forum-main" class="dash-left">
<div class="post">
    
<?php

    if ($containsPosts) {
        
        
    }

?>

    <button id="more-posts">More</button>
</div>

</div>