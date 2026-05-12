<?php
$pageTitle = 'Checkout';
$orderPlaced = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ['first_name','last_name','email','address','city','zip'];
    $valid = true;
    foreach ($required as $field) {
        if (empty(trim($_POST[$field] ?? ''))) { $valid = false; break; }
    }
    if ($valid) {
        $orderPlaced = true;
        $orderNum = strtoupper(substr(md5(time()), 0, 8));
    }
}

require_once 'includes/header.php';
?>

<div class="page-header py-3 text-white">
    <div class="container">
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="index.php" class="text-white-50">Home</a></li>
            <li class="breadcrumb-item"><a href="cart.php" class="text-white-50">Cart</a></li>
            <li class="breadcrumb-item active text-white">Checkout</li>
        </ol></nav>
        <h2 class="fw-bold mb-0"><i class="fas fa-lock me-2"></i>Secure Checkout</h2>
    </div>
</div>

<div class="container py-5">

<?php if ($orderPlaced): ?>
    <!-- Success -->
    <div class="text-center py-5">
        <div class="mb-4">
            <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center" style="width:100px;height:100px">
                <i class="fas fa-check fa-3x text-white"></i>
            </div>
        </div>
        <h2 class="fw-bold text-success">Order Placed Successfully!</h2>
        <p class="text-muted fs-5">Order #<strong><?= $orderNum ?></strong> has been confirmed.</p>
        <p class="text-muted">A confirmation email will be sent to <strong><?= htmlspecialchars($_POST['email']) ?></strong></p>
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="index.php" class="btn btn-primary btn-lg"><i class="fas fa-home me-2"></i>Back to Home</a>
            <a href="products.php" class="btn btn-outline-primary btn-lg"><i class="fas fa-store me-2"></i>Continue Shopping</a>
        </div>
    </div>
    <script>localStorage.removeItem('ts_cart');</script>

<?php else: ?>
    <!-- Steps -->
    <div class="d-flex justify-content-center mb-5">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center gap-2"><span class="badge bg-primary rounded-pill px-3 py-2">1</span><span class="fw-semibold">Shipping</span></div>
            <div class="text-muted">——</div>
            <div class="d-flex align-items-center gap-2"><span class="badge bg-secondary rounded-pill px-3 py-2">2</span><span class="text-muted">Payment</span></div>
            <div class="text-muted">——</div>
            <div class="d-flex align-items-center gap-2"><span class="badge bg-secondary rounded-pill px-3 py-2">3</span><span class="text-muted">Confirm</span></div>
        </div>
    </div>

    <form method="POST">
        <div class="row g-4">
            <!-- Shipping Info -->
            <div class="col-lg-7">
                <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                    <h5 class="fw-bold mb-4"><i class="fas fa-shipping-fast me-2 text-primary"></i>Shipping Information</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">First Name *</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Last Name *</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Email Address *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" placeholder="+20 100 ...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Street Address *</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">City *</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">ZIP Code *</label>
                            <input type="text" name="zip" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Country</label>
                            <select name="country" class="form-select">
                                <option>Egypt</option><option>Saudi Arabia</option>
                                <option>UAE</option><option>USA</option><option>Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Payment -->
                <div class="bg-white rounded-4 shadow-sm p-4">
                    <h5 class="fw-bold mb-4"><i class="fas fa-credit-card me-2 text-primary"></i>Payment Method</h5>
                    <div class="row g-2 mb-3">
                        <div class="col-12">
                            <div class="form-check border rounded p-3 mb-2">
                                <input type="radio" name="payment" id="payCard" value="card" class="form-check-input" checked>
                                <label class="form-check-label w-100 d-flex justify-content-between" for="payCard">
                                    <span><i class="fas fa-credit-card me-2 text-primary"></i>Credit / Debit Card</span>
                                    <span>
                                        <img src="https://placehold.co/30x20/fff/333?text=V" class="rounded me-1" alt="visa">
                                        <img src="https://placehold.co/30x20/fff/333?text=MC" class="rounded" alt="mc">
                                    </span>
                                </label>
                            </div>
                            <div class="form-check border rounded p-3 mb-2">
                                <input type="radio" name="payment" id="payPaypal" value="paypal" class="form-check-input">
                                <label class="form-check-label" for="payPaypal"><i class="fab fa-paypal me-2 text-primary"></i>PayPal</label>
                            </div>
                            <div class="form-check border rounded p-3">
                                <input type="radio" name="payment" id="payCash" value="cash" class="form-check-input">
                                <label class="form-check-label" for="payCash"><i class="fas fa-money-bill me-2 text-success"></i>Cash on Delivery</label>
                            </div>
                        </div>
                    </div>
                    <div id="cardFields">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Card Number</label>
                            <input type="text" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19">
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Expiry</label>
                                <input type="text" class="form-control" placeholder="MM/YY">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">CVV</label>
                                <input type="text" class="form-control" placeholder="•••">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-5">
                <div class="order-summary sticky-top" style="top:80px">
                    <h5 class="fw-bold mb-4"><i class="fas fa-receipt me-2 text-primary"></i>Order Summary</h5>
                    <div id="checkoutItems" class="mb-3"></div>
                    <hr>
                    <div class="d-flex justify-content-between mb-1"><span class="text-muted">Subtotal</span><span id="co_subtotal" class="fw-semibold">$0.00</span></div>
                    <div class="d-flex justify-content-between mb-1"><span class="text-muted">Shipping</span><span id="co_shipping" class="fw-semibold text-success">Free</span></div>
                    <div class="d-flex justify-content-between mb-3"><span class="text-muted">Tax (8%)</span><span id="co_tax" class="fw-semibold">$0.00</span></div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4"><span class="fw-bold fs-5">Total</span><span id="co_total" class="fw-bold fs-5 text-primary">$0.00</span></div>

                    <button type="submit" class="btn btn-success w-100 btn-lg fw-bold">
                        <i class="fas fa-check-circle me-2"></i>Place Order
                    </button>
                    <p class="text-center text-muted small mt-3"><i class="fas fa-shield-alt me-1 text-success"></i>Secure 256-bit SSL Encryption</p>
                </div>
            </div>
        </div>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const cart = Cart.get();
        const container = document.getElementById('checkoutItems');
        if (cart.length === 0) {
            container.innerHTML = '<p class="text-muted">Your cart is empty. <a href="products.php">Shop now</a></p>';
        } else {
            container.innerHTML = cart.map(i => `
                <div class="d-flex align-items-center gap-3 mb-2">
                    <img src="${i.img}" style="width:50px;height:50px;object-fit:contain;border-radius:8px;background:#f8f9fa;">
                    <div class="flex-grow-1"><div class="fw-semibold small">${i.name}</div><div class="text-muted small">Qty: ${i.qty}</div></div>
                    <span class="fw-semibold text-primary">$${(i.price*i.qty).toFixed(2)}</span>
                </div>`).join('');
        }
        const sub = Cart.total();
        const ship = sub > 50 ? 0 : 9.99;
        const tax = sub * 0.08;
        document.getElementById('co_subtotal').textContent = '$'+sub.toFixed(2);
        document.getElementById('co_shipping').textContent = ship===0?'Free':'$'+ship.toFixed(2);
        document.getElementById('co_tax').textContent = '$'+tax.toFixed(2);
        document.getElementById('co_total').textContent = '$'+(sub+ship+tax).toFixed(2);

        // Toggle card fields
        document.querySelectorAll('input[name="payment"]').forEach(r => {
            r.addEventListener('change', () => {
                document.getElementById('cardFields').style.display = r.value==='card'?'block':'none';
            });
        });
    });
    </script>
<?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
