<?php
session_start();
$_SESSION['auth'] = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Авторизация</title>
    <link rel="stylesheet" href="css/style_sticker.css">
</head>
<body>
<form action="sticker.php" id="form" method="POST">
	<p>Введите логин: <input type="text" id="login" name="login"></p>
	<p>Введите пароль:<input type="password" id="password" autocomplete="new-password" name="password"></p>
    <input type="submit" name="nameButtonSubmit">
    <a href="auth/register.php">Регистрация</a>
</form>
</body>
</html>