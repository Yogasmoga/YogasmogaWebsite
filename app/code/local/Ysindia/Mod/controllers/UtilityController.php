<?php

class Ysindia_Mod_UtilityController extends Mage_Core_Controller_Front_Action
{

    // for bundle gift set
    public function citytimeAction()
    {
        $city_times = $this->getRequest()->getParam('city_times');

        if(isset($city_times)){

            $times = array();

            $ar_city_times = explode(",", $city_times);

            foreach($ar_city_times as $city_time) {

                $timestamp = strtotime($city_time);

                $time = date('H:i A', $timestamp);

                $times[] = $time;
            }

            echo json_encode(array('message'=>'found', 'times' => $times, 'date' => date("H:i")));
        }
        else
            echo json_encode(array('message'=>'none'));
    }
}