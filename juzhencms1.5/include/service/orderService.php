<?
class orderService{
	function createOrderSn($prefix=""){
		return $prefix.date("ymdHis").substr(microtime(),2,4);
	}
	
	function saveOrder($record){
		global $dao;
		$record["order_sn"]=$this->createOrderSn();
		$record["create_time"]=date("Y-m-d H:i:s");
		$dao->insert($dao->tables->order,$record,true);
		$record["auto_id"]=$dao->get_insert_id();
		if($record["auto_id"]>0){
			return $record;
		}else{
			return NULL;
		}
	}
	
	function getOrderBySn($orderSn){
		global $dao;
		$order=$dao->get_row_by_where($dao->tables->order,"where order_sn='{$orderSn}'");
		return $order;
	}

	function addOrderLog($orderId,$username,$msg){
		global $dao;
		$order=$dao->get_row_by_where($dao->tables->order,"where auto_id='{$orderId}'",array("order_sn"));
		$record["order_id"]=$orderId;
		$record["order_sn"]=$order["order_sn"];
		$record["content_name"]=$username;
		$record["content_title"]=$msg;
		$record["create_time"]=date("Y-m-d H:i:s");
		$dao->insert($dao->tables->order_log,$record,true);
	}
	
}
?>