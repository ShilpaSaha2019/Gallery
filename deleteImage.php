<?php
require 'connection.php';
require 'fetchImage.php';
$imageId=base64_decode($_GET['imageId']);
deleteImage($imageId,$link);
