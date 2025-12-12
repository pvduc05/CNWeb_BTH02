<?php
session_start();

// Lấy controller & action từ URL
$controller = $_GET['controller'] ?? 'home';
$action     = $_GET['action']     ?? 'index';

// Tạo tên controller file & class
$controllerName = ucfirst($controller) . "Controller";
$controllerFile = __DIR__ . "/controllers/" . $controllerName . ".php";

// Kiểm tra file controller tồn tại hay không
if (!file_exists($controllerFile)) {
    die("❌ Controller '$controllerName' không tồn tại!");
}

// Require controller
require_once $controllerFile;

// Kiểm tra class có tồn tại không
if (!class_exists($controllerName)) {
    die("❌ Class '$controllerName' không tồn tại trong file $controllerFile");
}

// Tạo đối tượng controller
$controllerObj = new $controllerName();

// Kiểm tra action có tồn tại không
if (!method_exists($controllerObj, $action)) {
    die("❌ Action '$action' không tồn tại trong '$controllerName'");
}

// Gọi action
$controllerObj->$action();
