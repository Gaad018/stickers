<?php
require_once('connectbd/connectbd.php');

if (!empty($_REQUEST['object'])) {
	$object = str_replace('</textarea>', '', $_REQUEST['object']);
	$changes = $_REQUEST['changes'];
	preg_match_all('#id="(\d*?)"#su', $object, $match);
	$id = $match[1][0];

	$id_login = $_REQUEST['id'];
	$text = $_REQUEST['text'];

	$query = "SELECT * FROM `scickers` WHERE `id_sticker` ='$id'";
	$result = mysqli_query($link, $query);
	for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

	if (empty($data)) {
		$query = "INSERT INTO `scickers`(`user_id`, `id_sticker`, `object`, `text`, `changes`) VALUES ('$id_login', '$id', '$object', '$text', '$changes')";
	} else {
		$query = "UPDATE `scickers` SET `object`= '$object', `changes` = '$changes', `text` = '$text' WHERE `id_sticker` = '$id' AND `user_id` = '$id_login'";
	}


} else {
	$id = $_REQUEST['deleteObject'];
	$query = "DELETE FROM `scickers` WHERE `id_sticker` = '$id'";
}

$result = mysqli_query($link, $query);