<?php
session_start();
require_once 'function.php'; // 引入函数文件


echo forumHeader();
?>
<!DOCTYPE html>
<html>

<head>
    <title>登录</title>
    <link rel="stylesheet" href="./style/login.css">


</head>

<body>
    <h2>登录页面</h2>
    <form action="dologin.php" method="POST">
        <label for="username">用户名:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">密码:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label >验证码:</label>
        <input class="input"  name="vCode" />
        <img src="validatecode.php" onclick="this.src='validatecode.php?rand='+Math.random()" alt="点击，更换验证码" style="margin-left: 30%;"><br><br>

        <input type="submit" value="登录">
    </form>
    <?php echo forumtail() ?>
</body>

</html>