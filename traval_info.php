<!DOCTYPE html>
<!--STATUS OK-->
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<script>var baidu;var verticalData = null;var doubtBlackList = false;var isRainbow = false;</script>
<title>找伴去旅行 旅游信息</title>
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
$id = $_GET['id'];
$mysql = new SaeMysql();
$sql="SELECT t.id as tnum, u.id as unum, t.create_time,t.traval_content, u.weixin FROM traval as t INNER JOIN user as u ON t.uid = u.uid where t.id={$mysql->escape($id)}";
$data = $mysql->getData( $sql );
//print_r($data);
?>
<body>
<center>
<table>
  <tr>
  <td>旅游信息</td>
  </tr>
  <tr>
    <td class="width-td-table">
    内容
    </td>
  </tr>
 <tr>
    <td class="width-td-table">
      <textarea rols="5" cols="30" name="textarea"><?php echo $data[0]['traval_content']?></textarea>
    </td>
  </tr>
  <tr>
    <td class="width-td-table">
    微信号：<?php echo $data[0]['weixin']?>
    </td>
  </tr>
  <tr>
    <td class="width-td-table">
    时间：<?php echo $data[0]['create_time']?>
    </td>
  </tr>

</table>
</center>
</body>