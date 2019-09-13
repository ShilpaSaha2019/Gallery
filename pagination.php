<?php  
//connect to database
require 'connection.php';

//define how many results you want per page
$results_per_page = 2;

//find number of results stored in database
$query = "SELECT * FROM `photos` WHERE id='{$_SESSION['ID']}'";
$result = $link->query($query);
$number_of_results = $result->num_rows;

//determine number of total pages available
$number_of_pages = ceil($number_of_results/$results_per_page);

//determine which page number visitor is currently on
if(!isset($_GET['page']))
{
    $page=1;
}
else {
    $page=$_GET['page'];
}
//style for the images
$style= "width: 100px; height: 100px; margin:5%; border:2px solid black";
//determine the sql LIMIT starting number for the results
$this_page_first_result = ($page -1)*$results_per_page;

//retrieve selected results from database
$query = "SELECT * FROM `photos` LIMIT ". $this_page_first_result.','.$results_per_page;
$result = $link->query($query);

//display results
while($row = $result->fetch_assoc())
{
    
    echo "<img src='images/{$row['path']}' style='{$style}'></img>";
    
}

//display links to the pages
echo "<div>";
for($page=1;$page<=$number_of_pages;$page++)
{
    
    echo "<a href='pagination.php?page=$page'>$page</a> ";
    
}
echo "</div>";
?>