<?php
include '../config.php';
if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email' AND password='$password'");
    if (mysqli_num_rows($query) > 0) {
        $_SESSION['admin'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Wonderful Nganjuk</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,700;0,800;1,500&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --accent-green: #15803d;
            --text-main: #1e293b;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
            background-color: #f8fafc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            display: flex;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            overflow: hidden;
            width: 900px;
            max-width: 90%;
            min-height: 500px;
        }

        .login-image {
            flex: 1;
            background: url('../assets/img/default.jpg') center/cover;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .login-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(21,128,61,0.8) 0%, rgba(3,105,161,0.8) 100%);
        }

        .image-content {
            position: relative;
            z-index: 10;
            text-align: center;
            color: white;
        }

        .image-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .image-content p {
            font-size: 1rem;
            opacity: 0.9;
        }

        .login-form-container {
            flex: 1;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form-container h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 10px;
        }

        .login-form-container p {
            color: #64748b;
            margin-bottom: 30px;
            font-size: 0.95rem;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--accent-green);
            box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.1);
        }

        .btn-login {
            background-color: var(--accent-green);
            color: white;
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #166534;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(21, 128, 61, 0.3);
        }

        .alert {
            font-size: 0.9rem;
            padding: 10px 15px;
            border-radius: 10px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: var(--accent-green);
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }
            .login-image {
                min-height: 200px;
            }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="login-image">
            <div class="image-content">
                <h1>Wonderful Nganjuk</h1>
                <p>Content Management System</p>
            </div>
        </div>
        <div class="login-form-container">
            <h2>Selamat Datang</h2>
            <p>Silakan masuk ke akun administrator Anda.</p>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label" style="font-weight: 500; font-size: 0.9rem;">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label" style="font-weight: 500; font-size: 0.9rem;">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                
                <button type="submit" name="login" class="btn-login">Login Sekarang</button>
            </form>

            <div class="text-center">
                <a href="../index.php" class="back-link">← Kembali ke Halaman Utama</a>
            </div>
        </div>
    </div>

</body>
</html>