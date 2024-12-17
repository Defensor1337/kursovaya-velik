<?php
session_start();
require_once('pageConstruct.php');

// Класс для главной страницы
class UserPage extends StandardPage {

    public function getContent() {

        // Проверка на выход
        if (isset($_POST['logout'])) {
            // Уничтожаем сессию
            session_unset();
            session_destroy();
            // Перенаправляем на страницу входа
            header("Location: login.php");
            exit;
        }
        return <<<HTML
            <div class="user-accoun">
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
                            <span id="user-login">user123</span>
                        </div>
                        <div class="info-item">
                            <label>Email:</label>
                            <span id="user-email">user@example.com</span>
                        </div>
                        <div class="info-item">
                            <label>Пароль:</label>
                            <span id="user-password">********</span>
                            <button class="change-password-btn">Изменить</button>
                        </div>
                    </div>

                    <!-- Текущие заказы -->
                    <div class="order-history">
                        <h2>Текущие заказы</h2>

                        <!-- Заказ №1234 с несколькими товарами -->
                        <div class="order-item">
                            <div class="order-header">
                                <span>Заказ №1234</span>
                                <span class="order-status">В процессе</span>
                            </div>
                            <div class="order-content">
                                <ul class="product-list">
                                    <li class="product-item">
                                        <span>Товар: Электровелосипед SportBMW</span>
                                        <span>Количество: 1</span>
                                        <span>Цена: 30000 ₽</span>
                                    </li>
                                    <li class="product-item">
                                        <span>Товар: Защитный шлем</span>
                                        <span>Количество: 1</span>
                                        <span>Цена: 2000 ₽</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Заказ №5678 с несколькими товарами -->
                        <div class="order-item">
                            <div class="order-header">
                                <span>Заказ №5678</span>
                                <span class="order-status">Доставлен</span>
                            </div>
                            <div class="order-content">
                                <ul class="product-list">
                                    <li class="product-item">
                                        <span>Товар: Акустическая система</span>
                                        <span>Количество: 2</span>
                                        <span>Цена: 15000 ₽</span>
                                    </li>
                                    <li class="product-item">
                                        <span>Товар: Пульт управления</span>
                                        <span>Количество: 1</span>
                                        <span>Цена: 5000 ₽</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }
}
// Пример использования
$userPage = new UserPage();
$userPage->setTitle("Панель администратора - ВелоТрейд");
$userPage->write();