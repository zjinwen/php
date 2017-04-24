<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/20
 * Time: 23:35
 */

namespace unit\lrs;

require_once 'dao/Db.php';
require_once 'GUtils.php';
error_reporting(E_ALL);
ini_set('display_errors', 'on');

 $result=null;
if(isset($_REQUEST['message'])){
    $contact="";
   if( isset($_REQUEST['contact'])){
       $contact=$_REQUEST['contact'];
    }
    $message=$_REQUEST['message'];

    $db=new Db();
    $ip=getIP();
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $time=time();
    $createSql="CREATE TABLE `wk_feedback` (`id`  int NOT NULL AUTO_INCREMENT ,`contact`  varchar(64) NULL ,`message`  varchar(10240) NULL ,`ip`  varchar(32) NULL , `agent`  varchar(128) NULL ,`creatTime`  datetime NULL ,PRIMARY KEY (`id`))";

    if(!GUtils::isTableExist("feedback")){
        $db->exec($createSql);
    };
    $insertSql="INSERT INTO  `wk_feedback` (`id`, `contact`, `message`, `ip`, `agent`, `creatTime`) VALUES (null, :contact, :message, :ip,:agent, now())";

    $stmt = $db->dbh->prepare($insertSql);
    $stmt->bindParam("contact", $contact);
    $stmt->bindParam("message", $message);
    $stmt->bindParam("ip",$ip );
    $stmt->bindParam("agent",$agent );
    $stmt->execute();
    $result="感谢您的反馈，我们已收到。<br/>".$contact;
}
 function getIP(){
    $ip="";
    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } else {
            $ip = getenv("REMOTE_ADDR");
        }
    }
    return $ip;
}




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
                <li role="presentation" ><a href="index.php">Home</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">文件安全批量转移</h3>
    </div>

    <div class="jumbotronX">

        <form class="form-horizontal" id="lrs_enter" method="post" >
           <?php if($result!=null){ ?>
            <div class="form-group">
                <label for="inputMessageResult" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <div class="alert alert-success" role="alert" id="inputMessageResult" name="message"><?php echo $result ?></div>
                </div>
            </div>
            <?php } ?>
            <div class="form-group">
                <label for="inputMessage" class="col-sm-2 control-label">反馈内容</label>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="3"  id="inputMessage" name="message"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="inputContact" class="col-sm-2 control-label">（可选）联系方式</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control"  name="contact" id="inputContact" placeholder="邮箱、手机号、QQ、微信等">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success"  role="button" id="lrs_enter_but">发送</button>
                </div>
            </div>
        </form>


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
