
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
body, html,#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;}
#l-map{height:100%;width:78%;float:left;border-right:2px solid #bcbcbc;}
#r-result{height:100%;width:20%;float:left;}
</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<title>步行导航</title>
</head>
<body>
<div id="allmap"></div>
<div id="hidZuobiao" style="display:none;">
<input type=”hidden” id="mylatitude" value="<?php echo $_GET['mylatitude']?>" />
<input type=”hidden” id="mylongitude" value="<?php echo $_GET['mylongitude']?>" />
<input type=”hidden” id="latitude" value="<?php echo $_GET['latitude']?>" />
<input type=”hidden” id="longitude" value="<?php echo $_GET['longitude']?>" />
</div>
</body>
</html>
<!--
<script type="text/javascript">
var mylatitude= document.getElementById("mylatitude").value;
var mylongitude= document.getElementById("mylongitude").value;
var latitude= document.getElementById("latitude").value;
var longitude= document.getElementById("longitude").value;
  //alert(mylatitude);
var map = new BMap.Map("allmap");
map.centerAndZoom(new BMap.Point(mylatitude, mylongitude), 11);

var p1 = new BMap.Point(mylatitude,mylongitude);
var p2 = new BMap.Point(latitude,longitude);

var driving = new BMap.DrivingRoute(map, {renderOptions:{map: map, autoViewport: true}});
driving.search(p1, p2);
</script>
-->
<script type="text/javascript">
var mylatitude= document.getElementById("mylatitude").value;
var mylongitude= document.getElementById("mylongitude").value;
var latitude= document.getElementById("latitude").value;
var longitude= document.getElementById("longitude").value;
  //不知什么原因出现“”操他妈的原来是自己打得中文引号
  //mylatitude = mylatitude.substr(1,mylatitude.length-2);
  //mylongitude = mylongitude.substr(1,mylongitude.length-2);
  //latitude = latitude.substr(1,latitude.length-2);
  //longitude = longitude.substr(1,mylongitude.length-2);
//alert(mylatitude);
var map = new BMap.Map("allmap");            // 创建Map实例
map.centerAndZoom(new BMap.Point(mylongitude,mylatitude),14);  //初始化时，即可设置中心点和地图缩放级别。
//var marker1 = new BMap.Marker(new BMap.Point(mylongitude,mylatitude));  // 创建标注
//map.addOverlay(marker1);              // 将标注添加到地图中
//var marker2 = new BMap.Marker(new BMap.Point(116.4737, 39.88491));  // 创建标注
//map.addOverlay(marker2);              // 将标注添加到地图中

map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
map.addControl(new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_RIGHT, type: BMAP_NAVIGATION_CONTROL_SMALL}));  //右上角，仅包含平移和缩放按钮
map.addControl(new BMap.NavigationControl({anchor: BMAP_ANCHOR_BOTTOM_LEFT, type: BMAP_NAVIGATION_CONTROL_PAN}));  //左下角，仅包含平移按钮
map.addControl(new BMap.NavigationControl({anchor: BMAP_ANCHOR_BOTTOM_RIGHT, type: BMAP_NAVIGATION_CONTROL_ZOOM}));  //右下角，仅包含缩放按钮
var p1 = new BMap.Point(mylongitude,mylatitude);
var p2 = new BMap.Point(longitude,latitude);

var walking = new BMap.WalkingRoute(map, {renderOptions:{map: map, autoViewport: true}});
walking.search(p1, p2);

</script>