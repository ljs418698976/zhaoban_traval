<!DOCTYPE html>
<!--STATUS OK-->
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<script>var baidu;var verticalData = null;var doubtBlackList = false;var isRainbow = false;</script>
<title>找伴去旅行 关键词</title>
<meta name="Description" content="找伴去旅行，找个伙伴一起去旅行" />
<meta name="Keywords" content="找伴去旅行 找伴 旅行 zhaoban_traval" />
<link href="/static/usercenter/css/liteoutput/bk.uc_lemma.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery-1.9.1.min.js"></script>
<style>
  body {

  }
  table {
    width:100%;
    text-align:center;
  }
  
  td {border-bottom:1px dashed #000000;}
  .width-td-table {
    width:auto;
  }
  .width-num-td-table {
    width:20px;
  }
  .red {
    font-color:red;
    color:red;
  }
  .weight {
    font-weight:bond;
  }
</style>
<script type="text/javascript">
    function add_huifu(){
      $("#huifu_textarea").append("<br /><textarea cols=\"30\" rows=\"5\" name=\"huifu[]\"></textarea>");
    }
    function check_null(){
      if(''== $('#guanjianci').val()){
      	alert('关键词不能为空');
        return false;
      }
      if(''== $('#huifu1').val()){
      	alert('回复不能为空');
        return false;
      }
    }
</script>
</head>
<?php
$uid = $_REQUEST['uid'];
//echo $uid;

?>
<body>
<center>
<form action="post_keyword.php" method="post" onsubmit="return check_null();">
<table>
      <tr>
        <td>请输入关键词</td>
      </tr>
      <tr>
        <td><input type="text" name="guanjianci" id="guanjianci" value=""/><br /><span class="red weight">多个关键词之间用空格分开</span></td>
      </tr>
      <tr>
        <td>请输入回复信息</td>
      </tr>
      <tr>
        <td id="huifu_textarea"><textarea cols="30" rows="5" id="huifu1" name="huifu[]"></textarea><br /><span class="red weight">多条回复在显示时候会以随机形式显示一条</span></td>
      </tr>
       <tr>
        <td>
          <input type="hidden" name="uid" value="<?php echo $uid;?>" />
        </td>
      </tr>
      <tr>
        <td>
          <input type="submit" name="submit" value="提交" /><a href="show_keywords.php?uid=<?php echo $uid;?>"><input type="button" name="show_keywords" value="查看关键词" /></a><input type="button" onclick="add_huifu()" value="增加一条回复"/>
        </td>
      </tr>
</table>
</form>
</center>
</body>
</html>