<!-- Footer -->
<footer class="bg-dark text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5 class="fw-bold text-warning"><i class="fas fa-bolt me-2"></i>TechStore</h5>
                <p class="text-secondary">Your #1 destination for the latest tech products. Quality, speed, and trust — all in one place.</p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-secondary fs-5 hover-white"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-secondary fs-5 hover-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-secondary fs-5 hover-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-secondary fs-5 hover-white"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="fw-bold text-white">Quick Links</h6>
                <ul class="list-unstyled text-secondary">
                    <li><a href="index.php" class="footer-link">Home</a></li>
                    <li><a href="products.php" class="footer-link">Shop</a></li>
                    <li><a href="cart.php" class="footer-link">Cart</a></li>
                    <li><a href="contact.php" class="footer-link">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="fw-bold text-white">Categories</h6>
                <ul class="list-unstyled text-secondary">
                    <li><a href="products.php?category=phones" class="footer-link">Phones</a></li>
                    <li><a href="products.php?category=laptops" class="footer-link">Laptops</a></li>
                    <li><a href="products.php?category=audio" class="footer-link">Audio</a></li>
                    <li><a href="products.php?category=tv" class="footer-link">TV & Displays</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h6 class="fw-bold text-white">Newsletter</h6>
                <p class="text-secondary small">Subscribe for deals and new arrivals.</p>
                <form class="d-flex gap-2">
                    <input type="email" class="form-control form-control-sm bg-secondary border-0 text-white" placeholder="Your email">
                    <button class="btn btn-warning btn-sm text-dark fw-bold">Subscribe</button>
                </form>
                <div class="mt-3 d-flex flex-wrap gap-2">
                    <img src="https://placehold.co/50x30/fff/333?text=VISA" alt="Visa" class="rounded">
                    <img src="https://placehold.co/50x30/fff/333?text=MC" alt="Mastercard" class="rounded">
                    <img src="https://placehold.co/50x30/fff/333?text=PayPal" alt="PayPal" class="rounded">
                </div>
            </div>
        </div>
        <hr class="border-secondary mt-4">
        <div class="text-center text-secondary small">
            &copy; <?= date('Y') ?> TechStore. All rights reserved. | Built with <i class="fas fa-heart text-danger"></i> using Bootstrap 5
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= isset($rootPath) ? $rootPath : '' ?>js/main.js"></script>
</body>
</html>
