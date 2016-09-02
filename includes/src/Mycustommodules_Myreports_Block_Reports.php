<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Mycustommodules_Myreports_Block_Reports extends Mage_Core_Block_Template  {
    
    function getReports(){
//        if($this->getRequest()->getPost()) echo $id=$this->getRequest()->getPost('id');
//        $cond='';
//        if(!empty($id))$cond='id='.$id;
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $readresult=$write->query("SELECT * FROM custom_reports where status=1 ");
        return $readresult->fetchAll();
    }
}
