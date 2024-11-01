<?php

switch ($_SERVER['REQUEST_URI']) {
    case '/report.php':
        include 'report.php';
        break;
    case '/map.php':
        include 'map.php';
        break;
    case '/':
        include 'surveyornew.php';
        break;
    default:
        include '404.php';
        break;
}
?>