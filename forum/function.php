<?php
require_once 'comm.php'; // 引入配置文件

/*
 * 添加用户
 */
function addUser($uName, $uPass, $gender,$head) {
    $insertStr = "INSERT INTO user (uName, uPass, gender, head) VALUES ";
    // 准备插入操作参数
    $insertStr .= "('{$uName}', '{$uPass}', '{$gender}', '{$head}')";
    
    // 连接数据库
    $conn = get_Connect();
    
    // 执行插入操作
    $result = mysqli_query($conn, $insertStr);
    
    // 关闭数据库连接
    mysqli_close($conn);
    
    return $result;
}

/*
 * 查询用户登录信息
 */
function checkUserLogin($username, $password) {
    // 连接数据库
    $conn = get_Connect();

    // 防止SQL注入，使用参数化查询
    $query = "SELECT * FROM user WHERE uName = ? AND uPass = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
    mysqli_stmt_execute($stmt);

    // 获取查询结果
    $result = mysqli_stmt_get_result($stmt);

    // 关闭数据库连接
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    return $result;
}

function updateUserPassword($uId, $newPassword)
{
    // 连接数据库（您可以使用现有的数据库连接代码）
    $conn = get_Connect();

    // 更新用户密码
    $query = "UPDATE user SET uPass = ? WHERE uId = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $newPassword, $uId);
    $result = mysqli_stmt_execute($stmt);

    // 关闭数据库连接
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    return $result;
}

/**
 * 执行查询操作
 */
function execQuery($strQuery){
    $results = array();
    $connection = get_Connect();
    $rs = mysqli_query($connection,$strQuery) or die(header("location: error.php?msg=查询失败"));
    for ($i=0;$i<mysqli_num_rows($rs);$i++) {
        $results[$i] = mysqli_fetch_assoc($rs);//读取一条记录
    }
    mysqli_free_result($rs);//释放结果集
    mysqli_close($connection);//关闭连接
    return $results;//返回查询结果
}


/*
 *  2、根据编号查询用户信息 
 */
function findUserById($id)
{
    $strQuery ="select * from user where uId=$id";
    $rs = execQuery($strQuery);
    if (count($rs)>0){
        return $rs[0];
    }
    return $rs;
}

function getTotalMessageCount()
{
    $connection = get_Connect(); // 获取数据库连接

    $sql = "SELECT COUNT(*) as total FROM msg";

    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);

    mysqli_close($connection); // 关闭数据库连接

    return $row['total'];
}


function getAllMessages($start, $perPage) {
    $connection = get_Connect();

    // SQL 查询语句，限制返回的记录数量
    $sql = "SELECT * FROM msg ORDER BY posttime DESC LIMIT $start, $perPage";

    // 执行查询并返回结果集
    $result = mysqli_query($connection, $sql);

    $messages = array();

    if ($result) {
        // 遍历查询结果，将每条消息添加到数组中
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = $row;
        }

        // 释放结果集
        mysqli_free_result($result);
    }

    // 关闭数据库连接
    mysqli_close($connection);

    return $messages;
}

function getMessagesByUserId($userId) {
    $connection = get_Connect();
    $userId = mysqli_real_escape_string($connection, $userId);

    // 构造查询语句
    $sql = "SELECT * FROM msg WHERE uId = '$userId' ORDER BY postTime DESC";

    // 执行查询并返回结果集
    $result = mysqli_query($connection, $sql);

    $messages = array();

    if ($result) {
        // 遍历查询结果，将每条消息添加到数组中
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = $row;
        }

        // 释放结果集
        mysqli_free_result($result);
    }

    // 关闭数据库连接
    mysqli_close($connection);

    return $messages;
}

function deleteMessage($messageId) {
    $connection = get_Connect();

    // 使用预处理语句删除消息
    $sql = "DELETE FROM msg WHERE id = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "i", $messageId);
    mysqli_stmt_execute($stmt);

    // 检查是否成功删除了消息
    $rowsAffected = mysqli_stmt_affected_rows($stmt);

    // 关闭预处理语句和数据库连接
    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    // 返回受影响的行数
    return $rowsAffected;
}

