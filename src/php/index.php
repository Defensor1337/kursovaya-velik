<?php
require_once('pageConstruct.php');

// Класс для главной страницы
class MainPage extends BasePage {

    // Уникальный хедер только для главной страницы
    protected function getHeader() {
        // Проверяем, запущена ли сессия
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Проверяем, залогинен ли пользователь
        $userName = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : null;
    
        // Формируем HTML в зависимости от состояния сессии
        $loginBlock = $userName 
            ? "<a href='/php/login.php' class='icon-account'>
                    <svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M12 4C13.0609 4 14.0783 4.42143 14.8284 5.17157C15.5786 5.92172 16 6.93913 16 8C16 9.06087 15.5786 10.0783 14.8284 10.8284C14.0783 11.5786 13.0609 12 12 12C10.9391 12 9.92172 11.5786 9.17157 10.8284C8.42143 10.0783 8 9.06087 8 8C8 6.93913 8.42143 5.92172 9.17157 5.17157C9.92172 4.42143 10.9391 4 12 4ZM12 14C16.42 14 20 15.79 20 18V20H4V18C4 15.79 7.58 14 12 14Z' fill='black'/>
                    </svg>
                    <p>{$userName}</p>
                </a>"
            : "<a href='/php/login.php' class='icon-account'>
                    <svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M12 4C13.0609 4 14.0783 4.42143 14.8284 5.17157C15.5786 5.92172 16 6.93913 16 8C16 9.06087 15.5786 10.0783 14.8284 10.8284C14.0783 11.5786 13.0609 12 12 12C10.9391 12 9.92172 11.5786 9.17157 10.8284C8.42143 10.0783 8 9.06087 8 8C8 6.93913 8.42143 5.92172 9.17157 5.17157C9.92172 4.42143 10.9391 4 12 4ZM12 14C16.42 14 20 15.79 20 18V20H4V18C4 15.79 7.58 14 12 14Z' fill='black'/>
                    </svg>
                    <p>Войти</p>
                </a>";
    
        return <<<HTML
        <header>
            <div class="wrap">
                <div class="top-menu_ico">
                    <img src="/images/logo.svg" alt="icon">
                    <div class="text">
                        <h1>ВелоТрейд</h1>
                        <h2>Продажа велосипедов</h2>
                    </div>
                </div>
                <div class="header-menu">
                    <div class="top-menu_content">
                        <div class="top-menu_contacts">
                            <div class="makeacall">
                                <p>Заказать звонок:</p>
                                <a href="tel:+79991234567">
                                    <p class="number">+7 999 123-45-67</p>
                                </a>
                            </div>
                            <a href="mailto:info@velotrade.ru">
                                <p class="mail">info@velotrade.ru</p>
                            </a>
                        </div>
                        <div class="top-menu-btns">
                            <a href="/php/cart.php"><svg width="49" height="49" viewBox="0 0 49 49" fill="none" class="icon-basket"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.125 20.4167H8.16667M8.16667 20.4167L10.2083 40.8333H38.7917L40.8333 20.4167M8.16667 20.4167H16.3333M42.875 20.4167H40.8333M40.8333 20.4167H32.6667M32.6667 20.4167H16.3333M32.6667 20.4167V16.3333C32.6667 13.6118 31.0333 8.16667 24.5 8.16667C17.9667 8.16667 16.3333 13.6118 16.3333 16.3333V20.4167M24.5 28.5833V32.6667M30.625 28.5833V32.6667M18.375 28.5833V32.6667"
                                        stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                </svg></a>
                            {$loginBlock}
                        </div>
                    </div>
                    <nav>
                        <ul>
                            <a href="/php/index.php">
                                <li>Главная</li>
                            </a>
                            <a href="/php/catalog.php">
                                <li>Каталог</li>
                            </a>
                            <a href="/php/discount.php">
                                <li>Акции</li>
                            </a>
                            <a href="/php/about.php">
                                <li>О компании</li>
                            </a>
                            
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <div class="carousel-block">
            <div class="wrap">
                <div class="carousel-label-btn">
                    <div class="slider">
                        <h1>Лучшие велосипеды<br> по Спб и Лен области</h1>
                        <a href="/php/catalog.php"><button class="main-btn">Купить</button></a>
                    </div>
                    <div class="carousel-indicators">
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                    </div>
                </div>
                <div class="carousel">
                    <div class="carousel-images">
                        <img src="/images/велик_1 1.png" alt="slider1-pic1" class="carousel-item">
                        <img src="/images/велик_1 1.png" alt="slider1-pic1" class="carousel-item">
                        <img src="/images/велик_1 1.png" alt="slider1-pic1" class="carousel-item">
                    </div>
                </div>
            </div>
        </div>
        <nav class="navigation">
            <div class="wrap">
                <div class="bot-menu">
                    <button class="burger-btn" onclick="toggleMenu()">☰</button>
                    <ul id="nav-menu">
                        <a href="/php/index.php">
                            <li>Главная</li>
                        </a>
                        <a href="/php/catalog.php">
                            <li>Каталог</li>
                        </a>
                        <a href="/php/discount.php">
                            <li>Акции</li>
                        </a>
                        <a href="/php/about.php">
                            <li>О компании</li>
                        </a>
                        
                    </ul>
                </div>
                <div class="bot-menu-basket">
                    <a href="/php/cart.php"><img class="basket" src="/images/basket.svg" alt="basket"></a>
                    {$loginBlock}
                </div>
            </div>
        </nav>
    HTML;
    }
    

