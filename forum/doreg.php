<?php
session_start();
require_once 'comm.php'; // 引入配置文件
require_once 'function.php'; // 引入函数文件

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $head = $_POST['head'];
    $vCode = $_POST['vCode'];

    if (!isset($_SESSION["vCode"]) || $vCode !== $_SESSION["vCode"]) {
        $error_msg = "验证码错误，请重新输入";
        header("Location: error.php?msg=" . urlencode($error_msg));
        exit;
    }else{
        $result = addUser($username, $password, $gender,$head);
        if ($result) {
            // 注册成功，跳转到登录页面
            header("Location: login.php");
            exit;
        } else {
            // 注册失败，重定向到错误页面并传递错误消息
            $error_msg = "注册失败，请稍后再试";
            header("Location: error.php?msg=" . urlencode($error_msg));
            exit;
        }
    }
   
}
?>
