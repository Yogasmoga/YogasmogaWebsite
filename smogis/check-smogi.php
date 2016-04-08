<?php 
ini_set('max_execution_time',1800);
ini_set('memory_limit', '512M');


    require_once '../app/Mage.php';
    Mage::app();
    umask(0);
	
	$from_date = "2014-01-01 00:00:00";
    $to_date = "2015-12-31 23:59:59";
	
	
	$date_to_from = date("Y-m-d", strtotime($from_date));
    $date_to_now = date("Y-m-d", strtotime($to_date));
	
	$orders1 = Mage::getModel('sales/order')
        ->getCollection()
        ->addFieldToFilter('created_at', array('gteq' => $date_to_from,
            'lteq' => $date_to_now
        ));
        //->addFieldToFilter('rewardpoints');
		$normalorder = count($orders1->getData());
	echo "Normal order:- ".$normalorder."<hr/>";
	
	
	 $orders = Mage::getModel('sales/order')
        ->getCollection()
        ->addFieldToFilter('created_at', array('gteq' => $date_to_from,
            'lteq' => $date_to_now
        ))
        ->addFieldToFilter('rewardpoints',array('neq'=>'null'));
		$rewardpointsOrder = count($orders->getData()) ;
	echo "Order With Rewardspoint: ".$rewardpointsOrder."<hr/>";
	
		
		$calc =  ($rewardpointsOrder) *100/$normalorder;
		
		
		echo $calc; 
	
	//header('Content-Type: text/csv; charset=utf-8');
    //header('Content-Disposition: attachment; filename=customers.csv');

    //$fp = fopen('php://output', 'w');
	
	
	//fputcsv($fp, array("order_id","customer_email", "rewardpoints"));
		
		//$i=1;
		foreach($orders as $order)
			{
			//echo $i.'--'.$order->getCustomerEmail().'--'.$order->getIncrementId(). "==" .	$order->getRewardpoints().'<br/>';
			//$i++;
			/*$data = array(
							"order_id" =>$order->getIncrementId(),
							"customer_email" => $order->getCustomerEmail(),
							"rewardpoints" => $order->getRewardpoints(),
						);
			
			 fputcsv($fp, $data);	*/
			}
		 //fclose($fp);
		 //exit;	
?>		 