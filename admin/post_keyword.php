<?php
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
$uid = $_REQUEST['uid'];
if(isset($_POST['submit']) && !empty($_POST['guanjianci']) && !empty($_POST['huifu'])){
	$mysql = new SaeMysql();
        
        $guanjianci=trim($_POST['guanjianci']);
        $huifu_arr = $_POST['huifu'];
  	//print_r($huifu_arr);
  	if(strpos($guanjianci," ")){
        	$guanjianci_arr = explode(" ",$guanjianci);
                foreach($guanjianci_arr as $guanjiancis){
                	foreach($huifu_arr as $huifus){
                        
                                $sql = "INSERT  INTO `guanjianci` (`id`, `uid` , `guanjianci` , `huifu` ) VALUES ('', '"  . $uid . "' , '" . $mysql->escape( $guanjiancis ) . "' , '" . $mysql->escape( $huifus ) . "' ) ";
                                $data = $mysql->runSql( $sql );
                                if($data){
                                        echo '提交成功<br />';
                                        
                                }else{
                                        echo '提交失败<br />';
                                }
                        }

                }
        }else{
        	foreach($huifu_arr as $huifus){
                	$sql = "INSERT  INTO `guanjianci` (`id`, `uid` , `guanjianci` , `huifu` ) VALUES ('', '"  . $uid . "' , '" . $mysql->escape( $guanjianci ) . "' , '" . $mysql->escape( $huifus ) . "' ) ";
                  	$data = $mysql->runSql( $sql );
                        if($data){
                          	echo '提交成功<br />';
                        }else{
                          	echo '提交失败<br />';
                        }
                }
        }
        
	
        $mysql->closeDb();
  	$url="./guanjianci.php?uid={$uid}";
        echo "< script language='javascript' type='text/javascript'>";  
        echo "window.location.href='$url'";  
        echo "< /script>";
}
