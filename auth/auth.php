<?php 
	if (!empty($_POST) and $_SESSION['auth'] == 0) {
        
		$login = $_POST['login'];
		$password = $_POST['password'];

		$query = "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'";
		$result = mysqli_query($link, $query);
		for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
		$login = $data[0]['id'];

		//Если такой user есть то 
		if (!empty($data)) {
			$_SESSION['auth'] = 1;

			$user_id = $data[0]['id'];

			$query = "SELECT * FROM `scickers` WHERE `user_id` = '$user_id'";
			$result = mysqli_query($link, $query);
			for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

			foreach ($data as $key => $value) {

				if ($value['id_sticker'] > $id_max) {
					$id_max = $value['id_sticker'];
				}

				preg_match_all('#style\s?=\s?(["\'])(.*?)\1#su', $value['object'], $matches);
				$array[] = [
					'type' => 'textarea',
					'style' => $matches[2][0],
					'class' => 'sticker',
					'draggable' => true,
					'id' => $value['id_sticker'],
					'text' => $value['text']
				];
			}
			$array = json_encode($array); //Подготавливаю данные для js
		}
	}