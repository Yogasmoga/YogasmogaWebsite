<?php 
class Mycustommodules_Mycheckout_MycartController extends Mage_Core_Controller_Front_Action
{
    public function testAction()
    {
        echo "Output from Cart Module";
    }
    
    /**
     * Action list where need check enabled cookie
     *
     * @var array
     */
    protected $_cookieCheckActions = array('add');

    /**
     * Retrieve shopping cart model object
     *
     * @return Mage_Checkout_Model_Cart
     */
    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }

    /**
     * Get checkout session model instance
     *
     * @return Mage_Checkout_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * Get current active quote instance
     *
     * @return Mage_Sales_Model_Quote
     */
    protected function _getQuote()
    {
        return $this->_getCart()->getQuote();
    }

    /**
     * Set back redirect url to response
     *
     * @return Mage_Checkout_CartController
     */
    protected function _goBack()
    {
        $returnUrl = $this->getRequest()->getParam('return_url');
        if ($returnUrl) {

            if (!$this->_isUrlInternal($returnUrl)) {
                throw new Mage_Exception('External urls redirect to "' . $returnUrl . '" denied!');
            }

            $this->_getSession()->getMessages(true);
            $this->getResponse()->setRedirect($returnUrl);
        } elseif (!Mage::getStoreConfig('checkout/cart/redirect_to_cart')
            && !$this->getRequest()->getParam('in_cart')
            && $backUrl = $this->_getRefererUrl()
        ) {
            $this->getResponse()->setRedirect($backUrl);
        } else {
            if (($this->getRequest()->getActionName() == 'add') && !$this->getRequest()->getParam('in_cart')) {
                $this->_getSession()->setContinueShoppingUrl($this->_getRefererUrl());
            }
            $this->_redirect('checkout/cart');
        }
        return $this;
    }

    /**
     * Initialize product instance from request data
     *
     * @return Mage_Catalog_Model_Product || false
     */
    protected function _initProduct()
    {
        $productId = (int) $this->getRequest()->getParam('product');
        if ($productId) {
            $product = Mage::getModel('catalog/product')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($productId);
            if ($product->getId()) {
                return $product;
            }
        }
        return false;
    }
    
    public function addAction()
    {
        $cart   = $this->_getCart();
        $params = $this->getRequest()->getParams();
        try {
            if (isset($params['qty'])) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );
                $params['qty'] = $filter->filter($params['qty']);
            }

            $product = $this->_initProduct();
            $related = $this->getRequest()->getParam('related_product');

            /**
             * Check product availability
             */
            if (!$product) {
                $this->_goBack();
                return;
            }

            $cart->addProduct($product, $params);
            if (!empty($related)) {
                $cart->addProductsByIds(explode(',', $related));
            }

            $cart->save();

            $this->_getSession()->setCartWasUpdated(true);

            /**
             * @todo remove wishlist observer processAddToCart
             */
            Mage::dispatchEvent('checkout_cart_add_product_complete',
                array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
            );
            echo "success";
            //if (!$this->_getSession()->getNoCartRedirect(true)) {
//                if (!$cart->getQuote()->getHasError()){
//                    $message = $this->__('%s was added to your shopping cart.', Mage::helper('core')->escapeHtml($product->getName()));
//                    $this->_getSession()->addSuccess($message);
//                }
//                $this->_goBack();
//            }
        } catch (Mage_Core_Exception $e) {
            echo "error";
            //if ($this->_getSession()->getUseNotice(true)) {
//                $this->_getSession()->addNotice(Mage::helper('core')->escapeHtml($e->getMessage()));
//            } else {
//                $messages = array_unique(explode("\n", $e->getMessage()));
//                foreach ($messages as $message) {
//                    $this->_getSession()->addError(Mage::helper('core')->escapeHtml($message));
//                }
//            }
//
//            $url = $this->_getSession()->getRedirectUrl(true);
//            if ($url) {
//                $this->getResponse()->setRedirect($url);
//            } else {
//                $this->_redirectReferer(Mage::helper('checkout/cart')->getCartUrl());
//            }
        } catch (Exception $e) {
            echo "error";
            //$this->_getSession()->addException($e, $this->__('Cannot add the item to shopping cart.'));
//            Mage::logException($e);
//            $this->_goBack();
        }
    }
    
    public function htmlAction()
    {
        ?>
        <h1>Hello World</h1>
        <?php
    }
}
?>