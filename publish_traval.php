<!DOCTYPE html>
<!--STATUS OK-->
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<script>var baidu;var verticalData = null;var doubtBlackList = false;var isRainbow = false;</script>
<title>找伴去旅行 发布旅游信息</title>
<meta name="Description" content="找伴去旅行，找个伙伴一起去旅行" />
<meta name="Keywords" content="找伴去旅行 找伴 旅行 zhaoban_traval" />
<link href="/static/usercenter/css/liteoutput/bk.uc_lemma.css" rel="stylesheet" type="text/css" />
  <script src="js/jquery-1.9.1.min.js"></script>
<script src="js/vanadium.js"></script>
<style>
  body {
    text-align:center;
  }
  table {
    width:100%;
    text-align:center;
  }
  .width-td-table {
    width:25%;
  }
  .width-num-td-table {
    width:10%;
  }
  .red {
	color:red;
  }
</style>
</head>
<body>

<form name="publish_traval" action="" method="post">
<table>
  <tr>
    <td>
    	发布旅游信息
    </td>
  </tr>
   <tr>
    <td>
        <textarea cols="30" rows="5" name="textarea">
								</textarea>
							<span class="red">*</span>
       <br /><span>最好把自己的所有旅游信息都描述清楚，比如时间、地点、人员等禁止在此发布广告，如果发现多次会被拉入我们的黑名单哦</span>
    </td>
  </tr>
  
   <tr>
    <td>
    	<input type="submit" name="tijiao" value="提交旅游信息" />
    </td>
  </tr>
  <tr>
    <td>
      在提交之前需要用户填写个人信息，以便伙伴能够联系到您，如果没有注册，请点击<a href="userinfo.php"><input type="button" name="register" value="注册个人信息" /></a>
    </td>
  </tr>
  <tr>
    <td>
      查看旅游信息，请点击<a href="traval.php">查看旅游信息</a>
    </td>
  </tr>
</table>
</form>

</body>
<?php
$mysql = new SaeMysql();
$fromUsername = $_GET['num'];
$textarea = trim($_POST['textarea']);

if(isset($_POST['tijiao'])){
	if(!empty($textarea)){
		if(isset($fromUsername)){
      $sql="select * from user where uid='{$fromUsername}'";
      $data = $mysql->getData( $sql );
      if(empty($data)){
        echo "<span class='red'>用户还没有注册，请先注册填写个人信息</sapn>";
      }else{
      				$sql = "INSERT  INTO `traval` ( `uid` , `traval_content` , `create_time` ) VALUES ( '"  . $fromUsername . "' , '" . $mysql->escape( $textarea ) . "' , NOW() ) ";
      				$mysql->runSql( $sql );
      				echo "<span class='red'>发布旅游信息成功</span>";
      }
		}else{
			echo '<a href="#" class="red">非法操作，请通过微信公共账号接入</a>';
		}
	}else{
		echo '<a href="#" class="red">用户信息需要全部填写，这样别人才能联系到你</a>';
	}
	
}


$mysql->closeDb();
?>