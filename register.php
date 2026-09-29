<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Cek email apakah sudah ada
    $cek = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if(mysqli_num_rows($cek) > 0){
        $error = "Email sudah terdaftar!";
    } else {
        $hashed_password = md5($password); // Menggunakan md5 agar sama dengan sistem lama, namun idealnya password_hash
        $insert = mysqli_query($conn, "INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$hashed_password')");
        if($insert){
            header("Location: login_user.php?registered=1");
            exit;
        } else {
            $error = "Gagal mendaftar!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Wonderful Nganjuk</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,700;0,800;1,500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: #f8fafc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 400px;
        }
        .brand {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
            color: #1e293b;
        }
        .brand span { color: #15803d; }
    </style>
</head>
<body>

<div class="login-card">
    <div class="brand">Wonderful<br><span>Nganjuk</span></div>
    <h5 class="text-center mb-4">Buat Akun Baru</h5>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-danger py-2"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" required placeholder="John Doe">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required placeholder="user@gmail.com">
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
        </div>
        <button type="submit" name="register" class="btn btn-success w-100 mb-3" style="background: #15803d; border:none; padding:10px;">Daftar</button>
        
        <div class="text-center" style="font-size: 0.9rem;">
            Sudah punya akun? <a href="login_user.php" style="color: #15803d; text-decoration: none; font-weight: 600;">Login di sini</a><br>
            <a href="index.php" class="text-muted mt-3 d-inline-block" style="text-decoration: none;">&larr; Kembali ke Beranda</a>
        </div>
    </form>
</div>

</body>
</html>
