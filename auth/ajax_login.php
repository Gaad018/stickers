<?php 
require_once('../connectbd/connectbd.php');


if (isset($_POST['flag']) && trim($_POST['login']) <> '' && trim($_POST['password']) <> '' && preg_match('#[a-zA-Z.0-9]+?#su', $_POST['login'])) {
    $login =  trim($_POST['login']);
    $password = $_POST['password'];

    $query = "SELECT * FROM `users` WHERE `login` = '$login'";
    $result = mysqli_query($link, $query);
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

    if (empty($data)) {
        $query = "INSERT INTO `users`(`login`, `password`) VALUES ('$login', '$password')";
        $result = mysqli_query($link, $query);
    
        if ($result === true) {
            echo 'Вы успешно зарегестрировались! <br> <a href="http://teast.info/sticker/">Зайдите</a> и пользуйтесь';
        }
    } else {
        echo 'Логин занят!';
    }
}    

if (!empty($_POST) && isset($_POST)) {

        $login = $_POST['login'];
        $query = "SELECT * FROM `users` WHERE `login` = '$login'";
        $result = mysqli_query($link, $query);
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

        if (!empty($data)) {
            echo 'Логин занят!';
        }
}