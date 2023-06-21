<html>
    <head>
        <title>错误信息页面</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
    </head>
    <body>
        <!--      错误信息        -->
        <DIV align="center">
            <BR />
            <font color="red"><?php echo $_REQUEST["msg"]; ?>
            </font>
            <BR />
            <BR />
            <input type="button" value="返 回" onClick="window.history.back();" /> <!-- 返回上一级页面 -->
            <BR />
            <BR />
        </DIV>
    </body>
</html>
