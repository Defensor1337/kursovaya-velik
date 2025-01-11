<?php
session_start();
require_once('db.php');  // подключение к базе данных

// Устанавливаем заголовок, чтобы указать, что будет отправлен JSON
header('Content-Type: application/json');

// Проверка на наличие товаров в корзине
if (empty($_SESSION['cart']) or !isset($_SESSION['cart'])) {
    echo json_encode(['success' => false, 'message' => 'Корзина пуста. Невозможно оформить заказ.']);
    exit;
}

// Проверяем наличие скидки в session
$discount = isset($_SESSION['discount']) ? $_SESSION['discount'] : 0;

// Создаем заказ в таблице orders
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;  // если пользователь не залогинен, user_id будет NULL

$query = "INSERT INTO orders (user_id, discount, status) VALUES (?, ?, 'Оформлен')";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $userId, $discount);
$stmt->execute();
$orderId = $stmt->insert_id;  // Получаем ID только что созданного заказа

// Добавляем товары в таблицу order_items
foreach ($_SESSION['cart'] as $productId => $quantity) {
    $query = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $orderId, $productId, $quantity);
    $stmt->execute();
}

// Очистка корзины после оформления заказа
unset($_SESSION['cart']);
unset($_SESSION['discount']);  // Очистим скидку, если она была

// Отправляем пользователю номер заказа
echo json_encode(['success' => true, 'orderId' => $orderId, 'message' => 'Ваш заказ оформлен. Номер заказа: ' . $orderId]);
?>
