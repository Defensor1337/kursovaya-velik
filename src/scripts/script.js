// sliders
function initSlider(slideSelector, dotSelector, carouselImagesSelector, interval = 3000) {
    const slides = document.querySelectorAll(slideSelector);
    const dots = document.querySelectorAll(dotSelector);
    const carouselImages = document.querySelector(carouselImagesSelector);

    // Проверяем наличие элементов
    if (!carouselImages || slides.length === 0 || dots.length === 0) return;

    let currentIndex = 0;
    const totalSlides = slides.length;

    function showSlide(index) {
        currentIndex = (index + totalSlides) % totalSlides;

        carouselImages.style.transform = `translateX(-${currentIndex * 100}%)`;
        dots.forEach(dot => dot.classList.remove('active'));
        dots[currentIndex].classList.add('active');
    }

    const nextSlide = () => showSlide(currentIndex + 1);
    setInterval(nextSlide, interval);

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => showSlide(index));
    });

    showSlide(currentIndex);
}

// Инициализация слайдеров, проверка на наличие каждого набора элементов
initSlider('.carousel-item', '.dot', '.carousel-images');
initSlider('.advert-carousel-item', '.advert-dot', '.advert-carousel-images');

// Код для диапазона цен
// Код для диапазона цен
const rangeMin = document.getElementById('rangeMin');
const rangeMax = document.getElementById('rangeMax');
const priceMin = document.getElementById('priceMin');
const priceMax = document.getElementById('priceMax');

if (rangeMin && rangeMax && priceMin && priceMax) {
    // Функция синхронизации значений ползунка и поля ввода
    function syncRangeWithInput(range, input) {
        range.value = input.value;
    }

    // Обработчик изменения минимального диапазона
    rangeMin.addEventListener('input', () => {
        priceMin.value = rangeMin.value;
        // Проверка, чтобы минимальная цена не была больше максимальной
        if (+rangeMin.value > +rangeMax.value) {
            rangeMax.value = rangeMin.value;
            priceMax.value = rangeMax.value;
        }
    });

    // Обработчик изменения максимального диапазона
    rangeMax.addEventListener('input', () => {
        priceMax.value = rangeMax.value;
        // Проверка, чтобы максимальная цена не была меньше минимальной
        if (+rangeMax.value < +rangeMin.value) {
            rangeMin.value = rangeMax.value;
            priceMin.value = rangeMin.value;
        }
    });

    // Обработчик изменения значения в поле ввода для минимальной цены
    priceMin.addEventListener('input', () => {
        syncRangeWithInput(rangeMin, priceMin);
        // Проверка, чтобы минимальная цена не была больше максимальной
        if (+priceMin.value > +rangeMax.value) {
            rangeMax.value = priceMin.value;
            priceMax.value = rangeMax.value;
        }
    });

    // Обработчик изменения значения в поле ввода для максимальной цены
    priceMax.addEventListener('input', () => {
        syncRangeWithInput(rangeMax, priceMax);
        // Проверка, чтобы максимальная цена не была меньше минимальной
        if (+priceMax.value < +rangeMin.value) {
            rangeMin.value = priceMax.value;
            priceMin.value = rangeMin.value;
        }
    });
}

// Sticky навигация
const navigation = document.querySelector('.navigation');
if (navigation) {
    window.addEventListener('scroll', () => {
        navigation.classList.toggle('sticky', window.scrollY > 200);
    });
}
function toggleMenu() {
    const navMenu = document.getElementById('nav-menu');
    navMenu.classList.toggle('show'); // Переключаем класс для открытия/закрытия меню
    document.getElementById('nav-menu-second').classList.toggle('show');
}

// item-gallery

function updatePrimaryImage(thumbnail) {
    const primaryImage = document.getElementById('primary-image');
    if (primaryImage) {
        primaryImage.src = thumbnail.src;
    }
}

// login-page

const showRegisterLink = document.getElementById('show-register-form');
const showLoginLink = document.getElementById('show-login-form');
const loginForm = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');

