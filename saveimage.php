<?php
session_start();
if (isset($_POST['image1'])){
  $img = $_POST['image1'];
  $_SESSION['image1'] = $img;
  if (isset($_POST['image2'])){
    $img = $_POST['image2'];
    $_SESSION['image2'] = $img;
  }
  if (isset($_POST['image3'])){
    $img = $_POST['image3'];
    $_SESSION['image3'] = $img;
  }
}
?>