    public function getContent() {
        $categories = [
            'Горный' => 'горный',
            'Шоссейные' => 'шоссейный',
            'Гибридные' => 'гибридный',
            'Электро' => 'электровелосипед',
            'Мужские' => 'мужской',
            'Женские' => 'женский',
            'Взрослые' => 'взрослый',
            'Детские' => 'детский'
        ];
        // Генерируем HTML для категорий
        $catalogItems = '';
        foreach ($categories as $key => $value) {
            // Делаем выбор на основе того, что передаем в параметры запроса
            $paramType = '';
            $paramValue = '';

            if (in_array($value, ['горный', 'шоссейный', 'гибридный', 'электровелосипед'])) {
                $paramType = 'type';
                $paramValue = $value;
            } elseif (in_array($value, ['мужской', 'женский'])) {
                $paramType = 'gender';
                $paramValue = $value;
            } elseif (in_array($value, ['взрослый', 'детский'])) {
                $paramType = 'age';
                $paramValue = $value;
            }

            $catalogItems .= <<<HTML
            <a href="/php/catalog.php?{$paramType}={$paramValue}" class="catalog-item">
                <img src="/images/catalog-item-1.png" alt="catalog-item-pic">
                <p>{$key} велосипеды</p>
            </a>
            HTML;
        }

        return <<<HTML
            <div class="calc-block">
            <div class="wrap">
                <h1>Подберем для вас подходящий байк</h1>
                <form action="/php/catalog.php" method="get">
                <div class="calc-params">
                    <div class="calc-inp">
                        <span>от:</span>
                        <input type="number" class="calc-price-before" id="priceMin" name="priceMin" value="0" min="0" step="1">
                        <span>₽</span>
                    </div>
                    <div class="calc-inp">
                        <span>до:</span>
                        <input type="number" class="calc-price-after" id="priceMax" name="priceMax" value="999999" min="0" step="1">
                        <span>₽</span>
                    </div>
                    <div class="calc-inp custom-select-container">
                        <select class="custom-select" name="type">
                            <option value="" disabled selected hidden>Тип</option>
                            <option value="горный">Горный</option>
                            <option value="шоссейный">Шоссейный</option>
                            <option value="гибридный">Гибридный</option>
                            <option value="электровелосипед">Электровелосипед</option>
                        </select>
                    </div>
                    <div class="calc-inp custom-select-container">
                        <select class="custom-select" name="age">
                            <option value="" disabled selected hidden>Возраст</option>
                            <option value="взрослый">Взрослый</option>
                            <option value="детский">Детский</option>
                        </select>
                    </div>
                    <div class="calc-inp custom-select-container">
                        <select class="custom-select" name="gender">
                            <option value="" disabled selected hidden>Пол</option>
                            <option value="мужской">Мужской</option>
                            <option value="женский">Женский</option>
                        </select>
                    </div>
                </div>
                <div class="slider-button">
                    <div class="range-slider">
                        <input type="range" id="rangeMin"  min="0" max="1000000" value="0" step="1000" class="range-min">
                        <input type="range" id="rangeMax"  min="0" max="1000000" value="999999" step="1000" class="range-max">
                        <div class="slider-axis"></div> <!-- Ось между ползунками -->
                    </div>
                    <button type="submit" class="blue-btn">Показать</button>
                </div>
            </form>
            </div>
        </div>
        <div class="catalog-block">
            <div class="wrap">
                <h1>Каталог</h1>
                <div class="catalog-list">
                {$catalogItems}
                </div>
                <a href="/php/catalog.php" class="blue-btn">Показать</a>
            </div>
        </div>
        
HTML;
    }
}

// Пример использования
$mainPage = new MainPage();
$mainPage->setTitle("Добро пожаловать на ВелоТрейд");
$mainPage->write();

