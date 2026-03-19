<?php  
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

// Cek apakah admin sudah login
if(!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true){
    header("Location: login.php");
    exit();
}

// =======================
// HITUNG STATISTIK
// =======================

$menunggu = mysqli_fetch_assoc(mysqli_query($koneksi,
"SELECT COUNT(*) as total FROM aspirasi WHERE status='Menunggu'"
))['total'];

$proses = mysqli_fetch_assoc(mysqli_query($koneksi,
"SELECT COUNT(*) as total FROM aspirasi WHERE status='Proses'"
))['total'];

$selesai = mysqli_fetch_assoc(mysqli_query($koneksi,
"SELECT COUNT(*) as total FROM aspirasi WHERE status='Selesai'"
))['total'];


// =======================
// AMBIL DATA ASPIRASI
// =======================

$query = mysqli_query($koneksi, "
SELECT 
input_aspirasi.id_pelaporan,
siswa.nis,
siswa.kelas,
kategori.ket_kategori,
input_aspirasi.lokasi,
aspirasi.status,
aspirasi.feedback
FROM input_aspirasi
JOIN siswa ON input_aspirasi.nis = siswa.nis
JOIN kategori ON input_aspirasi.id_kategori = kategori.id_kategori
JOIN aspirasi ON input_aspirasi.id_pelaporan = aspirasi.id_pelaporan
ORDER BY input_aspirasi.id_pelaporan DESC
");

if(!$query){
die("Error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Aspirasi</title>
<link rel="stylesheet" href="css/style.css">

<style>

.container{
max-width:1200px;
margin:auto;
padding:20px;
}

.statistik{
display:flex;
gap:20px;
margin-bottom:40px;
}

.box{
flex:1;
padding:20px;
border-radius:10px;
color:white;
text-align:center;
}

/* WARNA SAMA DENGAN STATUS */

.kuning{
background:#e5ccff;
color:#5a2a82;
}

.biru{
background:#d6e6ff;
color:#2a4a82;
}

.hijau{
background:#f8c8dc;
color:#8b3a62;
}

.section{
background:white;
padding:20px;
border-radius:8px;
box-shadow:0 2px 4px rgba(0,0,0,0.1);
}

.section h2{
margin-top:0;
border-bottom:2px solid #f8c8dc;
padding-bottom:10px;
}

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

table th, table td{
padding:12px;
border-bottom:1px solid #ddd;
font-size:13px;
}

table th{
background:#f8c8dc;
color:white;
}

table tr:hover{
background:#fafafa;
}

/* STATUS */

.status{
padding:6px 14px;
border-radius:20px;
font-size:12px;
font-weight:bold;
display:inline-block;
}

.menunggu{
background:#e5ccff;
color:#5a2a82;
}

.proses{
background:#d6e6ff;
color:#2a4a82;
}

.selesai{
background:#f8c8dc;
color:#8b3a62;
}

.footer-text{
text-align:center;
margin-top:30px;
font-size:14px;
color:#666;
}

</style>

</head>

<body>

<header>
<div class="topbar">

<div class="logo">Aspirasi Siswa</div>

<ul>
<li><a href="dashboard_siswa.php">Dashboard</a></li>
<li><a href="input_aspirasi.php">Input Aspirasi</a></li>
</ul>

</div>
</header>


<div class="container">

<a href="index.php" class="btn-kembali">← Kembali ke Index</a>


<!-- STATISTIK -->

<div class="statistik">

<div class="box kuning">
<div>Menunggu</div>
<div style="font-size:32px;font-weight:bold;">
<?= $menunggu ?>
</div>
</div>

<div class="box biru">
<div>Proses</div>
<div style="font-size:32px;font-weight:bold;">
<?= $proses ?>
</div>
</div>

<div class="box hijau">
<div>Selesai</div>
<div style="font-size:32px;font-weight:bold;">
<?= $selesai ?>
</div>
</div>

</div>


<!-- TABEL ASPIRASI -->

<div class="section">

<h2>Pantau Progres Aspirasi</h2>

<table>

<thead>
<tr>
<th>No</th>
<th>ID</th>
<th>NIS</th>
<th>Kelas</th>
<th>Kategori</th>
<th>Lokasi</th>
<th>Status</th>
<th>Feedback</th>
</tr>
</thead>

<tbody>

<?php 
$no=1;

while($a=mysqli_fetch_assoc($query)){

$status_class = strtolower($a['status']);
?>

<tr>

<td><?php echo $no; ?></td>
<td><?php echo $a['id_pelaporan']; ?></td>
<td><?php echo $a['nis']; ?></td>
<td><?php echo $a['kelas']; ?></td>
<td><?php echo $a['ket_kategori']; ?></td>
<td><?php echo $a['lokasi']; ?></td>

<td>
<span class="status <?php echo $status_class; ?>">
<?php echo $a['status']; ?>
</span>
</td>

<td>
<?php echo (!empty($a['feedback']) ? substr($a['feedback'],0,40).'...' : '-'); ?>
</td>

</tr>

<?php 
$no++;
} 
?>

</tbody>
</table>

</div>

</div>

<p class="footer-text">© 2026 Sistem Aspirasi Siswa</p>

</body>
</html>