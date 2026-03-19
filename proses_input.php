<?php
include "koneksi.php";

$nis = $_POST['nis'];
$id_kategori = $_POST['id_kategori'];
$lokasi = $_POST['lokasi'];
$ket = $_POST['ket'];

$query = mysqli_query($koneksi,
"INSERT INTO input_aspirasi (nis,id_kategori,lokasi,ket)
VALUES ('$nis','$id_kategori','$lokasi','$ket')");

if($query){
    echo "Aspirasi berhasil dikirim";
}else{
    echo "Gagal mengirim aspirasi";
}
?>