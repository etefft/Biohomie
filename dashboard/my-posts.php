<?php
$containsPosts = false;
$amount_posts = '';
if (isset($_GET['amount'])) {
    if ($_GET['amount'] > 1000) {
        $amount_posts = 2000;
    } else {
        $amount_posts = 20 + $_GET['amount'];
    }
} else {
    $amount_posts = 20;
}
$retrievePosts = new Posting();
$retrievePosts->getUserPosts(0, $amount_posts);
?>

<div id="forum-main" class="dash-left">
<div class="post">
    
<?php

    if ($containsPosts) {
        
        
    }

?>

<form id="more-button" action="index.php#post-<?php echo $amount_posts;?>" method="get">
    <input type="hidden" name="dash" value="my-posts">
    <input type="hidden" name="amount" value="<?php echo $amount_posts; ?>">
    <button id="more-posts" type="submit">More</button>
</form>
</div>

</div>
</div>