<?php 
	session_start();
	require_once('connectbd/connectbd.php');
	$_SESSION['auth'] = 0;
	$id_max = 0;
	require_once('auth/auth.php');

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
	<link rel="stylesheet" type="text/css" href="css/style_sticker.css">
</head>
<body><?= $textWindow ?></body>
<script>
window.array = <?= $array ?>;
window.idLogin = <?= $login ?>; 
window.id = <?= $id_max ?>;
</script>
<script src="js/function_sticker.js"></script>				
</html>
	<?php } ?>