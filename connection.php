<?php
  // Created in PHP Version 8.2.12
  $dbHOST = "localhost";
  $dbUSER = "root";
  $dbPASS = "";
  $dbNAME = "xdata";

  try
  {
    $theLINK = mysqli_connect($dbHOST, $dbUSER, $dbPASS, $dbNAME);
  }
  catch (Throwable $throwable)
  {
    echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>";
    echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'></script>";
    echo "<div class='alert alert-danger alert-dismissible'>";
    echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
    echo "<b><u>Terjadi Kesalahan : </u></b><br>koneksi ke basis data gagal . . .</div>";
    die();
  }  
?>