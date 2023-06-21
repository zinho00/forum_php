<?php
session_start();
require_once 'comm.php'; // 引入配置文件
require_once 'function.php'; // 引入函数文件

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["messageId"]) && isset($_POST["userId"]) && isset($_POST["content"])) {
        $messageId = $_POST["messageId"];
        $userId = $_POST["userId"];
        $content = $_POST["content"];

        // 将回复内容插入到 reply 表中
        $result = insertReply($userId, $messageId, $content);

        if ($result) {
            // 回复成功，返回回复页面
            header("Location: reply.php?messageId=$messageId");
            exit;
        } else {
            // 回复失败，跳转到错误页面
            $error_msg = "回复失败";
            header("Location: error.php?msg=" . urlencode($error_msg));
            exit;
        }
    } else {
        // 缺少参数，跳转到错误页面
        $error_msg = "缺少参数";
        header("Location: error.php?msg=" . urlencode($error_msg));
        exit;
    }
} else {
    // 非法请求，跳转到错误页面
    $error_msg = "非法请求";
    header("Location: error.php?msg=" . urlencode($error_msg));
    exit;
}
?>
