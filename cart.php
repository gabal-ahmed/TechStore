<?php
$pageTitle = 'Shopping Cart';
require_once 'includes/db.php';
require_once 'includes/header.php';
?>

<div class="page-header py-3 text-white">
    <div class="container">
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="index.php" class="text-white-50">Home</a></li>
            <li class="breadcrumb-item active text-white">Shopping Cart</li>
        </ol></nav>
        <h2 class="fw-bold mb-0 mt-1"><i class="fas fa-shopping-cart me-2"></i>Shopping Cart</h2>
    </div>
</div>

<div class="container py-5">

    <!-- Empty Cart -->
    <div id="emptyCart" class="text-center py-5 d-none">
        <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
        <h3 class="text-muted">Your cart is empty</h3>
        <p class="text-muted">Looks like you haven't added anything yet.</p>
        <a href="products.php" class="btn btn-primary btn-lg mt-2"><i class="fas fa-store me-2"></i>Continue Shopping</a>
    </div>

    <!-- Cart Content -->
    <div id="cartBox" class="d-none">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="bg-white rounded-4 shadow-sm p-0 overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                        <h5 class="fw-bold mb-0">Cart Items</h5>
                        <button class="btn btn-sm btn-outline-danger" onclick="clearCart()">
                            <i class="fas fa-trash me-1"></i>Clear Cart
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Image</th><th>Product</th><th>Price</th>
                                    <th>Quantity</th><th>Subtotal</th><th></th>
                                </tr>
                            </thead>
                            <tbody id="cartItems"></tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-3 d-flex gap-3">
                    <a href="products.php" class="btn btn-outline-primary"><i class="fas fa-arrow-left me-2"></i>Continue Shopping</a>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="order-summary sticky-top" style="top:80px">
                    <h5 class="fw-bold mb-4"><i class="fas fa-receipt me-2 text-primary"></i>Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span><span id="subtotal" class="fw-semibold">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span><span id="shipping" class="fw-semibold text-success">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tax (8%)</span><span id="tax" class="fw-semibold">$0.00</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total</span>
                        <span id="orderTotal" class="fw-bold fs-5 text-primary">$0.00</span>
                    </div>

                    <!-- Coupon -->
                    <div class="mb-4">
                        <label class="form-label text-muted small">Coupon Code</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="couponInput" placeholder="e.g. SAVE10">
                            <button class="btn btn-outline-secondary" onclick="applyCoupon()">Apply</button>
                        </div>
                        <div id="couponMsg" class="mt-1 small"></div>
                    </div>

                    <a href="checkout.php" class="btn btn-primary w-100 btn-lg fw-bold">
                        <i class="fas fa-lock me-2"></i>Proceed to Checkout
                    </a>
                    <div class="text-center mt-3">
                        <small class="text-muted"><i class="fas fa-shield-alt me-1 text-success"></i>Secure checkout — 256-bit SSL</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() { renderCart(); });

function applyCoupon() {
    const code = document.getElementById('couponInput').value.toUpperCase().trim();
    const msg  = document.getElementById('couponMsg');
    if (code === 'SAVE10') {
        msg.innerHTML = '<span class="text-success"><i class="fas fa-check me-1"></i>10% discount applied!</span>';
    } else if (code === 'TECH20') {
        msg.innerHTML = '<span class="text-success"><i class="fas fa-check me-1"></i>20% discount applied!</span>';
    } else {
        msg.innerHTML = '<span class="text-danger"><i class="fas fa-times me-1"></i>Invalid coupon code.</span>';
    }
}
</script>

<?php require_once 'includes/footer.php'; ?>
