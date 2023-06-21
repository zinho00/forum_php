<?php
session_start();
require_once 'comm.php'; // 引入配置文件
require_once 'function.php'; // 引入函数文件

if (isset($_SESSION["CURRENT_USER"])) {
    $curUser = $_SESSION["CURRENT_USER"];

    if (isset($_GET['replyId'])) {
        $replyId = $_GET['replyId'];

        // 删除回复
        $rowsAffected = deleteReply($replyId, $curUser['uId']);

        if ($rowsAffected > 0) {
            // 删除成功，重定向到 reply.php 页面
            header("Location: reply.php?messageId=" . $_GET['messageId']);
            exit;
        } else {
            // 回复不存在或不属于当前用户，重定向到 reply.php 页面
            header("Location: reply.php?messageId=" . $_GET['messageId']);
            exit;
        }
    } else {
        // 没有提供回复ID，重定向到 index.php 页面
        header("Location: index.php");
        exit;
    }
} else {
    // 用户未登录，重定向到登录页面
    header("Location: login.php");
    exit;
}
?>
