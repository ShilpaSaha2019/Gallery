<?php
require 'connection.php';
include 'header.php';
include 'fetchImage.php';
if(empty($_SESSION['is_loggedin']))
{
    header("location: .");
}

if(isset($_POST['submit']))
{
    include 'upload.php';

}
               

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <style>
        p{
        width:500px;height:10px;color:white;font-size:20px;font-weight:bold;
    }
    </style>
   
</head>
<body>
    <div class="" id="outerDiv">
    <table class="table">
        <thead class="thead-dark">
            <tr>
            <th scope="col">Name</th>
            <th scope="col">Display</th>
            <th scope="col">Date</th>
            <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $images =fetchImage($link);
        // print_r($images);
        foreach($images as $image)
        {
            echo "<tr>";
            echo "<td>{$image['path']}</td>";
            echo "<td><img src='images/{$image['path']}' class='img-thumbnail' height='42px' width='42px'></td>";
            echo "<td>{$image['year']}</td>";
            echo "<td><a href='deleteImage.php?imageId=".base64_encode($image['id'])."'>Delete</a></td>";
        }
        ?>
        </tbody>
    </table>
    </div>

    <div class="buttonDiv">
    <form action="profile.php" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
    </form>
    <button onClick="window.location.href='gallery.php'">My Gallery</button>
    <button class="btn btn-success" id="logout" onClick="window.location.href='logout.php';">Logout</button>
    </div>
</body>
</html>