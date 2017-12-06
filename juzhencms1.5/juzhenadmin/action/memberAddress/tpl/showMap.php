<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>百度地图测试</title>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?=$global->baidu_js_ak?>"></script>
<script src="res/js/baiduMap/MarkerTool_min.js"></script>
<script src="res/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
var map,positionMarker;
$(function(){
	// 百度地图API功能
	map = new BMap.Map("mapDiv");    // 创建Map实例
	//map.addControl(new BMap.MapTypeControl());   //添加地图类型控件
	map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
	map.addControl(new BMap.NavigationControl());//开启缩放和平移控件
	
	//判断是否有默认值，若没有，则定位到北京
	var latVal=window.parent.window.document.getElementById("<?=$_GET["latField"]?>").value;
	var lngVal=window.parent.window.document.getElementById("<?=$_GET["lngField"]?>").value;
	if(latVal!="" && lngVal!=""){
		var latVal = parseFloat(latVal);
		var lngVal = parseFloat(lngVal);
		if(lngVal!=0&&latVal!=0){
			//添加标点
			setDefaultPoint(lngVal,latVal);
		}else{
			map.centerAndZoom("北京",11);
		}
	}else{
		//map.centerAndZoom(new BMap.Point(116.404, 39.915), 11);  // 初始化地图,设置中心点坐标和地图级别
		map.centerAndZoom("北京",11);
	}
	
	
});

function use_address(lng,lat){
	//alert(lng+","+lat);
	//$("#lat_val").val(lat);
	//$("#lng_val").val(lng);
	window.parent.window.document.getElementById("<?=$_GET["latField"]?>").value=lat;
	window.parent.window.document.getElementById("<?=$_GET["lngField"]?>").value=lng;
	setDefaultPoint(lng,lat);
	
}

function setDefaultPoint(lngVal,latVal){
	
	//设置此标注允许被清除
	if(positionMarker!=null)
		positionMarker.enableMassClear();
	//清除允许被清除的覆盖物
	map.clearOverlays();
	
	//var point = new BMap.Point(116.404, 39.915);
	var point = new BMap.Point(lngVal,latVal);
	map.centerAndZoom(point, 12);
	positionMarker = new BMap.Marker(point);// 创建标注
	positionMarker.disableMassClear();//不允许清除
	map.addOverlay(positionMarker); 
	var myGeo = new BMap.Geocoder();
	myGeo.getLocation(point, function(result){						  							
		if (result){
			var infoWin=get_address_window(result,false);
			positionMarker.infoWin=infoWin;
			positionMarker.openInfoWindow(infoWin);
		} 
	});
	
	positionMarker.addEventListener("click", function(evt){
		positionMarker.openInfoWindow(positionMarker.infoWin);
	});
	
	positionMarker.enableDragging();
	positionMarker.addEventListener("dragend", function(evt){
		var point=evt.point;
		var lng=point.lng;
		var lat=point.lat;
		var myGeo = new BMap.Geocoder();
		myGeo.getLocation(point, function(result){ 
			if (result){ 
				var infoWin=get_address_window(result,true);
				positionMarker.infoWin=infoWin;
				positionMarker.openInfoWindow(infoWin);
			} 
		});
	});
}


function markPoint(){
	//map.setDefaultCursor("url('bird.cur')");
	
	var mkrTool = new BMapLib.MarkerTool(map, {autoClose: true,followText:"点击定位"});
    mkrTool.open(); //打开工具 
    var icon = BMapLib.MarkerTool.SYS_ICONS[0]; //设置工具样式，使用系统提供的样式BMapLib.MarkerTool.SYS_ICONS[0]
	
	mkrTool.setIcon(icon); 
    
	mkrTool.addEventListener("markend", function(evt){ 
		var mkr = evt.marker;
		
		//设置此标注不允许被清除
		mkr.disableMassClear();
		//清除允许被清除的覆盖物
		map.clearOverlays();
		//设置此标注允许被清除
		mkr.enableMassClear();
		
		var point=mkr.getPosition();
		var lng=point.lng;
		var lat=point.lat;
		var myGeo = new BMap.Geocoder();
		myGeo.getLocation(point, function(result){ 
			if (result){ 
				var infoWin=get_address_window(result,true);
				mkr.infoWin=infoWin;
				mkr.openInfoWindow(infoWin);
			} 
		});
		//mkr.getLabel();
		
		mkr.enableDragging();
		mkr.addEventListener("click", function(evt){
			mkr.openInfoWindow(mkr.infoWin);
		});
		//拖拽结束
		
		mkr.addEventListener("dragend", function(evt){

			var point=evt.point;
			var lng=point.lng;
			var lat=point.lat;
			var myGeo = new BMap.Geocoder();
			myGeo.getLocation(point, function(result){ 
				if (result){ 
					var infoWin=get_address_window(result,true);
					mkr.infoWin=infoWin;
					mkr.openInfoWindow(infoWin);
				} 
			});
		});
		
	    mkrTool.close();
	 });	
}

function get_address_window(result,showBtn){
	
	var cityString=result.addressComponents.city+result.addressComponents.district;     
	//cityString=cityString.replace(/省|市/g, "");
	//拼接infowindow内容字串
	var infoWindowTitle = '<div><a style="font-weight:bold;color:#CE5521;font-size:14px">'+cityString+'</a></div>';
	var infoWindowHtml = [];
	infoWindowHtml.push('<table cellspacing="0" style="table-layout:fixed;width:100%;font:12px arial,simsun,sans-serif"><tbody>');
	infoWindowHtml.push('<tr>');
	infoWindowHtml.push('<td style="vertical-align:top;line-height:16px"><a>'+result.address+'</a></td>');
	infoWindowHtml.push('</tr>');
	infoWindowHtml.push('<tr>');
	infoWindowHtml.push('<td style="vertical-align:top;line-height:16px">');
	if(showBtn){
		infoWindowHtml.push('<a class="used" href="javascript:;" onclick="use_address(\''+result.point.lng+'\',\''+result.point.lat+'\');">使用此地址</a>');
	}	
	
	infoWindowHtml.push('</td>');
	infoWindowHtml.push('</tr>');
	infoWindowHtml.push('</tbody></table>');
	var infoWin = new BMap.InfoWindow(infoWindowHtml.join(""),{title:infoWindowTitle,enableMessage:false,width:200});
	return infoWin;
}


</script>
</head>

<body>

<div id="mapDiv" style="width:600px; height:430px; display:block; float:left"></div>
<input type="button" value="地图标点" onclick="markPoint()"/>



</body>
</html>
