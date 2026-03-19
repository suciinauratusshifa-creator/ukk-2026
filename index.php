<?php
// Halaman index dengan pilihan login
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Aspirasi Siswa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            width: 100%;
            max-width: 500px;
        }
        
        .header {
            text-align: center;
            color: white;
            margin-bottom: 50px;
        }
        
        .header h1 {
            font-size: 36px;
            margin-bottom: 10px;
            letter-spacing: -1px;
        }
        
        .header p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .login-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .login-card {
            background: white;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #333;
        }
        
        .login-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
        }
        
        .login-card.admin {
            border-top: 4px solid #667eea;
        }
        
        .login-card.siswa {
            border-top: 4px solid #28a745;
        }
        
        .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        
        .login-card h3 {
            font-size: 22px;
            margin-bottom: 8px;
            color: #1a1a2e;
        }
        
        .login-card p {
            font-size: 13px;
            color: #999;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .login-card.siswa .btn {
           background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        footer {
            text-align: center;
            color: white;
            margin-top: 50px;
            font-size: 13px;
            opacity: 0.8;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>🎓 Aspirasi Siswa</h1>
        <p>Sistem Pengajuan Aspirasi & Keluhan Siswa</p>
    </div>
    
    <div class="login-options">
        <a href="login.php" class="login-card admin">
            <div class="icon">👨‍💼</div>
            <h3>Admin</h3>
            <p>Kelola dan monitor semua aspirasi siswa</p>
            <span class="btn">Login Admin</span>
        </a>
        
        <a href="dashboard_siswa.php" class="login-card siswa">
            <div class="icon">👨‍🎓</div>
            <h3>Siswa</h3>
            <p>Ajukan aspirasi dan pantau statusnya</p>
            <span class="btn">Masuk Siswa</span>
        </a>
    </div>
    
    <footer>
        © 2026 Sistem Aspirasi Siswa - Sekolah Kami
    </footer>
</div>

</body>
</html>
