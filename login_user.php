<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($q) > 0) {
        $user = mysqli_fetch_assoc($q);
        // Cek password. Kita pakai md5 untuk menyesuaikan database default, tapi idealnya pakai password_verify
        if (md5($password) === $user['password'] || password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nama'] = $user['nama'];
            
            // Redirect ke halaman sebelumnya jika ada (sementara arahkan ke index dengan param)
            header("Location: index.php?login_success=1");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengguna - Wonderful Nganjuk</title>
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
    <h5 class="text-center mb-4">Login Pengunjung</h5>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-danger py-2"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required placeholder="user@gmail.com">
        </div>
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <label class="form-label mb-0">Password</label>
                <a href="forgot_password.php" style="font-size: 0.85rem; color: #15803d; text-decoration: none;">Lupa Password?</a>
            </div>
            <input type="password" name="password" class="form-control mt-2" required placeholder="***">
        </div>
        <button type="submit" name="login" class="btn btn-success w-100 mb-3" style="background: #15803d; border:none; padding:10px;">Masuk</button>
        
        <div class="text-center" style="font-size: 0.9rem;">
            Belum punya akun? <a href="register.php" style="color: #15803d; text-decoration: none; font-weight: 600;">Daftar Sekarang</a><br>
            <a href="index.php" class="text-muted mt-3 d-inline-block" style="text-decoration: none;">&larr; Kembali ke Beranda</a>
        </div>
    </form>
</div>

</body>
</html>
