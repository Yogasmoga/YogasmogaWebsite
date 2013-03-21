<?php 
class Mycustommodules_Myessentials_MylinkController extends Mage_Core_Controller_Front_Action
{
    public function testAction()
    {
        echo "Output from link Module";
    }
    
    public function getshorturlAction()
    {
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        
        $long_url = urlencode($this->getRequest()->getPost('longurl'));
        $readresult=$write->query("SELECT shorturl from bitly where longurl='".$long_url."'");
        $short_url = "";
        
        while ($row = $readresult->fetch() ) {
            $short_url = $row['shorturl'];
        }
        
        if($short_url == "")
        {
            $short_url = trim(file_get_contents("https://api-ssl.bitly.com/v3/shorten?longUrl=".$long_url."&APIKEY=R_487d67928c881cbd14a7d13f6acaafde&LOGIN=yogasmoga&format=txt"));
            $write->query("Insert into bitly values(\"".$long_url."\",'".$short_url."')");
        }
        $arr['shorturl'] = $short_url;
        $arr['id'] = $this->getRequest()->getPost('id');
        echo json_encode($arr);
        return;
        
        
        //$arr['longurl'] = urlencode($this->getRequest()->getPost('longurl'));
        $arr['id'] = $this->getRequest()->getPost('id');
        $long_url = urlencode($this->getRequest()->getPost('longurl'));
        $arr['shorturl'] = trim(file_get_contents("https://api-ssl.bitly.com/v3/shorten?longUrl=".$long_url."&APIKEY=R_487d67928c881cbd14a7d13f6acaafde&LOGIN=yogasmoga&format=txt"));
        echo json_encode($arr);
        return;
        
        $bitly_login = 'yogasmoga';
        $bitly_apikey = 'R_487d67928c881cbd14a7d13f6acaafde';
        $short_url = $bitly_response->data->url;
        
        
        $this->getRequest()->getPost('longurl');
        echo "Output from link Module";
    }
    
    public function applycardAction()
    {
        $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        $giftcardCode = trim((string) $this->getRequest()->getParam('giftcard_code'));
        $card = Mage::getModel('giftcards/giftcards')->load($giftcardCode, 'card_code');
        if ($card->getId() && $card->getCardStatus() == 2) {
            $card->activateCardForCustomer($customerId);
            $arr['result'] = 'success';
            $arr['balance'] = Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomerId());
            echo json_encode($arr);
    	} else {
           $arr['result'] = 'Invalid Gift of YS Card Code';
           //$arr['balance'] = Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomerId());
           echo json_encode($arr);
    	}
    }
}
?>