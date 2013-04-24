<?php
require "./class/common.inc.php";
/**
  * wechat php test
  */

//数据库连接
$conn = mysql_connect("localhost","223546","ljs578721") or die("无法连接数据库");
mysql_select_db("223546" ,$conn) or die ("找不到数据源");
mysql_query("set names utf8"); 
//$sql="select * from guanjianci";
//$data = getData($sql);
//print_r($data);exit;

//define your token
define("INDEXURL", "http://www.happinessboy.com/zhaoban/");
define("TOKEN", "zhaoban");

define("BAIDUMAPURL", "http://www.happinessboy.com/zhaoban/baidumap.php");

//大众点评
define('APPKEY','2710684315');
//AppSecret 信息，请替换
define('SECRET','49b277e6bf9943a19b0b43e542d2858f');
//API 请求地址
define('URL', 'http://api.dianping.com/v1/business/find_businesses');


include "city_weather_arr.php";

$wechatObj = new zhaoban_traval($config_arr);
//首次使用，请注释掉下面的一行代码。
//然后添加  $wechatObj->valid(); 供首次验证需要
//验证成功后,即可以使用下面的代码
//$wechatObj->valid();
$wechatObj->responseMsg();

class zhaoban_traval
{
	private $biaoqing = array();
    private $config_arr;
    private $limit=5;
    public function __construct($arr){
          $this->config_arr = $arr;
    }

	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		
      	//extract post data
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $MsgType = $postObj->MsgType;
				$time = time();
				$msgType = $MsgType;
                
