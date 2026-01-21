<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$page_title = basename($_SERVER['PHP_SELF'], '.php');
$title = '';

switch ($page_title) {
    case 'index': $title = 'Beranda - Bimbingan Belajar QTA'; break;
    case 'profil': $title = 'Profil Lembaga - Bimbingan Belajar QTA'; break;
    case 'layanan': $title = 'Program & Layanan - Bimbingan Belajar QTA'; break;
    case 'portofolio_testimoni': $title = 'Portofolio & Testimoni - Bimbingan Belajar QTA'; break;
    case 'kontak_pendaftaran': $title = 'Kontak & Pendaftaran - Bimbingan Belajar QTA'; break;
    case 'login': $title = 'Login Siswa - Bimbingan Belajar QTA'; break;
    case 'dashboard_siswa': $title = 'Dashboard Siswa - Bimbingan Belajar QTA'; break;
    default: $title = 'Bimbingan Belajar QTA';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-custom sticky-top shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            <img src="assets/images/logo_qta.png" alt="Logo QTA Bimbel" height="30" class="d-inline-block align-text-top me-2">
            QTA Bimbel
        </a> 
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($page_title == 'index') ? 'active' : ''; ?>" href="index.php">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($page_title == 'profil') ? 'active' : ''; ?>" href="profil.php">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($page_title == 'layanan') ? 'active' : ''; ?>" href="layanan.php">Layanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($page_title == 'portofolio_testimoni') ? 'active' : ''; ?>" href="portofolio_testimoni.php">Portofolio & Testimoni</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($page_title == 'kontak_pendaftaran') ? 'active' : ''; ?>" href="kontak_pendaftaran.php">Kontak & Pendaftaran</a>
                </li>
                
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === TRUE) : ?>
                    <li class="nav-item ms-lg-3">
                        <a class="nav-link btn btn-success text-white" href="dashboard_siswa.php"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link btn btn-danger text-white" href="logout.php"><i class="fas fa-sign-out-alt me-1"></i> Logout</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item ms-lg-3">
                        <a class="nav-link btn btn-outline-warning" href="http://moodle.test/login/index.php"><i class="fas fa-sign-in-alt me-1"></i> Login Siswa</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>