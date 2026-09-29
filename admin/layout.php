<?php
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
if (!isset($active_page)) {
    $active_page = basename($_SERVER['PHP_SELF']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Wisata Nganjuk</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,700;0,800;1,500&display=swap" rel="stylesheet">
    
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-body: #f8fafc;
            --bg-sidebar: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --accent-green: #15803d;  /* Hijau Khas Nganjuk */
            --accent-yellow: #ca8a04; /* Kuning Emas Nganjuk */
            --accent-blue: #0369a1;   /* Biru Nganjuk */
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: var(--bg-sidebar);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            box-shadow: 2px 0 15px rgba(0,0,0,0.03);
            border-right: 1px solid var(--border-color);
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
            text-align: center;
            margin-bottom: 30px;
            padding: 0 20px;
            text-decoration: none;
        }

        .sidebar-brand span {
            color: var(--accent-green);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        .sidebar-menu li {
            padding: 5px 20px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .sidebar-menu a i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-menu a:hover {
            background: rgba(21, 128, 61, 0.05); /* Light Green */
            color: var(--accent-green);
        }

        .sidebar-menu a.active {
            background: var(--accent-green);
            color: white;
            box-shadow: 0 4px 10px rgba(21, 128, 61, 0.3);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid var(--border-color);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 10px;
            background: #fef2f2;
            color: #dc2626;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: #dc2626;
            color: white;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 260px;
            padding: 30px 40px;
            min-height: 100vh;
        }

        /* HEADER */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .page-header h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--text-main);
            margin: 0;
            font-family: 'Playfair Display', serif;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            color: var(--text-muted);
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            background: var(--accent-green);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        /* WHITE CARD CONTAINER */
        .content-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            border: 1px solid var(--border-color);
        }

        /* BUTTONS */
        .btn-success {
            background-color: var(--accent-green);
            border-color: var(--accent-green);
        }
        .btn-success:hover {
            background-color: #166534;
            border-color: #166534;
        }
        .btn-warning {
            background-color: var(--accent-yellow);
            border-color: var(--accent-yellow);
            color: white;
        }
        .btn-warning:hover {
            background-color: #a16207;
            border-color: #a16207;
            color: white;
        }
        .btn-info {
            background-color: var(--accent-blue);
            border-color: var(--accent-blue);
            color: white;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <a href="dashboard.php" class="sidebar-brand">
            Admin <span>Nganjuk</span>
        </a>
        
        <ul class="sidebar-menu">
            <li>
                <a href="dashboard.php" class="<?= $active_page == 'dashboard.php' ? 'active' : '' ?>">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="wisata.php" class="<?= $active_page == 'wisata.php' ? 'active' : '' ?>">
                    <i class="fa-solid fa-mountain-sun"></i> Kelola Wisata
                </a>
            </li>
            <li>
                <a href="kuliner.php" class="<?= $active_page == 'kuliner.php' ? 'active' : '' ?>">
                    <i class="fa-solid fa-utensils"></i> Kelola Kuliner
                </a>
            </li>
            <li>
                <a href="event.php" class="<?= $active_page == 'event.php' ? 'active' : '' ?>">
                    <i class="fa-solid fa-calendar-star"></i> Kelola Event
                </a>
            </li>
            <li>
                <a href="../index.php" target="_blank">
                    <i class="fa-solid fa-earth-asia"></i> Lihat Website
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <a href="logout.php" class="btn-logout" onclick="return confirm('Yakin ingin keluar?')">
                <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout
            </a>
        </div>
    </div>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="main-content">
        <!-- HEADER -->
        <div class="page-header">
            <h2 id="page-title">Dashboard</h2>
            <div class="admin-profile">
                <span>Halo, Admin</span>
                <div class="admin-avatar">
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>
        </div>

        <!-- INJECT CONTENT HERE -->
        <div id="app-content">
            <?= $content ?? '' ?>
        </div>
    </div>

    <!-- Script to set title dynamically -->
    <script>
        const activeMenu = document.querySelector('.sidebar-menu a.active');
        if(activeMenu) {
            document.getElementById('page-title').innerText = activeMenu.innerText;
        }
    </script>
</body>
</html>