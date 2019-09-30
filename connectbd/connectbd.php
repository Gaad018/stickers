<?php	
$condition = 1;
if ($condition == 0) {
	//Устанавливаем доступы к базе данных:
	$host = 'localhost'; //имя хоста, на локальном компьютере это localhost
	$user = 'u0769680_default'; //имя пользователя, по умолчанию это root
	$password = 'Y0tDfrM_'; //пароль, по умолчанию пустой
	$db_name = 'u0769680_default'; //имя базы данных



	//Соединяемся с базой данных используя наши доступы:
	$link = mysqli_connect($host, $user, $password, $db_name);

	//Устанавливаем кодировку (не обязательно, но поможет избежать проблем):
	mysqli_query($link, "SET NAMES 'utf8'");

} else {
	$host = 'localhost';
	$login = 'root';
	$password = '';
	$bdName = 'scicker';
	$link = mysqli_connect($host, $login, $password, $bdName);
}