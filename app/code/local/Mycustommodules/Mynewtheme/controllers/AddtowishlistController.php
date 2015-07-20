<?php
class Mycustommodules_Mynewtheme_AddtowishlistController extends Mage_Core_Controller_Front_Action
{
    protected function _getWishlist($wishlistId = null)
    {
        $wishlist = Mage::registry('wishlist');
        if ($wishlist) {
            return $wishlist;
        }

        try {
            if (!$wishlistId) {
                $wishlistId = $this->getRequest()->getParam('wishlist_id');
            }
            $customerId = Mage::getSingleton('customer/session')->getCustomerId();
            /* @var Mage_Wishlist_Model_Wishlist $wishlist */
            $wishlist = Mage::getModel('wishlist/wishlist');
            if ($wishlistId) {
                $wishlist->load($wishlistId);
            } else {
                $wishlist->loadByCustomer($customerId, true);
            }

            if (!$wishlist->getId() || $wishlist->getCustomerId() != $customerId) {
                $wishlist = null;
                Mage::throwException(
                    Mage::helper('wishlist')->__("Requested wishlist doesn't exist")
                );
            }

            Mage::register('wishlist', $wishlist);
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('wishlist/session')->addError($e->getMessage());
            return false;
        } catch (Exception $e) {
            Mage::getSingleton('wishlist/session')->addException($e,
                Mage::helper('wishlist')->__('Wishlist could not be created.')
            );
            return false;
        }

        return $wishlist;
    }

    public function applyAddToWishlistAction()
    {
        $response = array(
            'status' => 'error',
            'errors' => '',
            'success_message' => ''
        );

        $wishlist = $this->_getWishlist();
        if (!$wishlist) {
            $response['errors'] = "Product can not be added to wishlist.";
            echo json_encode($response);
            return;
        }

        $session = Mage::getSingleton('customer/session');

        $productId = (int) $this->getRequest()->getParam('productid');
        if (!$productId) {
            $response['errors'] = "Not a valid product. ";
            echo json_encode($response);
            return;
        }

        $product = Mage::getModel('catalog/product')->load($productId);
        if (!$product->getId() || !$product->isVisibleInCatalog()) {
            $response['errors'] = "Can't specify product.";
            echo json_encode($response);
            return;
        }

        try {
            $requestParams = $this->getRequest()->getParams();
            if ($session->getBeforeWishlistRequest()) {
                $requestParams = $session->getBeforeWishlistRequest();
                $session->unsBeforeWishlistRequest();
            }
            $buyRequest = new Varien_Object($requestParams);

            $result = $wishlist->addNewItem($product, $buyRequest);
            if (is_string($result)) {
                Mage::throwException($result);
            }
            $wishlist->save();

            Mage::dispatchEvent(
                'wishlist_add_product',
                array(
                    'wishlist'  => $wishlist,
                    'product'   => $product,
                    'item'      => $result
                )
            );

            $referer = $session->getBeforeWishlistUrl();
            if ($referer) {
                $session->setBeforeWishlistUrl(null);
            } else {
                $referer = $this->_getRefererUrl();
            }

            /**
             *  Set referer to avoid referring to the compare popup window
             */
            $session->setAddActionReferer($referer);

            Mage::helper('wishlist')->calculate();


            $response['status'] = 'success';
            $response['success_message'] = 'Product has been added to your Wishlist.';
            echo json_encode($response);
            return;
        }
        catch (Mage_Core_Exception $e) {
            $session->addError($this->__('An error occurred while adding item to wishlist: %s', $e->getMessage()));
            $response['errors'] = "Can't add product to wishlist.";
            echo json_encode($response);
            return;
        }
        catch (Exception $e) {
            $session->addError($this->__('An error occurred while adding item to wishlist.'));
            $response['errors'] = "Can't add product to wishlist.";
            echo json_encode($response);
            return;
        }

        $response['status'] = 'success';
        $response['success_message'] = 'Product has been added to your Wishlist.';
        echo json_encode($response);
        return;
    }

	/**
     * Adding new item
     */
    public function addmobileAction()
    {
        $wishlist = $this->_getWishlist();
        if (!$wishlist) {
            return $this->norouteAction();
        }

        $session = Mage::getSingleton('customer/session');

        $productId = (int) $this->getRequest()->getParam('product');
        if (!$productId) {
            $this->_redirect('*/');
            return;
        }

        $product = Mage::getModel('catalog/product')->load($productId);
        if (!$product->getId() || !$product->isVisibleInCatalog()) {
            $session->addError($this->__('Cannot specify product.'));
            $this->_redirect('*/');
            return;
        }

        try {
            $requestParams = $this->getRequest()->getParams();
            if ($session->getBeforeWishlistRequest()) {
                $requestParams = $session->getBeforeWishlistRequest();
                $session->unsBeforeWishlistRequest();
            }
            $buyRequest = new Varien_Object($requestParams);

            $result = $wishlist->addNewItem($product, $buyRequest);
            if (is_string($result)) {
                Mage::throwException($result);
            }
            //$wishlist->save();

            Mage::dispatchEvent(
                'wishlist_add_product',
                array(
                    'wishlist'  => $wishlist,
                    'product'   => $product,
                    'item'      => $result
                )
            );
		         foreach (Mage::helper('wishlist')->getWishlistItemCollection() as $_wishlist_item) {
                  $wishid = $_wishlist_item->getWishlistItemId();
                    }
			echo Mage::helper('core/url')->getHomeUrl()."mynewtheme/addtowishlist/removemobile/item/".$wishid;
			

		//echo json_encode(array("status" => "success","wishlist" => $mincarthtml , "count" => $this->getcartcount()));

           
        }
        catch (Mage_Core_Exception $e) {
            $session->addError($this->__('An error occurred while adding item to wishlist: %s', $e->getMessage()));
        }
        catch (Exception $e) {
            $session->addError($this->__('An error occurred while adding item to wishlist.'));
        }

        //$this->_redirect('*', array('wishlist_id' => $wishlist->getId()));
    }

	 /**
     * Remove bobile item 
     */
    public function removemobileAction()
    {
        $id = (int) $this->getRequest()->getParam('item');
        $item = Mage::getModel('wishlist/item')->load($id);
        if (!$item->getId()) {
            return $this->norouteAction();
        }
        $wishlist = $this->_getWishlist($item->getWishlistId());
        if (!$wishlist) {
            return $this->norouteAction();
        }
        try {
            $item->delete();
            $wishlist->save();

		$productId = $item->getProductId();
		echo Mage::helper('core/url')->getHomeUrl()."mynewtheme/addtowishlist/addmobile/product/".$productId;
		//exit;
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('customer/session')->addError(
                $this->__('An error occurred while deleting the item from wishlist: %s', $e->getMessage())
            );
        } catch(Exception $e) {
            Mage::getSingleton('customer/session')->addError(
                $this->__('An error occurred while deleting the item from wishlist.')
            );
        }

        Mage::helper('wishlist')->calculate();

       // $this->_redirectReferer(Mage::getUrl('*/*'));
    }
}