<!DOCTYPE html>
<!--STATUS OK-->
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<script>var baidu;var verticalData = null;var doubtBlackList = false;var isRainbow = false;</script>
<title>找伴去旅行 关键词信息</title>
<meta name="Description" content="找伴去旅行，找个伙伴一起去旅行" />
<meta name="Keywords" content="找伴去旅行 找伴 旅行 zhaoban_traval" />
<link href="/static/usercenter/css/liteoutput/bk.uc_lemma.css" rel="stylesheet" type="text/css" />
<style>
  body {

  }
  table {
    width:100%;
    text-align:center;
  }
  
  td {border-bottom:1px dashed #000000;}
  .width-td-table {
    width:25%;
  }
  .width-num-td-table {
    width:10%;
  }
</style>
</head>
<?php
$id = $_REQUEST['id'];
//echo $id;
$mysql = new SaeMysql();

if(isset($_POST['update'])){
	$guanjianci 	= $_POST['guanjianci'];
        $huifu 		= $_POST['huifu'];
  	$sql = "UPDATE `app_zhaoban`.`guanjianci` SET `guanjianci` = '".$mysql->escape( $guanjianci )."', `huifu` = '".$mysql->escape( $huifu )."' WHERE `guanjianci`.`id` = {$id};";
        $data = $mysql->runSql( $sql );
	
        if($data){
        	echo '更新成功';
        }else{
        	echo '更新失败';
        }
}
$sql="SELECT * from guanjianci where id={$mysql->escape($id)}";
$data = $mysql->getData( $sql );
//print_r($data);
?>
<body>
<center>
<form action="" method="post">
<table>
  <tr>
  <td>关键词信息</td>
  </tr>
  <tr>
    <td class="width-td-table">
    关键词
    </td>
  </tr>
 <tr>
    <td class="width-td-table">
      <input type="text" name="guanjianci" value="<?php echo $data[0]['guanjianci'];?>" />
    </td>
  </tr>
  <tr>
    <td class="width-td-table">
    回复
    </td>
  </tr>
 <tr>
    <td class="width-td-table">
      <textarea rols="5" cols="30" name="huifu"><?php echo $data[0]['huifu']?></textarea>
    </td>
  </tr>
  <tr>
    <td class="width-td-table">
        <input type="hidden" name="id" value="<?php echo $id;?>" />
    </td>
  </tr>
  <tr>
    <td class="width-td-table">
      <input type="submit" name="update" value="修改" /><a href="show_keywords.php?uid=<?php echo $data[0]['uid'];?>"><input type="button" name="" value="回到关键词列表" /></a>
    </td>
  </tr>
</table>
</form>
</center>
</body>