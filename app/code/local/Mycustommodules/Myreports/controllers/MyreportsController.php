<?php
class Mycustommodules_Myreports_MyreportsController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $readresult=$write->query("SELECT * FROM custom_reports");
        while ($row = $readresult->fetch() ) {
            echo $row['title'].'<BR>';
        }
    }
}
?>