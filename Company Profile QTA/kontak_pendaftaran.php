<?php 
include 'includes/header.php'; 
include 'includes/db_connect.php'; 

$pendaftaran_sukses = false;
$pesan_status = '';
$wa_url = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Ambil dan bersihkan data
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']); 
    $password = $_POST['password']; 
    $telepon = $conn->real_escape_string($_POST['telepon']);
    $program = $conn->real_escape_string($_POST['program']);
    $pesan_tambahan = $conn->real_escape_string($_POST['pesan'] ?? '-');

    if (!empty($nama) && !empty($email) && !empty($username) && !empty($password)) {
        try {
            // 2. Simpan ke tabel pendaftaran
            $sql_pendaftaran = "INSERT INTO pendaftaran (nama, email, telepon, program_minat, pesan) 
                                VALUES ('$nama', '$email', '$telepon', '$program', '$pesan_tambahan')";
            $conn->query($sql_pendaftaran);

            // 3. Simpan ke tabel users
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql_user = "INSERT INTO users (username, password, nama_lengkap, role) 
                         VALUES ('$username', '$hashed_password', '$nama', 'siswa')";
            $conn->query($sql_user);

            $pendaftaran_sukses = true;
            
            // 4. Siapkan Link WhatsApp
            $noAdmin = "6285524415341";
            $pesanWA = "Halo Admin QTA Bimbel,%0A%0ASaya ingin mendaftar:%0A*Nama:* " . urlencode($nama) . "%0A*Program:* " . urlencode($program) . "%0A*WhatsApp:* " . urlencode($telepon);
            $wa_url = "https://wa.me/$noAdmin?text=$pesanWA";

        } catch (mysqli_sql_exception $e) {
            $pesan_status = "<div class='alert alert-danger'>Gagal menyimpan: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <?php if ($pendaftaran_sukses): ?>
                <div class="card shadow border-0 text-center p-5">
                    <div class="card-body">
                        <i class="fas fa-check-circle fa-5x text-success mb-3"></i>
                        <h3 class="fw-bold">Data Berhasil Disimpan!</h3>
                        <p class="text-muted mb-4">Data Anda sudah masuk ke database kami. Silakan klik tombol di bawah ini untuk mengirim konfirmasi pendaftaran ke WhatsApp Admin.</p>
                        
                        <a href="<?php echo $wa_url; ?>" target="_blank" class="btn btn-success btn-lg px-5 py-3 shadow">
                            <i class="fab fa-whatsapp me-2"></i>Kirim Konfirmasi ke WhatsApp
                        </a>
                        
                        <div class="mt-4">
                            <a href="index.php" class="text-secondary text-decoration-none small">Kembali ke Beranda</a>
                        </div>
                    </div>
                </div>

                <script>
                    window.onload = function() {
                        setTimeout(function() {
                            window.open("<?php echo $wa_url; ?>", "_blank");
                        }, 500);
                    };
                </script>

            <?php else: ?>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h3 class="mb-4 fw-bold">Pendaftaran Siswa Baru</h3>
                        <?php echo $pesan_status; ?>
                        <form action="kontak_pendaftaran.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor WhatsApp</label>
                                <input type="tel" name="telepon" class="form-control" placeholder="085524415341" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Program</label>
                                <select name="program" class="form-select" required>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="UTBK">Persiapan UTBK</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">DAFTAR SEKARANG</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>