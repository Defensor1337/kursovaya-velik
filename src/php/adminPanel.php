<?php
session_start();
require_once('pageConstruct.php');

// Класс для главной страницы
class AdminPage extends StandardPage {

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
             <div class="admin-block">
            <div class="wrap">
                <div class="admin-panel">
                    <!-- Заголовок панели администратора -->
                    <div class="admin-header">
                        <h1>Панель администратора</h1>
                        <nav class="admin-nav">
                            <a href="#orders" class="nav-link active" data-section="orders">Заказы</a>
                            <a href="#products" class="nav-link" data-section="products">Товары</a>
                            <a href="#promocodes" class="nav-link" data-section="promocodes">Промокоды</a>
                            <a href="#news" class="nav-link" data-section="news">Новости</a>
                        </nav>
                        <form method="POST" action="">
                            <button type="submit" name="logout" class="admin-logout-btn">Выход</button>
                        </form>
                    </div>

                    <!-- Блок заказов -->
                    <section id="orders" class="admin-orders-section admin-section active">
                        <h2>Заказы</h2>

                        <!-- Заказ -->
                        <div class="admin-order">
                            <div class="admin-order-info">
                                <p><strong>Заказчик:</strong> user123</p>

                                <!-- Список товаров в заказе -->
                                <ul class="admin-product-list">
                                    <li class="admin-product-item">
                                        <span>Название товара: Электровелосипед</span>
                                        <span>Количество: 1</span>
                                        <span>Стоимость: 30000 ₽</span>
                                    </li>
                                    <li class="admin-product-item">
                                        <span>Название товара: Шлем</span>
                                        <span>Количество: 2</span>
                                        <span>Стоимость: 4000 ₽</span>
                                    </li>
                                </ul>

                                <!-- Обновление состояния заказа -->
                                <div class="admin-order-status">
                                    <label for="order-status-select">Состояние:</label>
                                    <select id="order-status-select" class="admin-status-select">
                                        <option value="processing">В процессе</option>
                                        <option value="shipped">Отправлен</option>
                                        <option value="delivered">Доставлен</option>
                                        <option value="cancelled">Отменен</option>
                                    </select>
                                    <button class="admin-update-status-btn">Обновить состояние</button>
                                </div>
                            </div>
                        </div>

                        <!-- Копируйте блок .admin-order для добавления других заказов -->
                    </section>

                    <!-- Блок товаров -->
                    <section id="products" class="admin-products-section admin-section">
                        <h2>Товары</h2>

                        <!-- Товар -->
                        <div class="admin-product">
                            <div class="admin-product-info">
                                <p><strong>Название товара:</strong> Электровелосипед</p>
                                <p><strong>Цена:</strong> 30000 ₽</p>

                                <!-- Кнопки управления товаром -->
                                <div class="admin-product-actions">
                                    <button class="admin-edit-btn">Изменить</button>
                                    <button class="admin-delete-btn">Удалить</button>
                                </div>
                            </div>
                        </div>

                        <!-- Копируйте блок .admin-product для других товаров -->

                        <!-- Кнопка добавления товара -->
                        <button class="admin-add-product-btn">Добавить товар</button>
                    </section>
                    <!-- Блок промокодов -->
                    <section id="promocodes" class="admin-promocodes-section admin-section">
                        <h2>Промокоды</h2>

                        <!-- Кнопка создания нового промокода -->
                        <button class="admin-create-promocode-btn">Создать новый промокод</button>

                        <!-- Список промокодов -->
                        <div class="admin-promocode-list">
                            <!-- Промокод -->
                            <div class="admin-promocode-item">
                                <h3>Название: Летняя скидка</h3>
                                <p><strong>Описание:</strong> Скидка 15% на все товары летом</p>
                                <p><strong>Код:</strong> SUMMER15</p>
                                <button class="admin-delete-promocode-btn">Удалить</button>
                            </div>

                            <div class="admin-promocode-item">
                                <h3>Название: Зимняя скидка</h3>
                                <p><strong>Описание:</strong> Скидка 20% на зимние товары</p>
                                <p><strong>Код:</strong> WINTER20</p>
                                <button class="admin-delete-promocode-btn">Удалить</button>
                            </div>

                            <!-- Дополнительные промокоды можно добавить здесь -->
                        </div>
                    </section>
                    <!-- Блок новостей -->
                    <section id="news" class="admin-news-section admin-section">
                        <h2>Новости</h2>

                        <!-- Кнопка добавления новости -->
                        <button class="admin-add-news-btn">Добавить новость</button>

                        <!-- Список новостей -->
                        <div class="admin-news-list">
                            <!-- Новость -->
                            <div class="admin-news-item">
                                <h3>Название: Новая поставка товаров</h3>
                                <p><strong>Описание:</strong> Поступление новых товаров на склад.</p>
                                <p><strong>Дата:</strong> 2024-11-08</p>
                                <button class="admin-delete-news-btn">Удалить</button>
                            </div>

                            <div class="admin-news-item">
                                <h3>Название: Сезонные скидки</h3>
                                <p><strong>Описание:</strong> Скидки на сезонные товары до 50%!</p>
                                <p><strong>Дата:</strong> 2024-11-01</p>
                                <button class="admin-delete-news-btn">Удалить</button>
                            </div>

                            <!-- Дополнительные новости можно добавить здесь -->
                        </div>
                    </section>
                </div>
            </div>
        </div>
HTML;
    }
}
// Пример использования
$adminPage = new AdminPage();
$adminPage->setTitle("Панель администратора - ВелоТрейд");
$adminPage->write();