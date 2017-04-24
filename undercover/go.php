<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/3/20
 * Time: 23:35
 */

namespace unit\lrs;


error_reporting(E_ALL);
ini_set('display_errors', 'on');





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

    <title>XX</title>

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

    <script src="../undercover/js/jquery-3.2.0.js"></script>
    <script src="../undercover/js/jquery.cookie.js"></script>
    <script src="../undercover/js/lrs.js"></script>
</head>

<body>

<div class="container">
    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation" class="active"><a href="#">Home</a></li>
                <li role="presentation"><a href="#">About</a></li>
                <li role="presentation"><a href="feedback.php">反馈</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">XX</h3>
    </div>

    <div class="jumbotronX">
        <form class="form-horizontal" id="lrs_enter" >
            <div class="form-group">
                <label for="inputRoomNum" class="col-sm-2 control-label"></label>
                <div class="col-sm-10" id="lrs_enter_info">
                    请输入房间号和昵称进入,或者创建新房间
                </div>
            </div>
            <div class="form-group">
                <label for="inputRoomNum" class="col-sm-2 control-label">房间号</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputRoomNum" placeholder="房间号">
                </div>
            </div>
            <div class="form-group">
                <label for="inputNickname" class="col-sm-2 control-label">昵称</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputNickname" placeholder="昵称">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-success"  role="button" id="lrs_enter_but">进入</button>
                    <button type="button" class="btn "  role="button" id="lrs_enter_create">创建房间</button>
                </div>
            </div>
        </form>


    </div>

    <footer class="footer">
        <p>&copy; 2016 Company, Inc.</p>
    </footer>

</div> <!-- /container -->


<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../undercover/js/ie10-viewport-bug-workaround.js"></script>
</body>
<script>

    mainUrl="cmd.php";
    $(function(){

      var  roomNum= $.cookie('roomNum');
      if(!isNull(roomNum)){
          $("#lrs_enter #inputRoomNum").val(roomNum);
          $("#lrs_enter #lrs_enter_info").html("请输入昵称进入游戏");
      }

        $("#lrs_enter_but").click(function(){
            roomNum=$("#lrs_enter #inputRoomNum").val();

            nickName=$("#lrs_enter #inputNickname").val();
            if(isNull(roomNum)){
                alert("请输入房间号，或点击创建新房间");
                return ;
            }
            if(isNull(nickName)){
                alert("请输入昵称");
                return ;
            }
            $.ajax({
                url: mainUrl,
                data: {
                    cmd: "enter",
                    roomNum:roomNum,
                    nickName:nickName
                },
                success: function( result ) {
                    if(result.code!=0){
                        alert(result.message);
                    }else{
                       // alert("成功");
                        $.cookie('pid', result.message, { expires: 7, path: '/' });
                        $.cookie('roomNum',roomNum, { expires: 7, path: '/' });
                        window.location.href="play.php"
                    }
                }
            });
        })
        $("#lrs_enter_create").click(function(){
            window.location.href="create.php"
        });


    })

</script>
</html>
