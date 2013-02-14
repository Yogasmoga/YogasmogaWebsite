<?php 
class Mycustommodules_Myessentials_MylinkController extends Mage_Core_Controller_Front_Action
{
    public function testAction()
    {
        echo "Output from link Module";
    }
    
    public function getshorturlAction()
    {
        //$arr['longurl'] = urlencode($this->getRequest()->getPost('longurl'));
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
}
?>