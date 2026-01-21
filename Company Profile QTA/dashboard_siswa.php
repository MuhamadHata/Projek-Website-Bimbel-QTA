<?php 
session_start(); 

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== TRUE) {
    header("Location: login.php");
    exit;
}

include 'includes/db_connect.php'; 


$user_id = $_SESSION['user_id'];
$nama_siswa = $_SESSION['nama'];
$username_siswa = $_SESSION['username'];

$sql_nilai = "SELECT judul_kuis, nilai, total_soal, waktu_submit 
              FROM hasil_kuis 
              WHERE user_id = '$user_id' 
              ORDER BY waktu_submit ASC"; 

$result_nilai = $conn->query($sql_nilai);

$labels = []; 
$nilai_data = []; 
$total_kuis = 0;

if ($result_nilai->num_rows > 0) {
    while($row = $result_nilai->fetch_assoc()) {
        $labels[] = $row['judul_kuis'];
        $nilai_data[] = $row['nilai'];
        $total_kuis++;
    }
    
    $result_nilai->data_seek(0); 
}

$sql_avg = "SELECT AVG(nilai) AS rata_rata FROM hasil_kuis WHERE user_id = '$user_id'";
$result_avg = $conn->query($sql_avg);
$rata_rata = "N/A";

if ($result_avg->num_rows > 0) {
    $row_avg = $result_avg->fetch_assoc();
    $rata_rata = round($row_avg['rata_rata'], 1);
}

$conn->close();

include 'includes/header.php'; 
?>

<section class="container py-5">
    <h1 class="text-center mb-4 fw-bold text-primary animate-on-scroll">
        Dashboard Siswa - <?php echo htmlspecialchars($nama_siswa); ?>
    </h1>
    <p class="lead text-center mb-5 animate-on-scroll">
        Selamat datang kembali! Mari pantau kemajuan belajar Anda.
    </p>

    <div class="row mb-5">
        
        <div class="col-md-3 mb-4 animate-on-scroll">
            <div class="card p-4 text-center bg-primary text-white h-100"> 
                <i class="fas fa-chart-line fa-3x mb-2"></i>
                <h4 class="fw-bold">Rata-rata Nilai</h4>
                <h1 class="display-4 fw-bolder"><?php echo $rata_rata; ?></h1>
                <p>dari <?php echo $total_kuis; ?> kuis.</p>
            </div>
        </div>
        
        <div class="col-md-3 mb-4 animate-on-scroll">
            <div class="card p-4 text-center bg-danger text-white h-100">
                <i class="fas fa-book-open fa-3x mb-2"></i>
                <h4 class="fw-bold">Materi Belajar</h4>
                <p class="mt-3">Akses semua modul belajar terbaru.</p>
                <a href="#" class="btn btn-light text-danger fw-bold">Akses Modul</a> 
            </div>
        </div>
        
        <div class="col-md-3 mb-4 animate-on-scroll">
            <div class="card p-4 text-center bg-warning text-dark h-100">
                <i class="fas fa-edit fa-3x mb-2"></i>
                <h4 class="fw-bold">Kerjakan Soal</h4>
                <p class="mt-3">Uji pemahaman Anda dengan Try Out.</p>
                <a href="#" class="btn btn-dark fw-bold">Mulai Ujian</a> 
            </div>
        </div>
        
        <div class="col-md-3 mb-4 animate-on-scroll">
            <div class="card p-4 bg-light h-100">
                <h4 class="fw-bold text-primary"><i class="fas fa-user-circle me-2"></i> Info Akun</h4>
                <p class="mb-1 small">Nama: <?php echo htmlspecialchars($nama_siswa); ?></p>
                <p class="mb-1 small">Status: <?php echo htmlspecialchars($_SESSION['role']); ?></p>
                <a href="logout.php" class="btn btn-danger btn-sm mt-3 w-100"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </div>
        </div>

    </div>
    
    <div class="row mb-5">
        <div class="col-12 animate-on-scroll">
            <h2 class="fw-bold mb-4 border-bottom pb-2">Grafik Tren Nilai</h2>
            <div class="card p-4 shadow-sm">
                <?php if ($total_kuis > 0) : ?>
                    <canvas id="nilaiChart"></canvas>
                <?php else : ?>
                    <div class="alert alert-warning text-center">Kerjakan kuis pertama Anda untuk melihat tren nilai!</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 animate-on-scroll">
            <h2 class="fw-bold mb-4 border-bottom pb-2">Riwayat Semua Hasil Ujian</h2>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover shadow-sm">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>Judul Kuis/Ujian</th>
                            <th>Nilai</th>
                            <th>Total Soal</th>
                            <th>Tanggal Ujian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if ($result_nilai->num_rows > 0) {
                            // Reset pointer result untuk menampilkan dari awal lagi
                            $result_nilai->data_seek(0); 
                            while($row = $result_nilai->fetch_assoc()) {
                                $waktu_format = date('d M Y, H:i', strtotime($row['waktu_submit']));
                                // Menggunakan badge bg-danger (untuk warna Merah/Aksen)
                                echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$row['judul_kuis']}</td>
                                    <td><span class='badge bg-danger text-white fs-6'>{$row['nilai']}</span></td>
                                    <td>{$row['total_soal']}</td>
                                    <td>{$waktu_format}</td>
                                </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>Belum ada riwayat ujian yang tercatat.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    
    const labels = <?php echo json_encode($labels); ?>;
    const dataNilai = <?php echo json_encode($nilai_data); ?>;

    if (labels.length > 0) {
        const ctx = document.getElementById('nilaiChart');
        
        new Chart(ctx, {
            type: 'line', 
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nilai Kuis (%)',
                    data: dataNilai,
                    borderColor: 'rgba(0, 77, 153, 1)', 
                    backgroundColor: 'rgba(0, 77, 153, 0.1)',
                    tension: 0.4, 
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100, 
                        title: {
                            display: true,
                            text: 'Nilai (%)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false 
                    },
                    title: {
                        display: true,
                        text: 'Peningkatan Hasil Belajar Seiring Waktu'
                    }
                }
            }
        });
    }
</script>

<?php 
include 'includes/footer.php'; 
?>