				if('text' == $msgType){
					$keyword = trim($postObj->Content);
                    $textTpl = "<xml>
                          <ToUserName><![CDATA[%s]]></ToUserName>
                          <FromUserName><![CDATA[%s]]></FromUserName>
                          <CreateTime>%s</CreateTime>
                          <MsgType><![CDATA[%s]]></MsgType>
                          <Content><![CDATA[%s]]></Content>
                          <FuncFlag>0</FuncFlag>
                          </xml>";
					if(!empty( $keyword ))
					{
						$msgType = "text";
						$keyword_arr = explode('#', $keyword);
                      	$sql="select * from guanjianci where guanjianci='{$keyword}'";
                          //$data = $mysql->getData( $sql );
						//$re = mysql_query($sql);
						$data = getData($sql);
                        if(!empty($data)){
                                  $count=count($data);
                                  if(1 < $count){
                                          $contentStr = $data[array_rand($data, 1)]['huifu'];		//array_rand() 函数从数组中随机选出一个或多个元素，并返回。
                                  }else{
                                          $contentStr = $data[0]['huifu'];
                                  }
                                  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						} else if('小说' == $keyword){
							$contentStr = "点击进入<a href=\"http://yuedu.baidu.com/\">小说页面</a>";
							$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						} else if('歌曲' == $keyword){
							$contentStr = "点击进入<a href=\"http://music.baidu.com/\">歌曲页面</a>";
							  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						}
						else if('翻译' == $keyword){
							$contentStr = "点击进入<a href=\"http://fanyi.baidu.com/\">翻译页面</a>";
							  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						}
						else if('后台' == $keyword){
							$contentStr = "点击进入<a href=\"http://zhaoban.sinaapp.com/admin/?uid={$fromUsername}\">后台登录页面</a>";
							  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						}else if(array_search($keyword, $this->config_arr['personal_info'])){
                                    $sql="select * from user where uid='{$fromUsername}'";
                                    $data = getData( $sql );
                                    switch($keyword) { 
                                            case '姓名':
                                            $contentStr = empty($data[0]['name']) ? "您还没有填写姓名，请输入“创建#创建项#创建的内容”\n例如“创建#姓名#小王”" : "您的姓名：".$data[0]['name'];
                                            break;
                                            case '性别':
                                            $contentStr = empty($data[0]['sex']) ? "您还没有填写性别，请输入“创建#创建项#创建的内容”\n例如“创建#性别#男”" : "您的性别：".$data[0]['sex'];
                                            break;
                                            case '微信':
                                            $contentStr = empty($data[0]['weixin']) ? "您还没有填写微信号，请输入“创建#创建项#创建的内容”\n例如“创建#微信#456431351”" : "您的微信：".$data[0]['weixin'];
                                            break;
                                    }
                                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        }else if('音乐' == $keyword){
                                                          $contentStr = '';
                                                  foreach ($this->config_arr['推荐歌曲'] as $music_choose){
                                                   $contentStr .= "歌曲：".$music_choose['name']."\n链接：".$music_choose['musicurl']."\n";
                                                          
                                                          }
                                    $textTpl = "<xml>
                                                            <ToUserName><![CDATA[%s]]></ToUserName>
                                                            <FromUserName><![CDATA[%s]]></FromUserName>
                                                            <CreateTime>%s</CreateTime>
                                                            <MsgType><![CDATA[%s]]></MsgType>
                                                            <Content><![CDATA[%s]]></Content>
                                                            <FuncFlag>0</FuncFlag>
                                                            </xml>"; 
                                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr); 
                        }else if('旅游' == $keyword){
                                    $msgType='news';
                                    $sql="select * from traval  order by create_time desc limit 5";
                                    $data = getData( $sql );
                                    $num_data = count($data);
                                    $contentStr="最新旅游信息：\n";
                                    $num = 1;
                                    $items='';
                                    $PicUrl = INDEXURL.'images/logo.jpg';
                                    $Url="http://zhaoban.sinaapp.com/traval.php";
                                     foreach($data as $datas){
                                             $items.="<item>
                                                                   <Title><![CDATA[".$num." ".$datas['traval_content']."]]></Title> 
                                                                   <Description><![CDATA[".$datas['traval_content']."]]></Description>
                           <PicUrl><![CDATA[".$PicUrl."]]></PicUrl>
                                                                   <Url><![CDATA[".$Url."]]></Url>
                                                                   </item>
                                                                   ";
                                                  $num++;
                                          }
                                     
                                          $textTpl = "<xml>
                                                             <ToUserName><![CDATA[%s]]></ToUserName>
                                                             <FromUserName><![CDATA[%s]]></FromUserName>
                                                             <CreateTime>%s</CreateTime>
                                                             <MsgType><![CDATA[%s]]></MsgType>
                                                             <ArticleCount>".$num_data."</ArticleCount>
                                                             <Articles>"
                                                             .$items."
                                                             </Articles>
                                                             <FuncFlag>1</FuncFlag>
                                                             </xml> "; 
                                   
                                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType);

                            } else if('个人信息' == $keyword){
                                    $sql="select * from user where uid='{$fromUsername}'";
                                    $data = getData( $sql );
                                    if($data){
                                            if(empty($data[0]['name']) || empty($data[0]['sex']) || empty($data[0]['weixin'])){
                                                  $contentStr="我的个人信息：\n姓名：{$data[0]['name']}\n性别：{$data[0]['sex']}\n微信：{$data[0]['weixin']}\n个人资料不全，快来把资料补齐吧，要不然发不了信息哦，输入“发布”\nhttp://zhaoban.sinaapp.com/userinfo.php?num={$fromUsername}";
                                            } else {
                                              $contentStr="我的个人信息：\n姓名：{$data[0]['name']}\n性别：{$data[0]['sex']}\n微信：{$data[0]['weixin']}\n想修改个人信息的话请输入“创建#修改项#修改内容”，例如：“创建#姓名or性别or微信#小顺子”\n或者点击<a href=\"http://zhaoban.sinaapp.com/userinfo.php?num={$fromUsername}\">个人信息</a>";
                                            }
                                    }else{
                                                  $contentStr="您还没有个人信息，快来填写吧\n<a href=\"http://zhaoban.sinaapp.com/userinfo.php?num={$fromUsername}\">个人信息</a>";
                                    }
                                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            }else if("发布9" == $keyword){
                              $contentStr = "点击<a href=\"http://zhaoban.sinaapp.com/publish_traval.php?num={$fromUsername}\">发布旅游信息</a>";
                                  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            }else if(false !== strpos($keyword, '创建')){
                                    $info_add = explode('#', $keyword);
                                    if(isset($info_add[0]) && isset($info_add[1])){
                                           if('姓名' == $info_add[1]){
                                                  $sql="select * from user where uid='{$fromUsername}'";
                                                  $data = getData( $sql );
                                                  if(empty($data)){
														$sql = "INSERT  INTO `user` ( `uid` , `name` ) VALUES ( '"  . $fromUsername . "' , '" . trim( $info_add[2] ) . "') ";
														mysql_query( $sql );
														$contentStr = "创建".$info_add[1].'成功';

												  }else{
														$sql = "UPDATE `user` SET `name` = '".trim( $info_add[2] )."' WHERE `user`.`uid` ='{$fromUsername}'";
														mysql_query( $sql );
														$contentStr = "修改".$info_add[1].'成功';

												  }
                                                  
                                           }else if('性别' == $info_add[1]){
                                                  $sql="select * from user where uid='{$fromUsername}'";
                                                  $data = getData( $sql );
                                                  if(empty($data)){
														  $sql = "INSERT  INTO `user` ( `uid` , `sex` ) VALUES ( '"  . $fromUsername . "' , '" . trim( $info_add[2] ) . "') ";
													      mysql_query( $sql );
														  $contentStr = "创建".$info_add[1].'成功';

												  }else{
														  $sql = "UPDATE `user` SET `sex` = '".trim( $info_add[2] )."' WHERE `user`.`uid` ='{$fromUsername}'";
														  mysql_query( $sql );
														//	$contentStr = $sql;
														  $contentStr = "修改".$info_add[1].'成功';

												  }

                                           }else if('微信' == $info_add[1]){
                                                  $sql="select * from user where uid='{$fromUsername}'";
                                                  $data = getData( $sql );
                                                  if(empty($data)){
														$sql = "INSERT  INTO `user` ( `uid` , `weixin` ) VALUES ( '"  . $fromUsername . "' , '" . trim( $info_add[2] ) . "') ";
														mysql_query( $sql );
														$contentStr = "创建".$info_add[1].'成功';

												  }else{
														$sql = "UPDATE `user` SET `weixin` = '".trim( $info_add[2] )."' WHERE `user`.`uid` ='{$fromUsername}'";
														mysql_query( $sql );
														$contentStr = "修改".$info_add[1].'成功';
												  }

                                           }else if('信息' == $info_add[1]){
                                                  $sql="select * from user where uid='{$fromUsername}'";
												  $data = getData( $sql );
                                                  if(empty($data[0]['name']) || empty($data[0]['sex']) || empty($data[0]['weixin'])){
                                                       $contentStr = "用户信息不完全，为了让伙伴联系上你，需要填写完整才可以发布旅游信息\n输入“个人信息”，查看自己哪个没有填写";

												  }else{
													   $sql = "INSERT  INTO `traval` ( `uid` , `traval_content` , `create_time` ) VALUES ( '"  . $fromUsername . "' , '" . trim( $info_add[2] ) . "' , NOW() ) ";
													   mysql_query( $sql );
													   $contentStr = "创建".$info_add[1].'成功';
												  }
                                                          

                                           }
                                          //$contentStr = "创建".$info_add[1].'成功';
                                           $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                                           
                                    }
                                   
                            }else if('天气' == $keyword){
                                          $contentStr = "请输入所在城市的名称\n格式：[天气#北京]";
                                          $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            }else if(false !== strpos($keyword, '天气')){
                                  if(!empty($keyword_arr[1])){
												  if(array_search($keyword_arr[1], $this->config_arr['city_weather_arr'])){
																																																										  $getweather = new getweather($this->config_arr['city_weather_arr']);
																								  $contentStr=$getweather->getw($keyword_arr[1]);
												  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
												  } else {
								  $contentStr = "输入格式有误或者该城市查询不到\n格式：[天气#北京]";
																				  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);                 
                                           }
                                  }
                                  
                            }
                    
                                                  //高兴的表情		
                      //else if(array_search($keyword, $this->config_arr['gaoxing'])){
                      //               $contentStr = $this->config_arr['gaoxing_answer'][array_rand($this->config_arr['gaoxing_answer'], 1)];
                      // //               $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                      //    }
                            //难过的表情
                      //    else if(array_search($keyword, $this->config_arr['nanguo'])){
                      //                                                  $contentStr = $this->config_arr['nanguo_answer'][array_rand($this->config_arr['nanguo_answer'], 1)];
                      //              $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                      //   }
                            else if('表情' == $keyword){

                                          $filename = "biaoqing.txt"; 
                                          $file = fopen($filename, "a+");      //以写模式打开文件 
                                          fwrite($file, "Hello, world!\n");      //写入第一行 
                                          fwrite($file, "This is a test!\n");      //写入第二行 
                                          fclose($file);         //关闭文件 

                                          $contentStr = "表情\r\n";
                                          $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            }
                                                  //用户输入文档，会回复图文信息
                            else if('文档' == $keyword || 'wd' == $keyword){
                                          $msgType='news';
                                          $Url=$this->config_arr['wendang']['url'];
                                          $content = file_get_contents($Url);
                                          preg_match_all('/<title>(.*)<\/title>/sim', $content, $title);
                                          $title = $title[1][0];
                                          preg_match_all('/<IMG.*?src="(.*?)".*?>/sim', $content, $picurl);
                                          $picurl = $picurl[1][0];
                                          preg_match_all('/<script\sid="txt-desc".*>(.*)<\/script>/', $content, $des);
                                          $des = $des[1][0];
                                          $content = file_get_contents($Url);
                                          $textTpl = "<xml>
                                                             <ToUserName><![CDATA[%s]]></ToUserName>
                                                             <FromUserName><![CDATA[%s]]></FromUserName>
                                                             <CreateTime>%s</CreateTime>
                                                             <MsgType><![CDATA[%s]]></MsgType>
                                                             <ArticleCount>1</ArticleCount>
                                                             <Articles>
                                                             <item>
                                                             <Title><![CDATA[$title]]></Title> 
                                                             <Description><![CDATA[$des]]></Description>
                                                             <PicUrl><![CDATA[$picurl]]></PicUrl>
                                                                                                                                                                                                                                                                                                                                  <Url><![CDATA[$Url]]></Url>
                                                             </item>
                                                             </Articles>
                                                             <FuncFlag>1</FuncFlag>
                                                             </xml>";        

                                          $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType);
                            }else{
							$contentStr = '什么也没找到';
							$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						}
					}else{
						$msgType = "text";
						 $contentStr = '你什么也没写，怎么找女朋友呢';
						 $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						
					}
				}else if('image' == $msgType){
                    $msgType='news';
                    $PicUrl = '';
                    $Title =  '单张图片';
                    $Description =  '单张图片';
                    $Url = 'http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5MDA3ODc0MQ==&appmsgid=10000008&itemidx=1&uin=Njg5MjI3MTYw&key=91ddb0ec2d72afe50af6c5626beeb6803ee27de482cb3413f3362443b6ae47c76a275093fce31bcda5596f81fdd17ec6c19595264ce4c3e556101954c8fa7cb552c695a0cdf1b7204be9305379093b3d9a9cb709c73272e4c515dd5cfdca630b5c9c27079c937dac73c87e1ba44f1c0e6975307116acb357bebae18d7da5614e&devicetype=android-15&version=24050101';
                    $items = '';
                    for($i=1;$i<=1;$i++){
                    $items.="<item>
                             <Title><![CDATA[$Title]]></Title> 
                             <Description><![CDATA[$Title]]></Description>
                             <PicUrl><![CDATA[$PicUrl]]></PicUrl>
                             <Url><![CDATA[$Url]]></Url>
                             </item>
                             ";
                    }
                    $textTpl = "<xml>
                               <ToUserName><![CDATA[%s]]></ToUserName>
                               <FromUserName><![CDATA[%s]]></FromUserName>
                               <CreateTime>%s</CreateTime>
                               <MsgType><![CDATA[%s]]></MsgType>
                               <ArticleCount>1</ArticleCount>
                               <Articles>"
                               .$items."
                               </Articles>
                               <FuncFlag>1</FuncFlag>
                               </xml> ";        
                  // $contentStr = '这是图片：地址：'.$PicUrl;
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType);
  
                }else if('location' == $msgType){
                    $msgType  	= 'news';
                    $Location_X = $postObj->Location_X ;
                    $Location_Y = $postObj->Location_Y;
                    $Scale 	= $postObj->Scale;
                    $Label 	= $postObj->Label;
                    
                    //示例请求参数
                    $params = array('format'=>'json','latitude'=>"$Location_X",'longitude'=>"$Location_Y",'radius'=>'1000','offset_type'=>'1','sort'=>'7','category'=>'美食','limit'=>$this->limit);
                    
                    //按照参数名排序
                    ksort($params);
                    //print($params);
                    
                    //连接待加密的字符串
                    $codes = APPKEY;
                    
                    //请求的URL参数
                    $queryString = '';
                    
                    while (list($key, $val) = each($params))
                    {
                      $codes .=($key.$val);
                      $queryString .=('&'.$key.'='.urlencode($val));
                    }
                    
                    $codes .=SECRET;
                    //print($codes);
                    
                    $sign = strtoupper(sha1($codes));
                    
                    $url= URL . '?appkey='.APPKEY.'&sign='.$sign.$queryString;
                    
                    $curl = curl_init();
                    
                    // 设置你要访问的URL
                    curl_setopt($curl, CURLOPT_URL, $url);
                    
                    // 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    
                    curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
                    
                    // 运行cURL，请求API
                    $data = json_decode(curl_exec($curl), true);
                    $items='';
                  //$content="周边美食：\n";
                  foreach($data['businesses'] as $datas){
                  //       $content.='店名：'.$datas['name']."\n地址：".$datas['address']."\n地址：".$datas['business_url']."\n\n";
				   $baidumap = BAIDUMAPURL.'?&mylatitude='.$Location_X.'&mylongitude='.$Location_Y.'&latitude='.$datas['latitude'].'&longitude='.$datas['longitude'];
                   $photo_url = empty($datas['photo_url']) ? "INDEXURL.'images/logo.jpg'" : $datas['photo_url'];
                   $items.="<item>
                             <Title><![CDATA[".$datas['name']."\n".$datas['address']."]]></Title> 
                             <Description><![CDATA[".$datas['address']."]]></Description>
                             <PicUrl><![CDATA[".$photo_url."]]></PicUrl>
                             <Url><![CDATA[".$baidumap."]]></Url>
                             </item>
                             ";
                  }
                    
                    // 关闭URL请求
                    curl_close($curl);
                    
                    $textTpl = "<xml>
                               <ToUserName><![CDATA[%s]]></ToUserName>
                               <FromUserName><![CDATA[%s]]></FromUserName>
                               <CreateTime>%s</CreateTime>
                               <MsgType><![CDATA[%s]]></MsgType>
                               <ArticleCount>".$this->limit."</ArticleCount>
                               <Articles>"
                               .$items."
                               </Articles>
                               <FuncFlag>1</FuncFlag>
                               </xml> ";      

                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType);

                }else if('link' == $msgType){
                    $msgType  = 'text';
                    $PicUrl = $postObj->PicUrl;
                   $textTpl = "<xml>
                          <ToUserName><![CDATA[%s]]></ToUserName>
                          <FromUserName><![CDATA[%s]]></FromUserName>
                          <CreateTime>%s</CreateTime>
                          <MsgType><![CDATA[%s]]></MsgType>
                          <Content><![CDATA[%s]]></Content>
                          <FuncFlag>0</FuncFlag>
                          </xml>";        
  
                          $contentStr = '这是链接';
                          $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
  
                }else if('event' == $msgType){
                    $msgType  = 'text';
                    $PicUrl = $postObj->PicUrl;
                   $textTpl = "<xml>
                          <ToUserName><![CDATA[%s]]></ToUserName>
                          <FromUserName><![CDATA[%s]]></FromUserName>
                          <CreateTime>%s</CreateTime>
                          <MsgType><![CDATA[%s]]></MsgType>
                          <Content><![CDATA[%s]]></Content>
                          <FuncFlag>0</FuncFlag>
                          </xml>";        
  
                  $contentStr = "您好用户，这里是找伴旅游\n我是这里的管家“小顺子”，有不明白的可以随时发送【？】符号查看\n输入【查询】：查询现有的旅游信息\n输入【发布】，发布旅游信息和个人信息or直接点击<a href=\"http://zhaoban.sinaapp.com/publish_traval.php?num={$fromUsername}\">发布旅游信息</a>\n输入【天气】：获取天气信息\n输入【生活】，帮你打发休闲时间\n管理员用户请点击<a href=\"http://zhaoban.sinaapp.com/admin/?uid={$fromUsername}\">后台登录</a>\n输入【文档】或者【wd】，查看本帐号的帮助文档\n其他：点击<a href=\"http://yuedu.baidu.com/\">小说</a>点击<a href=\"http://music.baidu.com/\">歌曲</a>点击<a href=\"http://fanyi.baidu.com/\">翻译</a>";
                          $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
  
                }else if('music' == $msgType){
                    $msgType  = 'text';
                    $PicUrl = $postObj->PicUrl;
                   $textTpl = "<xml>
                          <ToUserName><![CDATA[%s]]></ToUserName>
                          <FromUserName><![CDATA[%s]]></FromUserName>
                          <CreateTime>%s</CreateTime>
                          <MsgType><![CDATA[%s]]></MsgType>
                          <Content><![CDATA[%s]]></Content>
                          <FuncFlag>0</FuncFlag>
                          </xml>";        
  
                          $contentStr = '这是音乐';
                          $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
  
                }else if('news' == $msgType){
                    $msgType  = 'text';
                    $PicUrl = $postObj->PicUrl;
                   $textTpl = "<xml>
                          <ToUserName><![CDATA[%s]]></ToUserName>
                          <FromUserName><![CDATA[%s]]></FromUserName>
                          <CreateTime>%s</CreateTime>
                          <MsgType><![CDATA[%s]]></MsgType>
                          <Content><![CDATA[%s]]></Content>
                          <FuncFlag>0</FuncFlag>
                          </xml>";        
  
                          $contentStr = '这是新闻';
                          $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
  
                }else{
                	$msgType  = 'text';
                	$textTpl = "<xml>
                          <ToUserName><![CDATA[%s]]></ToUserName>
                          <FromUserName><![CDATA[%s]]></FromUserName>
                          <CreateTime>%s</CreateTime>
                          <MsgType><![CDATA[%s]]></MsgType>
                          <Content><![CDATA[%s]]></Content>
                          <FuncFlag>0</FuncFlag>
                          </xml>";        
  
                          $contentStr = $MsgType;
                          $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
  
                }
				
				 echo $resultStr;
        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

