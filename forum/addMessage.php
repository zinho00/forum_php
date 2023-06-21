<?php
session_start();
require_once 'comm.php'; // 引入配置文件
require_once 'function.php'; // 引入函数文件

forumHeader();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['CURRENT_USER']['uId'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    if (empty($title) || empty($content)) {
        echo "标题和内容不能为空";
    } else {
        $result = addMessage($userId, $title, $content);

        if ($result) {
            header("Location: homepage.php");
            exit;
        } else {
            $error_msg = "发布失败";
            header("Location: error.php?msg=" . urlencode($error_msg));
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>发布新消息</title>
    <link rel="stylesheet" href="./style/editMessage.css">
</head>

<body>
    <h2>发布新消息</h2>
    <form action="addMessage.php" method="POST">
        <label>标题：</label><br>
        <input type="text" name="title"><br><br>
        <label>内容：</label><br>
        <textarea name="content"></textarea><br><br>
        <input type="submit" value="提交">
    </form>
</body>

</html>