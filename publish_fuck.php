<!DOCTYPE html>
<!--STATUS OK-->
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<script>var baidu;var verticalData = null;var doubtBlackList = false;var isRainbow = false;</script>
<title>我要骂人</title>
<meta name="Description" content="我要骂人" />
<meta name="Keywords" content="我要骂人" />
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
    	查看我的骂人信息
    </td>
  </tr>
   <tr>
    <td>
        <textarea cols="30" rows="5" name="textarea">
								</textarea>
							<span class="red">*</span>
       <br /><span>一次发布一条，最好把自己的所有骂人信息都加进来，多多发布</span>
    </td>
  </tr>
  
   <tr>
    <td>
    	<input type="submit" name="tijiao" value="提交旅游信息" />
    </td>
  </tr>
  <tr>
    <td>
      查看我的骂人信息，请点击<a href="show_fuck.php">查看我的骂人信息</a>
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
      				$sql = "INSERT  INTO `fuck` ( `uid` , `fuck_content` , `create_time` ) VALUES ( '"  . $fromUsername . "' , '" . $mysql->escape( $textarea ) . "' , NOW() ) ";
      				$mysql->runSql( $sql );
      				echo "<span class='red'>发布骂人信息成功</span>";
      
		}else{
			echo '<a href="#" class="red">非法操作，请通过微信公共账号接入</a>';
		}
	}else{
		echo '<a href="#" class="red">用户信息需要全部填写，这样别人才能联系到你</a>';
	}
	
}


$mysql->closeDb();
?>