<?php
	$host = 'localhost';
	$login = 'root';
	$password = '';
	$bdName = 'scicker';
$link = mysqli_connect($host, $login, $password, $bdName);


if (!empty($_REQUEST['object'])) {
	$object = $_REQUEST['object'];
	preg_match_all('#id="(\d*?)"#su', $object, $match);

	$id = $match[1][0];
	$query = "SELECT * FROM `scickers` WHERE `id` ='$id'";
	$result = mysqli_query($link, $query);
	for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
	if (empty($data)) {
		$query = "INSERT INTO `scickers`(`id_sticker`, `object`) VALUES ('$id', '$object')";
	} else {
		$query = "";$query = "UPDATE `scickers` SET `object`= '$object' WHERE `id_sticker` = '$id'";
	}

}

$result = mysqli_query($link, $query);