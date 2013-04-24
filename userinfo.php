<!DOCTYPE html>
<!--STATUS OK-->
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<script>var baidu;var verticalData = null;var doubtBlackList = false;var isRainbow = false;</script>
<title>找伴去旅行 个人资料</title>
<meta name="Description" content="找伴去旅行，找个伙伴一起去旅行" />
<meta name="Keywords" content="找伴去旅行 找伴 旅行 zhaoban_traval" />
<link href="/static/usercenter/css/liteoutput/bk.uc_lemma.css" rel="stylesheet" type="text/css" />
  <script src="js/jquery-1.9.1.min.js"></script>
<script src="js/vanadium.js"></script>
<style>
  body {
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
<center>
<form name="userinfo" action="" method="post">
<table>
  <tr>
    <td>
    	个人资料
    </td>
  </tr>
   <tr>
    <td>
        姓名<input type="text" name="name" value="" /><span class="red">*</span>
    </td>
  </tr>
   <tr>
    <td>
    	性别<input type="text" name="sex" value="" /><span class="red">*</span>
    </td>
  </tr>
   <tr>
    <td>
    	微信号<input type="text" name="weixin" value="" /><span class="red">*</span>
    </td>
  </tr>
   <tr>
    <td>
    	<input type="submit" name="tijiao" value="提交资料" />
    </td>
  </tr>
  <tr>
    <td>
      如果已经注册了个人信息，可以直接点击发布旅游信息按钮<a href="publish_traval.php"><input type="button" name="register" value="发布旅游信息" /></a>
    </td>
  </tr>
  <tr>
    <td>
      查看旅游信息，请点击<a href="traval.php">查看旅游信息</a>
    </td>
  </tr>
</table>
</form>
</center>
</body>
<?php
$mysql = new SaeMysql();
$fromUsername = $_GET['num'];
$name = trim($_POST['name']);
$sex = trim($_POST['sex']);
$weixin = trim($_POST['weixin']);

if(isset($_POST['tijiao'])){
	if(!empty($name) && !empty($sex) && !empty($weixin)){
		if(isset($fromUsername)){
			$sql="select * from user where uid='{$fromUsername}'";
			$data = $mysql->getData( $sql );
			if(empty($data)){
                            $sql = "INSERT  INTO `user` ( `uid`, `name` , `sex`  , `weixin` ) VALUES ( '"  . $fromUsername . "' , '" . $name . "' , '" . $sex. "', '" . $weixin . "') ";
                            $mysql->runSql( $sql );
                            echo "创建用户成功";

			}else{
                            $sql = "UPDATE `app_zhaoban`.`user` SET `name` = '".$name."',`sex` = '".$sex."',`weixin` = '".$weixin."' WHERE `user`.`uid` ='{$fromUsername}'";
                            $mysql->runSql( $sql );
                            echo "修改用户成功";

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