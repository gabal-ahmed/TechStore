# ⚡ TechStore — E-Commerce Project

A university e-commerce project built with **HTML, CSS, JavaScript, Bootstrap 5, and PHP**.  
Works out of the box with XAMPP — no manual database setup required.

---

## 📋 Pages

| Page | File | Description |
|------|------|-------------|
| Home | `index.php` | Hero, categories, featured products |
| Shop | `products.php` | All products with filter, sort & search |
| Product Detail | `product.php` | Images, tabs, related products |
| Cart | `cart.php` | Cart with quantity control & coupon codes |
| Checkout | `checkout.php` | Shipping form, payment method, order confirm |
| Login / Register | `login.php` | Auth with sessions |
| Contact | `contact.php` | Contact form + info cards |

---

## 🚀 Installation

### Requirements
- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL + PHP 8+)

### Steps

**1. Clone the repo**
```bash
git clone https://github.com/gabal-ahmed/TechStore.git
```

**2. Move to XAMPP**

Copy the `TechStore` folder into:
```
C:\xampp\htdocs\TechStore
```

**3. Start XAMPP**

Open XAMPP Control Panel and start:
- ✅ Apache
- ✅ MySQL

**4. Open in browser**
```
http://localhost/TechStore/
```

> The database `techstore`, all tables, and sample products are created **automatically** on first visit. No SQL file needed.

---

## 🗄️ Database

Created automatically on first run. Schema:

### `users`
| Column | Type | Notes |
|--------|------|-------|
| id | INT AUTO_INCREMENT | Primary key |
| name | VARCHAR(100) | Full name |
| email | VARCHAR(150) | Unique |
| password | VARCHAR(255) | Hashed with `password_hash()` |
| created_at | DATETIME | Auto |

### `products`
| Column | Type | Notes |
|--------|------|-------|
| id | INT AUTO_INCREMENT | Primary key |
| name | VARCHAR(200) | Product name |
| price | DECIMAL(10,2) | Current price |
| old_price | DECIMAL(10,2) | Original price (for discount display) |
| category | VARCHAR(50) | phones / laptops / audio / tablets / tv |
| rating | TINYINT | 1–5 |
| img | VARCHAR(500) | Image URL |
| badge | VARCHAR(50) | e.g. New, Sale, Hot (optional) |
| description | TEXT | Optional |
| created_at | DATETIME | Auto |

### Add a product via phpMyAdmin

1. Go to `http://localhost/phpmyadmin`
2. Open `techstore` → `products`
3. Click **Insert** and fill in the fields

---

## 🛒 Features

- **Auto DB setup** — database and tables created on first visit
- **Cart** — stored in `localStorage`, persists across pages
- **Wishlist** — stored in `localStorage`
- **Auth** — register/login with hashed passwords and PHP sessions
- **Search** — by product name (SQL `LIKE` query)
- **Filter** — by category
- **Sort** — by price (low/high) or name
- **Coupon codes** — `SAVE10` (10% off), `TECH20` (20% off)
- **Responsive** — mobile-friendly with Bootstrap 5

---

## 📁 Project Structure

```
TechStore/
├── index.php           # Home page
├── products.php        # Shop page
├── product.php         # Single product
├── cart.php            # Shopping cart
├── checkout.php        # Checkout
├── login.php           # Login / Register
├── logout.php          # Clears session
├── contact.php         # Contact form
├── includes/
│   ├── db.php          # DB connection, table creation, $products loader
│   ├── header.php      # Navbar (shared)
│   └── footer.php      # Footer + JS imports (shared)
├── css/
│   └── style.css       # Custom styles
└── js/
    └── main.js         # Cart, Wishlist, Toast notifications
```

---

## 🔧 Configuration

Edit `includes/db.php` to change database credentials:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');        // Add your MySQL password here
define('DB_NAME', 'techstore');
```

---

## 🛠️ Built With

- [Bootstrap 5.3](https://getbootstrap.com/)
- [Font Awesome 6.5](https://fontawesome.com/)
- PHP 8 + MySQLi
- Vanilla JavaScript (localStorage for cart/wishlist)
