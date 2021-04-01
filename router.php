<?php
    if ($_GET['path'] != "") {
        switch ($_GET['path']) {
            // Маршруты API
            case 'api/register':
                require __DIR__ . '/execute/api/register.php';
            break;
            // Маршруты HTML
            case 'register':
                print(file_get_contents(__DIR__ . '/execute/html/register.html'));
            break;
            default:
                // http_response_code(404);
                try {
                    echo @file_get_contents(__DIR__ . "/{$_GET['path']}");
                } catch (Exception $e) {
                    http_response_code(404);
                }
            break;
        }
    } else
        require __DIR__ . '/execute/index.php';