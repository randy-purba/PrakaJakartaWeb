<?php

    // echo $_SERVER['REQUEST_URI'];
    $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // echo "requestPath :".$requestPath;

    switch ($requestPath) {
        case '/':
            include 'dashboard.php';
            break;
        case '/login.php':
            include 'login.php';
            break;
        case '/report.php':
            include 'report.php';
            break;
        case '/map.php':
            include 'map.php';
            break;
        case '/koordinator.php':
            include 'koordinator.php';
            break;
        case '/surveyor.php':
            include 'surveyor.php';
            break;
        case '/mapnew.php':
            include 'mapnew.php';
            break;
        case '/reportnew.php':
            include 'reportnew.php';
            break;
        case '/surveyornew.php':
            include 'surveyornew.php';
            break;
        case '/dashboard.php':
            include 'dashboard.php';
            break;
        case '/export.php':
            include 'export.php';
            break;
        case '/action.php':
            include 'action.php';
            break;
        default:
            include '404.php';
            break;
    }
?>