class getweather{
	//天气的对应编码，可以通过文件引入
  	private $arr;
  //private $arr=array(
  //		101010100=>'北京',
  //);
	public  function __construct($arr){
        	$this->arr=$arr;
        }
	public  function getw($str){
		$code=$this->check($str);

		if ($code){

			$content = file_get_contents("http://m.weather.com.cn/data/{$code}.html");

			if(!$content){

				//mysql_query("insert into errorlog values(null,'没有取到天气接口数据','$date',$time)",$link);

				//echo mysql_error();

				file_put_contents('weather.txt', '没有接受到天气数据', FILE_APPEND);

				return '暂时没有取到天气数据,请稍后再试';

			}

	

			$result=json_decode($content,true);

			$info=$result['weatherinfo'];

	

			$strw="{$info['date_y']}{$info['week']},{$info['city']}的天气情况\n";

			$strw .= "今天:({$info['temp1']}){$info['weather1']}{$info['wind1']}{$info['fl1']}。";

			$strw .= "24小时穿衣指数:{$info['index_d']}\n";

			$strw .= "明天:({$info['temp2']}){$info['weather2']}{$info['wind2']}{$info['fl2']}。";

			$strw .= "48小时穿衣指数:{$info['index48_d']}";

			return $strw;

		}else{

			return "没有获取到该城市的天气,请确定输入了正确的城市名称,如'北京'\n熟悉帮助请输入？符号";

		}

	}

	/**
	 * 验证接受到的数据是否合法
	 * @param string $str  传入的接受到的数据
	 * @return mixed|boolean   有数据返回$code,没有数据返回false;
	 *  
	 */

	private function check($str){
          //print_r($this->arr);
          foreach($this->arr as $keys=>$values){

             if ($str == $values) {
               return  $keys;
                    
              }

          }
            

	}
      //测试用例方法
      //public function check_pub($str){
                    
               // return $str;
      // return $this->check($str);
      // }
}
?>