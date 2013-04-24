<!DOCTYPE html>
<!--STATUS OK-->
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>找伴去旅行后台登陆</title>
<meta name="Description" content="找伴去旅行，找个伙伴一起去旅行" />
<meta name="Keywords" content="找伴去旅行 找伴 旅行 zhaoban_traval" />
<link href="/static/usercenter/css/liteoutput/bk.uc_lemma.css" rel="stylesheet" type="text/css" />
<style>
  body {
    text-align:center;
    width:auto;
    font-size:15px;
  }
  table {
    width:100%;
  }
  .width-td-table {
    width:25%;
  }
  .width-num-td-table {
    width:10%;
  }
</style>
</head>
<?php
$uid = $_REQUEST['uid'];
//echo $uid;
if(isset($_POST['submit'])){
	$mysql = new SaeMysql();
        
        $username=trim($_POST['username']);
        $password=trim($_POST['password']);
        //echo $username.'dd'.$password;
        $sql="SELECT * from admin_users where username={$username} and password={$password}";
        $data = $mysql->getData( $sql );
        if(!empty($data))
        {
          echo "<script language=\"javascript\">alert('登录成功');window.location.href=\"guanjianci.php?uid={$uid}\";</script>";	
        }else{
                echo '输入错误，请重新输入';
        }
	$mysql->closeDb();
}


?>
<body>
  <h1>管理员登录</h1>
<br />
 <form action="" method="post">
  <table>
      <tr>
        <td>
          用户名：<input type="text" value="" name="username"/>
        </td>
      </tr>
      <tr>
        <td>
          密码：<input type="text" value="" name="password"/>
        </td>
      </tr>
      <tr>
        <td>
          <input type="hidden" name="uid" value="<?php echo $uid;?>" />
        </td>
      </tr>
      <tr>
        <td>
          <input type="submit" name="submit" value="登录" />
        </td>
      </tr>
  </table>
 </form>
</body>

