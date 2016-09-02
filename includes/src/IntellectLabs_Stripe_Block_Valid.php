<?php
/**
 * Valid Block
 *
 * @category   IntellectLabs
 * @package    IntellectLabs_Stripe
 * @author     Matt Kammersell <matt@kammersell.com>
 * @copyright  Intellect Labs, Inc <http://www.intellectlabs.com>
 * @license	   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class IntellectLabs_Stripe_Block_Valid extends Mage_Core_Block_Template
{
    public function _toHtml()
    {
        $helper = Mage::helper('stripe');
        $message = false;

        if($helper->checkSerial()) {
            return '';
        }
        
        return sprintf(base64_decode('PGRpdiBzdHlsZT0iYm9yZGVyOiBkb3R0ZWQgNHB4IHJlZDsgY29sb3I6IHJlZDsgZm9udC1mYWNlOiAnQXJpYWwgQmxhY2snOyI+SW52YWxpZCBzZXJpYWwgZm9yICVzIFBsZWFzZSBlbnRlciBhIHZhbGlkIHNlcmlhbCBudW1iZXIgb3IgY29udGFjdCBzdXBwb3J0QGludGVsbGVjdGxhYnMuY29tPC9kaXY+'),$_SERVER['SERVER_NAME']);
    }
}

