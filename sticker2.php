<?php 
	session_start();
	require_once('connectbd/connectbd.php');
	$_SESSION['auth'] = 0;
	$id_max = -1;

	if (!empty($_POST) and $_SESSION['auth'] == 0) {
		$login = $_POST['login'];
		$password = $_POST['password'];

		$query = "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'";
		$result = mysqli_query($link, $query);
		for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
		$login = $data[0]['id'];

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
				$textWindow .= $value['object'] . $value['text'] . '</textarea>';
			}
		}
	}

	if ($_SESSION['auth'] == 0) {
		echo '<a href="index.php">Залогиньтесь! </a>';
	} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .sticker {
            box-sizing: border-box;
            position: absolute;
            padding: 10px;
            font: italic 15px Arial;
        }
    </style>
</head>
<body><?= $textWindow ?></body>
<script>
				//Подгрузка контента из базы для пользователя 
				let inner = '<?= $textWindow ?>';
				document.body.innerHTML = inner;
				
				window.idLogin = '<?= $login ?>';
				let zIndex = 0;
				let zIndexDrag = 0;
				let id = '<?= $id_max ?>';

				//Создание textarea
				document.addEventListener('dblclick', function(event) {
					let textarea = document.createElement('textarea');
					//Атрибуты
					textarea.className = 'sticker';
					textarea.id = ++id;
					textarea.draggable = true;
					textarea.value = 'Текст...';

					//css свойства
					textarea.style.zIndex = ++zIndex;
					textarea.style.left = event.pageX + 'px';
					textarea.style.top = event.pageY + 'px';
					textarea.style.height = 150 + 'px';
					textarea.style.width = 200 + 'px';

					document.body.appendChild(textarea);

					let oldWidth = 200;
					let oldHeight = 150;
					let oldText = '';
					zIndexDrag = zIndex;

					save('update', textarea.outerHTML, 'creat', 'Текст...');

					//Изменение размера оббъекта
					textarea.addEventListener('mouseup', function(event)  {
						if (oldWidth !== this.style.width || oldHeight !== this.style.height) {
							if (oldWidth != parseInt(this.style.width)) {
								save('update', this.outerHTML, 'updateWidth');
							}
							if (oldHeight != parseInt(this.style.height)) {
								save('update', this.outerHTML, 'updateHeight');
							}
							oldWidth = this.style.width;
							oldHeight = this.style.height;
						}
							event.preventDefault();
					});

					//Изменение текста внутри объекта
					textarea.addEventListener('change', function(event) {
						console.log(this.value);
						console.log(oldText);
						if (oldText !== this.value) {
							save('update', this.outerHTML, 'updateText', this.value);
						}

						if (this.value == '') {
							save('update', this.outerHTML, 'updateText', ' ');
						}
						oldText = this.value;
						event.preventDefault();
					});

					//Изменение индекса объекта при фокусе
					let oldIndex = textarea.style.zIndex;
					textarea.addEventListener('click', function(event) {
						this.style.zIndex = ++zIndexDrag;
						event.preventDefault();
					})	
					textarea.addEventListener('blur', function(event) {
						this.style.zIndex = oldIndex;
					})


					//Перемещение объекта 
					let textareaMany = document.getElementsByTagName('textarea');
					for (var i = 0; i < textareaMany.length; i++ ) {
						textareaMany[i].addEventListener('dragstart', function(event) {
							window.correctionX = parseInt(event.pageX) - parseInt(this.style.left);
							window.correctionY = parseInt(event.pageY) - parseInt(this.style.top);
							++zIndexDrag;
						});

						textareaMany[i].addEventListener('dragend', function(event) {
							this.style.left = event.pageX -  window.correctionX + 'px';
							this.style.top = event.pageY -  window.correctionY + 'px';
							this.style.zIndex = zIndexDrag;
							save('update', this.outerHTML, 'Перемещене');
						});

					}
					event.preventDefault();
				});
				
				//Удаление textarea
				document.addEventListener('mousedown', function(event) {
						if (event.which == 2) {
							let textarea = document.getElementById(event.target.id);
							textarea.outerHTML = '';
							save('deleteObject', textarea.id);
							event.preventDefault();
						}
				});

	function save(wathChange, change, changes, valueText) {
		let conditious = '';
		switch (wathChange) {
			case 'update':
				if (valueText = '') {
					valueText = ' ';
				}
				conditious = 'object=' + change + '&changes=' + changes + '&id=' + window.idLogin + '&text=' + valueText;
			break;

			case 'deleteObject':
			console.log(change);
				conditious = 'deleteObject=' + change;
			break;
		}

		searchParams = new URLSearchParams( conditious );
		let promise = fetch('ajax.php', {
			method: 'POST',
			body: searchParams
		})
	}
</script>
</html>
	<?php } ?>