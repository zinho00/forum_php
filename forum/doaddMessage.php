<?php
require_once 'comm.php'; // 引入配置文件
require_once 'function.php'; // 引入函数文件

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $result = addMessage($userId, $title, $content);

    if ($result) {
        echo "消息保存成功";
    } else {
        echo "消息保存失败";
    }
}
?>