if (showRegisterLink && loginForm && registerForm) {
    showRegisterLink.addEventListener('click', function (e) {
        e.preventDefault();
        loginForm.classList.remove('active-form');
        registerForm.classList.add('active-form');
    });
}

if (showLoginLink && loginForm && registerForm) {
    showLoginLink.addEventListener('click', function (e) {
        e.preventDefault();
        registerForm.classList.remove('active-form');
        loginForm.classList.add('active-form');
    });
}

// admin panel section

document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();

        // Удаляем активный класс со всех ссылок и секций
        document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
        document.querySelectorAll('.admin-section').forEach(section => section.classList.remove('active'));

        // Добавляем активный класс к выбранной ссылке и соответствующей секции
        this.classList.add('active');
        const sectionId = this.getAttribute('data-section');
        document.getElementById(sectionId).classList.add('active');
    });
});

// Function to update the total price
document.addEventListener('DOMContentLoaded', function() {
    // Обработчик кнопки уменьшения количества
    document.querySelectorAll('.decrease').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('.cart-item-row');
            if (row) {
                const productId = row.getAttribute('data-id');
                let quantity = parseInt(row.querySelector('.quantity').textContent, 10);

                if (quantity > 1) {
                    updateCart(productId, -1); // Уменьшить количество
                }
            }
        });
    });

    // Обработчик кнопки увеличения количества
    document.querySelectorAll('.increase').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('.cart-item-row');
            if (row) {
                const productId = row.getAttribute('data-id');
                updateCart(productId, 1); // Увеличить количество
            }
        });
    });

    // Обработчик кнопки удаления товара
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('.cart-item-row');
            if (row) {
                const productId = row.getAttribute('data-id');
                updateCart(productId, 0, true); // Удалить товар из корзины
            }
        });
    });

    // Функция обновления корзины через AJAX
    function updateCart(productId, change, remove = false) {
        fetch('update_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ productId, change, remove })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = document.querySelector(`[data-id="${productId}"]`);
                if (row) {
                    if (remove) {
                        row.remove(); // Удаляем товар из корзины в HTML
                    } else {
                        const quantityElement = row.querySelector('.quantity');
                        if (quantityElement) {
                            let newQuantity = parseInt(quantityElement.textContent, 10) + change;
                            quantityElement.textContent = newQuantity;

                            // Обновляем цену товара в корзине
                            const price = parseFloat(row.getAttribute('data-price'));
                            const totalPriceElement = row.querySelector('.item-price');
                            if (totalPriceElement) {
                                totalPriceElement.textContent = (price * newQuantity) + ' ₽';
                            }
                        }
                    }

                    // Обновляем итоговую цену и скидку
                    updateTotalPrice();

                    // Проверяем, если корзина пуста
                    if (document.querySelectorAll('.cart-item-row').length === 0) {
                        const cartContainer = document.querySelector('.cart-container');
                        if (cartContainer) {
                            // Убираем все товары из корзины
                            const rows = cartContainer.querySelectorAll('.cart-item-row');
                            rows.forEach(row => row.remove());

                            // Добавляем сообщение о пустой корзине после cart-header
                            const emptyMessage = document.createElement('p');
                            emptyMessage.textContent = 'Корзина пуста.';
                            const cartHeader = cartContainer.querySelector('.cart-header');
                            if (cartHeader) {
                                cartContainer.insertBefore(emptyMessage, cartHeader.nextSibling); // Вставляем сообщение после cart-header
                            }

                            // Удаляем блоки с итоговой ценой и скидкой
                            const priceBlocks = document.querySelectorAll('.cart-summary, .cart-discount');
                            priceBlocks.forEach(block => block.remove());

                            // Добавляем блоки с промокодом и кнопкой "Оформить"
                            const cartSubmitBtn = document.querySelector('.cart-submit-btn');
                            if (cartSubmitBtn) {
                                cartContainer.appendChild(cartSubmitBtn);
                            }
                        }
                    }
                }
            } else {
                alert('Ошибка при обновлении корзины');
            }
        })
        .catch(error => console.error('Ошибка:', error));
    }

    // Функция для обновления итоговой цены и скидки
    function updateTotalPrice() {
        let totalPrice = 0;
        const cartItems = document.querySelectorAll('.cart-item-row');
        if (cartItems.length > 0) {
            cartItems.forEach(row => {
                const quantity = parseInt(row.querySelector('.quantity').textContent, 10);
                const price = parseFloat(row.getAttribute('data-price'));
                totalPrice += price * quantity;
            });

            let discountPercent = parseInt(document.getElementById('discount-percent')?.textContent, 10) || 0; // Учитываем промокод
            let discountedTotal = totalPrice * (1 - discountPercent / 100);

            const totalPriceElement = document.getElementById('total-price');
            if (totalPriceElement) {
                totalPriceElement.textContent = totalPrice; // Обновляем итоговую цену
            }

            const discountedTotalElement = document.getElementById('discounted-total');
            if (discountedTotalElement) {
                discountedTotalElement.textContent = discountedTotal; // Обновляем сумму со скидкой
            }

            const discountElement = document.getElementById('discount-percent');
            if (discountElement) {
                discountElement.textContent = discountPercent; // Обновляем процент скидки
            }
        }
    }

    // Вызов обновления итоговой цены сразу после загрузки страницы
    updateTotalPrice();

    const promoInput = document.getElementById('promo-code');
    const applyPromoButton = document.getElementById('apply-promo');

    if (applyPromoButton) {  // Проверяем, существует ли кнопка
        applyPromoButton.addEventListener('click', function () {
            const promoName = promoInput.value.trim();

            if (!promoName) {
                alert('Введите промокод');
                return;
            }

            fetch('apply_promo.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ promoName })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Данные с сервера:', data);
                if (data.success) {
                    const discount = data.discount;
                    document.getElementById('discount-percent').textContent = discount;

                    // Пересчет итоговой суммы
                    const totalPriceElement = document.getElementById('total-price');
                    const discountedTotalElement = document.getElementById('discounted-total');

                    if (totalPriceElement && discountedTotalElement) {
                        const totalPrice = parseFloat(totalPriceElement.textContent);
                        const discountedTotal = totalPrice * (1 - discount / 100);
                        discountedTotalElement.textContent = discountedTotal;
                    }
                    promoInput.value = '';
                    alert('Скидка успешно применена!');
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Ошибка:', error));
        });
    }

    // Обработчик кнопки оформления заказа
    const submitOrderButton = document.getElementById('submit-order');

    if (submitOrderButton) {
        submitOrderButton.addEventListener('click', function () {
            // Отправка запроса через fetch без перезагрузки страницы
            fetch('create_order.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({})  // Пустой объект, так как данные в сессии уже есть
            })
            .then(response => response.json())
            .then(data => {
                const cartContainer = document.querySelector('.cart-container');
                
                // Ищем уже существующий блок с результатом заказа
                let resultDiv = document.querySelector('.order-result');

                // Если блок не существует, создаем его
                if (!resultDiv) {
                    resultDiv = document.createElement('div');
                    resultDiv.classList.add('order-result');
                    cartContainer.appendChild(resultDiv);  // Добавляем новый блок в контейнер
                }

                if (data.success) {
                    resultDiv.textContent = data.message;  // Если заказ оформлен, показываем номер заказа
                    const cartContainer = document.querySelector('.cart-container');
                        if (cartContainer) {
                            // Убираем все товары из корзины
                            const rows = cartContainer.querySelectorAll('.cart-item-row');
                            rows.forEach(row => row.remove());

                            // Добавляем сообщение о пустой корзине после cart-header
                            const emptyMessage = document.createElement('p');
                            emptyMessage.textContent = 'Корзина пуста.';
                            const cartHeader = cartContainer.querySelector('.cart-header');
                            if (cartHeader) {
                                cartContainer.insertBefore(emptyMessage, cartHeader.nextSibling); // Вставляем сообщение после cart-header
                            }

                            // Удаляем блоки с итоговой ценой и скидкой
                            const priceBlocks = document.querySelectorAll('.cart-summary, .cart-discount');
                            priceBlocks.forEach(block => block.remove());

                            // Добавляем блоки с промокодом и кнопкой "Оформить"
                            const cartSubmitBtn = document.querySelector('.cart-submit-btn');
                            if (cartSubmitBtn) {
                                cartContainer.appendChild(cartSubmitBtn);
                            }
                        }
                } else {
                    resultDiv.textContent = data.message;  // В случае ошибки выводим сообщение
                }

                // Вставляем результат в корзину
                cartContainer.appendChild(resultDiv);
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Ошибка при оформлении заказа. Попробуйте позже.');
            });
        });
    }
});

