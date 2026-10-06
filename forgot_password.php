<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Cek apakah email ada di tabel users
        $q = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
        if (mysqli_num_rows($q) > 0) {
            
            // Hash password baru dengan algoritma BCRYPT bawaan PHP
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            $update = mysqli_query($conn, "UPDATE users SET password='$hashed_password' WHERE email='$email'");
            
            if ($update) {
                $success = "Password berhasil diubah! Silakan login.";
            } else {
                $error = "Gagal mengubah password!";
            }
        } else {
            $error = "Email tidak terdaftar di sistem kami!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Wonderful Nganjuk</title>
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
    <h5 class="text-center mb-4">Reset Password</h5>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-danger py-2"><?= $error ?></div>
    <?php endif; ?>
    <?php if(isset($success)): ?>
        <div class="alert alert-success py-2"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Email Terdaftar</label>
            <input type="email" name="email" class="form-control" required placeholder="user@gmail.com">
        </div>
        <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <input type="password" name="new_password" class="form-control" required placeholder="***">
        </div>
        <div class="mb-4">
            <label class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="confirm_password" class="form-control" required placeholder="***">
        </div>
        <button type="submit" name="reset" class="btn btn-success w-100 mb-3" style="background: #15803d; border:none; padding:10px;">Reset Password</button>
        
        <div class="text-center" style="font-size: 0.9rem;">
            <a href="login_user.php" class="text-muted d-inline-block" style="text-decoration: none;">&larr; Kembali ke Login</a>
        </div>
    </form>
</div>

</body>
</html>
