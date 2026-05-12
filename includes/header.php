<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' — TechStore' : 'TechStore' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= isset($rootPath) ? $rootPath : '' ?>css/style.css">
</head>
<body>

<!-- Top Bar -->
<div class="top-bar py-1">
    <div class="container d-flex justify-content-between align-items-center">
        <small><i class="fas fa-phone me-1"></i> +20 100 000 0000 &nbsp;|&nbsp; <i class="fas fa-envelope me-1"></i> support@techstore.com</small>
        <small><i class="fas fa-truck me-1"></i> Free shipping on orders over $50</small>
    </div>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="<?= isset($rootPath) ? $rootPath : '' ?>index.php">
            <i class="fas fa-bolt me-2"></i>TechStore
        </a>

        <!-- Search Bar -->
        <form class="d-none d-lg-flex mx-auto search-form" action="products.php" method="GET">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search products..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button class="btn btn-warning" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>

        <div class="d-flex align-items-center gap-3">
            <a href="<?= isset($rootPath) ? $rootPath : '' ?>cart.php" class="btn btn-outline-light position-relative">
                <i class="fas fa-shopping-cart"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark cart-count">0</span>
            </a>
            <?php if (isset($_SESSION['user_id'])): ?>
            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-user-check me-1"></i>
                    <span class="d-none d-sm-inline"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item-text text-muted small"><?= htmlspecialchars($_SESSION['user_name']) ?></span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="<?= isset($rootPath) ? $rootPath : '' ?>logout.php">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a></li>
                </ul>
            </div>
            <?php else: ?>
            <a href="<?= isset($rootPath) ? $rootPath : '' ?>login.php" class="btn btn-outline-light">
                <i class="fas fa-user me-1"></i><span class="d-none d-sm-inline">Login</span>
            </a>
            <?php endif; ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                <li class="nav-item"><a class="nav-link" href="<?= isset($rootPath) ? $rootPath : '' ?>index.php"><i class="fas fa-home me-1"></i>Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="fas fa-th-large me-1"></i>Categories</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="products.php?category=phones"><i class="fas fa-mobile-alt me-2 text-primary"></i>Phones</a></li>
                        <li><a class="dropdown-item" href="products.php?category=laptops"><i class="fas fa-laptop me-2 text-primary"></i>Laptops</a></li>
                        <li><a class="dropdown-item" href="products.php?category=audio"><i class="fas fa-headphones me-2 text-primary"></i>Audio</a></li>
                        <li><a class="dropdown-item" href="products.php?category=tablets"><i class="fas fa-tablet-alt me-2 text-primary"></i>Tablets</a></li>
                        <li><a class="dropdown-item" href="products.php?category=tv"><i class="fas fa-tv me-2 text-primary"></i>TV & Displays</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="<?= isset($rootPath) ? $rootPath : '' ?>products.php"><i class="fas fa-store me-1"></i>Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= isset($rootPath) ? $rootPath : '' ?>contact.php"><i class="fas fa-envelope me-1"></i>Contact</a></li>
            </ul>
        </div>
    </div>
</nav>