// добавление в корзину из каталога
document.addEventListener('DOMContentLoaded', function() {
    const catalogElement = document.querySelector('.catalog');
        if (catalogElement) {
        // Делегирование кликов по карточкам товаров
        document.querySelector('.catalog').addEventListener('click', function(event) {
            const productCell = event.target.closest('.catalog-cell');
            
            // Если клик был на карточке товара, переходим на страницу товара
            if (productCell) {
                // Проверяем, не был ли клик на кнопке "Добавить в корзину"
                if (!event.target.closest('.catalog-cell-basket-btn')) {
                    const productId = productCell.getAttribute('data-product-id');
                    window.location.href = 'item.php?id=' + productId;
                }
            }

            // Делегирование события для кнопок "Добавить в корзину"
            if (event.target.closest('.catalog-cell-basket-btn')) {
                const productId = event.target.closest('.catalog-cell-basket-btn').getAttribute('data-product-id');
                const quantity = event.target.closest('.catalog-cell-basket-btn').getAttribute('data-quantity');
                
                // Добавляем товар в корзину
                addToCart(productId, quantity);
                
                // Останавливаем дальнейшее распространение события, чтобы не было перехода
                event.stopPropagation();
            }
        });
    }
});

function addToCart(productId, quantity) {
    console.log('Добавление товара в корзину:', productId, quantity);

    // Пример отправки данных на сервер с помощью fetch
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ productId, quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`Товар с ID ${productId} добавлен в корзину!`);
        } else {
            alert('Ошибка при добавлении в корзину!');
        }
    })
    .catch(error => console.error('Ошибка при отправке запроса:', error));
}


