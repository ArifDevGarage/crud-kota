<?php
  require("connection.php");
  $kd_kota = "";  
  $nm_kota = "";

  if (isset($_POST['cmdSIMPAN']))
  {
    $kd_kota = strtoupper($_POST['kd_kota']);
    $nm_kota = ucwords($_POST['nm_kota']);

    try
    {
      $katanya = "INSERT INTO tbl_kota (kd_kota, nm_kota) VALUES('$kd_kota', '$nm_kota')";
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <div class="container my-3">
  <div class="card">
    <div class="card-headerbg-dark text-white">Tambah Data Kota</div>
    <div class="card-body">
      <form action="" method="post" class="needs-validation" novalidate>
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