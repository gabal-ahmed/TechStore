<?php
session_start();

// Already logged in → go home
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$pageTitle  = 'Login / Register';
$loginError = $registerError = $registerSuccess = '';

require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ── LOGIN ──────────────────────────────────────────────
    if ($_POST['action'] === 'login') {
        $email = trim($_POST['email'] ?? '');
        $pass  = $_POST['password'] ?? '';

        if (!$email || !$pass) {
            $loginError = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>Please fill in all fields.</div>';
        } elseif (!$conn) {
            $loginError = '<div class="alert alert-warning"><i class="fas fa-database me-2"></i>Database not available. Please make sure MySQL is running in XAMPP.</div>';
        } else {
            $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if ($row && password_verify($pass, $row['password'])) {
                $_SESSION['user_id']   = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                header('Location: index.php');
                exit;
            } else {
                $loginError = '<div class="alert alert-danger"><i class="fas fa-times-circle me-2"></i>Incorrect email or password.</div>';
            }
        }
    }

    // ── REGISTER ───────────────────────────────────────────
    elseif ($_POST['action'] === 'register') {
        $name  = trim($_POST['reg_name']     ?? '');
        $email = trim($_POST['reg_email']    ?? '');
        $pass  = $_POST['reg_password']      ?? '';

        if (!$name || !$email || !$pass) {
            $registerError = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>Please fill in all fields.</div>';
        } elseif (strlen($pass) < 6) {
            $registerError = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>Password must be at least 6 characters.</div>';
        } elseif (!$conn) {
            $registerError = '<div class="alert alert-warning"><i class="fas fa-database me-2"></i>Database not available. Please make sure MySQL is running in XAMPP.</div>';
        } else {
            // Check duplicate email
            $chk = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $chk->bind_param("s", $email);
            $chk->execute();
            $chk->store_result();
            $exists = $chk->num_rows > 0;
            $chk->close();

            if ($exists) {
                $registerError = '<div class="alert alert-danger"><i class="fas fa-times-circle me-2"></i>This email is already registered.</div>';
            } else {
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $ins  = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                $ins->bind_param("sss", $name, $email, $hash);
                $ins->execute();
                $ins->close();
                $registerSuccess = '<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>Account created! You can now sign in.</div>';
            }
        }
    }
}

require_once 'includes/header.php';
?>

<div class="page-header py-3 text-white">
    <div class="container">
        <h2 class="fw-bold mb-0"><i class="fas fa-user me-2"></i>My Account</h2>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card auth-card overflow-hidden">
                <div class="row g-0">
                    <!-- Sidebar -->
                    <div class="col-md-4 auth-sidebar text-white p-5 d-flex flex-column justify-content-center">
                        <h3 class="fw-bold mb-3"><i class="fas fa-bolt me-2 text-warning"></i>TechStore</h3>
                        <p class="text-white-50 mb-4">Join thousands of happy customers and get access to exclusive deals.</p>
                        <ul class="list-unstyled">
                            <li class="mb-3"><i class="fas fa-tag me-2 text-warning"></i>Exclusive member discounts</li>
                            <li class="mb-3"><i class="fas fa-truck me-2 text-warning"></i>Free shipping on all orders</li>
                            <li class="mb-3"><i class="fas fa-history me-2 text-warning"></i>Track your orders</li>
                            <li class="mb-3"><i class="fas fa-heart me-2 text-warning"></i>Save your wishlist</li>
                        </ul>
                    </div>

                    <!-- Forms -->
                    <div class="col-md-8 p-5">
                        <ul class="nav nav-tabs mb-4" id="authTabs">
                            <li class="nav-item">
                                <a class="nav-link fw-semibold <?= empty($registerError) && empty($registerSuccess) ? 'active' : '' ?>"
                                   data-bs-toggle="tab" href="#loginTab">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold <?= (!empty($registerError) || !empty($registerSuccess)) ? 'active' : '' ?>"
                                   data-bs-toggle="tab" href="#registerTab">Create Account</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <!-- Login Tab -->
                            <div class="tab-pane fade <?= empty($registerError) && empty($registerSuccess) ? 'show active' : '' ?>" id="loginTab">
                                <h4 class="fw-bold mb-4">Welcome Back!</h4>
                                <?= $loginError ?>
                                <form method="POST">
                                    <input type="hidden" name="action" value="login">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope text-primary"></i></span>
                                            <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock text-primary"></i></span>
                                            <input type="password" name="password" id="loginPass" class="form-control" placeholder="••••••••" required>
                                            <button type="button" class="btn btn-outline-secondary" onclick="togglePass('loginPass',this)"><i class="fas fa-eye"></i></button>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mb-4">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="remember">
                                            <label class="form-check-label text-muted" for="remember">Remember me</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                    </button>
                                </form>
                            </div>

                            <!-- Register Tab -->
                            <div class="tab-pane fade <?= (!empty($registerError) || !empty($registerSuccess)) ? 'show active' : '' ?>" id="registerTab">
                                <h4 class="fw-bold mb-4">Create Account</h4>
                                <?= $registerError ?>
                                <?= $registerSuccess ?>
                                <form method="POST">
                                    <input type="hidden" name="action" value="register">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Full Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user text-primary"></i></span>
                                            <input type="text" name="reg_name" class="form-control" placeholder="John Doe" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope text-primary"></i></span>
                                            <input type="email" name="reg_email" class="form-control" placeholder="you@example.com" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock text-primary"></i></span>
                                            <input type="password" name="reg_password" id="regPass" class="form-control" placeholder="Min 6 characters" required>
                                            <button type="button" class="btn btn-outline-secondary" onclick="togglePass('regPass',this)"><i class="fas fa-eye"></i></button>
                                        </div>
                                    </div>
                                    <div class="form-check mb-4">
                                        <input type="checkbox" class="form-check-input" id="terms" required>
                                        <label class="form-check-label text-muted" for="terms">I agree to the <a href="#">Terms & Conditions</a></label>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                                        <i class="fas fa-user-plus me-2"></i>Create Account
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePass(id, btn) {
    const inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
    btn.querySelector('i').classList.toggle('fa-eye');
    btn.querySelector('i').classList.toggle('fa-eye-slash');
}
</script>

<?php require_once 'includes/footer.php'; ?>
