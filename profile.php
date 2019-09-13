<?php
require 'connection.php';
include 'header.php';
if(empty($_SESSION['is_loggedin']))
{
    header("location: .");
}

if(isset($_POST['submit']))
{
    
$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "<p>File is an image - " . $check["mime"] . ".</p>";
        $uploadOk = 1;
    } else {
        echo "<p>File is not an image.</p>";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "<p>Sorry, file already exists.</p>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "<p>Sorry, your file is too large.</p>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "<p>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "<p>Sorry, your file was not uploaded.</p>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<p>The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.</p>";
    } else {
        echo "<p>Sorry, there was an error uploading your file.</p>";
    }
    $time= date("Y",time());
    $query = "INSERT INTO `photos`(id,path,year) VALUES('{$_SESSION['ID']}','{$_FILES['fileToUpload']['name']}','$time')";
    
    if($link->query($query))
    {
        echo "<p>Database updated</p>";
    }
    else {
        die ($link->error);
    }
}
               
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
    body{
        background-image: url(./bg.jpg);
    }
    .inputfile {
	width: 0.1px;
	height: 0.1px;
	opacity: 0;
	/* overflow: hidden; */
	position: absolute;
	z-index: -1;
    }
    .inputfile {
    font-size: 1.25em;
    font-weight: 700;
    color: black;
    background-color: #F0DD11;
    display: inline-block;
    margin: 1% 40% 0.5% 48.5%;
}

/* .inputfile:focus 
.inputfile :hover {
    background-color: #208838;
} */
.inputfile {
	cursor: pointer; /* "hand" cursor */
}
    /* #upload 
    {
        display:none;
    } */
    p{
        width:500px;height:10px;color:white;font-size:20px;font-weight:bold;
    }
    </style>
   
</head>
<body>
    <div>
    <p ></p>    
    </div>
    <div class="" id="outerDiv">
        
    </div>
    <form action="profile.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
    </form>
    <button onClick="window.location.href='pagination.php'">My Gallery</button>
    
    <button class="btn btn-success" id="logout" onClick="window.location.href='logout.php';">Logout</button>
   
</body>
</html>