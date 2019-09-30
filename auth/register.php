<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрция</title>
</head>
<body>
    <p>Логин вида: Gaad02312452</p>
    <form action="" method="POST" id="form">
        <p>Какой логин изволите? <input type="text" name="login" id="login"></p>
        <p>Пароль: <input type="пароль" id="password1"></p>
        <p>Повторите пароль: <input type="пароль" id="password2"></p>
        <input type="submit" name="nameButtonSubmit" id="button">
    </form>
    <div id="result"></div>
    <script>
        let form = document.getElementById('form');
        let login = document.getElementById('login');
        let password1 = document.getElementById('password1');
        let password2 = document.getElementById('password2');
        let divResult = document.getElementById('result');
        let button = document.getElementById('button');
        
        password2.addEventListener('change', function(event) {
            if (password1.value !== password2.value) {
                divResult.innerHTML += '<br>Пароли не совпадают';
             }
            event.preventDefault();
        })

        login.addEventListener('change', function(event) {

            let searchParams = new URLSearchParams('login=' + login.value);

            let promise = fetch('ajax_login.php', {
                method: 'POST',
                body: searchParams
            })

            promise.then(response => {
                return response.text();
            }).then(text => {
                divResult.innerHTML = text;
            })

            event.preventDefault();
        })
       
        form.addEventListener('submit', function(event) {
            searchParams = new URLSearchParams('login=' + login.value + '&password=' + password1.value + '&flag=1');

                let promise = fetch('ajax_login.php', {
                    method: 'POST',
                    body: searchParams
                 })

                promise.then(response => {
                    return response.text();
                }).then(text => {
                    divResult.innerHTML = text;
                })


            event.preventDefault();
        });
    </script>
</body>
</html>