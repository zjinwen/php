/**
 */
function isNull( str ){
    if(typeof(str)=="undefined"){
        return true;
    }
    if(str==null)return true;
    if ( str == "" ) return true;
    var regu = "^[ ]+$";
    var re = new RegExp(regu);
    return re.test(str);
}
String.prototype.startWith=function(str){
    var reg=new RegExp("^"+str);
    return reg.test(this);
}

String.prototype.endWith=function(str){
    var reg=new RegExp(str+"$");
    return reg.test(this);
}

function Player(roomId,playerId,enable){
    this.roomId = roomId;
    this.playerId = playerId;
    this.preComplete = true;
    this.privateId = -1;
    this.publicId = -1;


    this.init =false;
    this.select =null;
    this.event =false;
    this.enable =enable;
    this.rcount =0;
    this.current =false;
    this.doneEvent =false;
    this.lastPs =[];
    this.lastV =[];
    this.ext ="";
    this.witchOp ="";
    this.item=null;

}
Player.prototype.mainUrl = "cmd.php";
Player.prototype.loop = function() {
    if(this.init){
        console.log("已经初始化");
        return;
    }
    this.init=true;

    var  _th=this;
    $.ajax({
        url: this.mainUrl,
        data: {
            cmd: "enter",
            roomNum:this.roomId,
            nickName:this.playerId+"号",
            pid:_th.playerId
        },
        success: function( result ) {
            if(result.code!=0){
                alert(_th.playerId+"号进入失败"+result.message);
            }else{
                //window.location.href="play.php"
                //alert(this.playerId+"号进入成功");
                //alert(_th.playerId);
                if(_th.playerId!=0){
                    $("#lrs_test_all" ).append(

                        "<div class=\"item\" pid=\""+_th.playerId+"\">"+
                        "<div class=\"inputLrs\">"+
                        "<textarea  name=\"inputMessage\"></textarea>"+
                        "<button type=\"button\""+
                        "class=\" btn-success btn-sm \""+
                        "role=\"button\" id=\"lrs_ok_but\" "+(!_th.current?" disabled=\"disabled\"":"")+"  >确认</button>"+
                        "<input type=\"checkbox\" name=\"lrs_enable\""+(_th.enable?"checked":"")+" /></div>"+
                        "<div class=\"u\">"+
                        "</div>"+
                        "<div class=\"ps\">"+
                        "</div>"+
                        "<div class=\"ms\">"+
                        "</div>"+
                        "<div class=\"pms\">"+
                        "</div>"+
                        "</div>");

                    var item=$("#lrs_test_all .item[pid='"+_th.playerId+"']");
                    _th.item=item;
                };
                _th.loopInterval();
            }
        }
    });

}
Player.prototype.receiveUsers = function(users,die){
    var _th=this;
    for (var i = 0; i < users.length; i++) {
        var  p = users[i];
        if(p.d!=die)continue;
        var ac = "lrs_player";
        if (p.nm == null) {
            ac += " lrs_np ";
        }
        if (p.d ) {
            ac = +" lrs_die";
        }
        if(_th.select==p.n){
            ac+=" selU";
        }
        name = p.nm;
        if (p.nm == null) {
            name = "...";
        }
        var extInfo="";
        if(p.p){
            extInfo+="(警长)";
        }
        $(_th.item).find(".ps").append("<div pid=\"" + p.n + "\" class=\"" + ac + "\">" +
            "<span class=\"num\">" + p.n + "</span><span calss=\"name\">"+extInfo+"(" + name + ")</span></div>");

    }
}
Player.prototype.loopInterval = function() {
    var _th=this;
    setInterval(function () {
        if(_th.preComplete){
            _th.preComplete=false;
            // console.log("执行请求");
            if(_th.enable||_th.rcount<=0 ) {
                // alert("可用");
                _th.rcount++;
                _th.getMessage();
            }else{
                _th.preComplete=true;
            };
        }else{
            //console.log("放弃执行请求");
        }
    },3000);
}
Player.prototype.bindEvent =function () {
        var _th =this;
        _th.doneEvent=true;
        var item=$("#lrs_test_all .item[pid='"+_th.playerId+"']");
        $(item).on('change',"input[name=\"lrs_enable\"]",function (){
            if ($(this).is(':checked')) {
                _th.enable=true;
            }else{
                _th.enable=false;
            }
        });
        $(item).find(".ps").on('click','.lrs_player',function (){
            // alert($(this).attr("pid"));
            selClass="selU";
            var userSel= $(this).attr("pid");
            _th.select=userSel;
            // alert(userSel);
            $(this).parent().find(".selU").removeClass(selClass);
            if($(this).hasClass(selClass)){
                $(this).removeClass(selClass);
            }else{
                $(this).addClass(selClass);
            }
        });
        $(item).on('click','.inputLrs #lrs_ok_but',function (){
            if($(this).text()=='发言'){
                _th.chat();
             }else if($(this).text()=='投票'){
                _th.vote();
            }else if($(this).text()=="用毒药"){
                if(_th.select==null){
                    alert("请选择一个人投票");
                    return ;
                }
                _th.witchExt(_th.select);
            }else if($(this).text()=="验人"){
                _th.tell();
            }else if($(this).text()=="狼人杀人"){
                _th.wolve();
            }else if($(this).text()=="禁言"){
                _th.gag();
            }
        });
}
Player.prototype.gag =function () {
    var _th=this;
    if(_th.select==null){
        alert("请选择一个要验的人");
        return ;
    }
    // alert((_th.lastV.vbs)+" =="+_th.select+_th.lastV.vbs.indexOfMy(_th.select));
    if(_th.lastV.vbs.indexOfMy(_th.select)==-1){
        alert("不可用选择此人；可选择有"+ (_th.lastV.vbs));
        return ;
    }
    $.ajax({
        url: "cmd.php",
        data: {
            cmd: "gag",
            roomNum: _th.roomId,
            tid: _th.select,
            pid: _th.playerId
        },
        complete: function(){

        },
        error:  function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(errorThrown);
            _th.preComplete=true;
        },
        success: function (result) {

            if (result.code != 0) {
                alert(result.message);
            } else {
                //alert($(item).html())
                //alert(result.message);
                var item=$("#lrs_test_all .item[pid='"+_th.playerId+"']");
                $(item).find("#lrs_ok_but").attr('disabled',"true");
                $(item).find("#lrs_ok_but").text("禁言成功");
            }
            _th.preComplete=true;
        }
    });
}
Player.prototype.wolve =function () {
    var _th=this;
    var item=$("#lrs_test_all .item[pid='"+_th.playerId+"']");
    if(_th.select==null){
        alert("请选择一个要杀的人");
        return ;
    }
    // alert((_th.lastV.vbs)+" =="+_th.select+_th.lastV.vbs.indexOfMy(_th.select));
    if(_th.lastV.vbs.indexOfMy(_th.select)==-1){
        alert("不可用选择此人；可选择有"+ (_th.lastV.vbs));
        return ;
    }
    $.ajax({
        url: "cmd.php",
        data: {
            cmd: "wolve",
            roomNum: _th.roomId,
            vid: _th.select,
            pid: _th.playerId
        },
        complete: function(){

        },
        error:  function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(errorThrown);
            _th.preComplete=true;
        },
        success: function (result) {
            _th.preComplete=true;
            if (result.code != 0) {
                alert(result.message);
            } else {
                //alert($(item).html())
                if (result.code != 0) {
                    alert(result.message);
                } else {
                    $(item).find("#lrs_ok_but").attr('disabled',"true");
                    $(item).find("#lrs_ok_but").text(result.message);
                }
               /* var item=$("#lrs_test_all .item[pid='"+_th.playerId+"']");
                $(item).find("#lrs_ok_but").attr('disabled',"true");
                $(item).find("#lrs_ok_but").text("已验证"+result.message);*/
            }
        }
    });
}
Player.prototype.tell =function () {
    var _th=this;
    if(_th.select==null){
        alert("请选择一个要验的人");
        return ;
    }
    // alert((_th.lastV.vbs)+" =="+_th.select+_th.lastV.vbs.indexOfMy(_th.select));
    if(_th.lastV.vbs.indexOfMy(_th.select)==-1){
        alert("不可用选择此人；可选择有"+ (_th.lastV.vbs));
        return ;
    }
    $.ajax({
        url: "cmd.php",
        data: {
            cmd: "tell",
            roomNum: _th.roomId,
            tid: _th.select,
            pid: _th.playerId
        },
        complete: function(){

        },
        error:  function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(errorThrown);
            _th.preComplete=true;
        },
        success: function (result) {
            _th.preComplete=true;
            if (result.code != 0) {
                alert(result.message);
            } else {
                //alert($(item).html())
                alert(result.message);
                var item=$("#lrs_test_all .item[pid='"+_th.playerId+"']");
                $(item).find("#lrs_ok_but").attr('disabled',"true");
                $(item).find("#lrs_ok_but").text("已验证"+result.message);

            }
        }
    });
}
Player.prototype.chat =function () {
    var _th = this;
    var item=$("#lrs_test_all .item[pid='"+_th.playerId+"']");
    if(_th.lastV.spk==_th.playerId){
       var text=$(item).find("textarea[name=\"inputMessage\"]").val();
       if(text==''){
           if(!confirm("是否结束发言"+_th.playerId)){
             return ;
           }
       }
        $.ajax({
            url: "cmd.php",
            data: {
                cmd: "chat",
                roomNum: _th.roomId,
                mess: text,
                pid: _th.playerId
            },
            complete: function(){

            },
            error:  function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
                console.log(errorThrown);
                _th.preComplete=true;
            },
            success: function (result) {
                _th.preComplete=true;
                if (result.code != 0) {
                    alert(result.message);
                    $(item).find("#lrs_ok_but").attr('disabled',"true");
                    $(item).find("#lrs_ok_but").text(result.message)
                } else if(text==''){
                    $(item).find("#lrs_ok_but").attr('disabled',"true");
                    $(item).find("#lrs_ok_but").text("结束发言");
                }
                else{
                    //alert($(item).html())
                    //var item=$("#lrs_test_all .item[pid='"+_th.playerId+"']");
                    $(item).find("textarea[name=\"inputMessage\"]").val("");


                }
            }
        });


    }
}
Player.prototype.vote =function () {
   var _th=this;

    var ps=_th.lastPs;
    if(_th.select==null){
        alert("请选择一个人投票");
        return ;
    }
    // alert((_th.lastV.vbs)+" =="+_th.select+_th.lastV.vbs.indexOfMy(_th.select));
    if(_th.lastV.vbs.indexOfMy(_th.select)==-1){
        alert("不可用选择此人；可选择有"+ (_th.lastV.vbs));
        return ;
    }
    $.ajax({
        url: "cmd.php",
        data: {
            cmd: "vote",
            roomNum: _th.roomId,
            vid: _th.select,
            pid: _th.playerId
        },
        complete: function(){

        },
        error:  function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(errorThrown);
            _th.preComplete=true;
        },
        success: function (result) {
            _th.preComplete=true;
            if (result.code != 0) {
                alert(result.message);
            } else {
                //alert($(item).html())
                var item=$("#lrs_test_all .item[pid='"+_th.playerId+"']");
                $(item).find("#lrs_ok_but").attr('disabled',"true");
                $(item).find("#lrs_ok_but").text("投票成功");
            }
        }
    });
}
Player.prototype.witchExt =function (pid) {
    var _th=this;
    $.ajax({
        url: "cmd.php",
        data: {
            cmd: "witch",
            witchOp: _th.witchOp,
            roomNum: _th.roomId,
            wid: pid,
            pid: _th.playerId
        },
        complete: function(){

        },
        error:  function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(errorThrown);
            _th.preComplete=true;
        },
        success: function (result) {

            if (result.code != 0) {
                alert(result.message);
            } else {
                if(pid!=-1){
                    alert(result.message);
                }
                //alert($(item).html())
                //var item=$("#lrs_test_all .item[pid='"+_th.playerId+"']");
                //$(item).find("#lrs_ok_but").attr('disabled',"true");
            }
            _th.preComplete=true;
        }
    });
}
Player.prototype.afterGetMessage =function (result) {
    var _th=this;
    var item=$("#lrs_test_all .item[pid='"+_th.playerId+"']");
   if(_th.lastV!=null&& _th.lastV.vt=='chatOrder'&&_th.lastV.vs!=null&&_th.lastV&&result.g&&!_th.lastV.has){
        var order=1;
        if (confirm("警长请选择是否顺时针发言？")){
            order=-1;
        }
        $.ajax({
            url: "cmd.php",
            data: {
                cmd: "chatOrder",
                roomNum: _th.roomId,
                order: order,
                pid: _th.playerId
            },
            complete: function(){

            },
            error:  function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
                console.log(errorThrown);
                _th.preComplete=true;
            },
            success: function (result) {
                _th.preComplete=true;
                if (result.code != 0) {
                    alert(result.message);
                } else {
                    alert(result.message);
                    //alert($(item).html())
                    //var item=$("#lrs_test_all .item[pid='"+_th.playerId+"']");
                    //$(item).find("#lrs_ok_but").attr('disabled',"true");
                }
            }
        });

    }else  if(_th.lastV!=null&& _th.lastV.vt=='gag'&&_th.lastV.vs!=null&&_th.lastV&&result.g){//y预言
     if(!_th.lastV.has){
         $(item).find("#lrs_ok_but").text("禁言");
         $(item).find("#lrs_ok_but").removeAttr('disabled');
     }else{
         $(item).find("#lrs_ok_but").text("已选择");
         $(item).find("#lrs_ok_but").attr('disabled',"true");
     }
    }else if(_th.lastV!=null&& _th.lastV.vt=='wolve'&&_th.lastV.vs!=null&&_th.lastV&&result.g){//y预言
        if(!_th.lastV.has){
            $(item).find("#lrs_ok_but").text("狼人杀人");
            $(item).find("#lrs_ok_but").removeAttr('disabled');
        }else{
            $(item).find("#lrs_ok_but").text("已选择");
            $(item).find("#lrs_ok_but").attr('disabled',"true");
        }
    }else if(_th.lastV!=null&& _th.lastV.vt=='tell'&&_th.lastV.vs!=null&&_th.lastV&&result.g){//y预言
        if(!_th.lastV.has){
            $(item).find("#lrs_ok_but").text("验人");
            $(item).find("#lrs_ok_but").removeAttr('disabled');
        }else{
            $(item).find("#lrs_ok_but").text("已验人");
            $(item).find("#lrs_ok_but").attr('disabled',"true");
        }
    }  else if(_th.lastV!=null&& _th.lastV.vt=='witch'&&_th.lastV.vs!=null&&_th.lastV&&result.g&&!_th.lastV.has){
        var  vs= _th.lastV.vs;
        $(item).find("#lrs_ok_but").attr('disabled',"true");
        $(item).find("#lrs_ok_but").text("---");
        var witchExt=_th.lastV.ve;
        var lastKill=witchExt.lastPid;
        if(!witchExt.lifeUse){
            if(lastKill!=""&&lastKill!=-1){
                if (confirm("昨晚"+lastKill+"号被杀,你是否会救？")){
                    _th.witchOp="antidote";
                    _th.witchExt(lastKill);
                    return;

                }

            }
        }
        if(!witchExt.killUse){
            if (confirm("你有一瓶毒药，您要用吗，请选择要用玩家？")){
                $(item).find("#lrs_ok_but").removeAttr('disabled');
                $(item).find("#lrs_ok_but").text("用毒药");
                _th.witchOp="poison";
                return;
            }else{
                _th.witchOp="none";
                _th.witchExt(-1);
                return;
            }
        }else {
             alert("您的药物已用完！");
            _th.witchOp="none";
            _th.witchExt(-1);
            return;
        }

    }else if(_th.lastV!=null&& _th.lastV.vt=='normal'&&_th.lastV.vs!=null){
        var  vs= _th.lastV.vs;
        if(vs.indexOfMy(_th.playerId)!=-1){//开始投票
            if(_th.lastV.has){
                $(item).find("#lrs_ok_but").attr('disabled',"true");
                $(item).find("#lrs_ok_but").text("已投票");
            }else{
                $(item).find("#lrs_ok_but").removeAttr('disabled');
                $(item).find("#lrs_ok_but").text("投票");
            }
        }else{
            $(item).find("#lrs_ok_but").attr('disabled',"true");
            $(item).find("#lrs_ok_but").text("确认");
            _th.lastV=null;
        }
        _th.preComplete=true;
    }else if(_th.lastV!=null&& _th.lastV.vt=='chat'){//发言
        if(_th.lastV.spk==_th.playerId&&!_th.lastV.has){
            $(item).find("#lrs_ok_but").removeAttr('disabled');
            $(item).find("#lrs_ok_but").text("发言");

        }else if(_th.lastV.has){
            $(item).find("#lrs_ok_but").attr('disabled',"true");
            $(item).find("#lrs_ok_but").text("结束发言");
        }else if(_th.lastV.vs.indexOfMy(_th.playerId)!=-1){
            $(item).find("#lrs_ok_but").attr('disabled',"true");
            $(item).find("#lrs_ok_but").text("等待发言");
        }else if(_th.lastV.gaps.indexOfMy(_th.playerId)!=-1){
            $(item).find("#lrs_ok_but").attr('disabled',"true");
            $(item).find("#lrs_ok_but").text("禁言");
        }else {
            $(item).find("#lrs_ok_but").attr('disabled',"true");
            $(item).find("#lrs_ok_but").text("投票");
        }
        _th.preComplete=true;
    }else if(_th.lastV!=null&& _th.lastV.vt=='jz'){//竞选警长
        $(item).find("#lrs_ok_but").attr('disabled',"true");
        $(item).find("#lrs_ok_but").text("---");
        if(_th.lastV.has){
            $(item).find("#lrs_ok_but").text("已参选警长");
            return;
        }



        var vid=-11;
        if (confirm("是否参选警长"+_th.playerId)){
            vid= _th.playerId;
        }

        $.ajax({
            url: "cmd.php",
            data: {
                cmd: "vote",
                roomNum: _th.roomId,
                vid: vid,
                pid: _th.playerId
            },
            complete: function(){

            },
            error:  function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
                console.log(errorThrown);
                _th.preComplete=true;
            },
            success: function (result) {
                _th.preComplete=true;
                if (result.code != 0) {
                    alert(result.message);
                } else {
                    //alert($(item).html())
                    var item=$("#lrs_test_all .item[pid='"+_th.playerId+"']");
                    $(item).find("#lrs_ok_but").attr('disabled',"true");
                    if(vid!=-11){
                        $(item).find("#lrs_ok_but").text("参选警长");
                    }else{
                        $(item).find("#lrs_ok_but").text("不参选警长");
                    }
                }
            }
        });
    }else{
        _th.preComplete=true;
    }
}
Player.prototype.getMessage = function(){
    var _th=this;
    $.ajax({
        url: _th.mainUrl,
        data: {
            cmd: "message",
            roomNum: _th.roomId,
            privateId: _th.privateId,
            publicId: _th.publicId,
            pid: _th.playerId
        },
        complete: function(){

        },
        error:  function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(errorThrown);
            _th.preComplete=true;
        },
        success: function (result) {
            if (result.code != 0) {
                alert(result.message);
               // window.location.href = "go.php";
             } else {

                /* if(!_th.doneEvent){
                 _th.bindEvent();
                 }*/
                //接收全部用户状态
                var  users = result.users;
                if(users!=null&&users.length>0){
                    $(_th.item).find(".ps").empty();
                    _th.receiveUsers(users,false);
                    _th.receiveUsers(users,true);
                }
               //接收全部消息 public
                var publicMs = result.ps;
                for (var i = 0; i < publicMs.length; i++) {
                    $(_th.item).find(".ms").append(
                        "<div mid=\""+publicMs[i].mid+"\">"+publicMs[i].message+"</div>"
                    );
                    _th.publicId=publicMs[i].mid;
                }
                //接收全部消息 private
                var privateMs = result.prs;
                for (var i = 0; i < privateMs.length; i++) {
                    $(_th.item).find(".ms").append(
                        "<div mid=\""+privateMs[i].mid+"\">"+privateMs[i].message+"</div>"
                    );
                    _th.privateId=privateMs[i].mid;
                }
                //投票

                // 聊天
                if(result.role=="普通村民"){

               }

               return;

                var item=_th.item;
                _th.ext=result.ext;
                _th.lastV=result.v;
                if(result.g){
                    if(!$(item).hasClass("lrs_group")){
                        $(item).addClass("lrs_group");
                    }
                }else{
                    $(item).removeClass("lrs_group")
                }

                var u = result.u;
                var v = result.v;
                if (u) {
                    var   userName = "";
                    var  roomName = "";
                    if (u.rn != null) {
                        roomName = u.rn;
                    }
                    if (u.nm != null) {
                        userName = u.nm;
                    }
                    $(item).find(".u").html("<div class=\"room\">房间号" + _th.roomId + "" + roomName + "</div>"
                        + "<div class=\"user\">" +/* _th.playerId + "号玩家" +*/ userName + " "+u.r+"</div>");
                }
                ps = result.ps;
                if(ps!=null&&ps.length>0){
                    if(!_th.doneEvent){
                        _th.bindEvent();
                    }
                    _th.lastPs=ps;
                    $(item).find(".ps").empty();
                    _th.onPlayers(ps,false);
                    _th.onPlayers(ps,true);
                }
               var ms = result.ms;

                for (var i = 0; i < ms.length; i++) {
                    $(item).find(".ms").append(
                        "<div mid=\""+ms[i].mid+"\">"+ms[i].message+"</div>"
                    );
                    _th.lastMid=ms[i].mid;
                }
                var  cs = result.cs;
                for (var i = 0; i < cs.length; i++) {
                    $(item).find(".ms").append(
                        "<div mid=\""+cs[i].time+"\">"+cs[i].playerId+"号:"+cs[i].message+" "+cs[i].time+"</div>"
                    );
                    _th.lastCid=cs[i].time;
                }

                var pms = result.pms;

                for (var i = 0; i < pms.length; i++) {
                    $(item).find(".pms").append(
                        "<div mid=\""+pms[i].mid+"\">"+pms[i].message+"</div>"
                    );
                    _th.lastPmid=pms[i].mid;
                }
                //after success message;
                _th.afterGetMessage(result);
            }
        }
    });


};
function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}
$(function(){
    var room=6;
    var  urlRoom=getUrlParam("r");
    if(urlRoom!=null)room=urlRoom;
    var count=1;
    var ps = new Array(count)
    for(var i=0;i<count;i++){
        var p1=new Player(room,i+1,false);
        p1.loop();
        ps.push(p1);
    }

});
