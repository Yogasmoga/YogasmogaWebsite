<?php
/**
 * Payment CC Types Source Model
 *
 * @category	IntellectLabs
 * @package		IntellectLabs_Stripe
 * @author		Matthew Kammersell <matt@kammersell.com>
 * @copyright	Intellect Labs, Inc <http://intellectlabs.com>
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class IntellectLabs_Stripe_Model_Source_Cctype extends Mage_Payment_Model_Source_Cctype
{
	protected $_allowedTypes = array('AE','VI','MC','DI','JCB','OT');
}
