<div id="create-post" class="dash-left">
    <form action="<?php echo APP_ROOT . '/src/verify.php' ?>" method="post">
        Subject
        <input type="text" name="subject-post" id="">
        Body
        <textarea name="body-post" id="" cols="30" rows="10"></textarea>
        <input type="hidden" name="new-post">
        <button type="submit">Post</button>
    </form>
</div>