<?php
session_start();
require_once('db.php'); // Подключение к базе данных

// Получаем данные из запроса
$data = json_decode(file_get_contents('php://input'), true);
$promoName = $data['promoName'] ?? null;

if (!$promoName) {
    echo json_encode(['success' => false, 'message' => 'Промокод не указан']);
    exit;
}

// Проверяем промокод в базе данных
$stmt = $conn->prepare("SELECT discount FROM promocodes WHERE promoname = ?");
$stmt->bind_param("s", $promoName);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $promo = $result->fetch_assoc();
    $discount = (int)$promo['discount'];
    $_SESSION['discount'] = $discount; // Сохраняем скидку в сессии
    echo json_encode(['success' => true, 'discount' => $discount]);
} else {
    echo json_encode(['success' => false, 'message' => 'Неверный промокод']);
}

exit;

