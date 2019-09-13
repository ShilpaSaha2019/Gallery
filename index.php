<?php
require 'connection.php';
include 'header.php';  

if(!empty($_SESSION['is_loggedin']))
{
    header("location: profile.php");
}
if(isset($_POST['submit']))
{
    $whiteList = ['email','password'];
    $errorFields = [];
    foreach($whiteList as $key)
    {
        if(!isset($_POST[$key]))
        {
            $errorFields[$key] = "{$key} is missing!";
        }
    }
    $errors = [];
    foreach($whiteList as $val)
    {
        if(!$_POST[$val])
        {
            $errors[$val] = 1;
        }
    }

    if(!empty($errors) || !empty($errorFields))
    {
        die("There is a problem in the form!");
    }
    else {
        $query = "SELECT * FROM `users` WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."'";
        $result = $link->query($query);
        if($result->num_rows>0)
        {
            $row = $result->fetch_assoc();
            $hashedPassword = md5(md5($row['id']).$_POST['password']);
            if($hashedPassword == $row['password'])
            {
                $_SESSION['ID']=$row['id'];
                $_SESSION['is_loggedin'] = true;
                header("locatin:profile.php");
            }
            else {
                $errors['errPass'] = 1;
            }
        }
        else {
            $errors['errUser']=1;
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
    <title>Login</title>
    
</head>
<body>
<div class="main-div">
<form method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email"
    value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
    
    <?php 
    if(!empty($errorFields['email']))
    {
        ?>
        <div class="alert alert-danger" role="alert">
        <?php
        echo $errorFields['email'];?>
        </div>
    <?php }?>
    <?php 
    if(!empty($errors['email']))
    {
        ?>
        <div class="alert alert-danger" role="alert">
        <?php
        echo "Email can not be empty!!";
        ?>
        </div>
    <?php }?>
    
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password"
    value="<?php if(isset($_POST['password'])){echo $_POST['password'];} ?>">
    
    <?php 
    if(!empty($errorFields['password']))
    {
        ?>
        <div class="alert alert-danger" role="alert">
        <?php
        echo $errorFields['password'];
        ?>
        </div>
        <?php
    }?>
    <?php 
    if(!empty($errors['password']))
    {
        ?>
        <div class="alert alert-danger" role="alert">
        <?php
        echo "Password can not be empty!!";
        ?>
        </div>
    <?php }?>
    <?php 
    if(!empty($errors['errPass']))
    {
        ?>
        <div class="alert alert-danger" role="alert">
        <?php
        echo "Password is wrong!!";
        ?>
        </div>
    <?php }?>
    <?php 
    if(!empty($errors['errUser']))
    {
        ?>
        <div class="alert alert-danger" role="alert">
        <?php
        echo "User not found!!";
        ?>
        </div>
    <?php }?>
    
  </div>
  <!-- <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me </label>
  </div> -->
  <button type="submit" class="btn btn-primary" name="submit">Log In</button>
  <a href="register.php">Not Registered? Click to register!!</a>
</form>
</div>
</body>
</html>