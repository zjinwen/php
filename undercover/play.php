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
<style>
    .jumbotron{
        float: left;
    }
    #lrs_user{
        margin: 10px auto;
    }
    #lrs_players{
        width: 50%;
        float: left;
    /*background-color: #8f2626;*/
    }


    #lrs_message{
        width: 50%;
        float: right;
        background-color: #b9def0;
    }
    #lrs_input_message{
        width: 100%;
        float: left;
    }
    .lrs_player{
        width: 80px;
        height: 80px;
        float: left;
        border-radius:5px;
        background-color: #00A8EF;
        margin: 5px;
        display: flex;
        justify-content:center;
        align-items:Center;
        flex-direction: column-reverse;

        font-size: large;
        font-weight: bold;
        cursor: pointer;
     }
    #lrs_players .selU{
        background-color: #7CA821;
    }
    .lrs_player .num{
        -moz-user-select: none;
        -khtml-user-select: none;
        user-select: none;
    }
    .lrs_player .name{

    }

    .lrs_np{
        background-color: #b9def0;

    }


</style>
</head>

<body>

<div class="container">
    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation"><a href="cmd.php?cmd=exit">退出游戏</a></li>
                <li role="presentation"><a href="#">Home</a></li>
                <li role="presentation"><a href="#">About</a></li>
                <li role="presentation"><a href="feedback.php">反馈</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">XX</h3>
    </div>

    <div class="jumbotron">
        <div id="lrs_user">

        </div>
        <div id="lrs_players">

        </div>
        <div id="lrs_message"></div>
        <div id="lrs_input_message">
            <form class="form-horizontal" id="lrs_enter" >
                <div class="form-group">
                    <div class="col-sm-12">
                        <textarea class="form-control" rows="3" id="inputMessage"   placeholder="发言"></textarea>
                    </div>

                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-success"  role="button" id="lrs_enter_but">确认</button>
                    </div>
                </div>
            </form>

        </div>


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
        var preComplete=true;
        var lastMid=-1;
        var userSel=-1;
        function getMessage() {
            var roomNum = $.cookie('roomNum');
            var pid = $.cookie('pid');

            $.ajax({
                url: mainUrl,
                data: {
                    cmd: "message",
                    roomNum: roomNum,
                    lastMid: lastMid,
                    pid: pid
                },
                complete: function(){
                    preComplete=true;
                },
                error:  function(XMLHttpRequest, textStatus, errorThrown) {
                    /*alert(XMLHttpRequest.status);
                    alert(XMLHttpRequest.readyState);*/
                    console.log(XMLHttpRequest);
                    console.log(errorThrown);
                    console.log(textStatus);
                },
                success: function (result) {
                    if (result.code != 0) {
                        alert(result.message);
                        $.cookie('pid',"", { expires: 7, path: '/' });
                        $.cookie('roomNum',"", { expires: 7, path: '/' });
                        window.location.href = "go.php";
                    } else {
                        u = result.u;
                        if (u) {

                        userName = "";
                        roomName = "";
                        if (u.rn != null) {
                            roomName = u.rn;
                        }
                        if (u.nm != null) {
                            userName = u.nm;
                        }
                        $("#lrs_user").html("<div class=\"room\">房间号" + roomNum + "" + roomName + "</div>" + "<div class=\"user\">您是" + pid + "号玩家" + userName + "</div>");
                    }

                        ps = result.ps;
                       if(ps!=null&&ps.length>0){
                            $("#lrs_players").empty();
                        }

                        for (var i = 0; i < ps.length; i++) {
                            p = ps[i];
                            ac = "lrs_player";
                            if (p.nm == null) {
                                ac = "lrs_player lrs_np ";
                            }
                            if(userSel==p.n){
                                ac+=" selU";
                            }
                            name = p.nm;
                            if (p.nm == null) {
                                name = "等待加入...";
                            }


                            $("#lrs_players").append("<div pid=\"" + p.n + "\" class=\"" + ac + "\">" +
                                "<span class=\"num\">" + p.n + "</span><span calss=\"name\">" + name + "</span></div>");
                        }
                        ms = result.ms;

                        for (var i = 0; i < ms.length; i++) {
                            $("#lrs_message").append(
                                "<div mid=\""+ms[i].mid+"\">"+ms[i].message+"</div>"
                            );
                            lastMid=ms[i].mid;
                        }

                    }
                }
            });
            return {roomNum: roomNum, pid: pid};
        }

        $('#lrs_players').on('click','.lrs_player',function(){
            // alert($(this).attr("pid"));
            selClass="selU";
            userSel= $(this).attr("pid");
            $(this).parent().find(".selU").removeClass(selClass);
            if($(this).hasClass(selClass)){
                $(this).removeClass(selClass);
            }else{
                $(this).addClass(selClass);
            }



        });



        setInterval(function () {
            if(preComplete){
                preComplete=false;
               // console.log("执行请求");
                var __ret = getMessage();
                var roomNum = __ret.roomNum;
                var pid = __ret.pid;
            }else{
                //console.log("放弃执行请求");
            }

        },1000);

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
                        alert("成功");
                    }
                }
            });
        })



    })

</script>
</html>
