<?php


function fetchImage($link)
{
    $query="SELECT * FROM `photos` WHERE userId='{$_SESSION['ID']}'";

    if($link->query($query))
    {
        $result = $link->query($query);
        // if($result->num_rows){
        // return (mysqli_result($query, 0) == 1) ? true : false;
        // }
        $rows = [];
        while($row = $result->fetch_assoc())
        {
            $rows[] = $row;
        }
        return $rows;
    }
    else 
    {
        die($link->error);
    }
}

function deleteImage($imageId,$link){
    $query = "DELETE FROM `photos` WHERE id='$imageId'";

    if($link->query($query))
    {
        header("location:profile.php");
    }
    else {
        die($link->error);
    }
}
