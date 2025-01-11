<?php
require_once('db.php');

if (isset($_POST['id'])) {
    $userId = $_POST['id'];

    // Удаление всех заказов пользователя
    $stmt = $conn->prepare("DELETE FROM orders WHERE user_id = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    
    // Удаление пользователя по ID
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка при удалении пользователя']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Не указан ID пользователя']);
}
?>
