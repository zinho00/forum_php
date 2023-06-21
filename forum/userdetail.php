<?php
session_start();
require_once 'comm.php'; // 引入配置文件
require_once 'function.php'; // 引入函数文件

// 检查用户是否已登录
if (!isset($_SESSION["CURRENT_USER"])) {
    // 如果未登录，跳转到登录页面
    header("Location: login.php");
    exit;
}

// 获取当前用户信息
$current_user = $_SESSION["CURRENT_USER"];
$uId = $current_user["uId"];
$user = findUserById($uId);

// 处理密码更新请求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($newPassword !== $confirmPassword) {
        // 密码不一致，跳转到错误页面
        $error_msg = "密码不一致，请重新输入";
        header("Location: error.php?msg=" . urlencode($error_msg));
        exit;
    }

    // 更新用户密码
    $result = updateUserPassword($uId, $newPassword);

    if ($result) {
        // 密码更新成功
        session_destroy(); // 清除会话数据
        header("Location: login.php");
        exit;
    } else {
        // 密码更新失败
        $error_msg = "密码更新失败，请重试";
        header("Location: error.php?msg=" . urlencode($error_msg));
        exit;
    }
}
forumHeader();
?>

<!DOCTYPE html>
<html>
<head>
    <title>修改密码</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./style/userdetail.css">

</head>
<body>
    <div>
        <h2>修改密码</h2>

        <form name="userForm" action="userdetail.php" method="post">
            <input type="hidden" name="uId" value="<?php echo $user['uId']; ?>">
            <p align="center" class='username'><?php echo $user['uName']; ?><p>
            <p>新密码: <input type="password" name="newPassword" required></p>
            <p>重复密码: <input type="password" name="confirmPassword" required></p>
            <p><input type="submit" value="修改密码"></p>
        </form>
    </div>
    <?php echo forumtail() ?>
</body>
</html>
