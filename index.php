<?php

switch ($_SERVER['REQUEST_URI']) {
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
    case '/action.php':
        include 'action.php';
        break;
    case '/export.php':
        include 'export.php';
        break;
    default:
        include '404.php';
        break;
}
?>