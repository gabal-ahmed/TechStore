// ===== CART (localStorage) =====
const Cart = {
    get() { return JSON.parse(localStorage.getItem('ts_cart') || '[]'); },
    save(cart) { localStorage.setItem('ts_cart', JSON.stringify(cart)); },
    add(id, name, price, img) {
        const cart = this.get();
        const idx = cart.findIndex(i => i.id === id);
        if (idx > -1) { cart[idx].qty++; } else { cart.push({id, name, price, img, qty: 1}); }
        this.save(cart);
        this.updateBadge();
        showToast(`<i class="fas fa-check-circle me-2 text-success"></i>${name} added to cart!`);
    },
    remove(id) { this.save(this.get().filter(i => i.id !== id)); this.updateBadge(); },
    updateQty(id, qty) {
        const cart = this.get();
        const idx = cart.findIndex(i => i.id === id);
        if (idx > -1) { cart[idx].qty = Math.max(1, qty); this.save(cart); }
        this.updateBadge();
    },
    total() { return this.get().reduce((s, i) => s + i.price * i.qty, 0); },
    count() { return this.get().reduce((s, i) => s + i.qty, 0); },
    updateBadge() {
        const c = this.count();
        document.querySelectorAll('.cart-count').forEach(el => {
            el.textContent = c;
            el.style.display = c > 0 ? 'inline' : 'none';
        });
    }
};

// ===== WISHLIST =====
const Wishlist = {
    get() { return JSON.parse(localStorage.getItem('ts_wish') || '[]'); },
    toggle(id) {
        const w = this.get();
        const idx = w.indexOf(id);
        if (idx > -1) { w.splice(idx, 1); } else { w.push(id); }
        localStorage.setItem('ts_wish', JSON.stringify(w));
        return idx === -1;
    },
    has(id) { return this.get().includes(id); }
};

// ===== TOAST =====
function showToast(msg, type = 'success') {
    let container = document.getElementById('toastContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        document.body.appendChild(container);
    }
    const id = 'toast_' + Date.now();
    container.insertAdjacentHTML('beforeend', `
        <div id="${id}" class="toast align-items-center text-bg-dark border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">${msg}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>`);
    setTimeout(() => document.getElementById(id)?.remove(), 3000);
}

// ===== INIT =====
document.addEventListener('DOMContentLoaded', () => {
    Cart.updateBadge();

    // Add to cart buttons
    document.querySelectorAll('.btn-add-cart').forEach(btn => {
        btn.addEventListener('click', () => {
            Cart.add(
                parseInt(btn.dataset.id),
                btn.dataset.name,
                parseFloat(btn.dataset.price),
                btn.dataset.img
            );
        });
    });

    // Wishlist buttons
    document.querySelectorAll('.btn-wishlist').forEach(btn => {
        const id = parseInt(btn.dataset.id);
        if (Wishlist.has(id)) btn.querySelector('i').classList.replace('far','fas');
        btn.addEventListener('click', () => {
            const added = Wishlist.toggle(id);
            btn.querySelector('i').classList.toggle('far', !added);
            btn.querySelector('i').classList.toggle('fas', added);
            showToast(added ? '❤️ Added to wishlist!' : 'Removed from wishlist');
        });
    });
});

// ===== CART PAGE =====
function renderCart() {
    const tbody = document.getElementById('cartItems');
    const empty = document.getElementById('emptyCart');
    const cartBox = document.getElementById('cartBox');
    if (!tbody) return;

    const cart = Cart.get();
    if (cart.length === 0) {
        if (empty) empty.classList.remove('d-none');
        if (cartBox) cartBox.classList.add('d-none');
        return;
    }
    if (empty) empty.classList.add('d-none');
    if (cartBox) cartBox.classList.remove('d-none');

    tbody.innerHTML = cart.map(item => `
        <tr>
            <td><img src="${item.img}" class="cart-item-img" alt="${item.name}"></td>
            <td class="fw-semibold">${item.name}</td>
            <td>$${item.price.toFixed(2)}</td>
            <td>
                <div class="input-group input-group-sm" style="width:110px">
                    <button class="btn btn-outline-secondary" onclick="changeQty(${item.id},-1)">-</button>
                    <input type="number" class="form-control text-center" value="${item.qty}" min="1" onchange="changeQty(${item.id},0,this.value)">
                    <button class="btn btn-outline-secondary" onclick="changeQty(${item.id},1)">+</button>
                </div>
            </td>
            <td class="fw-bold text-primary">$${(item.price * item.qty).toFixed(2)}</td>
            <td><button class="btn btn-sm btn-outline-danger" onclick="removeItem(${item.id})"><i class="fas fa-trash"></i></button></td>
        </tr>`).join('');

    const subtotal = Cart.total();
    const shipping = subtotal > 50 ? 0 : 9.99;
    const tax = subtotal * 0.08;
    const total = subtotal + shipping + tax;

    const set = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
    set('subtotal', `$${subtotal.toFixed(2)}`);
    set('shipping', shipping === 0 ? 'Free' : `$${shipping.toFixed(2)}`);
    set('tax', `$${tax.toFixed(2)}`);
    set('orderTotal', `$${total.toFixed(2)}`);
}

function changeQty(id, delta, val) {
    const cart = Cart.get();
    const idx = cart.findIndex(i => i.id === id);
    if (idx > -1) {
        cart[idx].qty = delta !== 0 ? Math.max(1, cart[idx].qty + delta) : Math.max(1, parseInt(val));
        Cart.save(cart);
        Cart.updateBadge();
        renderCart();
    }
}

function removeItem(id) {
    Cart.remove(id);
    renderCart();
}

function clearCart() {
    if (confirm('Clear entire cart?')) {
        localStorage.removeItem('ts_cart');
        Cart.updateBadge();
        renderCart();
    }
}
