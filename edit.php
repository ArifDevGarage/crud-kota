<?php
  require("connection.php");

  $tempKODE = trim($_POST['tempKODE']);
  $katanya  = "SELECT * FROM tbl_kota WHERE kd_kota = '$tempKODE'";
  $sambung  = mysqli_query($theLINK, $katanya);
  while ($isi = mysqli_fetch_array($sambung))
  {
    $kd_kota  = $isi['kd_kota'];  
    $nm_kota  = $isi['nm_kota'];
  }

  if (isset($_POST['cmdSIMPAN']))
  {
    $kd_kota  = strtoupper($_POST['kd_kota']);  
    $nm_kota  = ucwords($_POST['nm_kota']);
    $tempKODE = $_POST['tempKODE'];

    try
    {
      $katanya = "UPDATE tbl_kota SET kd_kota = '$kd_kota', nm_kota ='$nm_kota' WHERE kd_kota = '$tempKODE'";
      $sambung = mysqli_query($theLINK, $katanya);
      echo '<script>window.location="index.php"</script>';
    }
    catch (Throwable $throwable)
    {
      echo "<div class='alert alert-danger alert-dismissible'>";
      echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
      echo "<b>TERJADI KESALAHAN : </b><br>" . mysqli_error($theLINK) . "</div>";
    }
  }
?>
<html>
<head>
  <title>CRUD Data Kota</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <div class="container my-3">
  <div class="card">
    <div class="card-header bg-dark text-white">Ubah Data Kota</div>
    <div class="card-body">
      <form action="" method="post" class="needs-validation" novalidate>
        <input type="hidden" name="tempKODE" id="tempKODE" value="<?= $tempKODE; ?>">
        <div class="form-group">
          <label for="kd_kota">KODE KOTA</label>
          <input type="text" class="form-control" name="kd_kota" id="kd_kota" required autocomplete="off" minlength="2" maxlength="2" value="<?=$kd_kota;?>">
          <div class="invalid-feedback">KODE KOTA harus diisi dengan 2 karakter</div>
        </div>
        <div class="form-group">
          <label for="nm_kota">NAMA KOTA</label>
          <input type="text" class="form-control" name="nm_kota" id="nm_kota" required autocomplete="off" minlength="1" maxlength="30" value="<?=$nm_kota;?>">
          <div class="invalid-feedback">NAMA KOTA harus diisi maksimal 30 karakter</div>
        </div>
        <button type="submit" class="btn btn-success btn-sm mt-3" name="cmdSIMPAN">Simpan</button>
        <a href="index.php" class="btn btn-danger btn-sm mt-3">Batal</a>
      </form>
    </div>
  </div>
  </div>
<script>
(function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
</body>
</html>