<?php
/**
  * wechat php test
  * name   : zhaoban_traval
  * anthor : lijiashun
  * c_time : 20130327
  */

//define your token
define("INDEXURL", "http://zhaoban.sinaapp.com/");
define("TOKEN", "zhaoban");

$wechatObj = new zhaoban_traval($config_arr);
//首次使用，请注释掉下面的一行代码。
//然后添加  $wechatObj->valid(); 供首次验证需要
//验证成功后,即可以使用下面的代码
//$wechatObj->valid();
$wechatObj->responseMsg();

class zhaoban_traval
{
			
    public function __construct($arr){

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
            $mysql = new SaeMysql();
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
                    if(!empty( $keyword )){
                      				
                          if('你好' == $keyword || 'ni hao' == $keyword || 'nihao' == $keyword){
                            $contentStr = "你好你妈啊！";
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                          }else if('？' == $keyword || '?' == $keyword){
                              $contentStr = "如果你想把你的骂人的话加入到这里，点击http://zhaoban.sinaapp.com/publish_fuck.php?num={$fromUsername}\n";
                              $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                          }else{
                            		$sql="select * from fuck";
                              $data = $mysql->getData( $sql );
                              shuffle($data);
                              $contentStr = $data[0]['fuck_content'];
                              $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                          }
                     
                          
                    }else{
                          $contentStr = '你什么也没写，你是懒猪啊';
                          $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    }
                    
  
  
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
        	echo "神马也没有";
        	exit;
        }
        $mysql->closeDb();
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



?>