// Оформление заказа при клике на кнопку

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.admin-status-select').forEach(select => {
        select.addEventListener('change', () => {
            const selectedValue = select.value;
            console.log('Новое значение статуса:', selectedValue); // Проверяем, что выбрано
        });
    });
    document.querySelectorAll('.admin-update-status-btn').forEach(button => {
        button.addEventListener('click', () => {
            const orderId = button.dataset.orderId;
            const statusSelect = document.querySelector(`#order-status-${orderId}`);
            const status = statusSelect.value;
            console.log(status);

            fetch('update_order_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ order_id: orderId, status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Статус успешно обновлен!');
                } else {
                    alert('Ошибка: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
            });
        });
    });
});

// Админ панель - товары
// Добавляем функционал для редактирования, удаления и добавления товаров через модальные окна
document.addEventListener('DOMContentLoaded', () => {
    // Обработчик для добавления/обновления товара
    const form = document.getElementById('product-form');
    if (form) {
        document.getElementById('product-form').addEventListener('submit', event => {
            event.preventDefault();

            const productId = document.getElementById('product-id').value;
            const productName = document.getElementById('product-name').value;
            const productBrand = document.getElementById('product-brand').value;
            const productType = document.getElementById('product-type').value;
            const productGender = document.getElementById('product-gender').value;
            const productAgeGroup = document.getElementById('product-age_group').value;
            const productGears = document.getElementById('product-gears').value;
            const productPrice = document.getElementById('product-price').value;
            const productDescription = document.getElementById('product-description').value;
            const productImages = document.getElementById('product-images').files;

            const formData = new FormData();
            formData.append('action', productId ? 'update' : 'add');
            formData.append('id', productId);
            formData.append('name', productName);
            formData.append('brand', productBrand);
            formData.append('type', productType);
            formData.append('gender', productGender);
            formData.append('age_group', productAgeGroup);
            formData.append('gears', productGears);
            formData.append('price', productPrice);
            formData.append('description', productDescription);
            if (productImages) {
                for (let i = 0; i < productImages.length; i++) {
                    formData.append('images[]', productImages[i]); // Убедитесь, что используется 'images[]'
                }
            }

            fetch('product_actions.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Товар сохранен успешно!');
                        if (productId) {
                            updateProductInList(productId, productName, productBrand, productType); // Обновляем товар в списке
                        } else {
                            // Проверка данных
                            console.log("Добавленный товар:", data.product);
                            if (data.product && data.product.id) {
                                addProductToDOM(data.product); // Добавляем новый товар в список
                            } else {
                                console.error('Ошибка: Отсутствуют данные о товаре или неправильный формат данных.');
                            }
                        }
                        document.getElementById('product-modal').style.display = 'none';
                    } else {
                        alert('Ошибка при сохранении товара');
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                });
        });
    }
    const formproduct = document.getElementById('promocode-form');
    if (formproduct) {
        document.getElementById('promocode-form').addEventListener('submit', event => {
            event.preventDefault();

            const promoId = document.getElementById('promo-id').value;
            const promoName = document.getElementById('promo-name').value;
            const promoPromoname = document.getElementById('promo-promoname').value;
            const promoDiscount = document.getElementById('promo-discount').value;

            const promoImage = document.getElementById('promo-picture').files[0];

            const formData = new FormData();
            formData.append('action', promoId ? 'update' : 'add');
            formData.append('id', promoId);
            formData.append('name', promoName);
            formData.append('promoname', promoPromoname);
            formData.append('discount', promoDiscount);
            
            if (promoImage) {
                formData.append('image', promoImage);
            }

            fetch('promo_actions.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Товар сохранен успешно!');
                        if (promoId) {
                            updatePromoInList(promoId, promoName); // Обновляем товар в списке
                        } else {
                            // Проверка данных
                            console.log("Добавленный товар:", data.promo);
                            if (data.promo && data.promo.id) {
                                addPromoToDOM(data.promo); // Добавляем новый товар в список
                            } else {
                                console.error('Ошибка: Отсутствуют данные о товаре или неправильный формат данных.');
                            }
                        }

                        document.getElementById('promocode-modal').style.display = 'none';
                    } else {
                        alert('Ошибка при сохранении товара');
                    }
                })
                .catch(error => {
                    alert('Ошибка при сохранении товара');
                });
        });
    }
    // Функция для обновления товара в DOM
    function updateProductInList(productId, productName, productBrand, productType) {
        const productElement = document.querySelector(`.admin-product[data-product-id='${productId}']`);
        if (productElement) {
            const productInfo = productElement.querySelector('.admin-product-info');
            productInfo.querySelector('p').innerHTML = `<strong>Название товара:</strong> ${productName}`;
            // Обновите другие данные по мере необходимости
        }
    }
    // Функция для обновления товара в DOM
    function updatePromoInList(promoId, promoName) {
        const promoElement = document.querySelector(`.admin-promo[data-promo-id='${promoId}']`);
        if (promoElement) {
            const promoInfo = promoElement.querySelector('.admin-promo-info');
            promoInfo.querySelector('p').innerHTML = `<strong>Название товара:</strong> ${promoName}`;
            // Обновите другие данные по мере необходимости
        }
    }

    // Функция для добавления нового товара в DOM
    function addProductToDOM(product) {
        const productsSection = document.querySelector('.admin-products-section');
        
        // Создаем HTML для нового товара
        const productHTML = `
            <div class="admin-product" data-product-id="${product.id}">
                <div class="admin-product-info">
                    <p><strong>Название товара:</strong> ${product.name}</p>
                    <div class="admin-product-actions">
                        <button class="admin-edit-btn" data-product-id="${product.id}">Изменить</button>
                        <button class="admin-delete-btn" data-product-id="${product.id}">Удалить</button>
                    </div>
                </div>
            </div>`;
    
        productsSection.appendChild(
            document.createRange().createContextualFragment(productHTML)
        );
    }
    function addPromoToDOM(promo) {
        const promoSection = document.querySelector('.admin-promocodes-section');
        
        // Создаем HTML для нового товара
        const promoHTML = `
            <div class="admin-promo" data-promo-id="${promo.id}">
                <div class="admin-promo-info">
                    <p><strong>Название товара:</strong> ${promo.name}</p>
                    <div class="admin-promo-actions">
                        <button class="admin-editpromo-btn" data-promo-id="${promo.id}">Изменить</button>
                        <button class="admin-deletepromo-btn" data-promo-id="${promo.id}">Удалить</button>
                    </div>
                </div>
            </div>`;
    
        promoSection.appendChild(
            document.createRange().createContextualFragment(promoHTML)
        );
    }

    // Функция для удаления товара из DOM
    function removeProductFromDOM(productId) {
        const productElement = document.querySelector(`.admin-product[data-product-id='${productId}']`);
        if (productElement) {
            productElement.remove();
        }
    }
    function removePromoFromDOM(promoId) {
        const promoElement = document.querySelector(`.admin-promo[data-promo-id='${promoId}']`);
        if (promoElement) {
            promoElement.remove();
        }
    }
    // Функция для отображения изображений товара в модальном окне
    function displayProductImages(productId) {
        fetch(`product_actions.php?action=get_images&id=${productId}`)
            .then(response => response.json())
            .then(data => {
                const previewContainer = document.getElementById('uploaded-images');
                previewContainer.innerHTML = ''; // Очищаем контейнер

                if (data.success && data.images) {
                    data.images.forEach((image, index) => {
                        const img = document.createElement('img');
                        img.src = 'data:image/jpeg;base64,' + image.image_url;  // Предполагается, что изображения хранятся в БД как BLOB
                        img.classList.add('preview-image');
                        img.dataset.isMain = index === 0 ? 1 : 0; // Устанавливаем главную картинку
                        previewContainer.appendChild(img);
                    });
                }
            })
            .catch(error => {
                console.error('Ошибка при загрузке изображений:', error);
            });
    }
    // Функция для отображения изображений товара в модальном окне
    function displayPromoImages(promoId) {
        fetch(`promo_actions.php?action=get_images&id=${promoId}`)
            .then(response => response.json())
            .then(data => {
                const previewContainer = document.getElementById('uploaded-promo-picture');
                previewContainer.innerHTML = ''; // Очищаем контейнер

                if (data.success && data.image) {
                    const img = document.createElement('img');
                    img.src = 'data:image/jpeg;base64,' + data.image;  // Изображение в формате Base64
                    img.classList.add('preview-image');
                    previewContainer.appendChild(img);
                }
            })
            .catch(error => {
                console.error('Ошибка при загрузке изображений:', error);
            });
    }
    // Открытие модального окна для добавления товара
    document.addEventListener('click', event => {
        // Обработчик нажатия на кнопку "Добавить товар"
        if (event.target.classList.contains('admin-add-product-btn')) {
            // Очищаем форму и открываем модальное окно для добавления товара
            document.getElementById('product-form').reset();
            document.getElementById('product-id').value = ''; // Убираем id товара
            document.getElementById('modal-title').textContent = 'Добавить товар';
            document.getElementById('product-modal').style.display = 'flex';
        }

        // Обработчик нажатия на кнопку "Изменить товар"
        if (event.target.classList.contains('admin-edit-btn')) {
            const productId = event.target.getAttribute('data-product-id');

            const modal = document.getElementById('product-modal');
            if (!modal) {
                console.error('Модальное окно отсутствует в DOM.');
                return;
            }

            // Сбрасываем содержимое формы
            document.getElementById('product-form').reset();

            fetch(`product_actions.php?action=get&id=${productId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const product = data.product;
                        document.getElementById('product-id').value = product.id;
                        document.getElementById('product-name').value = product.name;
                        document.getElementById('product-brand').value = product.brand;
                        document.getElementById('product-type').value = product.type;
                        document.getElementById('product-gender').value = product.gender;
                        document.getElementById('product-age_group').value = product.age_group;
                        document.getElementById('product-gears').value = product.gears;
                        document.getElementById('product-price').value = product.price;
                        document.getElementById('product-description').value = product.description;
                        document.getElementById('modal-title').textContent = 'Изменить товар';

                        // Загружаем изображения
                        displayProductImages(product.id);

                        document.getElementById('product-modal').style.display = 'flex';
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                });
        }

        // Удаление товара
        if (event.target.classList.contains('admin-delete-btn')) {
            const productId = event.target.getAttribute('data-product-id');

            if (confirm('Вы уверены, что хотите удалить этот товар?')) {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('id', productId);

                fetch('product_actions.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Товар удален успешно!');
                            removeProductFromDOM(productId); // Удаляем товар из списка
                        } else {
                            alert('Ошибка при удалении товара');
                        }
                    })
                    .catch(error => {
                        console.error('Ошибка:', error);
                        alert('Нельзя удалить товар, его купил пользователь!');
                    });
            }
        }
    });
    // Открытие модального окна для добавления промокода
    document.addEventListener('click', event => {
        // Обработчик нажатия на кнопку "Добавить товар"
        if (event.target.classList.contains('admin-add-promocode-btn')) {
            // Очищаем форму и открываем модальное окно для добавления товара
            document.getElementById('promocode-form').reset();
            document.getElementById('promo-id').value = ''; // Убираем id товара
            document.getElementById('promocode-modal-title').textContent = 'Добавить товар';
            document.getElementById('promocode-modal').style.display = 'flex';
        }

        // Обработчик нажатия на кнопку "Изменить товар"
        if (event.target.classList.contains('admin-editpromo-btn')) {
            const promoId = event.target.getAttribute('data-promo-id');

            const modal = document.getElementById('promocode-modal');
            if (!modal) {
                console.error('Модальное окно отсутствует в DOM.');
                return;
            }

            // Сбрасываем содержимое формы
            document.getElementById('promocode-form').reset();

            fetch(`promo_actions.php?action=get&id=${promoId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const promo = data.promo;
                        document.getElementById('promo-id').value = promo.id;
                        document.getElementById('promo-name').value = promo.name;
                        document.getElementById('promo-promoname').value = promo.promoname;
                        document.getElementById('promo-discount').value = promo.discount;
                        
                        document.getElementById('promocode-modal-title').textContent = 'Изменить товар';

                        // Загружаем изображения
                        displayPromoImages(promo.id);

                        document.getElementById('promocode-modal').style.display = 'flex';
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                });
        }

        // Удаление товара
        if (event.target.classList.contains('admin-deletepromo-btn')) {
            const promoId = event.target.getAttribute('data-promo-id');

            if (confirm('Вы уверены, что хотите удалить этот товар?')) {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('id', promoId);

                fetch('promo_actions.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Товар удален успешно!');
                            removePromoFromDOM(promoId); // Удаляем товар из списка
                        } else {
                            alert('Ошибка при удалении товара');
                        }
                    })
                    .catch(error => {
                        console.error('Ошибка:', error);
                        alert('Нельзя удалить товар, его купил пользователь!');
                    });
            }
        }
    });

    // Закрытие модального окна
    close =  document.querySelector('.close');
    if (close) {
        document.querySelector('.close').addEventListener('click', () => {
            document.getElementById('product-modal').style.display = 'none';
            // Очистка контейнера с превью изображений
            const previewContainer1 = document.getElementById('uploaded-images');
            previewContainer1.innerHTML = ''; // Очищаем все содержимое контейнера
        });
    }
    closePromo =  document.querySelector('.close-promo');
    if (closePromo) {
        // Закрытие модального окна
        document.querySelector('.close-promo').addEventListener('click', () => {
            document.getElementById('promocode-modal').style.display = 'none';
            // Очистка контейнера с превью изображений
            const previewContainer = document.getElementById('uploaded-promo-picture');
            previewContainer.innerHTML = ''; // Очищаем все содержимое контейнера
        });
    }
    promoPicture =  document.querySelector('.promo-picture');
    if (promoPicture) {
        document.getElementById('promo-picture').addEventListener('change', function () {
            const files = this.files;
            const previewContainer = document.getElementById('uploaded-promo-picture');
            previewContainer.innerHTML = ''; // Очищаем контейнер
        
            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('preview-image');
                    img.dataset.isMain = index === 0 ? 1 : 0; // Устанавливаем главную картинку
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    }
});

