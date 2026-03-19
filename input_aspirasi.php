<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login.php");
    exit();
}

$error_msg = '';

// Ambil data kategori
$kategori = mysqli_query($koneksi, "SELECT id_kategori, ket_kategori FROM kategori");

// Ambil data siswa
$siswa = mysqli_query($koneksi, "SELECT nis, kelas FROM siswa");

// Proses input
if (isset($_POST['submit'])) {

    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $id_kategori = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
    $lokasi = mysqli_real_escape_string($koneksi, $_POST['lokasi']);
    $feedback = mysqli_real_escape_string($koneksi, $_POST['feedback']);

    if (empty($nis) || empty($id_kategori) || empty($lokasi) || empty($feedback)) {
        $error_msg = "Semua field harus diisi!";
    } else {

        // Simpan ke tabel input_aspirasi
        $query_input = mysqli_query(
            $koneksi,
            "INSERT INTO input_aspirasi (nis, id_kategori, lokasi)
        VALUES ('$nis','$id_kategori','$lokasi')"
        );

        if ($query_input) {

            $id_pelaporan = mysqli_insert_id($koneksi);

            // Simpan ke tabel aspirasi
            $query_aspirasi = mysqli_query(
                $koneksi,
                "INSERT INTO aspirasi (id_pelaporan,status,feedback)
            VALUES ('$id_pelaporan','Menunggu','$feedback')"
            );

            if ($query_aspirasi) {
                echo "<script>alert('Aspirasi berhasil dikirim');window.location='aspirasi.php';</script>";
            } else {
                $error_msg = "Gagal menyimpan aspirasi";
            }

        } else {
            $error_msg = "Gagal menginput data";
        }

    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Input Aspirasi</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6fb;
        }

        .topbar {
            background: #0b1c4d;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
        }

        .topbar ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .topbar a {
            color: white;
            text-decoration: none;
        }

        .form-container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        textarea {
            min-height: 120px;
        }

        button {
            padding: 10px 20px;
            border: none;
            background: #cdb4db;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background: #b79acb;
        }
    </style>

</head>

<body>

    <header>
        <div class="topbar">

            <div><b>Input Aspirasi</b></div>

            <ul>
                <li><a href="dashboard_siswa.php">Dashboard</a></li>
                <li><a href="input_aspirasi.php">Input Aspirasi</a></li>
                <li><a href="aspirasi.php">Aspirasi</a></li>
            </ul>

        </div>
    </header>

    <div class="form-container">

        <h2>Form Input Aspirasi</h2>

        <?php if ($error_msg) { ?>
            <div style="background:#f8d7da;padding:10px;margin-bottom:15px;color:#721c24;">
                <?php echo $error_msg; ?>
            </div>
        <?php } ?>

        <form method="POST">

            <div class="form-group">
                <label>NIS Siswa</label>
                <select name="nis" required>
                    <option value="">-- Pilih Siswa --</option>

                    <?php
                    while ($s = mysqli_fetch_assoc($siswa)) {
                        echo "<option value='" . $s['nis'] . "'>" . $s['nis'] . " - " . $s['kelas'] . "</option>";
                    }
                    ?>

                </select>
            </div>

            <div class="form-group">
                <label>Kategori Aspirasi</label>
                <select name="id_kategori" required>
                    <option value="">-- Pilih Kategori --</option>

                    <?php
                    while ($k = mysqli_fetch_assoc($kategori)) {
                        echo "<option value='" . $k['id_kategori'] . "'>" . $k['ket_kategori'] . "</option>";
                    }
                    ?>

                </select>
            </div>

            <div class="form-group">
                <label>Lokasi</label>
                <input type="text" name="lokasi" required>
            </div>

            <div class="form-group">
                <label>Feedback</label>
                <textarea name="feedback" placeholder="Tuliskan aspirasi atau keluhan..." required></textarea>
            </div>

            <div style="text-align:center;margin-top:20px;">
                <button type="submit" name="submit">Kirim Aspirasi</button>
            </div>

        </form>

    </div>

</body>

</html>