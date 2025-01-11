<?php
require_once('db.php'); // Подключение к базе данных

$action = $_POST['action'] ?? $_GET['action'] ?? null;
$productId = $_POST['id'] ?? null;
$productName = $_POST['name'] ?? null;
$productBrand = $_POST['brand'] ?? null;
$productType = $_POST['type'] ?? null;
$productGender = $_POST['gender'] ?? null;
$productAgeGroup = $_POST['age_group'] ?? null;
$productGears = $_POST['gears'] ?? null;
$productPrice = $_POST['price'] ?? null;
$productDescription = $_POST['description'] ?? null;

if ($action == 'add' && $productName) {
    // Запрос на добавление товара
    $stmt = $conn->prepare("INSERT INTO products (name, brand, type, gender, age_group, gears, price, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssssis', $productName, $productBrand, $productType, $productGender, $productAgeGroup, $productGears, $productPrice, $productDescription);
    $stmt->execute();

    // Получаем ID только что добавленного товара
    $newProductId = $stmt->insert_id;
    // Загрузка изображений
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            $imageData = file_get_contents($tmpName);
            $isMain = $key === 0 ? 1 : 0; // Первая картинка — главная
            $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_url, is_main) VALUES (?, ?, ?)");
            $stmt->bind_param('isi', $newProductId, $imageData, $isMain);
            $stmt->execute();
        }
    }
    // Формируем ответ с данными о товаре
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param('i', $newProductId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode(['success' => true, 'product' => $product]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка при получении данных о товаре']);
    }
} elseif ($action == 'update' && $productId && $productName) {
    // Загружаем новые изображения
    if (!empty($_FILES['images']['name'][0])) {
        // Удаляем старые изображения
        $stmt = $conn->prepare("DELETE FROM product_images WHERE product_id = ?");
        $stmt->bind_param('i', $productId);
        $stmt->execute();

        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            $imageData = file_get_contents($tmpName);
            $isMain = $key === 0 ? 1 : 0; // Первая картинка — главная
            
            // Загружаем новые изображения
            $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_url, is_main) VALUES (?, ?, ?)");
            $stmt->bind_param('isi', $productId, $imageData, $isMain);
            $stmt->execute();
        }
    }
    $stmt = $conn->prepare("UPDATE products SET name = ?, brand = ?, type = ?, gender = ?, age_group = ?, gears = ?, price = ?, description = ? WHERE id = ?");
    $stmt->bind_param('ssssssisi', $productName, $productBrand, $productType, $productGender, $productAgeGroup, $productGears, $productPrice, $productDescription, $productId);
    $stmt->execute();
    echo json_encode(['success' => true]);
} elseif ($action == 'delete' && isset($_POST['id'])) {
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param('i', $_POST['id']);
    $stmt->execute();
    echo json_encode(['success' => true]);
} elseif ($action == 'list') {
    $result = $conn->query("SELECT id, name FROM products");
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    echo json_encode(['success' => true, 'products' => $products]);
} elseif ($action == 'get' && isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode(['success' => true, 'product' => $product]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Продукт не найден']);
    }
} elseif ($action == 'get_images' && isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT image_url FROM product_images WHERE product_id = ?");
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    $images = [];
    while ($row = $result->fetch_assoc()) {
        // Преобразуем бинарные данные изображения в формат Base64
        $images[] = ['image_url' => base64_encode($row['image_url'])];
    }

    echo json_encode(['success' => true, 'images' => $images]);
} else {
    echo json_encode(['success' => false, 'message' => 'Неверное действие']);
}
?>
