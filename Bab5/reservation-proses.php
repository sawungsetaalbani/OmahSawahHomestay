<?php
if (isset($_POST['simpan'])) {
  $nama = $_POST['nama'];
  $tanggal = $_POST['tanggal'];
  $durasi = $_POST['durasi'];
  $tipe = $_POST['tipe'];
  $foto = $_FILES['foto']['name'];
  $tmp = $_FILES['foto']['tmp_name'];

  // Simpan file upload ke folder
  $uploadDir = "uploads/";
  move_uploaded_file($tmp, $uploadDir . $foto);

  echo "<h2>Data Reservasi Berhasil Disimpan!</h2>";
  echo "Nama: $nama<br>";
  echo "Tanggal: $tanggal<br>";
  echo "Durasi: $durasi malam<br>";
  echo "Tipe Kamar: $tipe<br>";
  echo "Foto: <img src='uploads/$foto' width='120'><br>";
}
?>
