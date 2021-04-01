<?php
    $database = new mysqli('localhost', 'student', '12345', 'ega22a');
    if ($database -> errno) {
        http_response_code(500);
        exit();
    }