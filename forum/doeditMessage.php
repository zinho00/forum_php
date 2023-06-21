<?php
session_start();
require_once 'comm.php'; // 引入配置文件
require_once 'function.php'; // 引入函数文件

if (isset($_SESSION["CURRENT_USER"])) {
    $curUser = $_SESSION["CURRENT_USER"];

    if (isset($_POST['messageId']) && isset($_POST['title']) && isset($_POST['content'])) {
        $messageId = $_POST['messageId'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        // 更新消息
        $rowsAffected = updateMessage($messageId, $title, $content);

        if ($rowsAffected > 0) {
            // 更新成功，重定向到 homepage.php 页面
            header("Location: homepage.php");
            exit;
        } else {
            // 更新失败
            $error_msg = "更新失败";
            header("Location: error.php?msg=" . urlencode($error_msg));
            exit;
        }
    } else {
        // 缺少必要参数，跳转到错误页面
        $error_msg = "参数错误";
        header("Location: error.php?msg=" . urlencode($error_msg));
        exit;
    }
} else {
    // 用户未登录，跳转到登录页面
    header("Location: login.php");
    exit;
}
?>
