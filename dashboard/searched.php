<?php

if (isset($_GET['search-forum'])) {
    $search_query = str_replace(',', ' ', strtolower($_GET['search-forum']));
    $search_function = new Search();
    $search_function->searchDB($search_query);

} 

// $retrievePosts = new Posting();
// $retrievePosts->getPublicPosts(0, 100, false);
?>

<div id="forum-main" class="dash-left">
<div class="post">
    <button id="more-posts">More</button>
</div>

</div>
</div>