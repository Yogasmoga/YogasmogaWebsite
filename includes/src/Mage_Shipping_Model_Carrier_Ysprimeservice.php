<?php
class Mage_Shipping_Model_Carrier_Ysprimeservice
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
    {
        protected $_code = 'ysprimeservice';
        public function collectRates(Mage_Shipping_Model_Rate_Request $request)
        {
            if (!$this->getConfigFlag('active')) {
                return false;
            }
            $freeBoxes = 0;
            if ($request->getAllItems()) {
                foreach ($request->getAllItems() as $item) {
                    if ($item->getFreeShipping() && !$item->getProduct()->isVirtual()) {
                        $freeBoxes+=$item->getQty();
                    }
                }
            }
            $this->setFreeBoxes($freeBoxes);
            $result = Mage::getModel('shipping/rate_result');
            if ($this->getConfigData('type') == 'O') { // per order
                $shippingPrice = $this->getConfigData('price');
            } elseif ($this->getConfigData('type') == 'I') { // per item
                $shippingPrice = ($request->getPackageQty() * $this->getConfigData('price')) - ($this->getFreeBoxes() * $this->getConfigData('price'));
            } else {
                $shippingPrice = false;
            }
            $shippingPrice = $this->getFinalPriceWithHandlingFee($shippingPrice);
            if ($shippingPrice !== false) {
                $method = Mage::getModel('shipping/rate_result_method');
                $method->setCarrier('ysprimeservice');
                $method->setCarrierTitle($this->getConfigData('title'));
                $method->setMethod('ysprimeservice');
                $method->setMethodTitle($this->getConfigData('name'));
                if ($request->getFreeShipping() === true || $request->getPackageQty() == $this->getFreeBoxes()) {
                    $shippingPrice = '0.00';
                }
                $method->setPrice($shippingPrice);
                $method->setCost($shippingPrice);
                $result->append($method);
            }
            return $result;
        }
        public function getAllowedMethods()
        {
            return array('ysprimeservice'=>$this->getConfigData('name'));
        }
    }
?>