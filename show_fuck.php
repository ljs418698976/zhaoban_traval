<!DOCTYPE html>
<!--STATUS OK-->
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<script>var baidu;var verticalData = null;var doubtBlackList = false;var isRainbow = false;</script>
<title>我的骂人信息</title>
<meta name="Description" content="我的骂人信息" />
<meta name="Keywords" content="我的骂人信息" />
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
$mysql = new SaeMysql();
$sql="SELECT * FROM fuck  order by create_time desc";
$data = $mysql->getData( $sql );
$num=0;
?>
<body>
<center>
<table>
  <tr>
  <td colspan="3">我的骂人列表</td>
  </tr>
  <tr>
    <td class="width-num-td-table">
    序号
    </td>
    <td class="width-td-table">
    我的骂人
    </td>
    <td class="width-td-table">
    时间
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
    <?php echo $datas['fuck_content']?>
    </td>
    <td class="width-td-table">
    <?php echo $create_time[0]?>
    </td>
  </tr>
  <?php }?>
</table>
</center>
</body>