<?php
session_start();
include 'koneksi.php';

// AUTO SETUP DATABASE
$check_table = @mysqli_query($koneksi, "SHOW TABLES LIKE 'admin'");
if(!$check_table || mysqli_num_rows($check_table) == 0){
    if(file_exists('db_aspirasi.sql')){
        $sql_file = file_get_contents('db_aspirasi.sql');
        if($sql_file){
            $sql_file = str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $sql_file);
            $queries = preg_split('/;[\r\n]+/', $sql_file);
            
            foreach($queries as $query){
                $query = trim($query);
                if(!empty($query)){
                    if(strpos($query, '--') !== 0 && strpos($query, '/*') !== 0 && strpos($query, 'SET SQL_MODE') === false && strpos($query, '/*!') === false){
                        @mysqli_query($koneksi, $query);
                    }
                }
            }
        }
    }
    
    $check_admin = mysqli_query($koneksi, "SHOW TABLES LIKE 'admin'");
    if(!$check_admin || mysqli_num_rows($check_admin) == 0){
        mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS admin (
            id_admin int(11) NOT NULL AUTO_INCREMENT,
            username varchar(100) NOT NULL,
            password varchar(100) NOT NULL,
            PRIMARY KEY (id_admin)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }
    
    $check_admin_user = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='admin'");
    if(!$check_admin_user || mysqli_num_rows($check_admin_user) == 0){
        $default_user = 'admin';
        $default_pass = md5('admin');
        mysqli_query($koneksi, "INSERT INTO admin (username, password) VALUES ('$default_user', '$default_pass')");
    }
}

$login_error = '';

if(isset($_POST['login'])){
    $user = mysqli_real_escape_string($koneksi, $_POST['user']);
    $pass = mysqli_real_escape_string($koneksi, $_POST['pass']);

    $cek = mysqli_query($koneksi, 
        "SELECT * FROM admin 
         WHERE username='$user' 
         AND password='".md5($pass)."'");

    if(mysqli_num_rows($cek) > 0){
        $d = mysqli_fetch_object($cek);
        $_SESSION['status_login'] = true;
        $_SESSION['a_global'] = $d;
        $_SESSION['id'] = $d->id_admin;

        header("Location: dashboard.php");
        exit();
    } else {
        $login_error = 'Username atau Password salah!';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Aspirasi Siswa</title>
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
        
        .login-container {
            width: 100%;
            max-width: 360px;
        }
        
        .login-box {
            background: white;
            border-radius: 10px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 60px 40px;
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-box h2 {
            text-align: center;
            color: #1a1a2e;
            margin-bottom: 40px;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .error-box {
            background: #ffe6e6;
            border: 1px solid #ff6b6b;
            color: #c92a2a;
            padding: 12px 15px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 25px;
            animation: shake 0.4s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        form {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 13px 15px;
            border: 1.5px solid #e0e0e0;
            border-radius: 7px;
            font-size: 15px;
            transition: all 0.3s ease;
            font-family: inherit;
            background: #f8f9fa;
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.08);
        }
        
        input[type="text"]::placeholder,
        input[type="password"]::placeholder {
            color: #999;
        }
        
        button[type="submit"] {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 13px;
            border: none;
            border-radius: 7px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 6px;
            letter-spacing: 0.3px;
        }
        
        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.35);
        }
        
        button[type="submit"]:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-box">
        <h2>login</h2>
        
        <?php if($login_error): ?>
            <div class="error-box">
                <?php echo htmlspecialchars($login_error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="text" name="user" placeholder="username" required autofocus>
            <input type="password" name="pass" placeholder="password" required>
            <button type="submit" name="login">login</button>
        </form>
    </div>
</div>

</body>
</html>


