<?php
session_start();
include 'koneksi.php';
if(!isset($_SESSION['status_login'])){
    header("Location: login.php");
    exit();
}

/* Hitung Statistik */
$menunggu = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) as total FROM aspirasi WHERE status='Menunggu'"
))['total'];

$proses = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) as total FROM aspirasi WHERE status='Proses'"
))['total'];

$selesai = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) as total FROM aspirasi WHERE status='Selesai'"
))['total'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Admin</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family: Arial, sans-serif;
    background:#f4f6fb;
}

/* ===== NAVBAR ===== */
.topbar{
    background:#0b1c4d;
    color:white;
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.logo{
    font-size:18px;
    font-weight:bold;
}

.topbar ul{
    list-style:none;
    display:flex;
    gap:20px;
}

.topbar a{
    color:white;
    text-decoration:none;
    font-weight:500;
}

.topbar a:hover{
    opacity:0.8;
}

/* ===== CONTAINER ===== */
.container{
    width:90%;
    margin:30px auto;
}

/* ===== CARD STATISTIK ===== */
.card{
    display:inline-block;
    width:30%;
    padding:25px;
    margin:10px;
    border-radius:12px;
    color:white;
    text-align:center;
    font-size:18px;
    font-weight:bold;
}

.menunggu{background:#b39ddb;}
.proses{background:#90caf9;}
.selesai{background:#f8bbd0;}

/* ===== BOX CONTENT ===== */
.box{
    background:white;
    padding:25px;
    border-radius:12px;
    margin-top:20px;
    box-shadow:0 4px 10px rgba(0,0,0,0.05);
}

.box h3{
    margin-bottom:10px;
}

h2{
    margin-bottom:15px;
}
</style>
</head>

<body>

<!-- ===== NAVBAR ===== -->
<header>
    <div class="topbar">
        <div class="logo">✨ Admin Web Aspirasi</div>
        <ul>
            <li><a href="dashboard.php">dashboard</a></li>
              <li><a href="kategori.php"> kategori</a></li>
              <li><a href="aspirasi_admin.php"> Aspirasi</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</header>

    <div class="container">

    <div class="box">
    <h3>✨ Ruang yang Mendengar, Bukan Sekadar Menampilkan</h3>

    <p>
    Web Aspirasi adalah ruang terbuka bagi siswa untuk menyampaikan gagasan,
    saran, dan kritik secara terstruktur dan bertanggung jawab.
    Setiap aspirasi dipandang sebagai peluang untuk berkembang,
    bukan sekadar laporan yang lewat begitu saja.
    </p>

    <p>
    Platform ini dibangun untuk menumbuhkan budaya mendengar,
    transparansi, dan respon yang nyata.
    Dengan sistem yang tertata dan dapat dipantau,
    setiap suara memiliki nilai dan berkontribusi
    dalam kemajuan sekolah secara berkelanjutan.
    </p>

    <p>
    Karena perubahan tidak lahir dari diam,
    tetapi dari keberanian untuk berbicara
    dan kemauan untuk benar-benar mendengar.
    </p>

</div>