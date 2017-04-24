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
require_once 'role/Role.php';
require_once 'manager/RoleManager.php';






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
                <li role="presentation"><a href="#">Contact</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">XX</h3>
    </div>

    <div class="jumbotronX">
        <form class="form-horizontal" id="lrs_enter" >
            <div class="form-group">
                <label for="inputRoomName" class="col-sm-2 control-label">房间名</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputRoomName" placeholder="房间名" value="干死你">
                </div>
            </div>

            <?php

            RoleManager::initRoles();
            foreach (Role::$roles as $role){
            ?>
            <div class="form-group">
                <label for="inputRole<?php echo $role->roleId ?>" class="col-sm-2 control-label"><?php echo $role->name ?></label>
                <div class="col-sm-10">
                    <input  type="text" class="form-control roleInput" rid="<?php echo $role->roleId ?>" id="inputRole<?php echo $role->roleId ?>" placeholder="<?php echo $role->name ?>"
                           value="<?php echo $role->initSize ?>">
                </div>
            </div>
            <?php } ?>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-success"  role="button" id="lrs_ok_but">好了</button>
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


    var  roomNum= $.cookie('roomNum');
    var  pid= $.cookie('pid');


    mainUrl="cmd.php";
    $(function(){
        $("#lrs_ok_but").click(function(){
             var  name=$("#lrs_enter #inputRoomName").val();
             var roles="";
             $("#lrs_enter .roleInput").each(function(){
                 roles+=$(this).attr("rid")+"_"+$(this).val()+";";
             });
            roles=roles.substring(0,roles.length-1);

            if(isNull(name)){
                alert("请输入房间名");
                return ;
            }
            if(isNull(roles)){
                alert("请输入角色");
                return ;
            }
            $.ajax({
                url: mainUrl,
                data: {
                    cmd: "create",
                    name:name,
                    roles:roles
                },
                success: function( result ) {
                    if(result.code!=0){
                        alert(result.message);

                    }else{
                        alert("创建房间成功,房间号"+result.message);
                         $.cookie('roomNum', result.message, { expires: 7, path: '/' });
                        window.location.href="go.php"
                    }
                }
            });
        })
    })

</script>
</html>
