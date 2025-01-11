<?php
session_start();
$data = json_decode(file_get_contents('php://input'), true);

// Проверяем, что получены данные
$productId = $data['productId'] ?? null;
$change = $data['change'] ?? 0;
$remove = $data['remove'] ?? false;

// Если товар существует в корзине
if ($productId && isset($_SESSION['cart'][$productId])) {
    if ($remove) {
        unset($_SESSION['cart'][$productId]); // Удаляем товар
    } else {
        $_SESSION['cart'][$productId] += $change; // Изменяем количество товара
        if ($_SESSION['cart'][$productId] <= 0) {
            unset($_SESSION['cart'][$productId]); // Если количество <= 0, удаляем товар
        }
    }

    // Возвращаем успешный ответ
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Product not found in cart']);
}

exit;

