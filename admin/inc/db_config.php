<?php 

  $hname = 'localhost';
  $uname = 'root';
  $pass = '';
  $db = 'hbw';

  $con = mysqli_connect($hname,$uname,$pass,$db);

  if(!$con){
    die("Cannot Connect to Database".mysqli_connect_error());
  }

  function filteration($data){
    foreach($data as $key => $value){
      $value = trim($value);
      $value = stripslashes($value);
      $value = strip_tags($value);
      $value = htmlspecialchars($value);
      $data[$key] = $value;
    }
    return $data;
  }