<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'techstore');

mysqli_report(MYSQLI_REPORT_OFF);

// Connect without DB name first to create it if missing
$conn = @new mysqli(DB_HOST, DB_USER, DB_PASS);

if ($conn && !$conn->connect_error) {
    $conn->query("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $conn->select_db(DB_NAME);

    $conn->query("CREATE TABLE IF NOT EXISTS `users` (
        `id`         INT AUTO_INCREMENT PRIMARY KEY,
        `name`       VARCHAR(100) NOT NULL,
        `email`      VARCHAR(150) NOT NULL UNIQUE,
        `password`   VARCHAR(255) NOT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");
} else {
    $conn = null;
}

// Static products array (works without database)
$products = [
    ['id'=>1,'name'=>'iPhone 15 Pro','price'=>999,'old_price'=>1099,'category'=>'phones','rating'=>5,'img'=>'https://placehold.co/400x400/1a73e8/white?text=iPhone+15','badge'=>'New'],
    ['id'=>2,'name'=>'Samsung Galaxy S24','price'=>899,'old_price'=>999,'category'=>'phones','rating'=>4,'img'=>'https://placehold.co/400x400/333/white?text=Galaxy+S24','badge'=>'Sale'],
    ['id'=>3,'name'=>'MacBook Air M3','price'=>1299,'old_price'=>1499,'category'=>'laptops','rating'=>5,'img'=>'https://placehold.co/400x400/555/white?text=MacBook+Air','badge'=>'Hot'],
    ['id'=>4,'name'=>'Dell XPS 15','price'=>1199,'old_price'=>1399,'category'=>'laptops','rating'=>4,'img'=>'https://placehold.co/400x400/0078d4/white?text=Dell+XPS','badge'=>''],
    ['id'=>5,'name'=>'Sony WH-1000XM5','price'=>349,'old_price'=>399,'category'=>'audio','rating'=>5,'img'=>'https://placehold.co/400x400/111/white?text=Sony+XM5','badge'=>'Popular'],
    ['id'=>6,'name'=>'Apple AirPods Pro','price'=>249,'old_price'=>279,'category'=>'audio','rating'=>4,'img'=>'https://placehold.co/400x400/888/white?text=AirPods+Pro','badge'=>''],
    ['id'=>7,'name'=>'iPad Pro 12.9"','price'=>1099,'old_price'=>1199,'category'=>'tablets','rating'=>5,'img'=>'https://placehold.co/400x400/1a73e8/white?text=iPad+Pro','badge'=>'New'],
    ['id'=>8,'name'=>'Samsung 4K Smart TV','price'=>799,'old_price'=>999,'category'=>'tv','rating'=>4,'img'=>'https://placehold.co/400x400/222/white?text=Samsung+4K+TV','badge'=>'Sale'],
];

function getProductById($id) {
    global $products;
    foreach ($products as $p) {
        if ($p['id'] == $id) return $p;
    }
    return null;
}
?>
