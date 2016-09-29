<?php
class Ysindia_Bannerslider_Block_Adminhtml_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{

    public function render(Varien_Object $row)
    {

        $html = '<img  style="max-width:100px; width:100%"';
        $html .= 'id="' . $this->getColumn()->getId() . '" ';
        $html .= 'src="' .Mage::getBaseUrl('media').'slider/'. $row->getData($this->getColumn()->getIndex()) . '"';
        $html .= 'class="grid-image ' . $this->getColumn()->getInlineCss() . '"/>';
        return $html;

        //$value1 =  $row->getData($this->getColumn()->getIndex());
        //return $value1;
   //     echo "<pre/>";
     //   print_r($row);

    }
}