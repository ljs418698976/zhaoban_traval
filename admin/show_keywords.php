<!DOCTYPE html>
<!--STATUS OK-->
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<script>var baidu;var verticalData = null;var doubtBlackList = false;var isRainbow = false;</script>
<title>找伴去旅行 关键词列表信息</title>
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
    width:80%;
  }
  .width-num-td-table {
    width:20%;
  }
</style>
</head>
<?php
$mysql = new SaeMysql();
$uid = $_REQUEST['uid'];
//echo $uid;

require_once("../class/page_class.php"); 
//每页显示的条数 
  $page_size=10; 
//总条目数 
  $sql="SELECT count(*) as count from guanjianci where uid='{$uid}'";
  $count = $mysql->getData( $sql );
  $nums=$count[0]['count']; 
//每次显示的页数 
  $sub_pages=10; 
//得到当前是第几页 
	if( isset($_GET['p']) ){
           $pageCurrent = intval( $_GET['p'] );
        }
        else{
           $pageCurrent = 1;
        } 
// $pageCurrent=$_GET["p"]; 
  //if(!$pageCurrent) $pageCurrent=1; 
     

  
$offset = $pageCurrent*$page_size-$page_size;


$sql="SELECT * from guanjianci where uid='{$uid}'  limit ". ($pageCurrent-1)*$page_size .", $page_size";
$data = $mysql->getData( $sql );
//print_r($data);
$num=0;
?>
<body>
<center>
<table>
  <tr>
  <td colspan="2">我的关键词列表</td>
  </tr>
  <tr>
    <td class="width-num-td-table">
    序号
    </td>
    <td class="width-td-table">
    关键词
    </td>
    
  </tr>
  <?php foreach($data as $datas){
  $num++;
  ?>
  <tr>
    <td class="width-num-td-table">
    <?php echo $num;?>
    </td>
    <td class="width-td-table">
      <a href="keyword_info.php?id=<?php echo $datas['id']?>"><?php echo $datas['guanjianci']?></a>
    </td>
  </tr>
  <?php }?>
  <tr><td colspan="2"><?php   $subPages=new SubPages($page_size,$nums,$pageCurrent,$sub_pages,"show_keywords.php?uid={$uid}&p=",2);  ?></td></tr>
</table>
</center>
</body>