<html>
<head>
  <title>CRUD Data Kota</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <?php
  require("../connection.php");

  if (isset($_POST['cmdHAPUS']))
  {
    $tempKODE   = trim($_POST['temp_nik']);

    try
    {
      $permintaan = "DELETE FROM pegawai WHERE kd_kota = '$temp_nik'";
      $tersambung = mysqli_query($theLINK, $permintaan);
      echo '<script>window.location="index.php"</script>';
    }
    catch (Throwable $throwable)
    {
      echo "<div class='alert alert-danger alert-dismissible'>";
      echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
      if (substr(mysqli_error($theLINK),0,68) == "Cannot delete or update a parent row: a foreign key constraint fails")
        echo "<b>TERJADI KESALAHAN : </b><br>data pegawai dengan kode pegawai $temp_nik tidak boleh dihapus karena dipakai oleh entitas yang lain</div>";
      else
        echo "<b>TERJADI KESALAHAN : </b><br>" . mysqli_error($theLINK) . "</div>";
    }
  }  
  ?>
  <div class="container my-3">

      <nav class="navbar navbar-sm navbar-expand-lg navbar-dark bg-dark my-3 rounded" aria-label="navbar-primary">
      <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11" aria-controls="navbarsExample11" aria-expanded="true" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse d-lg-flex collapse show" id="navbarsExample11" style="">
          <a class="navbar-brand col-lg-3 me-0" href="#">CRUD</a>
          <ul class="navbar-nav col-lg-6 justify-content-lg-center">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="/index.php">Kota</a>
            </li>
        </div>
      </div>
    </nav>

    <div class="card">
      <div class="card-header bg-dark text-white">CRUD Data Pegawai</div>
      <div class="card-body">
      <p><a href="add.php" class="btn btn-sm btn-success">Tambah Data</a></p>
        <div class="table-responsive">
          <table class="table table-bordered table-sm">
            <tr>
              <th>NOMOR</th>
              <th>NIK</th>
              <th>NAMA PEGAWAI</th>
              <th>TANGGAL LAHIR</th>
              <th>JENIS KELAMIN</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
            </tr>
            <?php
            $nomor = 1;
            $katanya = "SELECT 
                        p.nik,
                        p.nama_pegawai,
                        p.tanggal_lahir,
                        p.zref_jenis_kelamin_id,
                        jk.nama AS jenis_kelamin
                    FROM pegawai AS p
                    LEFT JOIN zref_jenis_kelamin AS jk
                      ON jk.id = p.zref_jenis_kelamin_id
                    ORDER BY p.nama_pegawai";

            $sambung = mysqli_query($theLINK, $katanya);
            while ($isi = mysqli_fetch_assoc($sambung))
            {
            ?>
            <tr>
              <td><?=$nomor?></td>
              <td><?=$isi["nik"]?></td>
              <td><?=$isi["nama_pegawai"]?></td>
              <td><?=$isi["tanggal_lahir"]?></td>
              <td><?=$isi["jenis_kelamin"]?></td>
              <td class="text-center">
                <form action="edit.php" method="post">
                <input type="hidden" name="temp_nik" id="temp_nik" value="<?= $isi["nik"]; ?>">
                <button type="submit" class="btn btn-success btn-sm" name="cmdUBAH">Ubah</button>
                </form>
              </td>
              <td class="text-center">
                <form action="" method="post">
                <input type="hidden" name="temp_nik" id="temp_nik" value="<?= $isi["nik"]; ?>">
                <button type="submit" class="btn btn-danger btn-sm" name="cmdHAPUS" onclick="return confirm('Anda yakin ingin menghapus data ini?');">Hapus</button>
                </form>
              </td>
            </tr>
            <?php  
            $nomor = $nomor + 1;
            }	
            ?>
          </table>
        </div>
      </div> 
    </div>
  </div>
</body>
</html>