function getMessageById($messageId) {
    $connection = get_Connect();

    // 使用预处理语句查询消息
    $sql = "SELECT * FROM msg WHERE id = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "i", $messageId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // 获取消息的详细信息
    $message = mysqli_fetch_assoc($result);

    // 关闭预处理语句和数据库连接
    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    return $message;
}


function updateMessage($messageId, $title, $content) {
    $connection = get_Connect();

    // 更新消息
    $sql = "UPDATE msg SET title = ?, content = ? WHERE id = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $title, $content, $messageId);
    mysqli_stmt_execute($stmt);

    // 检查是否成功更新了消息
    $rowsAffected = mysqli_stmt_affected_rows($stmt);

    // 关闭预处理语句和数据库连接
    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    // 返回受影响的行数
    return $rowsAffected;
}

function getRepliesByMessageId($messageId) {
    $connection = get_Connect();
    $messageId = mysqli_real_escape_string($connection, $messageId);

    // 构造查询语句，获取回复内容和对应的用户名
    $sql = "SELECT r.id, r.userId, r.content, u.uName AS username
        FROM reply AS r
        INNER JOIN user AS u ON r.userId = u.uId
        WHERE r.messageId = ?";

$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, "i", $messageId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$replies = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $replies[] = $row;
    }
}

mysqli_stmt_close($stmt);
mysqli_close($connection);

return $replies;

}

function insertReply($userId, $messageId, $content) {
    $connection = get_Connect();

    // 插入回复内容到 reply 表
    $sql = "INSERT INTO reply (userId, messageId, content) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $userId, $messageId, $content);
    $result = mysqli_stmt_execute($stmt);

    // 关闭预处理语句
    mysqli_stmt_close($stmt);

    // 关闭数据库连接
    mysqli_close($connection);

    return $result;
}

function deleteReply($replyId, $userId) {
    $connection = get_Connect();

    // 检查回复是否属于当前用户
    $sql = "SELECT * FROM reply WHERE id = ? AND userId = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $replyId, $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // 检查结果集中是否存在回复
    if (mysqli_num_rows($result) > 0) {
        // 删除回复
        $sql = "DELETE FROM reply WHERE id = ?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $replyId);
        mysqli_stmt_execute($stmt);

        // 检查是否成功删除回复
        $rowsAffected = mysqli_stmt_affected_rows($stmt);

        // 关闭预处理语句
        mysqli_stmt_close($stmt);
    } else {
        // 回复不存在或不属于当前用户
        $rowsAffected = 0;
    }

    // 关闭数据库连接
    mysqli_close($connection);

    // 返回受影响的行数
    return $rowsAffected;
}

function forumHeader() {
    if (isset($_SESSION["CURRENT_USER"])) {
        $curUser = $_SESSION["CURRENT_USER"];
        $username = $curUser["uName"];
        $head = $curUser["head"];
        
        $headLink = "image/head/" . $head; // 头像图片链接
        $userLink = "userdetail.php"; // 用户信息编辑页面链接
        
        echo '<div style="background-color: darkgray;">';
        echo '<a href="index.php" style="padding-left: 10%; padding-right:20px;"><img src="image/forum.gif" alt="首页"></a>';
        echo '<a href="homepage.php" style="padding-right:20px;"><img src="'.$headLink.'" alt="头像"></a>';
        echo '<a href="'.$userLink.'">'.$username.'</a>&nbsp;|&nbsp;';
        echo '<a href="doLogout.php">登出</a>';
        echo '</div>';
    } else {
        echo '<div style="background-color: darkgray;">';
        echo '<a href="index.php" style="padding-left: 10%; padding-right:20px;"><img src="image/forum.gif" alt="首页"></a>';
        echo '<a href="login.php">登录</a>&nbsp;|&nbsp;';
        echo '<a href="reg.php">注册</a>';
        echo '</div>';
    }
}

//发布新消息
function addMessage($userId, $title, $content) {
    $connection = get_Connect();
    $title = mysqli_real_escape_string($connection, $title);
    $content = mysqli_real_escape_string($connection, $content);
    $insertQuery = "INSERT INTO msg (uId, title, content) VALUES ('$userId', '$title', '$content')";
    $result = mysqli_query($connection, $insertQuery);
    mysqli_close($connection);
    return $result;
}

function forumtail(){
    return "<CENTER class=\"gray\">2023 Zinho 版权所有</CENTER>";
}
?>

