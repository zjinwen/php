<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/2/21
 * Time: 10:50
 */
require_once 'Game.php';
?>

<?php
$dbms='mysql';     //数据库类型
$host='mysql'; //数据库主机名
$dbName='u364299180_ygaru';    //使用的数据库
$user='u364299180_aqule';      //数据库连接用户名
$pass='ahaLuXeVyG';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";
try {
     $dbh = new PDO($dsn, $user, $pass,array(PDO::ATTR_PERSISTENT => true)); //初始化一个PDO对象
     foreach ($dbh->query('SELECT * from wk_role ')->fetchAll() as $row) {
       // print_r($row['name']);
     }
     $dbh = null;
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
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

    <title>狼人杀 在线游戏 房间</title>

    <!-- Bootstrap core CSS -->
    <link href="../undercover/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../undercover/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../undercover/css/jumbotron-narrow.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../undercover/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../undercover/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">
    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation" class="active"><a href="#">Home</a></li>
                <li role="presentation"><a href="#">About</a></li>
                <li role="presentation"><a href="#">Contact</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">在线游</h3>
    </div>

    <div class="jumbotron">
        <p class="lead">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group">
              <!--<span class="input-group-addon">
                <input type="checkbox" aria-label="昵称">
              </span>-->
                         <input type="text" class="form-control" aria-label="..." placeholder="昵称">
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <div class="input-group">
              <!--<span class="input-group-addon">
                <input type="radio" aria-label="房间号">
              </span>-->
                            <input type="text" class="form-control" aria-label="..."  placeholder="房间号">
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
        </p>
        <p>
            <a class="btn btn-lg btn-success" href="start.php" role="button">进入房间</a>
            <a class="btn btn-lg " href="start.php" role="button">创建房间</a>
        </p>

    </div>

    <div class="row marketing">
        <div class="col-lg-6">
            <h4>游戏角色</h4>
            <p> 4张狼人(Werewolves)<br/>
                13张普通村民(Ordinary Townsfolk/villager)<br/>
                1张预言家(Fortune Teller/Seer)<br/>
                1张盗贼(Thief)<br/>
                1张猎人(Hunter)<br/>
                1张丘比特(Cupido)<br/>
                1张女巫(Witch)<br/>
                1张小女孩(Little Girl)<br/>
                1张警长标志牌(Sheriff)<br/>
            </p>

            <h4>游戏目标</h4>
            <p>
                村民的目标：白天的时候处决所有的狼人。<br/>
                狼人的目标：黑夜的时候杀死所有的村民。<br/>
                游戏中，狼人、预言家、村民是必须要使用的，其余角色根据游戏人数可适当加入。</p>

            <h4>人数配置</h4>
            <p>
                玩家人数	狼人数量	能力者	村民数量<br/>
                8	2	3	3<br/>
                9	3	3	3<br/>
                10	3	3	4<br/>
                11	3	4	4<br/>
                12	4	4	4<br/>
                13	4	4	5<br/>
                14	4	5	5<br/>
                15	5	5	5<br/>
                16	5	5	6<br/>
                17	5	6	6<br/>
                18	6	6	6<br/>
            </p>
        </div>

        <div class="col-lg-6">
            <h4>游戏进程</h4>
            <p>传送到
                <a target="_blank" href="http://baike.baidu.com/link?url=t0AKOvNE2xAv3dOWzMwbr5Eukr2jYECBT0LT_XX5mxMLWZdO3ck9gINJoPU0myk-KShY6YWPw3-DQgmFsPeo22cr2LXVRm5fL20VZhFM5uAC8rDdfoPMXHZACW-YqC3K">百度百科</a></p>
            <h4>在线</h4>
            <p>当日：1.历史合计：2</p>
            <h4>战绩</h4>
            <p>
                zhang:胜3败10.<br/>
                bb:胜3败10.<br/>
                cc:胜3败10.<br/>
                yy:胜3败10.<br/>
            </p>


        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2016 Company, Inc.</p>
    </footer>

</div> <!-- /container -->


<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../undercover/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
