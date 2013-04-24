<?php

//$mysql = new SaeMysql();
//$sql="SELECT * FROM biaoqing ";
//$data = $mysql->getData( $sql );
/*
$fp_in = fopen('./city_weather.txt', "r");
$city_weather_arr = array();
while (!feof($fp_in)) {
$line = fgets($fp_in);
 if(!strpos($line,'=')){
  	continue;
  }
  $u_arr = explode('=', $line);//如果有分割
   $city_weather_arr[$u_arr[0]] = $u_arr[1];
    
}
*/

//$biaoqing_arr = array();
//foreach ($data as $datas){
  //$biaoqing_arr[$datas['expression_name']] = $datas['exprssion_code'];
// echo $datas['exprssion_code'];
//}
$url="http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5MDA3ODc0MQ==&appmsgid=10000008&itemidx=1&uin=Njg5MjI3MTYw&key=91ddb0ec2d72afe50af6c5626beeb6803ee27de482cb3413f3362443b6ae47c76a275093fce31bcda5596f81fdd17ec6c19595264ce4c3e556101954c8fa7cb552c695a0cdf1b7204be9305379093b3d9a9cb709c73272e4c515dd5cfdca630b5c9c27079c937dac73c87e1ba44f1c0e6975307116acb357bebae18d7da5614e&devicetype=android-15&version=24050101";
$content = file_get_contents($url);
preg_match_all('/<title>(.*)<\/title>/sim', $content, $title);
$title = $title[1][0];
preg_match_all('/<IMG.*?src="(.*?)".*?>/sim', $content, $img);
$img = $img[1][0];
preg_match_all('/<script\sid="txt-desc".*>(.*)<\/script>/', $content, $dsc);
$dsc = $dsc[1][0];
echo '<pre>';
print_r($title);
print_r($img);
print_r($dsc);
echo '</pre>';
 preg_match_all('/<td width="516" height="28" class="z14"><a href="(.*?)" target="_blank">.*?<\/a><\/td>/sim', $content, $url_newslist);
 //print_r($url_newslist);
echo '<pre>';
//print_r($content);
echo '</pre>';
?>