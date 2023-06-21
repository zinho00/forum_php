<?php
session_start();
require_once 'function.php'; // 引入函数文件


forumHeader();
?>
<!DOCTYPE html>
<html>

<head>
    <title>注册页面</title>
    <link rel="stylesheet" href="./style/reg.css">
    <script language="javascript">
        function init() {
            document.regForm.head[0].checked = true; //初始化头像选择
        }
    </script>
</head>
<?php
require_once 'comm.php';
?>

<body onLoad="init()">
    <h2>注册</h2>
    <form action="doreg.php" method="POST">
        <label for="username">用户名:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">密码:</label>
        <input type="password" name="password" id="password" required><br><br>

        <label for="gender">性别:</label>
        <select name="gender" id="gender" required>
            <option value="1">男</option>
            <option value="2">女</option>
        </select><br><br>
        <p>请选择头像 </p>

        <?php
        for ($i = 1; $i <= 15; $i++) { //循环输出系统头像
            echo "<img src='image/head/$i.gif'/><input type='radio' name='head' value='$i.gif'/>";
            if ($i % 4 == 0) //每5个换一行
                echo "</br>";
        }
        ?>
        <p>验证码 &nbsp;<input class="input" tabIndex="3" type="text" maxLength="20" size="35" name="vCode" /></p>
        <img class="img" src="validatecode.php" onclick="this.src='validatecode.php?rand='+Math.random()" alt="点击，更换验证码"><br><br>


        <input type="submit" value="注 册">
    </form>
    <?php echo forumtail() ?>
</body>

</html>