<?php
require_once('db.php'); // Подключение к базе данных

$action = $_POST['action'] ?? $_GET['action'] ?? null;
$promoId = $_POST['id'] ?? null;
$promoName = $_POST['name'] ?? null;
$promoPromoname = $_POST['promoname'] ?? null;
$promoDiscount = $_POST['discount'] ?? null;

if ($action == 'add' && $promoName) {
    // Запрос на добавление промокода
    $stmt = $conn->prepare("INSERT INTO promocodes (name, promoname, discount) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $promoName, $promoPromoname, $promoDiscount);
    $stmt->execute();

    // Получаем ID только что добавленного промокода
    $newPromoId = $stmt->insert_id;
    // Загрузка одного изображения
    if (!empty($_FILES['image']['tmp_name'])) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $stmt = $conn->prepare("INSERT INTO promocodes (promo_image) VALUE ? WHERE id = ?");
        $stmt->bind_param('si',  $imageData, $newPromoId);
        $stmt->execute();
    }
    // Формируем ответ с данными о промокоде
    $stmt = $conn->prepare("SELECT * FROM promocodes WHERE id = ?");
    $stmt->bind_param('i', $newPromoId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $promo = $result->fetch_assoc();
        echo json_encode(['success' => true, 'promo' => $promo]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка при получении данных о промокоде']);
    }
} elseif ($action == 'update' && $promoId && $promoName) {
    // Загрузка одного изображения
    if (!empty($_FILES['image']['tmp_name'])) {
        // Чтение содержимого файла в бинарный формат
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        
        // Обновляем изображение
        $stmt = $conn->prepare("UPDATE promocodes SET promo_image = ? WHERE id = ?");
        $stmt->bind_param('si', $imageData, $promoId); // 'b' для BLOB и 'i' для ID
        $stmt->execute();
    }

    // Обновление других данных промокода
    $stmt = $conn->prepare("UPDATE promocodes SET name = ?, promoname = ?, discount = ? WHERE id = ?");
    $stmt->bind_param('ssii', $promoName, $promoPromoname, $promoDiscount, $promoId); // 'ssii' для строк и целых чисел
    $stmt->execute();

    echo json_encode(['success' => true]);
} elseif ($action == 'delete' && isset($_POST['id'])) {
    // Удаление промокода
    $stmt = $conn->prepare("DELETE FROM promocodes WHERE id = ?");
    $stmt->bind_param('i', $_POST['id']);
    $stmt->execute();
    echo json_encode(['success' => true]);
} elseif ($action == 'list') {
    // Получение списка всех промокодов
    $result = $conn->query("SELECT id, name FROM promocodes");
    $promos = [];
    while ($row = $result->fetch_assoc()) {
        $promos[] = $row;
    }
    echo json_encode(['success' => true, 'promos' => $promos]);
} elseif ($action == 'get' && isset($_GET['id'])) {
    // Получение данных о конкретном промокоде
    $stmt = $conn->prepare("SELECT id, name, promoname, discount FROM promocodes WHERE id = ?");
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $promo = $result->fetch_assoc();
        echo json_encode(['success' => true, 'promo' => $promo]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Промокод не найден']);
    }
} elseif ($action == 'get_images' && isset($_GET['id'])) {
    // Получение изображения промокода
    $stmt = $conn->prepare("SELECT promo_image FROM promocodes WHERE id = ?");
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    $image = null;
    if ($row = $result->fetch_assoc()) {
        // Преобразуем бинарные данные изображения в формат Base64
        if ($row['promo_image']) {
            $image = base64_encode($row['promo_image']);
        }
    }

    echo json_encode(['success' => true, 'image' => $image]);
} else {
    echo json_encode(['success' => false, 'message' => 'Неверное действие']);
}

?>