//

// Обработчик нажатия на кнопку "Удалить" пользователя
document.querySelectorAll('.admin-deleteuser-btn').forEach(button => {
    button.addEventListener('click', function() {
        const userId = this.getAttribute('data-user-id');

        // Отправка запроса для удаления пользователя
        fetch('delete_user.php', {
            method: 'POST',
            body: new URLSearchParams({ id: userId }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Удаляем элемент пользователя из DOM
                const userElement = document.querySelector(`.admin-user[data-user-id="${userId}"]`);
                if (userElement) {
                    userElement.remove();
                }
            } else {
                alert('Ошибка при удалении пользователя.');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
        });
    });
});

document.getElementById('review-form')?.addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('add_review.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const reviewContainer = document.getElementById('reviews-container');
            const newReview = document.createElement('div');
            newReview.classList.add('item-single-review');
            newReview.innerHTML = `
                <h3>${data.review.username}</h3>
                <p>${data.review.date}</p>
                <p>${data.review.text}</p>
            `;
            reviewContainer.prepend(newReview);
            document.getElementById('review-form').reset();
        } else {
            alert('Ошибка: ' + data.message);
        }
    })
    .catch(error => console.error('Ошибка:', error));
});

document.addEventListener("DOMContentLoaded", function () {
    // Функция для обновления каталога с учетом выбранных фильтров
    function updateCatalog() {
        let formData = new FormData(document.getElementById('filters-form'));
        formData.append("search", document.querySelector(".catalog-search-inp input").value); // Добавляем поисковый запрос
        
        fetch('search.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('catalog-items').innerHTML = data;
        });
    }

    // Обработчики событий для фильтров и кнопки "Подобрать"
    const applyFiltersButton = document.getElementById('apply-filters');
    if (applyFiltersButton) {
        applyFiltersButton.addEventListener('click', updateCatalog);
    }
    const resetFiltersButton = document.getElementById('reset-filters');
    if (resetFiltersButton) {
        document.getElementById('reset-filters').addEventListener('click', function () {
            document.getElementById('filters-form').reset();
            updateCatalog();
        });
    }

    const searchButton = document.querySelector(".catalog-search-inp-btn");
    if (searchButton) {
        // Поиск
        document.querySelector(".catalog-search-inp-btn").addEventListener("click", updateCatalog); // Триггерим обновление при нажатии на кнопку
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Проверяем наличие элемента '.item-buy-btn', чтобы избежать ошибок на других страницах
    const buyButton = document.querySelector('.item-buy-btn');
    if (buyButton) {
        buyButton.addEventListener('click', function(event) {
            const productId = this.getAttribute('data-product-id');
            const quantity = 1;  // Количество товара при добавлении по умолчанию 1

            // Отправка данных на сервер через AJAX с использованием JSON
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ productId, quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Товар с ID ${productId} добавлен в корзину!`);
                    // Обновите интерфейс, например, количество товаров в корзине
                    updateCartCount(data.cart_count);
                } else {
                    alert('Ошибка при добавлении в корзину!');
                }
            })
            .catch(error => console.error('Ошибка при отправке запроса:', error));
        });
    }
});
