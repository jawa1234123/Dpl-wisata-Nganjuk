<?php
include '../config.php';
use App\Repositories\WisataRepository;
use App\Repositories\KulinerRepository;
use App\Repositories\EventRepository;

$wisataRepo = new WisataRepository($conn);
$tw = $wisataRepo->count();

$kulinerRepo = new KulinerRepository($conn);
$tk = $kulinerRepo->count();

$eventRepo = new EventRepository($conn);
$te = $eventRepo->count();

ob_start();
?>
<style>
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    border: 1px solid var(--border-color);
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
}

/* Nganjuk Colors */
.icon-wisata { background: linear-gradient(135deg, #15803d, #16a34a); }
.icon-kuliner { background: linear-gradient(135deg, #ca8a04, #eab308); }
.icon-event { background: linear-gradient(135deg, #0369a1, #0284c7); }

.stat-info h3 {
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-main);
}

.stat-info p {
    margin: 0;
    color: var(--text-muted);
    font-size: 0.95rem;
    font-weight: 500;
}
</style>

<div class="dashboard-grid">
    <div class="stat-card">
        <div class="stat-icon icon-wisata">
            <i class="fa-solid fa-mountain-sun"></i>
        </div>
        <div class="stat-info">
            <h3><?= $tw ?></h3>
            <p>Total Wisata</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon icon-kuliner">
            <i class="fa-solid fa-utensils"></i>
        </div>
        <div class="stat-info">
            <h3><?= $tk ?></h3>
            <p>Total Kuliner</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon icon-event">
            <i class="fa-solid fa-calendar-star"></i>
        </div>
        <div class="stat-info">
            <h3><?= $te ?></h3>
            <p>Total Event</p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$active_page = 'dashboard.php';
include 'layout.php';
?>