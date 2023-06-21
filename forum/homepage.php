<!DOCTYPE html>
<html>
<head>
    <title>首页</title>
    <link rel="stylesheet" type="text/css" href="./style/homepage.css">
</head>
<body>
<?php
session_start();
require_once 'comm.php'; // 引入配置文件
require_once 'function.php'; // 引入函数文件

if (isset($_SESSION["CURRENT_USER"])) {
    $curUser = $_SESSION["CURRENT_USER"];
    $username = $curUser["uName"];
    $userId = $curUser["uId"]; // 获取当前用户信息
    $head = $curUser["head"];
    $headLink = "image/head/" . $head; // 头像图片链接
    $userLink = "userdetail.php"; // 用户信息编辑页面链接

    $header = <<<HTML_HEADER
    <div style="background-color: darkgray;">;
    <a href="index.php" style="padding-left: 10%;"><img src="image/forum.gif" alt="首页"></a>
    <a href="$userLink"><img src="$headLink" alt="头像"></a>
    <a href="$userLink">$username</a>&nbsp;|&nbsp;
    <a href="doLogout.php">登出</a>
    </div>
HTML_HEADER;

    echo $header;

    // 获取用户对应的消息列表
    $messages = getMessagesByUserId($userId);

    echo "<h2>我的消息</h2>";
    echo "<a class='new' href='addMessage.php'>发布新消息</a>";

    if (count($messages) > 0) {
        echo "<div class='messages'>";
        foreach ($messages as $message) {
            echo "<div class='message'>";
            echo "<h3>" . $message['title'] . "</h3>";
            echo "<p>" . $message['content'] . "</p>";
            echo "<p class='time'>" . $message['postTime'] . "</p>";

            // 只有消息发布者可以删除
            if ($message['uId'] == $userId) {
                echo "<form action='deleteMessage.php' method='POST'>";
                echo "<input type='hidden' name='messageId' value='" . $message['id'] . "'>";
                echo "<input type='submit' value='删除'>";
                echo "</form>";

                echo "<form action='editMessage.php' method='GET'>";
                echo "<input type='hidden' name='messageId' value='" . $message['id'] . "'>";
                echo "<input type='submit' value='编辑'>";
                echo "</form>";
            }

            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "暂无消息";
    }
} else {
    $header = <<<HTML_HEADER
    <a href="index.php" style="padding-left: 10%;"><img src="image/forum.gif" alt="首页"></a>
<a href="login.php">登录</a>&nbsp;|&nbsp;
<a href="reg.php">注册</a>
HTML_HEADER;

    echo $header;
}
?>
 <?php echo forumtail() ?>
</body>
</html>