<?php
session_start();
require_once 'comm.php'; // 引入配置文件
require_once 'function.php'; // 引入函数文件

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $vCode = $_POST['vCode'];

    // 检查验证码是否正确
    if (!isset($_SESSION["vCode"]) || $vCode !== $_SESSION["vCode"]) {
        $error_msg = "验证码错误，请重新输入";
        header("Location: error.php?msg=" . urlencode($error_msg));
        exit;
    }

    $result = checkUserLogin($username, $password);

    if ($row = mysqli_fetch_assoc($result)) {
        // 登录成功，跳转到首页
        $_SESSION["CURRENT_USER"] = $row;
        header("Location: homepage.php");
        exit;
    } else {
        // 登录失败，重定向到错误页面并传递错误消息
        $error_msg = "登录失败，请检查用户名和密码";
        header("Location: error.php?msg=" . urlencode($error_msg));
        exit;
    }
}
?>
