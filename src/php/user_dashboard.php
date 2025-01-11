<?php
session_start();
require_once('pageConstruct.php');

// Класс для главной страницы
class UserPage extends StandardPage {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getContent() {
        $conn = $this->conn;
        
        // Сохраняем ошибки и сообщения из сессии
        $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
        $success = isset($_SESSION['success']) ? $_SESSION['success'] : '';

        // Очищаем сообщения в сессии после их отображения
        unset($_SESSION['error']);
        unset($_SESSION['success']);

        // Проверка на выход
        if (isset($_POST['logout'])) {
            // Уничтожаем сессию
            session_unset();
            session_destroy();
            // Перенаправляем на страницу входа
            header("Location: login.php");
            exit;
        }

        // Проверка на залогинен ли пользователь
        if (!isset($_SESSION['user_id'])) {
            return "Вы не авторизованы. Пожалуйста, войдите в свой аккаунт.";
        }

        $userId = $_SESSION['user_id'];

        // Получаем email пользователя
        $userQuery = "SELECT email, password FROM users WHERE id = ?";
        $stmt = $conn->prepare($userQuery);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $userResult = $stmt->get_result();
        $user = $userResult->fetch_assoc();
        $userEmail = $user['email'];
        $userPasswordHash = $user['password'];

        // Обработка изменения пароля
        if (isset($_POST['change_password'])) {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            // Проверка текущего пароля
            if (!password_verify($currentPassword, $userPasswordHash)) {
                $_SESSION['error'] = "Неверный текущий пароль.";
            } elseif ($newPassword !== $confirmPassword) {
                $_SESSION['error'] = "Новые пароли не совпадают.";
            } else {
                // Обновление пароля в базе данных
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateQuery = "UPDATE users SET password = ? WHERE id = ?";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param("si", $newPasswordHash, $userId);
                $stmt->execute();
                $_SESSION['success'] = "Пароль успешно изменен.";
            }
            // Перезагружаем страницу, чтобы отобразить сообщения
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }

        // Получаем заказы пользователя
        $ordersQuery = "SELECT * FROM orders WHERE user_id = ? AND status IN ('Оформлен', 'В процессе', 'Доставлен')";
        $stmt = $conn->prepare($ordersQuery);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $ordersResult = $stmt->get_result();

        // Начинаем формировать HTML
        $orderHistoryHTML = '';
        while ($order = $ordersResult->fetch_assoc()) {
            $orderId = $order['order_id'];
            $status = $order['status'];
            $discount = $order['discount'];

            // Получаем товары для каждого заказа
            $orderItemsQuery = "SELECT oi.quantity, p.name, p.price FROM order_items oi 
                                JOIN products p ON oi.product_id = p.id 
                                WHERE oi.order_id = ?";
            $stmt = $conn->prepare($orderItemsQuery);
            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            $orderItemsResult = $stmt->get_result();

            // Считаем итоговую стоимость
            $totalAmount = 0;
            $orderItemsHTML = '';
            while ($item = $orderItemsResult->fetch_assoc()) {
                $quantity = $item['quantity'];
                $name = $item['name'];
                $price = $item['price'];
                $totalAmount += $quantity * $price;
                $orderItemsHTML .= "<li class='product-item'>
                                        <span class='product-name'>$name</span>
                                        <span class='product-quantity'>Количество: $quantity</span>
                                        <span class='product-price'>Цена: " . number_format($price, 0, ',', ' ') . " ₽</span>
                                      </li>";
            }

            // Применяем скидку
            $totalAmountWithDiscount = $totalAmount * (1 - $discount / 100);

            // Формируем HTML для каждого заказа
            $orderHistoryHTML .= "<div class='order-item'>
                                    <div class='order-header'>
                                        <h3>Заказ №$orderId</h3>
                                        <span class='order-status'>$status</span>
                                    </div>
                                    <div class='order-content'>
                                        <ul class='product-list'>
                                            $orderItemsHTML
                                        </ul>
                                        <div class='order-summary'>
                                            <span>Сумма: " . number_format($totalAmount, 0, ',', ' ') . " ₽</span><br>
                                            <span>Скидка: $discount %</span><br>
                                            <span>Итоговая сумма: " . number_format($totalAmountWithDiscount, 0, ',', ' ') . " ₽</span>
                                        </div>
                                    </div>
                                  </div>";
        }

        // Если заказы есть, показываем их
        if (empty($orderHistoryHTML)) {
            $orderHistoryHTML = "<p>У вас нет заказов.</p>";
        }

        // Формируем сообщения для отображения
        $messages = '';
        if ($error) {
            $messages .= "<p style='color:red;'>$error</p>";
        }
        if ($success) {
            $messages .= "<p style='color:green;'>$success</p>";
        }

        return <<<HTML
            <div class="user-account">
                <div class="wrap">
                    <div class="user-account">
                        <!-- Кнопка выхода -->
                        <div class="logout-container">
                            <form method="POST" action="">
                                <button type="submit" name="logout" class="logout-btn">Выйти из аккаунта</button>
                            </form>
                        </div>

                        <!-- Информация об аккаунте -->
                        <div class="account-info">
                            <h2>Информация об аккаунте</h2>
                            <div class="info-item">
                                <label>Логин:</label>
                                <span id="user-login">{$_SESSION['username']}</span>
                            </div>
                            <div class="info-item">
                                <label>Email:</label>
                                <span id="user-email">{$userEmail}</span>
                            </div>
                            <div class="info-item">
                                <label>Пароль:</label>
                                <span id="user-password">********</span>
                                <button class="change-password-btn" onclick="openModal()">Изменить</button>
                            </div>
                            $messages
                        </div>

                        <!-- Модальное окно для изменения пароля -->
                        <div id="change-password-modal" class="modal" style="display:none;">
                            <div class="modal-content">
                                <span class="close" onclick="closeModal()">&times;</span>
                                <h2>Изменить пароль</h2>
                                <form method="POST" action="">
                                    <div>
                                        <label for="current_password">Текущий пароль:</label>
                                        <input type="password" id="current_password" name="current_password" required>
                                    </div>
                                    <div>
                                        <label for="new_password">Новый пароль:</label>
                                        <input type="password" id="new_password" name="new_password" required>
                                    </div>
                                    <div>
                                        <label for="confirm_password">Подтвердите новый пароль:</label>
                                        <input type="password" id="confirm_password" name="confirm_password" required>
                                    </div>
                                    <button type="submit" name="change_password">Изменить пароль</button>
                                </form>
                                <!-- Ошибки и успех -->
                                <div>
                                   
                                </div>
                            </div>
                        </div>

                        <!-- Текущие заказы -->
                        <div class="order-history">
                            <h2>Текущие заказы</h2>
                            $orderHistoryHTML
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Открытие модального окна
                function openModal() {
                    document.getElementById('change-password-modal').style.display = 'flex';
                }

                // Закрытие модального окна
                function closeModal() {
                    document.getElementById('change-password-modal').style.display = 'none';
                }

                // Закрытие модального окна при клике вне его
                window.onclick = function(event) {
                    if (event.target == document.getElementById('change-password-modal')) {
                        closeModal();
                    }
                }
            </script>
HTML;
    }
}

// Пример использования
$userPage = new UserPage($conn);
$userPage->setTitle("Личный кабинет - ВелоТрейд");
$userPage->write();
