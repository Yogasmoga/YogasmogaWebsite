<?php
class Mage_Adminhtml_Block_Sales_Order_Renderer_Qtybool extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
public function render(Varien_Object $row)
{
 $value1 =  $row->getData($this->getColumn()->getIndex());

if($value1)
{
//return '<span style="color:green;">'. $value1.'</span>';
return '<span style="color:green;">'.'Yes'.'</span>';

}elseif($value1=='')
{
//return '<span style="color:red;">'.(int)$value1.'</span>';
return '<span style="color:red;">'.'No'.'</span>';

}
}
}
?>