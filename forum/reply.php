<?php
session_start();
require_once 'comm.php'; // 引入配置文件
require_once 'function.php'; // 引入函数文件

forumHeader();
if (isset($_SESSION["CURRENT_USER"])) {
    $curUser = $_SESSION["CURRENT_USER"];
    $userId = $curUser["uId"];
} else {
    // 用户未登录，跳转到登录页面
    header("Location: login.php");
    exit;
}

if (isset($_GET['messageId'])) {
    $messageId = $_GET['messageId'];
    // 根据消息ID获取消息内容
    $message = getMessageById($messageId);

    if ($message) {
        $title = $message['title'];
        $content = $message['content'];
    } else {
        // 消息不存在，跳转到首页
        header("Location: index.php");
        exit;
    }
} else {
    // 没有提供消息ID，跳转到首页
    header("Location: index.php");
    exit;
}

// 获取该消息的所有回复
$replies = getRepliesByMessageId($messageId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>回复消息</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="./style/reply.css">

</head>
<body>
    <table >
    <h3><?php echo $title; ?></h3>
    <p class="con"><?php echo $content; ?></p>
    </table>

    <div class="reply">
    <h3 style="text-align: left;padding-left: 10%;">回复</h3>
    <form action="doreply.php" method="POST">
        <input type="hidden" name="messageId" value="<?php echo $messageId; ?>">
        <input type="hidden" name="userId" value="<?php echo $userId; ?>">
        <textarea name="content" rows="4" cols="50" style="margin-left: 10%;"></textarea><br><br>
        <input type="submit" value="回复" style="margin-left: 10%;">
    </form>
</div>


    <h3>全部回复</h3>
<?php
if (count($replies) > 0) {
    echo "<table class='allreply'>";
    foreach ($replies as $reply) {
        $username = $reply['username'];
        $replyContent = $reply['content'];
        $replyUserId = $reply['userId'];
        $isCurrentUserReply = ($replyUserId == $userId);
        $deleteLink = "";

        if ($isCurrentUserReply) {
            // 当前登录用户的回复，显示删除链接
            $replyId = $reply['id'];
            $deleteLink = "<a href='delreply.php?replyId=$replyId&messageId=$messageId'>删除</a>";
        }

        echo "<tr><td class='td'>$username &nbsp;：</td><td>$replyContent</td><td>$deleteLink</td></tr>";
    }
    echo "</table>";
} else {
    echo "暂无回复";
}
?>
 <?php echo forumtail() ?>
</body>
</html>
