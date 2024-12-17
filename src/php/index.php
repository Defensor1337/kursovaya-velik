<?php
require_once('pageConstruct.php');

// Класс для главной страницы
class MainPage extends BasePage {

    // Уникальный хедер только для главной страницы
    protected function getHeader() {
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
                                <a href="">
                                    <p class="number">+7-927-029-41-17</p>
                                </a>
                            </div>
                            <a href="">
                                <p class="mail">test@mail.ru</p>
                            </a>
                        </div>
                        <div class="top-menu-btns">
                            <a href="/php/cart.php"><svg width="49" height="49" viewBox="0 0 49 49" fill="none" class="icon-basket"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.125 20.4167H8.16667M8.16667 20.4167L10.2083 40.8333H38.7917L40.8333 20.4167M8.16667 20.4167H16.3333M42.875 20.4167H40.8333M40.8333 20.4167H32.6667M32.6667 20.4167H16.3333M32.6667 20.4167V16.3333C32.6667 13.6118 31.0333 8.16667 24.5 8.16667C17.9667 8.16667 16.3333 13.6118 16.3333 16.3333V20.4167M24.5 28.5833V32.6667M30.625 28.5833V32.6667M18.375 28.5833V32.6667"
                                        stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                </svg></a>
                            <a href="/php/login.php" class="icon-account">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class=""
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 4C13.0609 4 14.0783 4.42143 14.8284 5.17157C15.5786 5.92172 16 6.93913 16 8C16 9.06087 15.5786 10.0783 14.8284 10.8284C14.0783 11.5786 13.0609 12 12 12C10.9391 12 9.92172 11.5786 9.17157 10.8284C8.42143 10.0783 8 9.06087 8 8C8 6.93913 8.42143 5.92172 9.17157 5.17157C9.92172 4.42143 10.9391 4 12 4ZM12 14C16.42 14 20 15.79 20 18V20H4V18C4 15.79 7.58 14 12 14Z"
                                        fill="black" />
                                </svg>
                                <p>Войти</p>
                            </a>
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
                            <a href="/php/news.php">
                                <li>Новости</li>
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
                        <a href=""><button class="main-btn">Купить</button></a>
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
                        <a href="/php/news.php">
                            <li>Новости</li>
                        </a>
                    </ul>
                </div>
                <div class="bot-menu-basket">
                    <a href="/php/cart.php"><img class="basket" src="/images/basket.svg" alt="basket"></a>
                    <a href="/php/login.php" class="account">
                        <img src="/images/account.svg" alt="account">
                        <p>Войти</p>
                    </a>
                </div>
            </div>
        </nav>
HTML;
    }

