function register() {
    var _form = document.getElementsByTagName('form')[0],
        _login = document.getElementById('login').value,
        _password = document.getElementById('password').value,
        _secPassword = document.getElementById('secPassword').value,
        _email = document.getElementById('email').value;
    if (_form.checkValidity()) {
        if (_password == _secPassword) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/ega22a/api/register', false);
            var _form = new FormData();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    switch (xhr.status) {
                        case 200:
                            alert('Вы зарегестрированы!');
                        break;
                        case 403:
                            var _status = JSON.parse(xhr.response);
                            switch (_status) {
                                case "METHOD_IS_NOT_POST":
                                    alert("Метод не POST.");
                                break;
                                case "SOME_DATA_IS_EMPTY":
                                    alert("Не все данные были переданы!");
                                break;
                                case "PASSWORD_IS_NOT_EQUAL":
                                    alert("Пароли не совпадают!");
                                break;
                                case "LOGIN_IS_NOT_UNIQUE":
                                    alert("Логин уже используется!");
                                break;
                                case "EMAIL_IS_NOT_UNIQUE":
                                    alert("Адрес электронной почты уже используется!");
                                break;
                            }
                        break;
                    }
                }
            }
            _form.append('login', _login);
            _form.append('password', _password);
            _form.append('secPassword', _secPassword);
            _form.append('email', _email);
            xhr.send(_form);
        } else
            alert("Пароли не совпадают!");
    } else
        alert("Заполните полностью форму!");
}