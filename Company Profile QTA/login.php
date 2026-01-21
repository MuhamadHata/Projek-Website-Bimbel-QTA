<?php

session_start();

include 'includes/header.php'; 
// Panggil koneksi DB.
include 'includes/db_connect.php'; 

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Sanitasi Input
    $username = $_POST['username'] ?? ''; 
    $password = $_POST['password'] ?? ''; 

    $sql = "SELECT id, username, password, nama_lengkap, role FROM users WHERE username = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                
                // Password BENAR. Isi variabel sesi
                $_SESSION['logged_in'] = TRUE;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama'] = $user['nama_lengkap'];
                $_SESSION['role'] = $user['role'];
                
                if ($user['role'] == 'admin') {
                    header("Location: dashboard_admin.php"); 
                } else {
                    header("Location: dashboard_siswa.php"); 
                }
                $stmt->close(); 
                exit;
                
            } else {
                $login_error = "<div class='alert alert-danger'>Username atau Password salah.</div>";
            }
        } else {
            $login_error = "<div class='alert alert-danger'>Username atau Password salah.</div>";
        }
        $stmt->close(); 
    } else {
        $login_error = "<div class='alert alert-danger'>Terjadi kesalahan pada database (prepare error).</div>";
    }
}

$conn->close();
?>

<section class="container py-5" style="min-height: 70vh;">
    <div class="row justify-content-center">
        <div class="col-md-5 animate-on-scroll">
            <div class="card p-4 shadow-lg">
                <h2 class="text-center text-primary mb-4 fw-bold">Login Siswa</h2>
                
                <?php echo $login_error; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_login_input" class="form-label">Password:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_login_input" name="password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordLogin">
                                <i class="fas fa-eye-slash" id="eyeIconLogin"></i> 
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">Masuk Dashboard</button> 
                </form>
                
                <p class="mt-3 text-center small text-muted">Lupa akun? Silakan hubungi admin lembaga.</p>
            </div>
        </div>
    </div>
</section>

<?php 
include 'includes/footer.php'; 
?>