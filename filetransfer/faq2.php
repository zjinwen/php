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
        <h3 class="text-muted">FileTransfer</h3>
    </div>
    <div class="row marketing">
        <div class="col-lg-12">
            <h4>步骤 手机->电脑</h4>
            <p> 1.电脑启动服务端<br/>
                安装jre http://www.oracle.com/technetwork/java/javase/downloads/jre8-downloads-2133155.html<br/>
                选择 Accept License,下载对应系统版本,安装 下一步 完成..<br/>
                打开文件 config.txt<br/>
                #服务端监听端口,客户端连接端口<br/>
                config.port=20009<br/>
                #接收文件目录<br/>
                config.destDir=D:\\images\\dst<br/>
                上面配置 转移到D盘 images dst 目录下（\需要两个\\）<br/>
            </p>
            <p> 2.手机端<br/>
                点击开始<br/>
                设置要转移目录<br/>
                服务端ip 端口，转移成功后删除源文件。确认<br/>
            </p>

        </div>
    </div>
    <div class="row marketing">
        <div class="col-lg-12">
            <h4>为什么需要这个</h4>
    <p>
        <br/>
        我的手机上有5000多张照片，想转移到电脑上：<br/>
        1.有时候复制到电脑上，居然提示图片已损坏，5000个文件我也不能一个一个打开看看。<br/>
        2.插上我的手机数据线，居然一张照片都没看到。<br/>
        所以就需要批量转移，并且能检查复制的文件和原来文件一样。<br/>
    </p>
        </div>
    </div>
   <!-- <div class="jumbotron" style="text-align: left">
        <div>
            <p><br/>
            手机和电脑<br/>
            因为是通过网络发送数据，需要手机和电脑可以通过网络连接，同一路由器下，或局域网，或者手机开启wifi热点，电脑链接此热点，不消耗流量。<br/>
           <br/>

            <br/>
            设置dst 为要接收的目录<br/>
            服务端在屏幕上打印日志，可以看到接收的目录，服务端ip 和端口（手机端设置时需要填写此ip 端口，显示多个ip，可能有多个网卡虚拟网卡，手机依次填下试试）。<br/>
            2.打开手机app，点击开始 ，设置要转移目录，电脑ip 端口，转移成功后验证通过可以删除源文件。点击 确认 。手机端会显示转移日志，手机端配置自动保存。<br/>
            </p>
            <p>
            电脑和电脑<br/>
            1.其中一台电脑作为服务端，同手机和电脑服务端<br/>
            2.另一台电脑作为客户端<br/>
            下载 解压后，点击 start.cmd<br/>
            </p>
            <p>
            为什么需要这个<br/>
            我的手机上有5000多张照片，想转移到电脑上：<br/>
            1.有时候复制到电脑上，居然提示图片已损坏，5000个文件我也不能一个一个打开看看。<br/>
            2.插上我的手机数据线，居然一张照片都没看到。<br/>
            所以就需要批量转移，并且能检查复制的文件和原来文件一样。<br/>
            </p>
        </div>


    </div>-->

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
