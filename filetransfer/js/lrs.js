/**
 * Created by user on 2017/3/24.
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

    Array.prototype.indexOfMy = function (obj) {
        for (var i = 0; i < this.length; i++) {
            if (this[i] == obj) {
                return i;
            }
        }
        return -1;
    }
String.prototype.startWith=function(str){
    var reg=new RegExp("^"+str);
    return reg.test(this);
}

String.prototype.endWith=function(str){
    var reg=new RegExp(str+"$");
    return reg.test(this);
}
$(function(){
    var  roomNum= $.cookie('roomNum');
    var  pid= $.cookie('pid');
   if(!isNull(roomNum)&&!isNull(pid)){
       var url=window.location.href;
       var  playUrl="play.php";
        if(!url.endWith(playUrl)){
            window.location.href=playUrl;
        }
   }

})