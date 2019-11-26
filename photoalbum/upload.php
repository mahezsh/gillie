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
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;
use Aws\S3\Model\MultipartUpload\UploadBuilder;

$s3_client = new S3Client([
    'version' => 'latest',
    'region' => 'ap-southeast-2']);

    $bucket = "s3gilliebucket";
    $key = $_FILES["photoUpload"]["name"];

if (isset($_POST['submit'])) {
    $uploadDir = '/var/www/html/gillie/uploads/';
    $uploadFile = $uploadDir . basename($_FILES['photoUploadField']['name']);

    $is_file_uploaded = move_uploaded_file($_FILES['photoUploadField']['tmp_name'], $uploadFile);

    if ($is_file_uploaded) {
        $uploader = new MultipartUploader(
            $s3_client,
            dirname(__FILE__) . '/uploads/' . basename($_FILES['photoUploadField']['name']),
            ['bucket' => 'gillie-bucket', 'key' => basename($_FILES['photoUploadField']['name'])]);
        try {
            $result = $uploader->upload();
        } catch (S3Exception $e) {
        }
    }

    $DBConnect = @mysqli_connect("gillie-db.c1x7jt5kkcd5.ap-southeast-2.rds.amazonaws.com", "master","master123", "gilliedb")
    Or die ("<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysqli_connect_errno() . ": " . mysqli_connect_error()) . "</p>";

    $title = $_POST['title'];
    $description = $_POST['description'];
      $date = $_POST['date'];
      $keyword = $_POST['keywords'];
      $url = "http://d3fdfky3hoojcv.cloudfront.net/" . $key;

    $SQLstring = "INSERT INTO photos (photo_title,description,date_of_photo,keywords,reference)
         VALUES ('" . $title . "','" . $description . "','" . $date . "','" . $keyword . "','" . $url . "')";


    $queryResult = @mysqli_query($DBConnect, $SQLstring)
      Or die ("<p>Unable to query the photos table.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect)) . "</p>";

    echo "<p style='color: green'>Added Successfully.</p>";

    mysqli_close($DBConnect);

}
?>
</body>
</html>
