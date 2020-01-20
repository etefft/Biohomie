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
            $errorMsg = "You need to fill out the subject and body of your post";
        break;

        default:
            $errorMsg = "Sorry, something went wrong please try later.";
            break;
    }
}

?>

<div id="create-post" class="dash-left">
    <form action="<?php echo APP_ROOT . '/src/verify.php' ?>" class="file-uploader" method="post" enctype="multipart/form-data">
    <h3><?php echo $errorMsg;?></h3>
        Subject
        <input type="text" name="subject-post" id="" required>
        Body
        <textarea name="body-post" id="" cols="30" rows="10" required></textarea>
        <input type="hidden" name="new-post">
        Enter up to 5 tag names separated by commas
        <input type="text" name="tag" id="">
        <div class="file-uploader__message-area">
            <p>Select a file to upload</p>
        </div>
        <div class="file-chooser">
            <input class="file-chooser__input" name="fileToUpload[]" type="file" multiple>
        </div>
        <input class="file-uploader__submit-button" type="submit" value="Upload">
    </form>
</div>