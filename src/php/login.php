<?php
session_start();
require_once('pageConstruct.php');
require_once 'db.php'; // Подключение к базе данных

// Класс для главной страницы
class LoginPage extends StandardPage {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function getContent() {
        $conn = $this->conn;
      
        // Проверка, если пользователь уже вошел
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['role'] === 'admin') {
                header("Location: adminPanel.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit;
        }

        // Обработка формы входа
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['username'], $_POST['password'])) {
                // Вход
                $username = $_POST['username'];
                $password = $_POST['password'];

                // Проверка учетных данных пользователя
                $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 1) {
                    $user = $result->fetch_assoc();
                    if (password_verify($password, $user['password'])) {
                        // Установка сессии
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['role'] = $user['role'];

                        // Перенаправление
                        if ($user['role'] === 'admin') {
                            header("Location: adminPanel.php");
                        } else {
                            header("Location: user_dashboard.php");
                        }
                        exit;
                    } else {
                        $error = "Неверный пароль!";
                        echo $error;
                    }
                } else {
                    $error = "Пользователь не найден!";
                    echo $error;
                }
            }

            // Обработка формы регистрации
            elseif (isset($_POST['register-username'], $_POST['register-email'], $_POST['register-password'])) {
                $username = $_POST['register-username'];
                $email = $_POST['register-email'];
                $password = password_hash($_POST['register-password'], PASSWORD_BCRYPT);

                // Проверка, что пользователя нет в базе
                $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
                $stmt->bind_param("ss", $username, $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 0) {
                    // Вставка нового пользователя
                    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
                    $stmt->bind_param("sss", $username, $email, $password);

                    if ($stmt->execute()) {
                        $_SESSION['user_id'] = $stmt->insert_id;
                        $_SESSION['role'] = 'user';
                        header("Location: user_dashboard.php");
                        exit;
                    } else {
                        $error = "Ошибка при регистрации! Код ошибки: " . $stmt->error;
                        echo $error;
                    }
                } else {
                    $error = "Пользователь с таким логином или email уже существует!";
                    echo $error;
                }
            }
        }

        return <<<HTML
            <div class="login-form">
            <div class="wrap">
                <div class="form-container">
                    <!-- Логин -->
                    <form id="login-form" class="user-form active-form" method="POST" action="login.php">
                        <h2>Вход</h2>
                        <label for="login-username">Логин</label>
                        <input type="text" id="login-username" name="username" placeholder="Введите логин" required>
                
                        <label for="login-password">Пароль</label>
                        <input type="password" id="login-password" name="password" placeholder="Введите пароль" required>
                
                        <button type="submit" class="form-submit-btn">Войти</button>
                        <p>Нет аккаунта? <a href="#" id="show-register-form">Регистрация</a></p>
                    </form>
                
                    <!-- Регистрация -->
                    <form id="register-form" class="user-form" method="POST" action="login.php">
                        <h2>Регистрация</h2>
                        <label for="register-username">Логин</label>
                        <input type="text" id="register-username" name="register-username" placeholder="Введите логин" required>
                
                        <label for="register-email">Email</label>
                        <input type="email" id="register-email" name="register-email" placeholder="Введите email" required>
                
                        <label for="register-password">Пароль</label>
                        <input type="password" id="register-password" name="register-password" placeholder="Введите пароль" required>
                
                        <button type="submit" class="form-submit-btn">Зарегистрироваться</button>
                        <p>Уже есть аккаунт? <a href="#" id="show-login-form">Вход</a></p>
                    </form>
                </div>
            </div>
        </div>
HTML;
    }
}

// Пример использования
$loginPage = new LoginPage($conn);
$loginPage->setTitle("Вход - ВелоТрейд");
$loginPage->write();
