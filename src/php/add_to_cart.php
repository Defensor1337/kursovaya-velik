<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Получаем данные из JSON запроса
$data = json_decode(file_get_contents('php://input'), true);

// Проверяем, что данные получены корректно
if (isset($data['productId']) && isset($data['quantity'])) {
    $productId = $data['productId'];
    $quantity = $data['quantity'];

    // Инициализация корзины, если она пуста
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Добавление или обновление товара в корзине
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity; // Увеличиваем количество товара
    } else {
        $_SESSION['cart'][$productId] = $quantity; // Добавляем товар в корзину
    }

    // Возвращаем успешный ответ
    echo json_encode(['success' => true]);
} else {
    // Возвращаем ошибку, если данные некорректны
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
}

exit;

