<?php 
// KRITIS: session_start() harus dipanggil di baris pertama file utama
session_start(); 
include 'includes/header.php'; 
?>

<header class="bg-light p-5 text-center bg-dynamic-section"> 
    <div class="container">
        <h1 class="display-4 fw-bold animate-on-scroll">Siap Berprestasi? QTA Solusinya!</h1> 
        <p class="lead mt-3 animate-on-scroll">Mencetak generasi cerdas, berkarakter, dan siap meraih masa depan cemerlang.</p>
        
        <a href="layanan.php" class="btn btn-primary btn-lg mt-3 me-2 animate-on-scroll">Lihat Program Kami</a>
        <a href="http://moodle.test/login/index.php" class="btn btn-outline-primary btn-lg mt-3 animate-on-scroll">Login Sekarang</a>
    </div>
</header>

<section class="bg-light-bg py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold animate-on-scroll">Mengapa Memilih QTA Bimbel?</h2>
        <div class="row text-center">
            
            <div class="col-md-4 mb-4 animate-on-scroll">
                <div class="p-4 border rounded shadow-sm bg-white h-100">
                    <i class="fas fa-chalkboard-teacher fa-3x text-warning mb-3"></i>
                    <h5 class="fw-bold">Pengajar Profesional</h5>
                    <p>Dibimbing oleh mentor berpengalaman dan lulusan universitas terkemuka.</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4 animate-on-scroll">
                <div class="p-4 border rounded shadow-sm bg-white h-100">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i> 
                    <h5 class="fw-bold">Kelas Kecil</h5>
                    <p>Fokus belajar maksimal dengan rasio siswa yang optimal, perhatian personal terjamin.</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4 animate-on-scroll">
                <div class="p-4 border rounded shadow-sm bg-white h-100">
                    <i class="fas fa-book-open fa-3x text-warning mb-3"></i>
                    <h5 class="fw-bold">Materi Terkini</h5>
                    <p>Materi belajar yang selalu diperbarui sesuai kurikulum terbaru dan kebutuhan ujian.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
include 'includes/footer.php'; 
?>