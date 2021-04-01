<?php
    header("Content-Type: application/json");
    require __DIR__ . "/../../configuration/database.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['secPassword']) && !empty($_POST['email'])) {
            foreach ($_POST as $key => $value)
                $_POST[$key] = $database -> real_escape_string(htmlspecialchars($value));
            if ($_POST['password'] == $_POST['secPassword']) {
                if ($database -> query("SELECT `id` FROM `users` WHERE `login` = '{$_POST["login"]}';") -> num_rows == 0) {
                    if ($database -> query("SELECT `id` FROM `users` WHERE `email` = '{$_POST["email"]}';") -> num_rows == 0) {
                        $payload = [
                            'login' => $_POST['login'],
                            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                            'email' => $_POST['email']
                        ];
                        $database -> query("INSERT INTO `users` (`login`, `password`, `email`) VALUES ('{$payload["login"]}', '{$payload["password"]}', '{$payload["email"]}');");
                        print(json_encode([
                            'status' => 'OK'
                        ]));
                    } else {
                        http_response_code(403);
                        print(json_encode([
                            'status' => 'EMAIL_IS_NOT_UNIQUE'
                        ]));
                    }
                } else {
                    http_response_code(403);
                    print(json_encode([
                        'status' => 'LOGIN_IS_NOT_UNIQUE'
                    ]));
                }
            } else {
                http_response_code(403);
                print(json_encode([
                    'status' => 'PASSWORD_IS_NOT_EQUAL'
                ]));
            }
        } else {
            http_response_code(403);
            print(json_encode([
                'status' => 'SOME_DATA_IS_EMPTY'
            ]));
        }
    } else {
        http_response_code(403);
        print(json_encode([
            'status' => 'METHOD_IS_NOT_POST'
        ]));
    }
    $database -> close();