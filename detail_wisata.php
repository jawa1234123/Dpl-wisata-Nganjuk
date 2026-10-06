<?php
include 'config.php';
use App\Repositories\WisataRepository;

$id = $_GET['id'] ?? 0;

// ambil data
$wisataRepo = new WisataRepository($conn);
$data = $wisataRepo->getById($id);

// jika tidak ada data
if (!$data) {
    die("Data tidak ditemukan");
}

// handle gambar
$gambar = $data['gambar'] ?? '';
$path_gambar = "assets/img/" . $gambar;

// fallback gambar
if ($gambar == '' || !file_exists($path_gambar)) {
    $path_gambar = "assets/img/default.jpg";
}

// Cek apakah user sudah memberikan ulasan
$user_review = null;
if (isset($_SESSION['user_id'])) {
    $u_id = $_SESSION['user_id'];
    $cek_rev = mysqli_query($conn, "SELECT * FROM reviews WHERE tipe='wisata' AND item_id=$id AND user_id=$u_id");
    if (mysqli_num_rows($cek_rev) > 0) {
        $user_review = mysqli_fetch_assoc($cek_rev);
    }
}

// Proses form ulasan (Tambah, Edit, Hapus)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        
        if (isset($_POST['submit_review'])) {
            if (!$user_review) {
                $rating = (int)$_POST['rating'];
                $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
                mysqli_query($conn, "INSERT INTO reviews (tipe, item_id, user_id, rating, komentar) VALUES ('wisata', $id, $user_id, $rating, '$komentar')");
                header("Location: detail_wisata.php?id=$id&review_success=1");
                exit;
            }
        } elseif (isset($_POST['edit_review'])) {
            if ($user_review) {
                $rating = (int)$_POST['rating'];
                $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
                $rev_id = $user_review['id'];
                mysqli_query($conn, "UPDATE reviews SET rating=$rating, komentar='$komentar' WHERE id=$rev_id AND user_id=$user_id");
                header("Location: detail_wisata.php?id=$id&review_updated=1");
                exit;
            }
        } elseif (isset($_POST['delete_review'])) {
            if ($user_review) {
                $rev_id = $user_review['id'];
                mysqli_query($conn, "DELETE FROM reviews WHERE id=$rev_id AND user_id=$user_id");
                header("Location: detail_wisata.php?id=$id&review_deleted=1");
                exit;
            }
        }
    } else {
        $error_msg = "Anda harus login untuk memberikan ulasan.";
    }
}

