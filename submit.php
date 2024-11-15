<?php
$servername = "localhost"; // или ваш сервер
$username = "root"; // имя пользователя
$password = ""; // пароль
$dbname = "mydatabase"; // имя базы данных

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получение данных из формы
$fullName = $_POST['fullName'];
$passport = $_POST['passport'];
$enrollmentOrder = $_POST['enrollmentOrder'];

// Подготовка и выполнение запроса
$sql = "INSERT INTO submissions (fullName, passport, enrollmentOrder) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $fullName, $passport, $enrollmentOrder);

if ($stmt->execute()) {
    // Перенаправление на форму с сообщением об успехе
    echo "<script>
            window.onload = function() {
                window.opener.showModal('Данные успешно сохранены!');
                window.close();
            }
          </script>";
} else {
    echo "<script>
            window.onload = function() {
                window.opener.showModal('Ошибка: " . $stmt->error . "');
                window.close();
            }
          </script>";
}

// Закрытие соединения
$stmt->close();
$conn->close();
?>
