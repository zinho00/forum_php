<?php
session_start();
require_once 'comm.php'; // 引入配置文件
require_once 'function.php'; // 引入函数文件


forumHeader();
?>

<!DOCTYPE html>
<html>

<head>
    <title>首页</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="./style/index.css">
</head>

<body>
    <?php
    // 获取当前页码，默认为第一页
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    // 每页显示的记录数
    $perPage = 10;

    // 调用函数获取总记录数
    $totalRecords = getTotalMessageCount();

    // 计算总页数
    $totalPages = ceil($totalRecords / $perPage);

    // 计算当前页的起始记录索引
    $start = ($page - 1) * $perPage;

    // 调用函数获取指定页的消息数据
    $messages = getAllMessages($start, $perPage);

    echo "<h2>消息列表</h2>";

    if (count($messages) > 0) {
        echo "<table>";
        foreach ($messages as $message) {
            $messageId = $message['id'];
            $title = $message['title'];
            $content = $message['content'];
            $postTime = $message['postTime'];

            echo "<tr>";
            echo "<td>";
            echo "<div class='message-box'>";
            echo "<h3><a href='reply.php?messageId=$messageId'>$title</a></h3>";
            echo "<p>$content</p>";
            echo "<p id='time'>$postTime</p>";
            echo "</div>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "暂无消息";
    }


    // 显示分页链接
    echo "<div class='pagination'>";
    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = ($i == $page) ? 'active' : '';
        echo "<a href='index.php?page=$i' class='$activeClass'>$i</a> ";
    }
    echo "</div>";

    ?>
 <?php echo forumtail() ?>
</body>

</html>