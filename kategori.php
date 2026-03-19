<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['status_login'])){
    header("Location: login.php");
    exit();
}

/* TAMBAH KATEGORI */
if(isset($_POST['simpan'])){

$ket_kategori = $_POST['ket_kategori'];

mysqli_query($koneksi,"
INSERT INTO kategori (ket_kategori)
VALUES ('$ket_kategori')
");

echo "<script>alert('Kategori berhasil ditambahkan');</script>";
}

/* HAPUS KATEGORI */
if(isset($_GET['hapus'])){

$id = $_GET['hapus'];

mysqli_query($koneksi,"DELETE FROM kategori WHERE id_kategori='$id'");

echo "<script>
alert('Kategori berhasil dihapus');
window.location='kategori.php';
</script>";

}

/* AMBIL DATA */
$query = mysqli_query($koneksi,"SELECT * FROM kategori ORDER BY id_kategori DESC");

?>

<!DOCTYPE html>
<html>
<head>
<title>Kategori Aspirasi</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
font-family:Arial;
background:#f4f6fb;
}

/* NAVBAR */

.topbar{
background:#0b1c4d;
color:white;
padding:15px 30px;
display:flex;
justify-content:space-between;
align-items:center;
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

/* CONTAINER */

.container{
width:97%;
margin:30px auto;
}

/* FORM (SUDAH DIPERLEBAR) */

form{
background:white;
padding:25px;
border-radius:10px;
width:100%;
margin-bottom:30px;
box-shadow:0 2px 6px rgba(0,0,0,0.1);
}

input{
width:100%;
padding:12px;
margin:10px 0;
border:1px solid #ccc;
border-radius:5px;
}

button{
padding:10px 18px;
background:#4CAF50;
color:white;
border:none;
cursor:pointer;
border-radius:5px;
}

button:hover{
background:#45a049;
}

/* TABLE */

table{
width:100%;
border-collapse:collapse;
background:white;
}

th,td{
padding:12px;
border:1px solid #ddd;
text-align:center;
}

th{
background:#0b1c4d;
color:white;
}

tr:hover{
background:#f1f1f1;
}

.hapus{
background:red;
color:white;
padding:6px 12px;
text-decoration:none;
border-radius:5px;
}

</style>

</head>

<body>

<header>

<div class="topbar">

<div><b>✨ Admin Web Aspirasi</b></div>

<ul>
<li><a href="dashboard.php">Dashboard</a></li>
<li><a href="kategori.php">Kategori</a></li>
<li><a href="aspirasi_admin.php">Aspirasi</a></li>
<li><a href="logout.php">Logout</a></li>
</ul>

</div>

</header>

<div class="container">

<h2>Tambah Kategori</h2>

<form method="POST">

<label>Nama Kategori</label>
<input type="text" name="ket_kategori" placeholder="Masukkan nama kategori..." required>

<button type="submit" name="simpan">Simpan</button>

</form>

<h2>Data Kategori</h2>

<table>

<tr>
<th>ID</th>
<th>Kategori</th>
<th>Aksi</th>
</tr>

<?php while($data = mysqli_fetch_assoc($query)){ ?>

<tr>

<td><?php echo $data['id_kategori']; ?></td>

<td><?php echo $data['ket_kategori']; ?></td>

<td>

<a class="hapus" href="kategori.php?hapus=<?php echo $data['id_kategori']; ?>" onclick="return confirm('Yakin ingin menghapus?')">
Hapus
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>