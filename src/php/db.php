<?php
$host = 'db'; // сервер базы данных
$username = 'user';  // имя пользователя (по умолчанию root для OpenServer)
$password = 'password';      // пароль (по умолчанию пустой для OpenServer)
$dbname = 'myDB_kurs'; // имя базы данных

// Создаём соединение
$conn = new mysqli($host, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

?>
