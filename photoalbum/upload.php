<html>
<head>
    <title>Photo Uploader</title>
    <style>
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
<H1>Photo Uploader</H1>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <label class="bold">Photo Title:</label> <input type="text" name="title"><br><br>
        <label class="bold">Select a photo:</label> <input type="file" name="fileToUpload" id="fileToUpload"><br><br>
        <label class="bold">Description:</label> <input type="text" name="description"><br><br>
        <label class="bold">Date:</label> <input type="text" name="date"><br><br>
        <label class="bold">Keywords (separated by a semicolon, e.g. keyword1; keyword2; etc.):<label><br> <input
                        type="text" name="keywords"><br><br>
                <input type="submit" value="Upload" name="submit">
    </fieldset>
</form>

<a href="./getphotos.php">Photo Album</a> <br/><br/>


<?php

require dirname(__FILE__) . '/../aws/aws-autoloader.php';

use Aws\S3\S3Client;
use Aws\S3\MultipartUploader;
use Aws\Common\Exception\S3Exception;

$s3_client = new S3Client([
    'version' => 'latest',
    'region' => 'ap-southeast-2']);

if (isset($_POST['submit'])) {
    $uploadDir = '/var/www/html/gillie/uploads/';
    $uploadFile = $uploadDir . basename($_FILES['photoUploadField']['name']);

    $is_file_uploaded = move_uploaded_file($_FILES['photoUploadField']['tmp_name'], $uploadFile);

    if ($is_file_uploaded) {
        $uploader = new MultipartUploader(
            $s3_client,
            dirname(__FILE__) . '/uploads/' . basename($_FILES['photoUploadField']['name']),
            ['bucket' => 'photostore23', 'key' => basename($_FILES['photoUploadField']['name'])]);
        try {
            $result = $uploader->upload();
        } catch (S3Exception $e) {
        }
    }

    $DBConnect = @mysqli_connect("gillie-db.c1x7jt5kkcd5.ap-southeast-2.rds.amazonaws.com", "master","master123", "gilliedb")
    Or die ("<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysqli_connect_errno() . ": " . mysqli_connect_error()) . "</p>";

    //Insert data in the keywords table
    $keywords = array_map('trim', explode(';', $_POST['photoKeywordsField']));
    $SQLstring = "INSERT INTO keywords (photo_type,image_file_format,image_orientation,color)
         VALUES ('" . $keywords[0] . "','" . $keywords[1] . "','" . $keywords[2] . "','" . $keywords[3] . "')";

    $queryResult = @mysqli_query($DBConnect, $SQLstring)
    Or die ("<p>Unable to insert data in the keywords table.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect)) . "</p>";

    //Insert data in the photos table
    $photoReference = basename($_FILES['photoUploadField']['name']);
    $keyWordID = mysqli_insert_id($DBConnect);
    $SQLstring = "INSERT INTO photos (title,description,date_of_photo,reference, keyword_id)
         VALUES ('" . $_POST['photoTitleField'] . "','" . $_POST['photoDescriptionField'] . "','" . $_POST['photoDateField'] . "','" . $photoReference . "', '" . $keyWordID . "')";

    $queryResult = @mysqli_query($DBConnect, $SQLstring)
    Or die ("<p>Unable to insert data in the photos table.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect)) . "</p>";

    echo "<p style='color: green'>Photo has been added in the Album.</p>";


    mysqli_close($DBConnect);

}
?>
</body>
</html>
