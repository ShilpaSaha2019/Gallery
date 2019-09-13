<?php
require 'connection.php';
include 'header.php';
// if(!empty($_SESSION['is_loggedin']))
// {
//   header("location: profile.php");
// }
if(isset($_POST['submit']))
{
  $whiteList = ['email','password','conPassword'];
  $errosFields = [];
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
    if(empty($errorFields) && empty($errors))
    {
      if($_POST['email'] && !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$_POST['email']))
      {
        $errors['errEmail'] = "Email type invalid!!";
      }
      elseif($_POST['password'] && !preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#",$_POST['password']))
      {
        $errors['errPassword'] = "Password should contain at least one upper case, one lower case, one special character, at least 8 characters";
      }
      elseif($_POST['password'] != $_POST['conPassword'])
      {
        $errors['mismatchErr']= "Passwords do not match!!";
      }
      else 
      {
        $query ="SELECT id FROM `users` WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."'";
        $result = $link->query($query);
        if($result->num_rows>0)
        {
            $errors['already'] = "User already exists!!";
        }
        else
        {
          $stmt =$link->prepare("INSERT INTO users(email,password) VALUES(?,?)");
          $stmt->bind_param("ss",$_POST['email'],$_POST['password']);
          $stmt->execute() or die("There is a problem in data insertion!!");
          $idFetched = $link->insert_id;
          $query = "UPDATE `users` SET password='".md5(md5($idFetched).$_POST['password'])."' WHERE id='{$idFetched}' ";
          $link->query($query) or die("Error in password insertion!!");
            $_SESSION['ID']= $idFetched;
            $_SESSION['is_loggedin']=true;
            header("location: profile.php");
        }
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
    <title>Register</title>
</head>
<body>
<div class="main-div">
<form method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" 
    value="<?php if(isset($_POST['email'])){ echo $_POST['email'];}?>">
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
    <?php 
    if(!empty($errors['errEmail']))
    {
        ?>
        <div class="alert alert-danger" role="alert">
        <?php
        echo $errors['errEmail'];
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
    if(!empty($errors['errPassword']))
    {
        ?>
        <div class="alert alert-danger" role="alert">
        <?php
        echo $errors['errPassword'];
        ?>
        </div>
    <?php }?>

    <?php 
    if(!empty($errors['mismatchErr']))
    {
        ?>
        <div class="alert alert-danger" role="alert">
        <?php
        echo $errors['mismatchErr'];
        ?>
        </div>
    <?php }?>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Confirm Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="conPassword"
    value="<?php if(isset($_POST['conPassword'])){echo $_POST['conPassword'];} ?>">
    <?php 
    if(!empty($errorFields['conPassword']))
    {
        ?>
        <div class="alert alert-danger" role="alert">
        <?php
        echo $errorFields['conPassword'];
        ?>
        </div>
        <?php
    }?>
    <?php 
    if(!empty($errors['conPassword']))
    {
        ?>
        <div class="alert alert-danger" role="alert">
        <?php
        echo "Confirm Password can not be empty!!";
        ?>
        </div>
    <?php }?>
    <?php 
    if(!empty($errors['mismatchErr']))
    {
        ?>
        <div class="alert alert-danger" role="alert">
        <?php
        echo $errors['mismatchErr'];
        ?>
        </div>
    <?php }?>
    <?php 
    if(!empty($errors['already']))
    {
        ?>
        <div class="alert alert-danger" role="alert">
        <?php
        echo $errors['already'];
        ?>
        </div>
    <?php }?>
  </div>
  <!-- <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div> -->
  <button type="submit" class="btn btn-primary" name="submit">Sign Up</button>
</form>
</div>
</body>
</html>