// Ambil data ulasan
$q_reviews = mysqli_query($conn, "SELECT r.*, u.nama as nama_user FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.tipe='wisata' AND r.item_id=$id ORDER BY r.id DESC");
$reviews = [];
while($row = mysqli_fetch_assoc($q_reviews)) {
    $reviews[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['nama'] ?> - Wonderful Nganjuk</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,700;0,800;1,500&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --text-main: #1e293b;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --bg-white: #ffffff;
            --accent-green: #15803d; /* Hijau Khas Nganjuk */
        }

        body {
            margin: 0;
            background: var(--bg-light);
            color: var(--text-main);
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, .brand-text {
            font-family: 'Playfair Display', serif;
        }

        /* NAVBAR */
        .navbar-custom {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 5%;
            z-index: 100;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: white;
            text-decoration: none;
            background: rgba(0,0,0,0.4);
            padding: 10px 20px;
            border-radius: 30px;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
            font-weight: 500;
            font-family: 'Montserrat', sans-serif;
        }

        .btn-back:hover {
            background: white;
            color: var(--text-main);
        }

        /* HERO HEADER */
        .hero-header {
            position: relative;
            height: 70vh;
            width: 100%;
        }

        .hero-header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.1) 50%, rgba(0,0,0,0.7) 100%);
        }

        .hero-text {
            position: absolute;
            bottom: 50px;
            left: 5%;
            color: white;
            z-index: 10;
        }

        .badge-kategori {
            background: var(--accent-green);
            color: white;
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            display: inline-block;
            margin-bottom: 20px;
            font-family: 'Montserrat', sans-serif;
        }

        .hero-text h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 10px;
            text-shadow: 0 4px 15px rgba(0,0,0,0.5);
            font-style: italic;
        }

        .hero-text .location {
            font-size: 1.2rem;
            font-weight: 400;
            text-shadow: 0 2px 5px rgba(0,0,0,0.5);
        }

        /* MAIN CONTENT */
        .content-wrapper {
            background: var(--bg-white);
            padding: 60px 5%;
            margin-top: -20px;
            position: relative;
            z-index: 20;
            border-radius: 20px 20px 0 0;
            box-shadow: 0 -10px 30px rgba(0,0,0,0.1);
        }

        .article-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .article-content p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #475569;
            margin-bottom: 25px;
            text-align: justify;
        }

        .article-content p:first-of-type::first-letter {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            float: left;
            line-height: 0.8;
            margin-right: 15px;
            margin-top: 5px;
            color: var(--accent-green);
            font-weight: 700;
        }

        /* INFO GRID */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 50px 0;
            background: var(--bg-light);
            padding: 40px;
            border-radius: 16px;
            border-left: 5px solid var(--accent-green);
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .info-icon {
            font-size: 1.5rem;
            color: var(--accent-green);
            background: white;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .info-text h4 {
            font-size: 1rem;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--text-main);
        }

        .info-text p {
            font-size: 0.95rem;
            color: var(--text-muted);
            margin: 0;
            text-align: left;
        }
        
        .info-text p::first-letter {
            font-size: 0.95rem;
            font-family: 'Montserrat', sans-serif;
            float: none;
            color: var(--text-muted);
        }

        /* MAP SECTION */
        .map-section {
            margin-top: 50px;
        }

        .map-section h2 {
            font-size: 2rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .map-container {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .map-container iframe {
            width: 100%;
            height: 450px;
            border: none;
            display: block;
        }

        footer {
            background: #1e293b;
            color: white;
            text-align: center;
            padding: 40px 0;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar-custom">
    <a href="index.php" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<!-- HERO HEADER -->
<div class="hero-header">
    <img src="<?= $path_gambar ?>" alt="<?= $data['nama'] ?>">
    <div class="hero-overlay"></div>
    
    <div class="hero-text">
        <span class="badge-kategori"><?= $data['kategori'] ?></span>
        <h1><?= $data['nama'] ?></h1>
        <div class="location"><i class="fa-solid fa-location-dot text-danger me-2"></i> <?= $data['lokasi'] ?></div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="content-wrapper">
    <div class="article-content">
        
        <?= nl2br($data['deskripsi']) ?>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                <div class="info-text">
                    <h4>Alamat Lokasi</h4>
                    <p><?= $data['lokasi'] ?></p>
                </div>
            </div>
            <div class="info-item">
                <div class="info-icon"><i class="fa-solid fa-tag"></i></div>
                <div class="info-text">
                    <h4>Kategori Wisata</h4>
                    <p><?= $data['kategori'] ?></p>
                </div>
            </div>
        </div>

        <div class="map-section">
            <h2>Peta Penunjuk Arah</h2>
            <div class="map-container">
                <iframe src="https://maps.google.com/maps?q=<?= $data['latitude'] ?>,<?= $data['longitude'] ?>&z=15&output=embed" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>

        <!-- REVIEWS SECTION -->
        <div class="reviews-section" style="margin-top: 50px;">
            <h2 style="font-size: 2rem; margin-bottom: 30px; text-align: center;">Ulasan Pengunjung</h2>
            
            <?php if(isset($error_msg)): ?>
                <div class="alert alert-danger"><?= $error_msg ?></div>
            <?php endif; ?>

            <?php if(isset($_SESSION['user_id'])): ?>
                <?php if($user_review): ?>
                <!-- Form Edit/Hapus Ulasan -->
                <div class="card mb-4" style="border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-radius: 12px; border-left: 4px solid #f59e0b;">
                    <div class="card-body p-4">
                        <h5 class="mb-3" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">Ulasan Anda</h5>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <select name="rating" class="form-select" required style="width: 150px;">
                                    <option value="5" <?= $user_review['rating']==5 ? 'selected':'' ?>>⭐⭐⭐⭐⭐ (5/5)</option>
                                    <option value="4" <?= $user_review['rating']==4 ? 'selected':'' ?>>⭐⭐⭐⭐ (4/5)</option>
                                    <option value="3" <?= $user_review['rating']==3 ? 'selected':'' ?>>⭐⭐⭐ (3/5)</option>
                                    <option value="2" <?= $user_review['rating']==2 ? 'selected':'' ?>>⭐⭐ (2/5)</option>
                                    <option value="1" <?= $user_review['rating']==1 ? 'selected':'' ?>>⭐ (1/5)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Komentar</label>
                                <textarea name="komentar" class="form-control" rows="3" required><?= htmlspecialchars($user_review['komentar']) ?></textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" name="edit_review" class="btn btn-warning text-white" style="border: none; padding: 10px 25px; border-radius: 30px;">Update Ulasan</button>
                                <button type="submit" name="delete_review" class="btn btn-danger" style="border: none; padding: 10px 25px; border-radius: 30px;" onclick="return confirm('Yakin ingin menghapus ulasan ini?');">Hapus Ulasan</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php else: ?>
                <!-- Form Tambah Ulasan -->
                <div class="card mb-4" style="border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-radius: 12px;">
                    <div class="card-body p-4">
                        <h5 class="mb-3" style="font-family: 'Montserrat', sans-serif; font-weight: 600;">Tulis Ulasan Anda</h5>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <select name="rating" class="form-select" required style="width: 150px;">
                                    <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                                    <option value="4">⭐⭐⭐⭐ (4/5)</option>
                                    <option value="3">⭐⭐⭐ (3/5)</option>
                                    <option value="2">⭐⭐ (2/5)</option>
                                    <option value="1">⭐ (1/5)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Komentar</label>
                                <textarea name="komentar" class="form-control" rows="3" required placeholder="Bagaimana pengalaman Anda?"></textarea>
                            </div>
                            <button type="submit" name="submit_review" class="btn btn-success" style="background: var(--accent-green); border: none; padding: 10px 25px; border-radius: 30px;">Kirim Ulasan</button>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
            <?php else: ?>
            <div class="alert alert-info text-center" style="border-radius: 10px;">
                Silakan <a href="login_user.php" class="alert-link">Login</a> untuk memberikan ulasan.
            </div>
            <?php endif; ?>

            <div class="review-list">
                <?php if(count($reviews) > 0): ?>
                    <?php foreach($reviews as $rev): ?>
                    <div class="card mb-3" style="border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border-radius: 10px;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0" style="font-weight: 700; color: var(--text-main);"><i class="fa-solid fa-circle-user text-muted me-2"></i><?= htmlspecialchars($rev['nama_user']) ?></h6>
                                <div class="text-warning" style="font-size: 0.9rem;">
                                    <?= str_repeat('⭐', $rev['rating']) ?>
                                </div>
                            </div>
                            <small class="text-muted d-block mb-2"><?= date('d M Y, H:i', strtotime($rev['created_at'])) ?></small>
                            <p class="mb-0" style="color: #475569;"><?= nl2br(htmlspecialchars($rev['komentar'])) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-muted">Belum ada ulasan untuk tempat wisata ini. Jadilah yang pertama!</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- END REVIEWS -->

        <div class="share-section" style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #e2e8f0; text-align: center;">
            <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1.1rem; font-weight: 600; margin-bottom: 15px;">Bagikan ke Teman:</h4>
            <a href="https://wa.me/?text=Lihat Wisata <?= urlencode($data['nama']) ?> di Nganjuk: <?= urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ?>" target="_blank" class="btn btn-success rounded-circle me-2" style="width: 45px; height: 45px; display: inline-flex; align-items: center; justify-content: center;"><i class="fa-brands fa-whatsapp"></i></a>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ?>" target="_blank" class="btn btn-primary rounded-circle me-2" style="width: 45px; height: 45px; display: inline-flex; align-items: center; justify-content: center;"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="https://twitter.com/intent/tweet?url=<?= urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ?>&text=Lihat Wisata <?= urlencode($data['nama']) ?> di Nganjuk!" target="_blank" class="btn btn-info text-white rounded-circle" style="width: 45px; height: 45px; display: inline-flex; align-items: center; justify-content: center;"><i class="fa-brands fa-twitter"></i></a>
        </div>

    </div>
</div>

<footer>
    <div style="font-family: 'Playfair Display', serif; font-size: 1.5rem; margin-bottom: 10px;">Wonderful <span style="color: var(--accent-green);">Nganjuk</span></div>
    &copy; <?= date('Y') ?> Wisata Nganjuk
</footer>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('review_success') || urlParams.has('review_updated') || urlParams.has('review_deleted')) {
        let titleMsg = 'Berhasil!';
        let textMsg = '';
        if (urlParams.has('review_success')) textMsg = 'Ulasan Anda berhasil dikirimkan.';
        if (urlParams.has('review_updated')) textMsg = 'Ulasan Anda berhasil diperbarui.';
        if (urlParams.has('review_deleted')) textMsg = 'Ulasan Anda berhasil dihapus.';

        Swal.fire({
            icon: 'success',
            title: titleMsg,
            text: textMsg,
            timer: 3000,
            showConfirmButton: false
        });
        urlParams.delete('review_success');
        urlParams.delete('review_updated');
        urlParams.delete('review_deleted');
        let newUrl = window.location.pathname + '?' + urlParams.toString();
        window.history.replaceState({}, document.title, newUrl);
    }
</script>
</body>
</html>