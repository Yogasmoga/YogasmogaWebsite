<?php
class Mailchimp_Mod_Adminhtml_CustomController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $myfile = fopen("mailchimp_list.txt", "r");
        $str = fgets($myfile);
        fclose($myfile);

        if(isset($str)) {
            $ar = explode(",", $str);

            if(is_array($ar) && count($ar)>0) {
                $apikey = $ar[0];
                $listid = $ar[1];
            }
            else{
                $apikey = "";
                $listid = "";
            }
        }
        else{
            $apikey = "";
            $listid = "";
        }

        Mage::register('apikey',$apikey);
        Mage::register('listid',$listid);

        $message = Mage::getSingleton('core/session')->getMessage();

        if(isset($message) && strlen($message)>0)
            ;
        else
            $message = "";

        Mage::register('message',$message);

        $this->loadLayout();
        $this->_title($this->__("Mailchimp Settings"));
        $this->renderLayout();

        Mage::getSingleton('core/session')->setMessage("");
    }

    public function saveAction(){
        $data = $this->getRequest()->getPost();

        $apikey = $data['apikey'];
        $listid = $data['listid'];

        $myfile = fopen("mailchimp_list.txt", "w");
        fwrite($myfile, "$apikey,$listid");
        fclose($myfile);

        $message = 'Mailchimp settings saved successfully.';
        Mage::getSingleton('core/session')->setMessage($message);

        $this->_redirect('mod/adminhtml_custom/index');
    }

    public function unsubscribeAction(){

        $message = Mage::getSingleton('core/session')->getUnsubscribemessage();

        if(isset($message) && strlen($message)>0)
            ;
        else
            $message = "";

        Mage::register('unsubscribemessage',$message);

        $this->loadLayout();
        $this->_title($this->__("Unsubscribe Customer"));
        $this->renderLayout();

        Mage::getSingleton('core/session')->setUnsubscribemessage("");
    }

    public function unsubscribecustomerAction(){
        $data = $this->getRequest()->getPost();

        $email = $data['email'];

        Mage::getModel('newsletter/subscriber')->loadByEmail($email)->unsubscribe();

        $myfile = fopen("mailchimp_list.txt", "r");
        $str = fgets($myfile);
        fclose($myfile);

        $ar = explode(",", $str);

        $api_key = $ar[0];
        $list_id = $ar[1];

        include("mailchimpapi/Drewm/MailChimp.php");

        $mailChimp = new Drewm\MailChimp($api_key);

        $result = $mailChimp->call('lists/unsubscribe', array(
            'id'                => $list_id,
            'email'             => array('email'=>$email),
            'delete_member'     => false,
            'send_goodbye'      => false,
            'send_notify'      => false,
        ));

        $message = 'Customer unsubscribed successfully.';
        Mage::getSingleton('core/session')->setUnsubscribemessage($message);

        $this->_redirect('mod/adminhtml_custom/unsubscribe');
    }
}