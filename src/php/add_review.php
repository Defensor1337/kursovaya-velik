<?php
require_once('db.php');

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['product_id'], $_POST['username'], $_POST['text'])) {
        echo json_encode(['success' => false, 'message' => 'Некорректные данные.']);
        exit;
    }

    $product_id = $_POST['product_id'];
    $username = trim($_POST['username']);
    $text = trim($_POST['text']);

    if (empty($username) || empty($text)) {
        echo json_encode(['success' => false, 'message' => 'Все поля обязательны для заполнения.']);
        exit;
    }

    $sql = "INSERT INTO reviews (product_id, username, text, date) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $product_id, $username, $text);

    if ($stmt->execute()) {
        $date = date('Y-m-d H:i:s');
        echo json_encode([
            'success' => true,
            'review' => [
                'username' => htmlspecialchars($username),
                'text' => htmlspecialchars($text),
                'date' => $date
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка при добавлении отзыва: ' . $stmt->error]);
    }
}
