<?php
class IntellectLabs_Stripe_Model_Source_PaymentAction
{
	public function toOptionArray()
	{
		return array(
				array(
						'value' => IntellectLabs_Stripe_Model_Payment::ACTION_AUTHORIZE,
						'label' => Mage::helper('paygate')->__('Authorize Only')
				),
				array(
						'value' => IntellectLabs_Stripe_Model_Payment::ACTION_AUTHORIZE_CAPTURE,
						'label' => Mage::helper('paygate')->__('Authorize and Capture')
				),
		);
	}
}