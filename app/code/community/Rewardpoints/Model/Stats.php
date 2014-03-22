<?php
/**
 * J2T RewardsPoint2
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@j2t-design.com so we can send you a copy immediately.
 *
 * @category   Magento extension
 * @package    RewardsPoint2
 * @copyright  Copyright (c) 2009 J2T DESIGN. (http://www.j2t-design.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Rewardpoints_Model_Stats extends Mage_Core_Model_Abstract
{
    const TARGET_PER_ORDER     = 1;
    const TARGET_FREE   = 2;
    const APPLY_ALL_ORDERS  = '-1';

    const TYPE_POINTS_ADMIN  = '-1';
    const TYPE_POINTS_REVIEW  = '-2';
    const TYPE_POINTS_REGISTRATION  = '-3';
    const TYPE_POINTS_REQUIRED  = '-10';
    const TYPE_POINTS_BIRTHDAY  = '-20';

    protected $_targets;

    protected $_eventPrefix = 'rewardpoints_account';
    protected $_eventObject = 'stats';

    protected $points_received;
    protected $points_received_no_exp;
    // J2T points validation date
    protected $points_received_reajust;
    protected $points_spent;

    protected $points_lost;

    const XML_PATH_NOTIFICATION_EMAIL_TEMPLATE       = 'rewardpoints/notifications/notification_email_template';
    const XML_PATH_NOTIFICATION_EMAIL_IDENTITY       = 'rewardpoints/notifications/notification_email_identity';

    public function _construct()
    {
        parent::_construct();
        $this->_init('rewardpoints/stats');

        $this->_targets = array(
            self::TARGET_PER_ORDER     => Mage::helper('rewardpoints')->__('Related to Order ID'),
            self::TARGET_FREE   => Mage::helper('rewardpoints')->__('Not related to Order ID'),
        );

    }

    public function getTargetsArray()
    {
        return $this->_targets;
    }

    public function targetsToOptionArray()
    {
        return $this->_toOptionArray($this->_targets);
    }

    protected function _toOptionArray($array)
    {
        $res = array();
        foreach ($array as $value => $label) {
            $res[] = array('value' => $value, 'label' => $label);
        }
        return $res;
    }


    //J2T Check referral
    public function loadByReferralId($referral_id, $referral_customer_id = null)
    {
        $this->addData($this->getResource()->loadByReferralId($referral_id, $referral_customer_id));
        return $this;
    }

    public function loadpointsbydate($store_id, $customer_id, $date){
        $collection = $this->getCollection();
        $collection->getSelect()->where("main_table.customer_id = ?", $customer_id);
        $collection->getSelect()->where("( ? >= main_table.date_start )", $date);
        $collection->getSelect()->where("( main_table.date_end >= ? )", $date);
        $collection->getSelect()->where("( main_table.date_end <= NOW() )");
        $collection->addValidPoints($store_id, true);

        //echo $collection->getSelect()->__toString();
        //die;

        $row = $collection->getFirstItem();
        if (!$row) return $this;
        return $row;
    }

    public function getDobPoints($store_id, $customer_id)
    {
        //self::TYPE_POINTS_BIRTHDAY
        $collection = $this->getCollection();
        $collection->getSelect()->where("main_table.customer_id = ?", $customer_id);
        //$collection->getSelect()->where("( ? >= main_table.date_start )", $date);
        $collection->getSelect()->where("main_table.order_id  = ?", self::TYPE_POINTS_BIRTHDAY);
        $collection->pointsByDate();

        $row = $collection->getFirstItem();
        if (!$row) return $this;
        return $row;
    }

    public function loadByCustomerId($customer_id)
    {
        $collection = $this->getCollection();
        $collection->getSelect()->where('customer_id = ?', $customer_id);

        $row = $collection->getFirstItem();
        if (!$row) return $this;
        return $row;
    }

    public function loadReferrer($customer_id, $order_id)
    {
        $collection = $this->getCollection();
        $collection->getSelect()->where('customer_id <> ?', $customer_id);
        $collection->getSelect()->where('order_id = ?', $order_id);


        $row = $collection->getFirstItem();
        if (!$row) return $this;
        return $row;
    }

    public function checkProcessedOrder($customer_id, $order_id, $isCredit = true)
    {
        $collection = $this->getCollection();
        $collection->getSelect()->where('customer_id = ?', $customer_id);
        $collection->getSelect()->where('order_id = ?', $order_id);
        if ($isCredit){
            $collection->getSelect()->where('points_current > 0');
        } else {
            $collection->getSelect()->where('points_spent > 0');
        }

        $row = $collection->getFirstItem();
        if (!$row) return $this;
        return $row;
    }


    public function getPointsUsed($order_id, $customer_id)
    {
        $collection = $this->getCollection();
        $collection->getSelect()->where('customer_id = ?', $customer_id);
        $collection->getSelect()->where('order_id = ?', $order_id);
        $collection->getSelect()->where('points_spent > ?', '0');

        $row = $collection->getFirstItem();
        if (!$row) return $this;
        return $row;
    }


    public function getPointsWaitingValidation($customer_id, $store_id){
        $collection = $this->getCollection()->joinFullCustomerPoints($customer_id, $store_id);
        $row = $collection->getFirstItem();
        return $row->getNbCredit() - $this->getPointsReceived($customer_id, $store_id) + $this->getPointsReceivedReajustment($customer_id, $store_id);
    }


    public function sendNotification(Mage_Customer_Model_Customer $customer, $store_id, $points, $days)
    {
        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $email = Mage::getModel('core/email_template');

        $template = Mage::getStoreConfig(self::XML_PATH_NOTIFICATION_EMAIL_TEMPLATE, $store_id);
        $recipient = array(
            'email' => $customer->getEmail(),
            'name'  => $customer->getName()
        );

        $sender  = Mage::getStoreConfig(self::XML_PATH_NOTIFICATION_EMAIL_IDENTITY, $store_id);
        $email->setDesignConfig(array('area'=>'frontend', 'store'=>$store_id))
            ->sendTransactional(
                $template,
                $sender,
                $recipient['email'],
                $recipient['name'],
                array(
                    'points'   => $points,
                    'days'   => $days,
                    'customer' => $customer
                )
            );
        $translate->setTranslateInline(true);
        return $email->getSentSuccess();
    }

    /**
     * J2T modification fixing issue related to points validation dates
     * getPointsReceivedReajustment protected function allowing to readjust points regarding points validation dates
     * @param int $customer_id
     * @param int $store_id
     * @return int
     */
    protected function getPointsReceivedReajustment($customer_id, $store_id) {
        /*$points = Mage::getModel('rewardpoints/stats')
                                ->getResourceCollection()
                                ->addUsedpointsbydate($store_id, $customer_id);*/

        if ($this->points_received_reajust != null){
            return $this->points_received_reajust;
        } else {
            //get all points used groupped by date
            $points = $this
                ->getResourceCollection()
                ->addUsedpointsbydate($store_id, $customer_id);
            $acc_fix_points = 0;
            if ($points->getSize()){
                foreach ($points as $current_point){
                    //validate points per date
                    $points_accum = Mage::getModel('rewardpoints/stats')->loadpointsbydate($store_id, $customer_id, $current_point->getData('date_order'));
                    //if ($points_accum->getData('nb_credit') >= $current_point->getData('nb_credit_spent')){
                    //FIX POINTS READJUST!!!!
                    if ($points_accum->getData('nb_credit') >= $current_point->getData('nb_credit_spent')){
                        $acc_fix_points += $current_point->getData('nb_credit_spent');
                    }
                }
            }
            $this->points_received_reajust = $acc_fix_points;
            return $acc_fix_points;
        }
    }


    public function getRealPointsLost($customerId, $store_id) {
        if ($this->points_lost){
            return $this->points_lost;
        }
        $this->points_lost = $this->getRealPointsReceivedNoExpiry($customerId, $store_id) - $this->getPointsReceived($customerId, $store_id);
        return $this->points_lost;
    }


    public function getPointsReceived($customer_id, $store_id){
        if ($this->points_received){
            return $this->points_received;
        }
        $statuses = Mage::getStoreConfig('rewardpoints/default/valid_statuses', Mage::app()->getStore()->getId());
        $order_states = explode(",", $statuses);

        //$order_states = array("'processing'","'complete'");
        $collection = $this->getCollection();
        $collection->joinValidPointsOrder($customer_id, $store_id, $order_states);

        /*$collection->printlogquery(true);
        die;*/
        $row = $collection->getFirstItem();
        $this->points_received = $row->getNbCredit() + $this->getPointsReceivedReajustment($customer_id, $store_id);

        //J2T modification fixing issue related to points validation dates
        //return $row->getNbCredit();
        //echo $collection->getSelect()->__toString();
        //die;
        //echo ">> ".($row->getNbCredit() + $this->getPointsReceivedReajustment($customer_id, $store_id)) . " <<";
        //die;
        return $row->getNbCredit() + $this->getPointsReceivedReajustment($customer_id, $store_id);
    }



    public function getRealPointsReceivedNoExpiry($customer_id, $store_id){
        if ($this->points_received_no_exp){
            return $this->points_received_no_exp;
        }
        $statuses = Mage::getStoreConfig('rewardpoints/default/valid_statuses', Mage::app()->getStore()->getId());
        $order_states = explode(",", $statuses);

        //$order_states = array("'processing'","'complete'");
        $collection = $this->getCollection();
        $collection->joinValidPointsOrder($customer_id, $store_id, $order_states, false, true);

        /*$collection->printlogquery(true);
        die;*/
        $row = $collection->getFirstItem();
        $this->points_received_no_exp = $row->getNbCredit();

        //J2T modification fixing issue related to points validation dates
        //return $row->getNbCredit();
        //echo $collection->getSelect()->__toString();
        //die;
        return $row->getNbCredit();
    }

    public function getPointsSpent($customer_id, $store_id){

        if ($this->points_spent){
            return $this->points_spent;
        }

        $statuses = Mage::getStoreConfig('rewardpoints/default/valid_statuses', Mage::app()->getStore()->getId());
        $order_states = explode(",", $statuses);
        $order_states[] = 'new';


        //$order_states = array("'processing'","'complete'","'new'");

        $collection = $this->getCollection();
        $collection->joinValidPointsOrder($customer_id, $store_id, $order_states, true);

        $row = $collection->getFirstItem();

        $this->points_spent = $row->getNbCredit();

        return $row->getNbCredit();
    }
    
    public function getPointsCurrent($customerid, $store_id, $date = null, $arraymode = false, $excludelast = false){
        if($date == null)
            $date = date('Y-m-d');
        $balanceon = strtotime($date);
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $query = "SELECT * FROM (SELECT points_current, points_spent,points_current AS 'balance',date_start,date_end,rewardpoints_account_id, order_id FROM rewardpoints_account WHERE customer_id = ".$customerid." AND order_id IN (-3,-2,-1,-20) UNION SELECT points_current, points_spent,points_current AS 'balance',date_start,date_end,rewardpoints_account_id, order_id FROM rewardpoints_account, sales_flat_order WHERE rewardpoints_account.customer_id = ".$customerid." AND order_id NOT IN (-3,-2,-1,-20) AND sales_flat_order.increment_id = rewardpoints_account.order_id AND sales_flat_order.state IN ('new','pending','processing','complete')) AS smogihistory ORDER BY rewardpoints_account_id";
        $smogihistory = $read->fetchAll($query);

        $unsetarray = array();
        for($i = 0; $i < count($smogihistory); $i++)
        {
            $orderid = $smogihistory[$i]['order_id'];
            if(($orderid != -3 || $orderid != -2 || $orderid != -1 || $orderid != -20) && $smogihistory[$i]['points_spent'] > 0)
            {
                $temp = $smogihistory[$i]['points_spent'];
                for($j = $i - 1; $j >= 0; $j--)
                {
                    if(($smogihistory[$j]['order_id'] == $smogihistory[$i]['order_id']) && $smogihistory[$j]['points_current'] > 0)
                    {
                        if($smogihistory[$j]['points_current'] >= $temp)
                        {
                            $smogihistory[$j]['points_current'] -= $temp;
                            $smogihistory[$j]['balance'] -= $temp;
                            array_push($unsetarray,$i);
                            $smogihistory[$i]['points_spent'] = 0;
                        }
                    }
                }
            }
        }

        $lastindex = count($smogihistory);
        if($excludelast)
            $lastindex--;
        for($i = 0; $i < $lastindex; $i++)
        {
            if($smogihistory[$i]['points_spent'] <= 0)
                continue;
            $temp = $smogihistory[$i]['points_spent'];
            $negativebalance = 0;


            $temparray = array();
            for($j = 0; $j < $i; $j++)
            {
                array_push($temparray, array(
                    "index" => $j,
                    "date_end" => $smogihistory[$j]['date_end'],
                    "balance" => $smogihistory[$j]['balance']
                ));
            }
            $date_end = array();
            foreach($temparray as $key => $value)
            {
                $date_end[$key] = $value['date_end'];
            }
            array_multisort($date_end, SORT_ASC, $temparray);
            for($j = 0; $j < $i; $j++)
            {
                if((strtotime($temparray[$j]['date_end']) > strtotime($smogihistory[$i]['date_start'])) && $temparray[$j]['balance'] > 0)
                {
                    if($temparray[$j]['balance'] >= $temp)
                    {
                        $smogihistory[$temparray[$j]['index']]['balance'] -= $temp;
                        $temp = 0;
                    }
                    else
                    {
                        $temp -= $temparray[$j]['balance'];
                        $smogihistory[$temparray[$j]['index']]['balance'] = 0;
                    }
                }
                if($temp <= 0)
                    break;
            }

            /*
            for($j = 0; $j < $i; $j++)
            {
                if((strtotime($smogihistory[$j]['date_end']) > strtotime($smogihistory[$i]['date_start'])) && $smogihistory[$j]['balance'] > 0)
                {
                    if($smogihistory[$j]['balance'] >= $temp)
                    {
                        $smogihistory[$j]['balance'] -= $temp;
                        $temp = 0;
                    }
                    else
                    {
                        $temp -= $smogihistory[$j]['balance'];
                        $smogihistory[$j]['balance'] = 0;
                    }
                }
                if($temp <= 0)
                    break;
            }
            */
        }
        $negativebalance += $temp;
        $balance = 0;
        for($i = 0; $i < count($smogihistory); $i++)
        {
            if(strtotime($smogihistory[$i]['date_end']) > strtotime($date))
            {
                $balance += $smogihistory[$i]['balance'];
            }
        }
        if(!$arraymode)
            return $balance;
        else
            return array("history" => $smogihistory,"balance" => $balance,"negativebalance" => $negativebalance);
//        echo "<pre>";
//        print_r($smogihistory);
//        echo "<pre>";
        //echo 'Current Balance -> '.$balance;
    }

    public function getPointsCurrent_excludelast($customerid, $store_id, $date = null, $arraymode = false){
        if($date == null)
            $date = date('Y-m-d');
        $balanceon = strtotime($date);
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $query = "SELECT * FROM (SELECT points_current, points_spent,points_current AS 'balance',date_start,date_end,rewardpoints_account_id FROM rewardpoints_account WHERE customer_id = ".$customerid." AND order_id IN (-3,-2,-1,-20) UNION SELECT points_current, points_spent,points_current AS 'balance',date_start,date_end,rewardpoints_account_id FROM rewardpoints_account, sales_flat_order WHERE rewardpoints_account.customer_id = ".$customerid." AND order_id NOT IN (-3,-2,-1,-20) AND sales_flat_order.increment_id = rewardpoints_account.order_id AND sales_flat_order.state IN ('new','pending','processing','complete')) AS smogihistory ORDER BY rewardpoints_account_id";
        $smogihistory = $read->fetchAll($query);
        for($i = 0; $i < count($smogihistory) - 1; $i++)
        {
            if($smogihistory[$i]['points_spent'] <= 0)
                continue;
            $temp = $smogihistory[$i]['points_spent'];
            $negativebalance = 0;
            for($j = 0; $j < $i; $j++)
            {
                if((strtotime($smogihistory[$j]['date_end']) > strtotime($smogihistory[$i]['date_start'])) && $smogihistory[$j]['balance'] > 0)
                {
                    if($smogihistory[$j]['balance'] >= $temp)
                    {
                        $smogihistory[$j]['balance'] -= $temp;
                        $temp = 0;
                    }
                    else
                    {
                        $temp -= $smogihistory[$j]['balance'];
                        $smogihistory[$j]['balance'] = 0;
                    }
                }
                if($temp <= 0)
                    break;
            }
        }
        $negativebalance += $temp;
        $balance = 0;
        for($i = 0; $i < count($smogihistory); $i++)
        {
            if(strtotime($smogihistory[$i]['date_end']) > strtotime($date))
            {
                $balance += $smogihistory[$i]['balance'];
            }
        }
        if(!$arraymode)
            return $balance;
        else
            return array("history" => $smogihistory,"balance" => $balance,"negativebalance" => $negativebalance);
//        echo "<pre>";
//        print_r($smogihistory);
//        echo "<pre>";
        //echo 'Current Balance -> '.$balance;
    }

    public function getPointsCurrent_old($customerid, $store_id, $date = null, $arraymode = false){

        if($date == null)
            $date = date('Y-m-d');
        //$customerid = $this->getRequest()->getParam('customerid');
        $balanceon = strtotime($date);
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $query= "SELECT * FROM  (SELECT SUM(points_current) AS points, date_end FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_current > 0 AND order_id IN (-3,-2,-1,-20) GROUP BY date_end UNION SELECT SUM(points_current) AS points, date_end FROM rewardpoints_account, sales_flat_order WHERE sales_flat_order.increment_id = rewardpoints_account.order_id AND sales_flat_order.state IN ('new','pending', 'processing', 'complete') AND order_id NOT IN (-3,-2,-1,-20) AND rewardpoints_account.customer_id = ".$customerid." AND points_current > 0 GROUP BY date_end) AS temp ORDER BY date_end";
        Mage::log($query,null,"distribution.log");
        $readresult=$read->query("SELECT * FROM  (SELECT SUM(points_current) AS points, date_end FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_current > 0 AND order_id IN (-3,-2,-1,-20) GROUP BY date_end UNION SELECT SUM(points_current) AS points, date_end FROM rewardpoints_account, sales_flat_order WHERE sales_flat_order.increment_id = rewardpoints_account.order_id AND sales_flat_order.state IN ('new','pending', 'processing', 'complete') AND order_id NOT IN (-3,-2,-1,-20) AND rewardpoints_account.customer_id = ".$customerid." AND points_current > 0 GROUP BY date_end) AS temp ORDER BY date_end");

        $arrEarnedPoints = array();
        while($row = $readresult->fetch())
        {
            array_push($arrEarnedPoints, array("points" => $row['points'], "expiry" => $row['date_end'], "balance" => $row['points']));
        }
        $arrSpentPoints = array();
        //$readresult=$read->query("SELECT SUM(points_spent) AS points, date_start FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_spent > 0 GROUP BY date_start ORDER BY date_start");
        $readresult=$read->query("SELECT * FROM (SELECT SUM(points_spent) AS points, date_start FROM rewardpoints_account WHERE customer_id = ".$customerid." AND points_spent > 0 AND order_id IN (-3,-2,-1,-20) GROUP BY date_start UNION SELECT SUM(points_spent) AS points, date_start FROM rewardpoints_account, sales_flat_order WHERE sales_flat_order.increment_id = rewardpoints_account.order_id AND sales_flat_order.state IN ('new','pending', 'processing', 'complete')  AND order_id NOT IN (-3,-2,-1,-20) AND rewardpoints_account.customer_id = ".$customerid." AND points_spent > 0 GROUP BY date_start) AS temp ORDER BY date_start ");
        while($row = $readresult->fetch())
        {
            array_push($arrSpentPoints, array("points" => $row['points'], "usedon" => $row['date_start']));
        }


        foreach($arrSpentPoints as $spentinfo)
        {
            $temp = $spentinfo['points'];
            foreach($arrEarnedPoints as $key => $value)
            {

                if((strtotime($arrEarnedPoints[$key]['expiry']) > strtotime($spentinfo['usedon'])) && ($arrEarnedPoints[$key]['balance'] > 0))
                {
                    if($arrEarnedPoints[$key]['balance'] >= $temp)
                    {

                        $arrEarnedPoints[$key]['balance'] -= $temp;
                        $temp = 0;
                    }
                    else
                    {
                        $temp -= $arrEarnedPoints[$key]['balance'];
                        $arrEarnedPoints[$key]['balance'] = 0;
                    }

                    if($temp <= 0)
                        break;
                }
            }

        }
        $balance = 0;
        foreach($arrEarnedPoints as $earninfo)
        {
            if(strtotime($earninfo['expiry']) > $balanceon)
            {
                $balance += $earninfo['balance'];
            }
        }
        //echo "balance = ".$balance;
        if(!$arraymode)
            return $balance;
        else
            return array("history" => $arrEarnedPoints,"balance" => $balance);
        $total = $this->getPointsReceived($customer_id, $store_id) - $this->getPointsSpent($customer_id, $store_id);
        if ($total > 0){
            return $total;
        } else {
            return 0;
        }
    }

    public function recordPoints($pointsInt, $customerId, $orderId, $store_id, $force_nodelay = false) {
        $post = array(
            'order_id' => $orderId,
            'customer_id' => $customerId,
            'store_id' => $store_id,
            'points_current' => $pointsInt,
            'convertion_rate' => Mage::getStoreConfig('rewardpoints/default/points_money', $store_id)
        );
        //v.2.0.0
        $add_delay = 0;
        if ($delay = Mage::getStoreConfig('rewardpoints/default/points_delay', $store_id) && $force_nodelay){
            if (is_numeric($delay)){
                $post['date_start'] = $this->getResource()->formatDate(mktime(0, 0, 0, date("m"), date("d")+$delay, date("Y")));
                $add_delay = $delay;
            }
        }

        if ($duration = Mage::getStoreConfig('rewardpoints/default/points_duration', $store_id)){
            if (is_numeric($duration)){
                if (!isset($post['date_start'])){
                    $post['date_start'] = $this->getResource()->formatDate(time());
                }
                $post['date_end'] = $this->getResource()->formatDate(mktime(0, 0, 0, date("m"), date("d")+$duration+$add_delay, date("Y")));
            }
        }
        $this->setData($post);
        $this->save();
    }
    public function orderLog($orderNumber, $process, $creditMemoId = null, $log, $logType )
    {
        $resource = Mage::getSingleton('core/resource');
 		$readConnection = $resource->getConnection('core_write');
        Mage::log("Insert into smogi_debug_info values (NULL, '$orderNumber', '$process','$creditMemoId','$logType','$log',NOW())",null,'distribution.log');
		$readConnection->query("Insert into smogi_debug_info values (NULL, '$orderNumber', '$process','$creditMemoId','$logType','$log',NOW())");
    }

    public function getPointsCurrentdefault($customer_id, $store_id){
        $total = $this->getPointsReceived($customer_id, $store_id) - $this->getPointsSpent($customer_id, $store_id);
        if ($total > 0){
            return $total;
        } else {
            return 0;
        }
    }
    
    public function ordercompleteoperations($order, $source)
    {
        $lastOrderId = $order->getId();
        $this->orderLog($order->getIncrementId(), 'discount distribution', '',$source, 'Source');
        try{
            $write = Mage::getSingleton('core/resource')->getConnection('core_write');
            $readresult=$write->query("Select base_discount_amount, rewardpoints_quantity, grand_total, coupon_code,store_id,entity_id,customer_id,increment_id from sales_flat_order where entity_id=".$lastOrderId);
            $row = $readresult->fetch();
            $smogiused = false;
			//Mage::log("Base Discount = ".$row['base_discount_amount'],null,'distribution.log');
            $this->orderLog($order->getIncrementId(), 'discount distribution', '',$row['base_discount_amount'], 'Base Discount Amount');    
            $couponcode = $row['coupon_code'];
            $this->orderLog($order->getIncrementId(), 'discount distribution', '',$couponcode, 'Coupon Code');
            //if($row['base_discount_amount'] < 0 && $row['grand_total'] > 0)
            if($row['base_discount_amount'] < 0 && $row['grand_total'] > 0 && $row['coupon_code'] == '')
            {
                $discount_amount = $row['base_discount_amount'] * -1;
				//Mage::log("Rewardpoints = ".$row['rewardpoints_quantity'],null,'distribution.log');
                $this->orderLog($order->getIncrementId(), 'discount distribution', '',$row['rewardpoints_quantity'], 'SMOGI Bucks Used');
                if($row['rewardpoints_quantity'] > 0)
                {
                    $this->smogi_setstartdate($order->getIncrementId());
                    $smogiused = true;
                    $this->smogi_storeExpiryDate($row);
                }

                //Mage::log("Smogi used = $smogiused",null,'distribution.log');        
                $readresult=$write->query("Select entity_id from sales_flat_invoice where order_id=".$lastOrderId);
                $row = $readresult->fetch();
                if($row)
                    $invoiceid = $row['entity_id'];
                else{
                    $invoiceid = '';
                }
                $arrOrderItem = array();
                $readresult=$write->query("Select product_id, row_total_incl_tax, item_id from sales_flat_order_item where order_id=".$lastOrderId." and price > 0");
                while ($row = $readresult->fetch() ) {
                    $temp = array();
                    $temp['product_id'] = $row['product_id'];
                    $temp['price'] = $row['row_total_incl_tax'];
                    $temp['item_id'] = $row['item_id'];
                    $temp['exclude'] = 0;
                    if($smogiused)
                    {
                        $write1 = Mage::getSingleton('core/resource')->getConnection('core_write');
                        $readresult1=$write1->query("SELECT COUNT(*) AS cnt FROM catalog_category_product ccp, catalog_category_flat_store_1 ccfs WHERE ccp.product_id = ".$row['product_id']." AND ccfs.entity_id = ccp.category_id AND category_id IN (".Mage::getModel('core/variable')->loadByCode('nosmogicategories ')->getValue('plain').")");
                        //Mage::log("SELECT COUNT(*) AS cnt FROM catalog_category_product ccp, catalog_category_flat_store_1 ccfs WHERE ccp.product_id = ".$row['product_id']." AND ccfs.entity_id = ccp.category_id AND category_id IN (".Mage::getModel('core/variable')->loadByCode('nosmogicategories ')->getValue('plain').")",null,'distribution.log');
                        $row1 = $readresult1->fetch();
                        if($row1['cnt'] > 0)
                        {
                            $temp['exclude'] = 1;
                            Mage::log("Excluded = ".$row['product_id'],null,'distribution.log');
                            $this->orderLog($order->getIncrementId(), 'discount distribution', '',$row['product_id'], 'Excluding Product ID for distribution');            
                        }
                    }
                    array_push($arrOrderItem, $temp);
                }
                $total = 0;
                for($i = 0; $i < count($arrOrderItem); $i++)
                {
                    if($arrOrderItem[$i]['exclude'] == 0)
                        $total += $arrOrderItem[$i]['price'];
                }
				//Mage::log("Total Calculatable = ".$total,null,'distribution.log');
                $this->orderLog($order->getIncrementId(), 'discount distribution', '',$total, 'Total Amount of products applicable for discount.');
                $temp = 0;
                for($i = 0; $i < count($arrOrderItem); $i++)
                {
                    if($arrOrderItem[$i]['exclude'] == 1)
                    {
                        $arrOrderItem[$i]['price'] = 0;    
                    }
                    else
                    {
                        if($couponcode == '')
                        {
                            $percent = round((($arrOrderItem[$i]['price'] / $total) * 100), 2);
                            $discount = round(($discount_amount * $percent) / 100);    
                        }
                        else
                        {
                            $percent = ($arrOrderItem[$i]['price'] / $total) * 100;
                            $discount = round((($discount_amount * $percent) / 100), 2);
                            Mage::log($arrOrderItem[$i]['product_id']." - ".$percent."% - ".$discount,null,'distribution.log');
                        }
                        $temp += $discount;
                        $arrOrderItem[$i]['price'] = $discount;   
                    }
                    //Mage::log($arrOrderItem[$i]['price']."  ".$arrOrderItem[$i]['product_id'] ,null,'distribution.log');
                    $this->orderLog($order->getIncrementId(), 'discount distribution', '',$arrOrderItem[$i]['price'], 'New Discount for Product ID = '.$arrOrderItem[$i]['product_id']);
                }
                Mage::log($temp."   ".$discount_amount,null,'distribution.log');    
                $this->orderLog($order->getIncrementId(), 'discount distribution', '',$temp, 'Sum of all allocated discounts');
                if($temp < $discount_amount)
                {
                    for($i = count($arrOrderItem)-1; $i >=0 ; $i--)
                    {
                        if($arrOrderItem[$i]['exclude'] == 0)
                        {
                            $arrOrderItem[$i]['price'] += ($discount_amount - $temp);
                            $this->orderLog($order->getIncrementId(), 'discount distribution', '',$arrOrderItem[$i]['price'], 'Allocated amount is less than discount amount, new discount for Product ID = '.$arrOrderItem[$i]['product_id']);
                            break;
                        }
                        //$arrOrderItem[count($arrOrderItem) - 1]['price'] += ($discount_amount - $temp);
                    }

                }
                if($temp > $discount_amount)
                {
                    for($i = count($arrOrderItem)-1; $i >=0 ; $i--)
                    {
                        if($arrOrderItem[$i]['exclude'] == 0)
                        {
                            $arrOrderItem[$i]['price'] -= ($temp - $discount_amount);
                            $this->orderLog($order->getIncrementId(), 'discount distribution', '',$arrOrderItem[$i]['price'], 'Allocated amount is more than discount amount, new discount for Product ID = '.$arrOrderItem[$i]['product_id']);
                            break;
                        }
                        //$arrOrderItem[count($arrOrderItem) - 1]['price'] += ($discount_amount - $temp);
                    }

                }
                for($i = 0; $i < count($arrOrderItem); $i++)
                {
                    //$readresult=$write->query("Update sales_flat_order_item set discount_amount=".$arrOrderItem[$i]['price'].", base_discount_amount=".$arrOrderItem[$i]['price'].", discount_invoiced=".$arrOrderItem[$i]['price'].", base_discount_invoiced=".$arrOrderItem[$i]['price']." where order_id=".$lastOrderId." and product_id=".$arrOrderItem[$i]['product_id']);
                    $readresult=$write->query("Update sales_flat_order_item set discount_amount=".$arrOrderItem[$i]['price'].", base_discount_amount=".$arrOrderItem[$i]['price'].", discount_invoiced=".$arrOrderItem[$i]['price'].", base_discount_invoiced=".$arrOrderItem[$i]['price']." where order_id=".$lastOrderId." and item_id=".$arrOrderItem[$i]['item_id']);
                    if($invoiceid !='')
                    $readresult=$write->query("Update sales_flat_invoice_item set discount_amount=".$arrOrderItem[$i]['price'].", base_discount_amount=".$arrOrderItem[$i]['price']." where parent_id=".$invoiceid." and order_item_id=".$arrOrderItem[$i]['item_id']);
                }
                //Mage::log($temp."   ".$discount_amount,null,'distribution.log');
            }
            else
            {
                $this->orderLog($order->getIncrementId(), 'discount distribution', '','Reward Points is not used hence exiting.', 'EXIT');
            }
            $readresult=$write->query("SELECT COUNT(item_id) AS cnt FROM sales_flat_order_item WHERE order_id=".$lastOrderId." AND qty_backordered>0");
            $row = $readresult->fetch();
            
            if($row['cnt'] > 0)
            {
               // $order = Mage::getModel('sales/order')->load($lastOrderId);
                $order->addStatusHistoryComment("This order contains Pre-Ordered items.");
                $order->save();   
            }
            /*
            if($smogiused)
            {

                // $query = "SELECT * FROM rewardpoints_account WHERE order_id = '".$order->getIncrementId()."' and date_start is null order by rewardpoints_account_id desc limit 1";
                // Mage::log($query,null,'distirbution.log');
                $readresult=$write->query("SELECT * FROM rewardpoints_account WHERE order_id = '".$order->getIncrementId()."' and date_start is null order by rewardpoints_account_id desc limit 1");
                $row = $readresult->fetch();
                //  $query = "Update rewardpoints_account set date_start='".date('Y-m-d')."' where rewardpoints_account_id=".$row['rewardpoints_account_id'];
                //  Mage::log($query,null,'distirbution.log');
                $write->query("Update rewardpoints_account set date_start='".date('Y-m-d')."' where rewardpoints_account_id=".$row['rewardpoints_account_id']);
                $this->orderLog($order->getIncrementId(), 'smogi used point date', '',$row['rewardpoints_account_id'], 'Setting date for used smogi points = '.date('Y-m-d'));
            }*/
        }
        catch(Exception $e)
        {
            //Mage::log("Error Occured".$e->getMessage(),null,'distribution.log');
            $this->orderLog($order->getIncrementId(), 'discount distribution', '',$e->getMessage(), 'ERROR');
        }
    }
    public function smogi_setstartdate($incrementid)
    {
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $readresult=$write->query("SELECT * FROM rewardpoints_account WHERE order_id = '".$incrementid."' and date_start is null order by rewardpoints_account_id desc limit 1");
        $row = $readresult->fetch();
        $write->query("Update rewardpoints_account set date_start='".date('Y-m-d')."' where rewardpoints_account_id=".$row['rewardpoints_account_id']);
        $this->orderLog($incrementid, 'smogi used point date', '',$row['rewardpoints_account_id'], 'Setting date for used smogi points = '.date('Y-m-d'));
    }
    public function smogi_storeExpiryDate($orderinfo)
    {
        $smogi_balance = $this->getPointsCurrent($orderinfo['customer_id'], $orderinfo['store_id'], null, true, true);
        Mage::log(json_encode($smogi_balance),null,'smogi_balance.log');
        //Mage::getModel('rewardpoints/stats')->orderLog($orderinfo['increment_id'], 'smogi expiry date', '',json_encode($smogi_balance), 'Current SMOGI Balance');
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $arrEarnedPoints = $smogi_balance['history'];
        $temp = $orderinfo['rewardpoints_quantity'];
        $date_end = array();
        foreach($arrEarnedPoints as $key => $value)
        {
            $date_end[$key] = $value['date_end'];
        }
        array_multisort($date_end, SORT_ASC, $arrEarnedPoints);
        foreach($arrEarnedPoints as $key => $value)
        {
            if($arrEarnedPoints[$key]['points_current'] <= 0)
                continue;
            if((strtotime($arrEarnedPoints[$key]['date_end']) > strtotime(date('Y-m-d'))) && ($arrEarnedPoints[$key]['balance'] > 0))
            {
                if($arrEarnedPoints[$key]['balance'] >= $temp)
                {
                    $write->query("Insert into smogi_store_expiry_date values(null,".$orderinfo['entity_id'].",".$orderinfo['customer_id'].",".$temp.",'".$arrEarnedPoints[$key]['date_end']."',0)");
                    $temp = 0;
                }
                else
                {
                    $write->query("Insert into smogi_store_expiry_date values(null,".$orderinfo['entity_id'].",".$orderinfo['customer_id'].",".$arrEarnedPoints[$key]['balance'].",'".$arrEarnedPoints[$key]['date_end']."',0)");
                    $temp -= $arrEarnedPoints[$key]['balance'];
                }
                if($temp <= 0)
                    break;
            }
        }
    }
}

