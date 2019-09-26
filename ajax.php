<?php
	$host = 'localhost';
	$login = 'root';
	$password = '';
	$bdName = 'scicker';
$link = mysqli_connect($host, $login, $password, $bdName);

if (!empty($_REQUEST['object'])) {
	$object = $_REQUEST['object'];
	$changes = $_REQUEST['changes'];
	preg_match_all('#id="(\d*?)"#su', $object, $match);
	$id = $match[1][0];

	$query = "SELECT * FROM `scickers` WHERE `id_sticker` ='$id'";
	$result = mysqli_query($link, $query);
	for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

	if (empty($data)) {
		$query = "INSERT INTO `scickers`(`id_sticker`, `object`, `changes`) VALUES ('$id', '$object', 'changes')";
	} else {
		$query = "UPDATE `scickers` SET `object`= '$object', `changes` = '$changes' WHERE `id_sticker` = '$id'";
	}

} else {
	$id = $_REQUEST['deleteObject'];
	$query = "DELETE FROM `scickers` WHERE `id_sticker` = '$id'";
}

$result = mysqli_query($link, $query);