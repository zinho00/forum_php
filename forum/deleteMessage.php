<?php
session_start();
require_once 'comm.php'; // 引入配置文件
require_once 'function.php'; // 引入函数文件

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION["CURRENT_USER"])) {
        $curUser = $_SESSION["CURRENT_USER"];
        $userId = $curUser["id"];
        
        $messageId = $_POST['messageId'];

        // 调用函数删除消息
        deleteMessage($messageId);

        // 重定向回首页
        header("Location: homepage.php");
        exit;
    } else {
        // 用户未登录，重定向到登录页面
        header("Location: login.php");
        exit;
    }
}
?>
