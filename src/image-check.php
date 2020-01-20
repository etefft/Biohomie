<?php
$target_dir = "../images/";

foreach ($_FILES['fileToUpload']['tmp_name'] as $key => $tmp_name) {
$target_file = $target_dir . time(). "_" . time() * 2 . basename($_FILES["fileToUpload"]["name"][$key]);
$target_file = trim(preg_replace('/\s+/', ' ', $target_file));
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is an actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$key]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $errorMsg = 1;
        $uploadOk = 0;
    }
}
// Check if file already exists
// if (file_exists($target_file)) {
//     $errorMsg = 2;
//     $uploadOk = 0;
// }
// Check file size
// if ($_FILES["fileToUpload"]["size"] > 500000) {
//     $errorMsg = 3;
//     $uploadOk = 0;
// }
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $errorMsg = 4;
    $uploadOk = 0;
    echo "fail";
}
// if everything is ok, try to upload file
if ($uploadOk === 1) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$key], $target_file)) {
        $url_images[$key] = "$target_file";
        // echo "The file ". basename( $_FILES["fileToUpload"]["name"][$key]). " has been uploaded.";
    } 
}

}
    