<?php 

	require_once 'app/Mage.php';
	Mage::app();
	$productsCollection = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('type_id','configurable');
        
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=configurable-products.csv');
	$output = fopen('php://output', 'w');


	fputcsv($output, array('parent_product_name', 'simple_sku', 'simple_product_name','qty','price','category_ids'));
	foreach($productsCollection as $product){
	 
		$configurableProducts = Mage::getModel('catalog/product_type_configurable')->setProduct($product);
		$simple_collection = $configurableProducts->getUsedProductCollection()->addAttributeToSelect('*')->addFilterByRequiredOptions();
		foreach($simple_collection as $simple_product){
			
			$categoryIds = $simple_product->getCategoryIds();
			$categoryIds = implode(',',$categoryIds);
			$stock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($simple_product);
			
			$rows = array(
					'parent_product_name' => $product->getName(),
					'simple_sku' => $simple_product->getSku(),
					'simple_product_name' => $simple_product->getName(),
					'qty' =>floor($stock->getQty()),
					'price' => Mage::helper('core')->currency($simple_product->getPrice(),true,false),
					'category_ids' => $categoryIds
				);
		fputcsv($output, $rows);			
		}
	}

	
?>