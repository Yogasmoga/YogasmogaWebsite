<?php
/**
 * Sugarcrm user operations collection
 *
 * @category   Belitsoft
 * @package    Belitsoft_Sugarcrm
 * @author     Belitsoft <bits@belitsoft.com>
 */
class Belitsoft_Sugarcrm_Model_Mysql4_Operations_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('sugarcrm/operations');
    }
}