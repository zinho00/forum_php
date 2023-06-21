<?php
require_once 'dblink.php'; //引入配置文件

/*
 * 数据库连接
 */
function get_Connect() {
    $conn = mysqli_connect(
        $GLOBALS['cfg']["server"]["adds"],
        $GLOBALS['cfg']["server"]["db_user"],
        $GLOBALS['cfg']["server"]["db_psw"],
        $GLOBALS['cfg']["server"]["db_name"],
        $GLOBALS['cfg']["server"]["db_port"]
    ) or die(header("location: error.php?msg=数据库连接错误"));

    return $conn;
}


?>
