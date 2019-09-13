<?php
require 'connection.php';
// include 'pagination.php';
include 'fetchImage.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style type="text/css">
    body {
    font-family: sans-serif;
}
#container 
{
    background: #FFFFFF;
    max-width: 1400px;
}
.item {
    width: 200px;
    float: left;
}
.item img {
    display: block;
    width: 100%;
}
button {
    font-size: 18px;
}
.container{
    width:100%;
}
    </style>
</head>
<body>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<script>
  $(function () {

var $container = $('#container').masonry({
    itemSelector: '.item',
    columnWidth: 200
});

// reveal initial images
$container.masonryImagesReveal($('#images').find('.item'));
});

$.fn.masonryImagesReveal = function ($items) {
var msnry = this.data('masonry');
var itemSelector = msnry.options.itemSelector;
// hide by default
$items.hide();
// append to container
this.append($items);
$items.imagesLoaded().progress(function (imgLoad, image) {
    // get item
    // image is imagesLoaded class, not <img>, <img> is image.img
    var $item = $(image.img).parents(itemSelector);
    // un-hide item
    $item.show();
    // masonry does its thing
    msnry.appended($item);
});

return this;
};
</script>
<div class="container">
<h1>My Gallery</h1>

<div id="container"></div>
<div id="images">
    <!-- <div class="item"> -->
       <?php 
       $images = fetchImage($link);
        foreach($images as $image)
        {
            echo "<div class='item'>";
            echo "<img src='images/{$image['path']}'>";
            echo "</div>";
        }?>
    <!-- </div> -->
    
</div>
<p>
    <button id="load-images">Load images</button>
    
    <script src="//masonry.desandro.com/masonry.pkgd.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.0.4/jquery.imagesloaded.js"></script>
    
    
    
    </div>
    
</p>
</body>
</html>