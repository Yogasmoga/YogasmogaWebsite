<?php
class Pixel_Tracking_Model_Observer
{

    public function handle_me($observer)
	{
		/*$block = $this->getLayout()->createBlock('Mage_Core_Block_Text');       
		$block->setText('<script type="text/javascript">var fb_param = {};
		fb_param.pixel_id = "6013735872746";
		fb_param.value = "0.00";
		fb_param.currency = "USD";
		(function(){
		var fpw = document.createElement("script");
		fpw.async = true;
		fpw.src = "//connect.facebook.net/en_US/fp.js";
		var ref = document.getElementsByTagName("script")[0];
		ref.parentNode.insertBefore(fpw, ref);
		})();</script>');                 
		 $this->getLayout()->getBlock('content')->append($block);
		return $this; */
		
		Mage::getSingleton('customer/session')->setCustomerRegistered('yes');
	}
}

