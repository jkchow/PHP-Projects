<?php defined ('ALLOW_ACCESS' ) or die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>欢迎界面</title>
    
    <style type="text/css">
        p.l-log-content
        {
            margin: 0;
            padding: 0;
            padding-left: 20px;
            line-height: 22px;
            font-size: 12px;
        }
        span.l-log-content-tag
        {
            color: #008000;
            margin-right: 2px;
            font-weight: bold;
        }
        h2.l-title
        {
            margin: 7px;
            padding: 0;
            font-size: 17px;
            font-weight: bold;
        }
        h3.l-title
        {
            margin: 4px;
            padding: 0;
            font-size: 15px;
            font-weight: bold;
        }
        a {
            color:#1870A9;
        }
        a.hover {
            color: #BC2A4D;
        }
    </style>
<script src="res/js/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="res/js/Highstock-2.1.5/js/highstock.js" type="text/javascript"></script>
<script src="res/js/Highstock-2.1.5/js/modules/exporting.js" type="text/javascript"></script>
<script>
<?
//查询10天内的访问量数据
$beginDate=date("Y-m-d",strtotime("-10 day"));
$sql="select sum(content_hit) as visit_num,content_date from {$dao->tables->vistor_log} where content_date>='{$beginDate}' group by content_date order by content_date asc";
$tmpDatalist=$dao->get_datalist($sql);

$dateArr=array();
$tmpDate=$beginDate;
while($tmpDate<=date("Y-m-d")){
	$dateArr[]=$tmpDate;
	$tmpDate=date("Y-m-d",strtotime("+1 day",strtotime($tmpDate)));
}
//y轴最大值
$max_num=100;
//Y轴刻度的间隔值
$tickInterval=10;

$datalist=array();
foreach($dateArr as $key=>$vl){
	$num=0;
	if(is_array($tmpDatalist))
	foreach($tmpDatalist as $k=>$v){
		if($v["content_date"]==$vl){
			$num=$v["visit_num"];
			unset($tmpDatalist[$k]);
			break;
		}
	}
	$datalist[]=$num;
	if($num>$max_num)
		$max_num=$num;
}

if($max_num>100){
	//计算获得y轴最大坐标
	$tmplength=strlen($max_num);
	$firstnum=substr($max_num,0,1);
	if($firstnum==0)
		$firstnum=1;
	if($firstnum<5)
		$firstnum=5;
	else
		$firstnum=10;
		
	$max_num=$firstnum;
	for($i=1;$i<$tmplength;$i++){
		$max_num=$max_num."0";
	}
	//获取Y轴刻度的间隔值
	$tickInterval=$max_num/$firstnum;
}





?>
var rate_charts = [{"name":"访问量统计","num":0,"data":[<?=implode(',',$datalist);?>],"categories":[<?='"'.implode('","',$dateArr).'"';?>]}];


                            
$(function() {
	$("#container").highcharts({ 
		chart: {
			type: 'spline',
			spacingTop:0,
			plotBorderColor:'#bbbbbb',
			plotBorderWidth:1,
			spacingBottom:0,
			margin: [ 30, 10, 80, 90]
		},
		title: {
			text: '访问量统计'
		},
		subtitle: {
			text: ''
		},
		credits: {
			enabled:false
		},
		exporting: {
            enabled:false
		},
		xAxis: {
			categories: rate_charts[0].categories
		},
		yAxis: {
			title: {
				text: '页面访问量'
			},
			lineColor:"#bbb",
			tickInterval: <?=$tickInterval?>,
			min: 0,
			max:<?=$max_num?>,
			labels:{
				formatter:function(){
					//return Highcharts.numberFormat(this.value,1,'.')+"%";
					return this.value;
				}
			}
		},
		legend: {
			enabled: false
		},
		tooltip: {
			enabled: true,
			formatter: function() {
				return '日期：'+  this.x + '<br/>访问量：'+this.y;
			}
		},
		plotOptions: {
			spline: {
				dataLabels: {
					enabled: false
				},
				enableMouseTracking: true,
				marker:{
					enabled: false
				}
			}
		},
		series: rate_charts
	});

});


</script>
</head>
<body style="background: white; font-size: 12px;"> 
 
    <h2>
        尊敬的 <?=$_record["user"]["NAME"]?>，您好，欢迎使用矩阵CMS内容管理系统</h2>
    <p class="l-log-content">
        当前登录用户：<b><?=$_record["user"]["USER"]?></b>&nbsp;&nbsp;&nbsp;&nbsp;登录时间：<?=$_record["user"]["LOGINTIME"]?>&nbsp;&nbsp;&nbsp;&nbsp;当前软件版本<? global $global;echo $global->version; ?></p></p>
<hr/>   
<div id="container" style="padding-top: 5px; width: 698px; height: 360px; margin: 0 auto;">
</div>
    
</body>
</html>
