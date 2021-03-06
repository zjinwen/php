<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/20
 * Time: 23:35
 */
namespace unit\lrs;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../images/favicon.ico">

    <title>FileTransfer</title>

    <!-- Bootstrap core CSS -->
    <link href="../filetransfer/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../filetransfer/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../filetransfer/css/jumbotron-narrow.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../filetransfer/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../filetransfer/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="../filetransfer/js/jquery-3.2.0.js"></script>
    <script src="../filetransfer/js/jquery.cookie.js"></script>
    <script src="../filetransfer/js/lrs.js"></script>
</head>

<body>

<div class="container">
    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
              <!--  <li role="presentation" ><a href="index.php">Home</a></li>-->
            </ul>
        </nav>
       <!-- <h3 class="text-muted">FileTransfer</h3>-->
    </div>
    <div class="row marketing">
        <div class="col-lg-12">
            <h4>步骤 手机->电脑</h4>
            <p> 1.电脑启动服务端<br/>
                安装jre http://www.oracle.com/technetwork/java/javase/downloads/jre8-downloads-2133155.html<br/>
                选择 Accept License,下载对应系统版本,安装 下一步 完成..<br/>
                下载<a href ="http://pan.baidu.com/s/1mh5zE4o">ft-server</a><br/>
                (无法下载,复制以下链接致浏览器打开 http://pan.baidu.com/s/1mh5zE4o )<br/>
                解压<br/>
                打开文件 config.txt<br/>
                修改
                #接收文件目录<br/>
                config.destDir=D:\\images\\dst<br/>
                表示接收到文件存放到 D盘images dst 目录下（\需要两个\\）<br/>
                #服务端监听端口,客户端连接端口<br/>
                config.port=20009<br/>
                双击start.cmd<br/>
            </p>
            <p> 2.手机端<br/>
                点击开始<br/>
                设置要转移目录<br/>
                服务端ip 端口，转移成功后删除源文件。确认<br/>
            </p>

        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2016 Company, Inc.</p>
    </footer>
</div> <!-- /container -->


<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../filetransfer/js/ie10-viewport-bug-workaround.js"></script>
</body>
<script>



</script>
</html>
