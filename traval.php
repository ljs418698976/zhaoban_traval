<!DOCTYPE html>
<!--STATUS OK-->
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<script>var baidu;var verticalData = null;var doubtBlackList = false;var isRainbow = false;</script>
<title>找伴去旅行 旅游列表信息</title>
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
    width:auto;
  }
  .width-num-td-table {
    width:20px;
  }
</style>
</head>
<?php
$mysql = new SaeMysql();
$sql="SELECT t.id as tnum, u.id as unum, t.create_time,t.traval_content, u.weixin FROM traval as t INNER JOIN user as u ON t.uid = u.uid order by t.create_time desc limit 10";
$data = $mysql->getData( $sql );
//print_r($data);
$num=0;
?>
<body>
<center>
<table>
  <tr>
  <td colspan="2">旅游信息列表</td>
  </tr>
  <tr>
    <td class="width-num-td-table">
    序号
    </td>
    <td class="width-td-table">
    标题
    </td>
    
  </tr>
  <?php foreach($data as $datas){
  $create_time=explode(' ', $datas['create_time']);
  $num++;
  ?>
  <tr>
    <td class="width-num-td-table">
    <?php echo $num;?>
    </td>
    <td class="width-td-table">
      <a href="traval_info.php?id=<?php echo $datas['tnum']?>"><?php echo $datas['traval_content']?></a>
    </td>
  </tr>
  <?php }?>
</table>
</center>
</body>