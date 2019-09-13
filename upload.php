<?php

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
            $time= date("Y-m-d",time());
            $query = "INSERT INTO `photos`(userId,path,year) VALUES('{$_SESSION['ID']}','{$_FILES['fileToUpload']['name']}','$time')";
            
            if($link->query($query))
            {
                echo "<p>Database updated</p>";
            }
            else {
                die ($link->error);
            }
        }

?>

