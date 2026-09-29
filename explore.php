<?php
include 'config.php';

// Ambil 3 ulasan terbaik terbaru untuk ditampilkan di beranda
$testimoni = [];
$q_testi = mysqli_query($conn, "SELECT r.*, u.nama as nama_user FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.rating >= 4 ORDER BY r.id DESC LIMIT 3");
if($q_testi) {
    while($row = mysqli_fetch_assoc($q_testi)) $testimoni[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wonderful Nganjuk - Jantung Hati Jawa Timur</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,700;0,800;1,500&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --text-main: #1e293b;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --bg-white: #ffffff;
            --accent-green: #15803d;  /* Hijau Khas Nganjuk */
            --accent-yellow: #ca8a04; /* Kuning Emas Nganjuk */
            --accent-blue: #0369a1;   /* Biru Nganjuk */
        }

        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background: white;
            color: var(--text-main);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, .brand-text {
            font-family: 'Playfair Display', serif;
        }

        /* HEADER NAVBAR */
        .navbar-custom {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 15px 5%;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
            text-decoration: none;
            display: flex;
            align-items: center;
            line-height: 1.2;
        }

        .navbar-brand span {
            color: var(--accent-green);
            font-size: 1rem;
            font-weight: 400;
        }
        
        .nav-links {
            display: flex;
            gap: 25px;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #6b7280;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s;
        }
        
        .nav-links a:hover, .nav-links a.active {
            color: #ef4444;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-actions i {
            color: var(--text-main);
            font-size: 1.2rem;
            cursor: pointer;
        }

        /* HERO SECTION */
        .hero {
            height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            margin-top: 0;
            overflow: hidden;
        }

        .hero-carousel {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: 0;
        }

        .carousel-item {
            transition: transform 1.2s ease-in-out, opacity 1.2s ease-in-out;
        }

        .carousel-item img {
            width: 100%;
            height: 100vh;
            object-fit: cover;
        }

        .carousel-control-prev, .carousel-control-next {
            width: 50px;
            height: 50px;
            background: black;
            top: 50%;
            transform: translateY(-50%);
            opacity: 1;
            border-radius: 0;
            z-index: 20;
        }

        @keyframes textFadeUp {
            from {
                opacity: 0;
                transform: translateY(60px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .hero-big-text {
            font-size: 12vw;
            font-weight: 800;
            color: white;
            text-align: center;
            line-height: 1.1;
            font-family: 'Montserrat', sans-serif;
            text-shadow: 0 10px 30px rgba(0,0,0,0.4);
            z-index: 10;
            margin-top: 50px;
            letter-spacing: -2px;
            pointer-events: none;
            animation: textFadeUp 1.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        .hero-cloud {
            position: absolute;
            bottom: -20px;
            left: 0;
            width: 100%;
            height: 350px;
            background: linear-gradient(to top, white 20%, rgba(255,255,255,0.7) 60%, transparent 100%);
            z-index: 5;
            pointer-events: none;
            filter: blur(10px);
        }

        .btn-trip {
            position: relative;
            z-index: 15;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            color: white;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
            margin-top: -30px;
            transition: transform 0.3s ease;
        }

        .btn-trip:hover {
            transform: translateY(-3px);
            color: white;
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.5);
        }
        
        .btn-trip i {
            font-size: 1.5rem;
        }

        /* SECTION */
        .section {
            padding: 120px 5% 60px;
            background: white;
        }

        /* HEADER SECTION */
        .section-header {
            text-align: center;
            margin-bottom: 70px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .section-header h2 {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 20px;
            letter-spacing: -1px;
        }

        .section-header p {
            color: var(--text-muted);
            font-size: 1.15rem;
            line-height: 1.8;
            font-weight: 400;
        }

        /* NAV BUTTONS */
        .nav-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-bottom: 20px;
            padding-right: 5%;
        }

        .nav-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: white;
            border: 1px solid #e2e8f0;
            color: var(--text-main);
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .nav-btn:hover {
            background: var(--accent-green);
            color: white;
            border-color: var(--accent-green);
            transform: scale(1.05);
        }

        /* SLIDER */
        .slider-wrapper {
            position: relative;
            margin: 0 -5%;
            padding: 10px 5% 40px;
        }

        .slider {
            display: flex;
            gap: 30px;
            overflow-x: auto;
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
            padding-bottom: 20px;
        }

        .slider::-webkit-scrollbar {
            display: none; /* Hide scrollbar for a cleaner magazine look */
        }

        /* CARD */
        .card-item {
            min-width: 380px;
            border-radius: 0;
            overflow: hidden;
            position: relative;
            flex: 0 0 auto;
            scroll-snap-align: start;
            transition: all 0.4s ease;
            text-decoration: none;
            background: white;
            border: 1px solid #f1f5f9;
            box-shadow: none;
            display: flex;
            flex-direction: column;
        }

        .card-img-wrapper {
            width: 100%;
            height: 250px;
            overflow: hidden;
            position: relative;
        }

        .card-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.06);
            border-color: transparent;
        }

        .card-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 1s ease;
        }

        .card-item:hover img {
            transform: scale(1.05);
        }

        .card-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background: white;
            color: var(--text-main);
            padding: 6px 15px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            z-index: 2;
        }

        .card-content {
            padding: 35px 30px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-item h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 15px;
            transition: color 0.3s ease;
        }

        .card-item:hover h3 {
            color: var(--accent-green);
        }

        .card-item p {
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-footer {
            margin-top: auto;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            color: var(--accent-green);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: transparent;
            border: none;
            padding: 0;
        }

        .card-footer i {
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        .card-item:hover .card-footer i {
            transform: translateX(5px);
        }

        /* FOOTER */
        footer {
            background: var(--bg-white);
            padding: 60px 5%;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 20px;
        }
        
        .footer-logo span {
            color: var(--accent-green);
        }
    </style>
</head>

<body>

<!-- HEADER -->
<nav class="navbar-custom">
    <a href="index.php" class="navbar-brand" style="display: flex; align-items: center; text-decoration: none;">
        <img src="assets/img/imgbin-nganjuk-regency-logo-sedudo-waterfall-others-E7KLt8zCV21fNhya7677U5e77.jpg" alt="Logo Nganjuk" style="height: 55px; margin-right: 15px;">
        <div style="line-height: 1.2; color: var(--text-main);">
            Wonderful<br>
            <span style="color: var(--accent-green); font-size: 1rem; font-weight: 400;">Nganjuk</span>
        </div>
    </a>
    <div class="nav-links d-none d-md-flex">
        <a href="index.php" class="active">Home</a>
        <a href="wisata.php">Wisata</a>
        <a href="kuliner.php">Kuliner</a>
        <a href="event.php">Event</a>
    </div>
    <div class="nav-actions d-flex align-items-center gap-3">
        <!-- Widget Cuaca -->
        <div id="weather-widget" class="d-flex align-items-center text-muted" style="font-size: 0.85rem; font-weight: 500;" title="Cuaca Nganjuk Saat Ini">
            <span id="weather-text"><i class="fa-solid fa-spinner fa-spin"></i> Cek Suhu</span>
        </div>

        <form action="search.php" method="GET" class="d-flex align-items-center rounded-pill px-3 py-1" style="border: 1px solid #e2e8f0; background: #f8fafc; margin: 0;">
            <input type="text" name="q" placeholder="Cari..." class="form-control bg-transparent border-0 shadow-none p-0 me-2" style="width: 130px; font-size: 0.9rem;" required>
            <button type="submit" class="btn p-0 border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></button>
        </form>

        <!-- User Profile / Login -->
        <?php if(isset($_SESSION['user_id'])): ?>
            <div class="dropdown">
                <a class="btn btn-light rounded-pill dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid #e2e8f0; background: white;">
                    <i class="fa-solid fa-circle-user text-success me-2"></i> <?= htmlspecialchars(explode(' ', $_SESSION['user_nama'] ?? 'User')[0]) ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius: 12px; margin-top: 10px;">
                    <li><a class="dropdown-item text-danger py-2" href="logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="login_user.php" class="btn btn-success rounded-pill px-4" style="background: var(--accent-green); border: none;">Login</a>
        <?php endif; ?>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <!-- Bootstrap Carousel -->
    <div id="heroCarousel" class="carousel slide carousel-fade hero-carousel" data-bs-ride="carousel" data-bs-interval="5000" data-bs-touch="true">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/img/sepasangcarrier 1.jpg" onerror="this.src='assets/img/banner.jpg'" alt="Slide 1">
            </div>
            <div class="carousel-item">
                <img src="assets/img/banner.jpg" alt="Slide 2">
            </div>
            <div class="carousel-item">
                <img src="assets/img/1777353582_Jolotundo.jpeg" alt="Slide 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <i class="fa-solid fa-arrow-left text-white"></i>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <i class="fa-solid fa-arrow-right text-white"></i>
        </button>
    </div>

    <!-- Huge Text Overlapping -->
    <h1 class="hero-big-text">WISATA<br>NGANJUK</h1>

    <!-- Cloud Mask Bottom -->
    <div class="hero-cloud"></div>

    <!-- Action Button Overlapping Cloud -->
    <!-- Action Button Overlapping Cloud -->
    <a href="#explore" class="btn-trip">
        <i class="fa-regular fa-compass"></i> Mulai Menjelajah
    </a>
</section>

<!-- MAIN EXPLORE SECTION -->
<section class="section" id="explore">
    <div class="section-header">
        <h2>Selamat Datang di Kota Angin</h2>
        <p>Nganjuk, kota yang kaya akan sejarah, pesona alam yang memukau, serta kelezatan kuliner yang tak tertandingi. Temukan pengalaman liburan yang tak terlupakan di setiap sudutnya.</p>
    </div>
    
    <div class="container" style="margin-top: 50px; margin-bottom: 50px;">
        <div class="row g-4 justify-content-center">
            <!-- Wisata -->
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden; height: 100%; transition: transform 0.3s ease;">
                    <img src="assets/img/sepasangcarrier 1.jpg" onerror="this.src='assets/img/banner.jpg'" class="card-img-top" style="height: 220px; object-fit: cover;" alt="Wisata">
                    <div class="card-body text-center p-4">
                        <div style="width: 70px; height: 70px; background: var(--accent-green); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: -55px auto 20px; position: relative; z-index: 1; border: 5px solid white;">
                            <i class="fa-solid fa-mountain-sun text-white" style="font-size: 1.8rem;"></i>
                        </div>
                        <h4 style="font-family: 'Playfair Display', serif; font-weight: 700; color: var(--text-main);">Destinasi Wisata</h4>
                        <p class="text-muted" style="font-size: 0.95rem; line-height: 1.6;">Jelajahi keindahan alam memukau dari air terjun merambat hingga goa eksotis.</p>
                        <a href="wisata.php" class="btn rounded-pill mt-3 px-4 fw-bold" style="background: rgba(21,128,61,0.1); color: var(--accent-green);">Eksplor Wisata</a>
                    </div>
                </div>
            </div>
            
            <!-- Kuliner -->
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden; height: 100%; transition: transform 0.3s ease;">
                    <img src="assets/img/1777437662_47558f6d-bb7f-4575-8eb1-0888949ce951-3433108699.jpeg" onerror="this.src='assets/img/default.jpg'" class="card-img-top" style="height: 220px; object-fit: cover;" alt="Kuliner">
                    <div class="card-body text-center p-4">
                        <div style="width: 70px; height: 70px; background: var(--accent-yellow); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: -55px auto 20px; position: relative; z-index: 1; border: 5px solid white;">
                            <i class="fa-solid fa-utensils text-white" style="font-size: 1.8rem;"></i>
                        </div>
                        <h4 style="font-family: 'Playfair Display', serif; font-weight: 700; color: var(--text-main);">Kuliner Khas</h4>
                        <p class="text-muted" style="font-size: 0.95rem; line-height: 1.6;">Cicipi kelezatan resep legendaris warisan leluhur yang kaya akan rempah.</p>
                        <a href="kuliner.php" class="btn rounded-pill mt-3 px-4 fw-bold" style="background: rgba(202,138,4,0.1); color: var(--accent-yellow);">Eksplor Kuliner</a>
                    </div>
                </div>
            </div>
            
            <!-- Event -->
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden; height: 100%; transition: transform 0.3s ease;">
                    <img src="assets/img/1777436619_FotoJet-53-1137886000.webp" onerror="this.src='assets/img/default.jpg'" class="card-img-top" style="height: 220px; object-fit: cover;" alt="Event">
                    <div class="card-body text-center p-4">
                        <div style="width: 70px; height: 70px; background: var(--accent-blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: -55px auto 20px; position: relative; z-index: 1; border: 5px solid white;">
                            <i class="fa-solid fa-calendar-days text-white" style="font-size: 1.8rem;"></i>
                        </div>
                        <h4 style="font-family: 'Playfair Display', serif; font-weight: 700; color: var(--text-main);">Event & Budaya</h4>
                        <p class="text-muted" style="font-size: 0.95rem; line-height: 1.6;">Saksikan kemeriahan perayaan tradisi dan acara budaya masyarakat lokal.</p>
                        <a href="event.php" class="btn rounded-pill mt-3 px-4 fw-bold" style="background: rgba(3,105,161,0.1); color: var(--accent-blue);">Eksplor Event</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIAL SECTION (Social Proof) -->
<?php if(count($testimoni) > 0): ?>
<section class="section" style="background: white; padding-top: 40px; padding-bottom: 80px;" data-aos="fade-up">
    <div class="section-header" style="margin-bottom: 40px;">
        <h2>Apa Kata Mereka?</h2>
        <p>Ulasan terbaru dari pengunjung yang telah menjelajahi pesona Nganjuk.</p>
    </div>
    <div class="container">
        <div class="row justify-content-center g-4">
            <?php foreach($testimoni as $t): ?>
            <div class="col-12 col-md-4">
                <div class="card h-100 border-0" style="background: var(--bg-light); border-radius: 15px; padding: 20px;">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 45px; height: 45px; background: var(--accent-green); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; margin-right: 15px;">
                            <?= strtoupper(substr($t['nama_user'], 0, 1)) ?>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold"><?= htmlspecialchars($t['nama_user']) ?></h6>
                            <div class="text-warning" style="font-size: 0.8rem;">
                                <?= str_repeat('⭐', $t['rating']) ?>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted fst-italic mb-0" style="font-size: 0.9rem;">"<?= htmlspecialchars(substr($t['komentar'], 0, 120)) ?><?= strlen($t['komentar']) > 120 ? '...' : '' ?>"</p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<footer>
    <div class="footer-logo">Wonderful <span>Nganjuk</span></div>
    <p class="text-muted mb-0" style="font-size: 0.9rem;">&copy; <?= date('Y') ?> Dinas Pariwisata Kabupaten Nganjuk. All rights reserved.</p>
</footer>

<!-- JS LIBRARIES -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
// INITIALIZE AOS (Animation)
AOS.init({
    duration: 800,
    once: true,
    offset: 100
});

// ADD ANIMATION CLASSES TO CARDS DYNAMICALLY
document.querySelectorAll('.card').forEach((el, index) => {
    el.setAttribute('data-aos', 'fade-up');
    el.setAttribute('data-aos-delay', (index * 100).toString());
});

// FETCH WEATHER
fetch('https://wttr.in/Nganjuk?format=%c+%t')
    .then(response => response.text())
    .then(data => {
        document.getElementById('weather-text').innerHTML = data;
    })
    .catch(err => {
        document.getElementById('weather-text').innerHTML = '<i class="fa-solid fa-cloud"></i> Nganjuk';
    });

// SWEETALERT FOR LOGIN/REGISTER PARAMS
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.has('login_success')) {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil Login!',
        text: 'Selamat datang kembali di Wonderful Nganjuk.',
        timer: 3000,
        showConfirmButton: false
    });
    // hapus param dari URL agar tidak muncul terus saat refresh
    window.history.replaceState({}, document.title, "index.php");
}
</script>
</body>
</html>