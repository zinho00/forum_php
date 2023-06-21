<?php
session_start();
require_once 'comm.php'; // 引入配置文件
require_once 'function.php'; // 引入函数文件

forumHeader();

if (isset($_SESSION["CURRENT_USER"])) {
    $curUser = $_SESSION["CURRENT_USER"];

    if (isset($_GET['messageId'])) {
        $messageId = $_GET['messageId'];

        // 根据消息ID获取消息内容
        $message = getMessageById($messageId);

        if ($message) {
            $title = $message['title'];
            $content = $message['content'];
        } else {
            // 消息不存在或不属于当前用户，跳转到 homepage.php
            $error_msg = "消息不存在";
            header("Location: error.php?msg=" . urlencode($error_msg));
            exit;
        }
    } else {
        // 没有提供消息ID，跳转到 homepage.php
        $error_msg = "没有id";
        header("Location: error.php?msg=" . urlencode($error_msg));
        exit;
    }
} else {
    // 用户未登录，跳转到登录页面
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>修改信息</title>
    <link rel="stylesheet" href="./style/editMessage.css">

</head>

<body>
    <h2>修改信息</h2>
    <form action="doeditMessage.php" method="POST">
        <input type="hidden" name="messageId" value="<?php echo $messageId; ?>">
        <label>标题：</label><br>
        <input type="text" name="title" value="<?php echo $title; ?>"><br><br>
        <label>内容：</label><br>
        <textarea name="content"><?php echo $content; ?></textarea><br><br>
        <input type="submit" value="提交">
    </form>
    <?php echo forumtail() ?>
</body>

</html>