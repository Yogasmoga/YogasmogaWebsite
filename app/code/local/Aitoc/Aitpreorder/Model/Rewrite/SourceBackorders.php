<?php
/**
 * Product:     Pre-Order
 * Package:     Aitoc_Aitpreorder_1.1.25_398049
 * Purchase ID: GFmKN376RqwlXbrxLFev6fwkrQkQ4sDnXgpK7XouBr
 * Generated:   2012-10-12 17:01:01
 * File path:   app/code/local/Aitoc/Aitpreorder/Model/Rewrite/SourceBackorders.php
 * Copyright:   (c) 2012 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ wIIYegBakZyhTUka('e1881b6ce888fe7c0be884bc9f832391'); ?><?php
/**
 * @copyright  Copyright (c) 2011 AITOC, Inc.
 */
class Aitoc_Aitpreorder_Model_Rewrite_SourceBackorders extends Mage_CatalogInventory_Model_Source_Backorders
{
	const BACKORDERS_YES_PREORDERS = 30;
	public function toOptionArray()
    {
        $options = parent::toOptionArray();

		$options[] = array(
			'value' => self::BACKORDERS_YES_PREORDERS,
			'label'=>Mage::helper('cataloginventory')->__('Preorders')
		);

		return $options;
    }
}
 } ?>