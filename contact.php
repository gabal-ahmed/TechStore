<?php
$pageTitle = 'Contact Us';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($name && $email && $subject && $message) {
        // In real project: mail() or store in DB
        $success = true;
    }
}

require_once 'includes/header.php';
?>

<div class="page-header py-4 text-white">
    <div class="container">
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="index.php" class="text-white-50">Home</a></li>
            <li class="breadcrumb-item active text-white">Contact</li>
        </ol></nav>
        <h2 class="fw-bold mb-0"><i class="fas fa-envelope me-2"></i>Contact Us</h2>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Info Cards -->
        <div class="col-lg-4">
            <div class="contact-card p-4 mb-3">
                <div class="info-icon bg-primary bg-opacity-10 mb-3">
                    <i class="fas fa-map-marker-alt text-primary fs-5"></i>
                </div>
                <h6 class="fw-bold">Our Location</h6>
                <p class="text-muted mb-0">123 Tech Street, Cairo, Egypt</p>
            </div>
            <div class="contact-card p-4 mb-3">
                <div class="info-icon bg-success bg-opacity-10 mb-3">
                    <i class="fas fa-phone text-success fs-5"></i>
                </div>
                <h6 class="fw-bold">Phone</h6>
                <p class="text-muted mb-0">+20 100 000 0000<br>+20 100 111 1111</p>
            </div>
            <div class="contact-card p-4 mb-3">
                <div class="info-icon bg-warning bg-opacity-10 mb-3">
                    <i class="fas fa-envelope text-warning fs-5"></i>
                </div>
                <h6 class="fw-bold">Email</h6>
                <p class="text-muted mb-0">support@techstore.com<br>sales@techstore.com</p>
            </div>
            <div class="contact-card p-4">
                <div class="info-icon bg-info bg-opacity-10 mb-3">
                    <i class="fas fa-clock text-info fs-5"></i>
                </div>
                <h6 class="fw-bold">Working Hours</h6>
                <p class="text-muted mb-0">Mon – Fri: 9am – 6pm<br>Sat: 10am – 4pm</p>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-8">
            <div class="contact-card p-5">
                <h4 class="fw-bold mb-1">Send a Message</h4>
                <p class="text-muted mb-4">We'll get back to you within 24 hours.</p>

                <?php if ($success): ?>
                <div class="alert alert-success d-flex align-items-center gap-2">
                    <i class="fas fa-check-circle fa-lg"></i>
                    <div><strong>Message sent!</strong> We'll get back to you shortly.</div>
                </div>
                <?php endif; ?>

                <form method="POST" novalidate class="needs-validation">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user text-primary"></i></span>
                                <input type="text" name="name" class="form-control" placeholder="Your name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope text-primary"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag text-primary"></i></span>
                                <select name="subject" class="form-select" required>
                                    <option value="">-- Select a subject --</option>
                                    <option>Order Inquiry</option>
                                    <option>Product Question</option>
                                    <option>Return / Refund</option>
                                    <option>Technical Support</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control" rows="5" placeholder="Write your message here..." required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Map Placeholder -->
    <div class="mt-5 rounded-4 overflow-hidden shadow-sm" style="height:300px; background: linear-gradient(135deg,#e9ecef,#dee2e6); display:flex; align-items:center; justify-content:center;">
        <div class="text-center text-muted">
            <i class="fas fa-map-marked-alt fa-4x mb-3 text-primary opacity-50"></i>
            <h5>Map — Embed Google Maps here after XAMPP setup</h5>
            <small>Replace this div with an &lt;iframe&gt; from Google Maps</small>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
