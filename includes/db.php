<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'techstore');

mysqli_report(MYSQLI_REPORT_OFF);

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

    $conn->query("CREATE TABLE IF NOT EXISTS `products` (
        `id`          INT AUTO_INCREMENT PRIMARY KEY,
        `name`        VARCHAR(200) NOT NULL,
        `price`       DECIMAL(10,2) NOT NULL,
        `old_price`   DECIMAL(10,2) NOT NULL,
        `category`    VARCHAR(50) NOT NULL,
        `rating`      TINYINT NOT NULL DEFAULT 4,
        `img`         VARCHAR(500) NOT NULL,
        `badge`       VARCHAR(50) DEFAULT '',
        `description` TEXT,
        `created_at`  DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");

    // Seed default products once if table is empty
    $count = $conn->query("SELECT COUNT(*) as c FROM products")->fetch_assoc()['c'];
    if ($count == 0) {
        $conn->query("INSERT INTO products (name, price, old_price, category, rating, img, badge) VALUES
            ('iPhone 15 Pro',       999,  1099, 'phones',  5, 'https://placehold.co/400x400/1a73e8/white?text=iPhone+15',   'New'),
            ('Samsung Galaxy S24',  899,   999, 'phones',  4, 'https://placehold.co/400x400/333/white?text=Galaxy+S24',     'Sale'),
            ('MacBook Air M3',     1299,  1499, 'laptops', 5, 'https://placehold.co/400x400/555/white?text=MacBook+Air',    'Hot'),
            ('Dell XPS 15',        1199,  1399, 'laptops', 4, 'https://placehold.co/400x400/0078d4/white?text=Dell+XPS',    ''),
            ('Sony WH-1000XM5',     349,   399, 'audio',   5, 'https://placehold.co/400x400/111/white?text=Sony+XM5',       'Popular'),
            ('Apple AirPods Pro',   249,   279, 'audio',   4, 'https://placehold.co/400x400/888/white?text=AirPods+Pro',    ''),
            ('iPad Pro 12.9\"',    1099,  1199, 'tablets', 5, 'https://placehold.co/400x400/1a73e8/white?text=iPad+Pro',    'New'),
            ('Samsung 4K Smart TV', 799,   999, 'tv',      4, 'https://placehold.co/400x400/222/white?text=Samsung+4K+TV',  'Sale')
        ");
    }

    // Load products from DB into $products array
    $result = $conn->query("SELECT * FROM products ORDER BY id ASC");
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $row['price']     = (float)$row['price'];
        $row['old_price'] = (float)$row['old_price'];
        $row['rating']    = (int)$row['rating'];
        $products[] = $row;
    }

} else {
    $conn = null;

    // Fallback static data when MySQL is offline
    $products = [
        ['id'=>1,'name'=>'iPhone 15 Pro',      'price'=>999, 'old_price'=>1099,'category'=>'phones', 'rating'=>5,'img'=>'https://placehold.co/400x400/1a73e8/white?text=iPhone+15',  'badge'=>'New'],
        ['id'=>2,'name'=>'Samsung Galaxy S24',  'price'=>899, 'old_price'=>999, 'category'=>'phones', 'rating'=>4,'img'=>'https://placehold.co/400x400/333/white?text=Galaxy+S24',    'badge'=>'Sale'],
        ['id'=>3,'name'=>'MacBook Air M3',      'price'=>1299,'old_price'=>1499,'category'=>'laptops','rating'=>5,'img'=>'https://placehold.co/400x400/555/white?text=MacBook+Air',   'badge'=>'Hot'],
        ['id'=>4,'name'=>'Dell XPS 15',         'price'=>1199,'old_price'=>1399,'category'=>'laptops','rating'=>4,'img'=>'https://placehold.co/400x400/0078d4/white?text=Dell+XPS',   'badge'=>''],
        ['id'=>5,'name'=>'Sony WH-1000XM5',     'price'=>349, 'old_price'=>399, 'category'=>'audio',  'rating'=>5,'img'=>'https://placehold.co/400x400/111/white?text=Sony+XM5',      'badge'=>'Popular'],
        ['id'=>6,'name'=>'Apple AirPods Pro',   'price'=>249, 'old_price'=>279, 'category'=>'audio',  'rating'=>4,'img'=>'https://placehold.co/400x400/888/white?text=AirPods+Pro',   'badge'=>''],
        ['id'=>7,'name'=>'iPad Pro 12.9"',      'price'=>1099,'old_price'=>1199,'category'=>'tablets','rating'=>5,'img'=>'https://placehold.co/400x400/1a73e8/white?text=iPad+Pro',   'badge'=>'New'],
        ['id'=>8,'name'=>'Samsung 4K Smart TV', 'price'=>799, 'old_price'=>999, 'category'=>'tv',     'rating'=>4,'img'=>'https://placehold.co/400x400/222/white?text=Samsung+4K+TV', 'badge'=>'Sale'],
    ];
}

function getProductById($id) {
    global $conn;
    if ($conn) {
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if ($row) {
            $row['price']     = (float)$row['price'];
            $row['old_price'] = (float)$row['old_price'];
            $row['rating']    = (int)$row['rating'];
            return $row;
        }
        return null;
    }
    // Fallback to static array
    global $products;
    foreach ($products as $p) {
        if ($p['id'] == $id) return $p;
    }
    return null;
}
?>
