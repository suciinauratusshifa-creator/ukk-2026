<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['status_login'])){
    header("Location: login.php");
    exit();
}

/* HAPUS DATA */
if(isset($_GET['hapus'])){
$id = $_GET['hapus'];

mysqli_query($koneksi,"DELETE FROM aspirasi WHERE id_pelaporan='$id'");
mysqli_query($koneksi,"DELETE FROM input_aspirasi WHERE id_pelaporan='$id'");

echo "<script>alert('Data berhasil dihapus');window.location='aspirasi_admin.php';</script>";
}

/* UPDATE STATUS & FEEDBACK */
if(isset($_POST['update'])){

$id = $_POST['id'];
$status = $_POST['status'];
$feedback = $_POST['feedback'];

$cek = mysqli_query($koneksi,"SELECT * FROM aspirasi WHERE id_pelaporan='$id'");

if(mysqli_num_rows($cek) > 0){

mysqli_query($koneksi,"
UPDATE aspirasi 
SET status='$status', feedback='$feedback'
WHERE id_pelaporan='$id'
");

}else{

mysqli_query($koneksi,"
INSERT INTO aspirasi(id_pelaporan,status,feedback)
VALUES('$id','$status','$feedback')
");

}

echo "<script>alert('Data berhasil diupdate');window.location='aspirasi_admin.php';</script>";

}

/* FILTER */

$where = "WHERE 1=1";

if(isset($_GET['tanggal']) && $_GET['tanggal'] != ''){
$tanggal = $_GET['tanggal'];
$where .= " AND DATE(input_aspirasi.created_at)='$tanggal'";
}

if(isset($_GET['bulan']) && $_GET['bulan'] != ''){
$bulan = $_GET['bulan'];
$where .= " AND MONTH(input_aspirasi.created_at)='$bulan'";
}

if(isset($_GET['kategori']) && $_GET['kategori'] != ''){
$kategori = $_GET['kategori'];
$where .= " AND input_aspirasi.id_kategori='$kategori'";
}

if(isset($_GET['nis']) && $_GET['nis'] != ''){
$nis = $_GET['nis'];
$where .= " AND input_aspirasi.nis='$nis'";
}

/* QUERY DATA */

$query = mysqli_query($koneksi,"
SELECT 
input_aspirasi.id_pelaporan,
siswa.nis,
siswa.kelas,
kategori.ket_kategori,
input_aspirasi.lokasi,
input_aspirasi.ket,
input_aspirasi.created_at,
aspirasi.status,
aspirasi.feedback
FROM input_aspirasi
JOIN siswa ON input_aspirasi.nis = siswa.nis
JOIN kategori ON input_aspirasi.id_kategori = kategori.id_kategori
LEFT JOIN aspirasi ON input_aspirasi.id_pelaporan = aspirasi.id_pelaporan
$where
ORDER BY input_aspirasi.id_pelaporan DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Aspirasi Admin</title>

<style>

*{margin:0;padding:0;box-sizing:border-box;}

body{
font-family:Arial;
background:#f4f6fb;
}

.topbar{
background:#0b1c4d;
color:white;
padding:15px 30px;
display:flex;
justify-content:space-between;
}

.topbar ul{
list-style:none;
display:flex;
gap:20px;
}

.topbar a{
color:white;
text-decoration:none;
}

.container{
width:95%;
margin:30px auto;
}

.filter{
background:white;
padding:20px;
border-radius:10px;
margin-bottom:20px;
display:flex;
gap:15px;
flex-wrap:wrap;
}

input,select{
padding:7px;
}

button{
padding:7px 15px;
background:#4CAF50;
color:white;
border:none;
cursor:pointer;
}

.reset{
background:#777;
color:white;
padding:7px 15px;
text-decoration:none;
border-radius:4px;
}

table{
width:100%;
border-collapse:collapse;
background:white;
}

th,td{
padding:10px;
border:1px solid #ddd;
text-align:center;
}

th{
background:#0b1c4d;
color:white;
}

.status{
padding:5px 12px;
border-radius:20px;
font-size:12px;
font-weight:bold;
}

.menunggu{
background:#e6d6ff;
color:#6a3fb5;
}

.proses{
background:#ffd6e7;
color:#b03060;
}

.selesai{
background:#f8c8dc;
color:#8b3a62;
}

.hapus{
background:#e74c3c;
color:white;
padding:5px 10px;
border-radius:5px;
text-decoration:none;
}

</style>
</head>

<body>

<header>
<div class="topbar">

<div><b>✨ Admin Web Aspirasi</b></div>

<ul>
<li><a href="dashboard_siswa.php">Dashboard</a></li>
<li><a href="kategori.php">Kategori</a></li>
<li><a href="aspirasi_admin.php">Aspirasi</a></li>
<li><a href="logout.php">Logout</a></li>
</ul>

</div>
</header>

<div class="container">

<h2>Data Aspirasi Siswa</h2>

<form method="GET" class="filter">

<div>
<label>Tanggal</label><br>
<input type="date" name="tanggal">
</div>

<div>
<label>Bulan</label><br>
<select name="bulan">
<option value="">Semua</option>
<option value="1">Januari</option>
<option value="2">Februari</option>
<option value="3">Maret</option>
<option value="4">April</option>
<option value="5">Mei</option>
<option value="6">Juni</option>
<option value="7">Juli</option>
<option value="8">Agustus</option>
<option value="9">September</option>
<option value="10">Oktober</option>
<option value="11">November</option>
<option value="12">Desember</option>
</select>
</div>

<div>
<label>Siswa</label><br>
<select name="nis">

<option value="">Semua Siswa</option>

<?php
$siswa = mysqli_query($koneksi,"SELECT * FROM siswa");
while($s = mysqli_fetch_assoc($siswa)){
?>

<option value="<?php echo $s['nis']; ?>">
<?php echo $s['nis']." - ".$s['kelas']; ?>
</option>

<?php } ?>

</select>
</div>

<div>
<label>Kategori</label><br>
<select name="kategori">

<option value="">Semua</option>

<?php
$kat = mysqli_query($koneksi,"SELECT * FROM kategori");
while($k = mysqli_fetch_assoc($kat)){
?>

<option value="<?php echo $k['id_kategori']; ?>">
<?php echo $k['ket_kategori']; ?>
</option>

<?php } ?>

</select>
</div>

<div>
<button type="submit">Filter</button>
</div>

<div>
<a href="aspirasi_admin.php" class="reset">Reset</a>
</div>

</form>

<table>

<tr>
<th>ID</th>
<th>NIS</th>
<th>Kelas</th>
<th>Kategori</th>
<th>Lokasi</th>
<th>Keterangan</th>
<th>Status</th>
<th>Feedback</th>
<th>Tanggal</th>
<th>Aksi</th>
</tr>

<?php while($data = mysqli_fetch_assoc($query)){ 

$status = strtolower($data['status'] ?? 'menunggu');

?>

<tr>

<td><?php echo $data['id_pelaporan']; ?></td>
<td><?php echo $data['nis']; ?></td>
<td><?php echo $data['kelas']; ?></td>
<td><?php echo $data['ket_kategori']; ?></td>
<td><?php echo $data['lokasi']; ?></td>
<td><?php echo $data['ket']; ?></td>

<td>
<span class="status <?php echo $status; ?>">
<?php echo $data['status'] ?? 'Menunggu'; ?>
</span>
</td>

<td><?php echo $data['feedback'] ?? '-'; ?></td>

<td><?php echo date("d-m-Y",strtotime($data['created_at'])); ?></td>

<td>

<form method="POST">

<input type="hidden" name="id" value="<?php echo $data['id_pelaporan']; ?>">

<select name="status">
<option value="Menunggu">Menunggu</option>
<option value="Proses">Proses</option>
<option value="Selesai">Selesai</option>
</select>

<br><br>

<input type="text" name="feedback" placeholder="Feedback">

<br><br>

<button type="submit" name="update">Update</button>

<a class="hapus" href="aspirasi_admin.php?hapus=<?php echo $data['id_pelaporan']; ?>" onclick="return confirm('Yakin ingin menghapus?')">
Hapus
</a>

</form>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>
```
