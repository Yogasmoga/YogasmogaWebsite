<?php
class Mage_Adminhtml_Block_Sales_Order_Renderer_Qtybool extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
public function render(Varien_Object $row)
{
$value =  $row->getData($this->getColumn()->getIndex());

if($value)
{
//return '<span style="color:green;">'.$value.'</span>';
return '<span style="color:green;">'.'Yes'.'</span>';

}else
{
//return '<span style="color:red;">'.'No'.'</span>';

}
}
}
?>