<?php
/**
 * Magento to SugarCRM bridge
 *
 * @category   Belitsoft
 * @package    Belitsoft_Sugarcrm
 * @author     Belitsoft <bits@belitsoft.com>
 */

class Belitsoft_Sugarcrm_Block_Adminhtml_Operations_Userorder_Stages_Cases extends Belitsoft_Sugarcrm_Block_Adminhtml_Operations_Userorder_Stages_Opportunities
{
	public function getStageType()
	{
		return 'opportunities';
	}
}
