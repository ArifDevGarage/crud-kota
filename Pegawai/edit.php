<?php
  require("../connection.php");

  $errors = [];
  // Defaults for first paint
  $nik = $nama_pegawai = $tanggal_lahir = '';
  $selectedJenisKelamin = '';

  // ---------- determine key ----------
  $originalNik = $_GET['nik'] ?? ($_POST['temp_nik'] ?? null);
  if ($originalNik === null || $originalNik === '') {
      // No key → go back to list
      header("Location: index.php");
      exit;
  }

  if (isset($_POST['cmdSIMPAN']))
  {
    $nik            = trim((string)($_POST['nik'] ?? ''));
    $namaRaw        = trim((string)($_POST['nama_pegawai'] ?? ''));
    $jkRaw          = $_POST['jenis_kelamin'] ?? '';
    $tanggal_lahir  = trim((string)($_POST['tanggal_lahir'] ?? ''));

    // === Validations ===
    if ($nik === '') {
        $errors['nik'] = 'NIK wajib diisi.';
    }

    if ($namaRaw === '') {
        $errors['nama_pegawai'] = 'Nama pegawai wajib diisi.';
    } else {
        // Normalize capitalization
        $nama_pegawai = function_exists('mb_strtolower')
            ? ucwords(mb_strtolower($namaRaw, 'UTF-8'))
            : ucwords(strtolower($namaRaw));
    }

    if ($jkRaw === '') {
        $errors['jenis_kelamin'] = 'Jenis kelamin harus dipilih.';
    } else {
        $jenis_kelaminid = (int)$jkRaw;
        // (Opsional) validasi ID jk terhadap master $jenis_kelamin_items
        if (isset($jenis_kelamin_items) && is_array($jenis_kelamin_items)) {
            $allowedIds = array_map('intval', array_column($jenis_kelamin_items, 'id'));
            if (!in_array($jenis_kelaminid, $allowedIds, true)) {
                $errors['jenis_kelamin'] = 'Jenis kelamin tidak valid.';
            }
        }
      }

    // === If errors: show alert and stop ===
    if (!empty($errors)) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '<strong>Terjadi kesalahan input.</strong> Periksa kembali form Anda.';
        echo '<ul class="mb-0">';
        foreach ($errors as $msg) {
            echo '<li>' . htmlspecialchars($msg, ENT_QUOTES) . '</li>';
        }
        echo '</ul>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';

        // Keep user selections on re-render
        $selectedJenisKelamin = (string)$jenis_kelaminid;
    } else {
      try
      {
        $katanya = "UPDATE pegawai SET nama_pegawai = '$nama_pegawai', tanggal_lahir = '$tanggal_lahir', zref_jenis_kelamin_id = $jenis_kelaminid WHERE nik = '$originalNik'";
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
  }

  function getJenisKelaminItem($theLINK)
  {
      $query = mysqli_query($theLINK, "SELECT * FROM zref_jenis_kelamin ORDER BY Id");
      $items = [];
      while ($row = mysqli_fetch_assoc($query)) {
          $items[] = $row;
      }
      return $items;
  }

  $sql  = "SELECT `nik`, `nama_pegawai`, `tanggal_lahir`, `zref_jenis_kelamin_id` FROM pegawai WHERE nik = '$originalNik' LIMIT 1";
  $sambung  = mysqli_query($theLINK, $sql);
  if ($isi = mysqli_fetch_assoc($sambung)) {
      $nik               = $isi['nik'];
      $nama_pegawai      = $isi['nama_pegawai'];
      $tanggal_lahir     = $isi['tanggal_lahir'];
      $dbJenisKelaminId  = $isi['zref_jenis_kelamin_id'] ?? null;
      $selectedJenisKelamin = $_POST['jenis_kelamin'] ?? (string)($dbJenisKelaminId ?? '');
  } else {
      $errors['nik'] = 'Data pegawai tidak ditemukan.';
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
    <div class="card-header bg-dark text-white">Ubah Data Pegawai</div>
    <div class="card-body">
      <form action="" method="post" class="needs-validation" novalidate>
        <div class="form-group">
          <label class="fw-bold" for="nik">Nomor Induk Pegawai</label>
          <input type="text" class="form-control bg-light" name="nik" id="nik"required autocomplete="off" value="<?=$nik;?>" readonly>
          <div class="invalid-feedback">NIK harus diisi dengan numerik karakter</div>
        </div>
        <div class="form-group">
          <label class="fw-bold" for="nama_pegawai">Nama Pegawai</label>
          <input type="text" class="form-control" name="nama_pegawai" id="nama_pegawai" required autocomplete="off" minlength="1" maxlength="255" value="<?=$nama_pegawai;?>">
          <div class="invalid-feedback">Nama Pegawai harus diisi maksimal 255 karakter</div>
        </div>
        <div class="form-group">
          <label class="fw-bold" for="tanggal_lahir">Tanggal Lahir</label>
          <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?=$tanggal_lahir?>" required >
          <div class="invalid-feedback">Tanggal Lahir harus tanggal yang valid</div>
        </div>
          <?php $jenis_kelamin_items = getJenisKelaminItem($theLINK); ?>
          <div class="mb-2">
            <span class="fw-bold" for="jenis_kelamin">Jenis Kelamin</span>
            <?php
                foreach ($jenis_kelamin_items as $row) {
                  $value   = (string)$row['id'];
                  $label   = $row['nama'];
                  $checked = ($value === (string)$selectedJenisKelamin) ? 'checked' : '';
            ?>
              <div class="form-check">
                  <input class="form-check-input" id="jk_<?=$row['id']?>" type="radio" name="jenis_kelamin" value="<?=$row['id']?>" <?= $checked ?>>
                  <label class="form-check-label" for="jk_<?= $row['id'] ?>">
                    <?= $row['nama'] ?>
                  </label>
              </div>
            <?php
                }
            ?>
            <div class="invalid-feedback">Jenis Kelamin harus dipilih salah satu yang valid</div>
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