    public function getContent() {
        return <<<HTML
            <div class="calc-block">
            <div class="wrap">
                <h1>Подберем для вас подходящий байк</h1>
                <div class="calc-params">
                    <div class="calc-inp">
                        <span>от:</span>
                        <input type="number" class="calc-price-before" id="priceMin" value="5000" min="0" step="1">
                        <span>₽</span>
                    </div>
                    <div class="calc-inp">
                        <span>до:</span>
                        <input type="number" class="calc-price-after" id="priceMax" value="60000" min="0" step="1">
                        <span>₽</span>
                    </div>
                    <div class="calc-inp custom-select-container">
                        <select class="custom-select">
                            <option value="" disabled selected hidden>Для кого</option>
                            <option value="option1">Опция 1</option>
                            <option value="option2">Опция 2</option>
                            <option value="option3">Опция 3</option>
                        </select>
                    </div>
                    <div class="calc-inp custom-select-container">
                        <select class="custom-select">
                            <option value="" disabled selected hidden>Тип</option>
                            <option value="option1">Опция 1</option>
                            <option value="option2">Опция 2</option>
                            <option value="option3">Опция 3</option>
                        </select>
                    </div>
                    <div class="calc-inp custom-select-container">
                        <select class="custom-select">
                            <option value="" disabled selected hidden>Марка</option>
                            <option value="option1">Опция 1</option>
                            <option value="option2">Опция 2</option>
                            <option value="option3">Опция 3</option>
                        </select>
                    </div>
                </div>
                <div class="slider-button">
                    <div class="range-slider">
                        <input type="range" id="rangeMin" min="0" max="100000" value="5000" step="1" class="range-min">
                        <input type="range" id="rangeMax" min="0" max="100000" value="60000" step="1" class="range-max">
                        <div class="slider-axis"></div> <!-- Ось между ползунками -->
                    </div>
                    <a href=""><button class="blue-btn">Показать</button></a>
                </div>
            </div>
        </div>
        <div class="catalog-block">
            <div class="wrap">
                <h1>Каталог</h1>
                <div class="catalog-list">
                    <a href="" class="catalog-item">
                        <img src="/images/catalog-item-1.png" alt="catalog-item-pic">
                        <p>Горные велосипеды</p>
                    </a>
                    <a href="" class="catalog-item">
                        <img src="/images/catalog-item-1.png" alt="catalog-item-pic">
                        <p>Женские велосипеды</p>
                    </a>
                    <a href="" class="catalog-item">
                        <img src="/images/catalog-item-1.png" alt="catalog-item-pic">
                        <p>Мужские велосипеды</p>
                    </a>
                    <a href="" class="catalog-item">
                        <img src="/images/catalog-item-1.png" alt="catalog-item-pic">
                        <p>Детские велосипеды</p>
                    </a>
                    <a href="" class="catalog-item">
                        <img src="/images/catalog-item-1.png" alt="catalog-item-pic">
                        <p>Дорожные велосипеды</p>
                    </a>
                    <a href="" class="catalog-item">
                        <img src="/images/catalog-item-1.png" alt="catalog-item-pic">
                        <p>Шоссейные велосипеды</p>
                    </a>
                    <a href="" class="catalog-item">
                        <img src="/images/catalog-item-1.png" alt="catalog-item-pic">
                        <p>Подростковые велосипеды</p>
                    </a>
                    <a href="" class="catalog-item">
                        <img src="/images/catalog-item-1.png" alt="catalog-item-pic">
                        <p>Электровелосипеды</p>
                    </a>
                </div>
                <button class="blue-btn">Показать</button>
            </div>
        </div>
        <div class="news-block">
            <div class="wrap">
                <div class="news-container">
                    <div class="news-item">
                        <img src="/images/news1.png" alt="news1-pic">
                        <span></span>
                        <div class="text">
                            <h1>Новая коллекция велосипедов 2024 года — инновации и стиль</h1>
                            <p>Мы рады сообщить о запуске новой коллекции велосипедов 2024 года! В линейке представлены
                                модели для всех типов катания: от городских и шоссейных до горных и электрических
                                велосипедов. </p>
                        </div>
                    </div>
                    <div class="news-item">
                        <img src="/images/news1.png" alt="news1-pic">
                        <span></span>
                        <div class="text">
                            <h1>Новая коллекция велосипедов 2024 года — инновации и стиль</h1>
                            <p>Мы рады сообщить о запуске новой коллекции велосипедов 2024 года! В линейке представлены
                                модели для всех типов катания: от городских и шоссейных до горных и электрических
                                велосипедов. </p>
                        </div>
                    </div>
                    <div class="news-item">
                        <img src="/images/news1.png" alt="news1-pic">
                        <span></span>
                        <div class="text">
                            <h1>Новая коллекция велосипедов 2024 года — инновации и стиль</h1>
                            <p>Мы рады сообщить о запуске новой коллекции велосипедов 2024 года! В линейке представлены
                                модели для всех типов катания: от городских и шоссейных до горных и электрических
                                велосипедов. </p>
                        </div>
                    </div>
                </div>
                <button class="main-btn">Больше новостей</button>
            </div>
        </div>
HTML;
    }
}

// Пример использования
$mainPage = new MainPage();
$mainPage->setTitle("Добро пожаловать на ВелоТрейд");
$mainPage->write();

