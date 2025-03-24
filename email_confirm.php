<?php

  require('admin/inc/db_config.php');
  require('admin/inc/essentials.php');

  if(isset($_GET['email_confirmation']))
  {
    $data = filteration($_GET);

    $query = select("SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? LIMIT 1",
      [$data['email'],$data['token']],'ss');

    if(mysqli_num_rows($query)==1)
    {
      $fetch = mysqli_fetch_assoc($query);

      if($fetch['is_verified']==1){
        echo"<script>alert('Email already verified!')</script>";
      }