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
const rangeMin = document.getElementById('rangeMin');
const rangeMax = document.getElementById('rangeMax');
const priceMin = document.getElementById('priceMin');
const priceMax = document.getElementById('priceMax');

if (rangeMin && rangeMax && priceMin && priceMax) {
    function syncRangeWithInput(range, input) {
        range.value = input.value;
    }

    rangeMin.addEventListener('input', () => {
        priceMin.value = rangeMin.value;
        if (+rangeMin.value > +rangeMax.value) {
            rangeMax.value = rangeMin.value;
            priceMax.value = rangeMax.value;
        }
    });

    rangeMax.addEventListener('input', () => {
        priceMax.value = rangeMax.value;
        if (+rangeMax.value < +rangeMin.value) {
            rangeMin.value = rangeMax.value;
            priceMin.value = rangeMin.value;
        }
    });

    priceMin.addEventListener('input', () => syncRangeWithInput(rangeMin, priceMin));
    priceMax.addEventListener('input', () => syncRangeWithInput(rangeMax, priceMax));
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

// cart-func

// Function to update the total price
function updateTotal() {
    const cartItems = document.querySelectorAll('.cart-item-row');
    let total = 0;
    cartItems.forEach(item => {
        const price = item.getAttribute('data-price');
        const quantityElem = item.querySelector('.quantity');
        if (price && quantityElem) {
            const quantity = parseInt(quantityElem.textContent, 10);
            total += price * quantity;
        }
    });
    const totalPriceElem = document.getElementById('total-price');
    if (totalPriceElem) {
        totalPriceElem.textContent = total;
    }
}

// Event listeners for quantity control buttons and remove buttons
document.querySelectorAll('.cart-item-row').forEach(item => {
    const increaseBtn = item.querySelector('.increase');
    const decreaseBtn = item.querySelector('.decrease');
    const quantityElem = item.querySelector('.quantity');
    const itemPriceElem = item.querySelector('.item-price');
    const removeBtn = item.querySelector('.remove-item');
    const pricePerItem = parseInt(item.getAttribute('data-price'), 10);

    if (increaseBtn && quantityElem && itemPriceElem) {
        increaseBtn.addEventListener('click', () => {
            let quantity = parseInt(quantityElem.textContent, 10);
            quantity += 1;
            quantityElem.textContent = quantity;
            itemPriceElem.textContent = `${quantity * pricePerItem} ₽`;
            updateTotal();
        });
    }

    if (decreaseBtn && quantityElem && itemPriceElem) {
        decreaseBtn.addEventListener('click', () => {
            let quantity = parseInt(quantityElem.textContent, 10);
            if (quantity > 1) {
                quantity -= 1;
                quantityElem.textContent = quantity;
                itemPriceElem.textContent = `${quantity * pricePerItem} ₽`;
                updateTotal();
            }
        });
    }

    if (removeBtn) {
        removeBtn.addEventListener('click', () => {
            item.remove();
            updateTotal();
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const promoInput = document.getElementById("promo-code");
    const applyPromoBtn = document.getElementById("apply-promo");
    const totalPriceEl = document.getElementById("total-price");
    const discountEl = document.getElementById("discount-amount");
    const discountedTotalEl = document.getElementById("discounted-total");

    const promoCodes = {
        "SALE10": 10,
        "SALE20": 20,
    };

    function updateTotalWithDiscount() {
        const originalTotal = parseFloat(totalPriceEl?.textContent || 0);
        const discount = parseFloat(discountEl?.textContent || 0);
        const discountedTotal = originalTotal * (1 - discount / 100);
        if (discountedTotalEl) {
            discountedTotalEl.textContent = discountedTotal.toFixed(2);
        }
    }

    if (applyPromoBtn && promoInput && discountEl) {
        applyPromoBtn.addEventListener("click", function () {
            const promoCode = promoInput.value.trim();
            const discount = promoCodes[promoCode] || 0;
            discountEl.textContent = discount;
            updateTotalWithDiscount();
        });
    }

    updateTotalWithDiscount(); // Initial update
});

// Initial total update
updateTotal();

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
