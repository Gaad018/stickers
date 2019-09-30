<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрция</title>
</head>
<body>
    <form action="" method="POST" id="form">
        <p>Какой логин изволите? <input type="text" name="login" value="<?= $_POST['login'] ?>"></p>
        <p>Пароль: <input type="пароль"></p>
        <input type="submit" name="nameButtonSubmit">
    </form>
    <script>
        let form = document.getElementById('form');

        form.addEventListener('submit', function(event) {
            console.log('YEs, into');
            event.preventDefault();
        });
    </script>
</body>
</html>