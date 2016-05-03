<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Customer
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Customer address book block
 *
 * @category   Mage
 * @package    Mage_Customer
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Customer_Block_Address_Book extends Mage_Core_Block_Template
{
    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('head')
            ->setTitle(Mage::helper('customer')->__('Address Book'));

        return parent::_prepareLayout();
    }

    public function getAddAddressUrl()
    {
        return $this->getUrl('customer/address/new', array('_secure'=>true));
    }

    public function getBackUrl()
    {
        if ($this->getRefererUrl()) {
            return $this->getRefererUrl();
        }
        return $this->getUrl('customer/account/', array('_secure'=>true));
    }

    public function getDeleteUrl()
    {
        return $this->getUrl('customer/address/delete');
    }

    public function getAddressEditUrl($address)
    {
        return $this->getUrl('customer/address/edit', array('_secure'=>true, 'id'=>$address->getId()));
    }

    public function getPrimaryBillingAddress()
    {
        return $this->getCustomer()->getPrimaryBillingAddress();
    }

    public function getPrimaryShippingAddress()
    {
        return $this->getCustomer()->getPrimaryShippingAddress();
    }

    public function hasPrimaryAddress()
    {
        return $this->getPrimaryBillingAddress() || $this->getPrimaryShippingAddress();
    }

    public function getAdditionalAddresses()
    {
        $addresses = $this->getCustomer()->getAdditionalAddresses();
        return empty($addresses) ? false : $addresses;
    }

    public function getAddressHtml($address)
    {
        return $address->format('html');
        //return $address->toString($address->getHtmlFormat());
    }

    public function getCustomer()
    {
        $customer = $this->getData('customer');
        if (is_null($customer)) {
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            $this->setData('customer', $customer);
        }
        return $customer;
    }
    public function getBillingAddressForBook(){

        $address = $this->getCustomer()->getPrimaryBillingAddress();

        if( $address instanceof Varien_Object ) {
            $regionId = $address->getData('region_id');
            $resource = Mage::getSingleton('core/resource');
            $read = $resource->getConnection('core_read');
            $result = $read->fetchAll("SELECT code FROM directory_country_region  where region_id ='" .$regionId ."' limit 1");
            foreach($result as $code){
                $regionCode = $code['code'];
            }
            $country = Mage::getModel('directory/country')->loadByCode($address->getCountryId());

            echo  '<span class="caddress">
	            <span class="cname">'.$address->getFirstname().' '. $address->getLastname().'</span>'.
                $address->getData('street').
                '<span>'.$address->getCity().', '.
                $regionCode.' '.
                $address->getPostcode().
                ',
                </span>
            </span>
            <span>'.$country->getName().'</span><br>
            <span class="tel">'.$address->getTelephone().'</span>';
        }
        else {
            echo Mage::helper('customer')->__('You have not set a default shipping address.');
        }


    }
    public function getShippingAddressForBook(){

        $address = $this->getCustomer()->getPrimaryShippingAddress();

        if( $address instanceof Varien_Object ) {
            $regionId = $address->getData('region_id');
            $resource = Mage::getSingleton('core/resource');
            $read = $resource->getConnection('core_read');
            $result = $read->fetchAll("SELECT code FROM directory_country_region  where region_id ='" .$regionId ."' limit 1");
            foreach($result as $code){
                $regionCode = $code['code'];
            }
            $country = Mage::getModel('directory/country')->loadByCode($address->getCountryId());

            echo  '<span class="caddress">
	            <span class="cname">'.$address->getFirstname().' '. $address->getLastname().'</span>'.
                $address->getData('street').
                '<span>'.$address->getCity().', '.
                $regionCode.' '.
                $address->getPostcode().
                ',
                </span>
            </span>
            <span>'.$country->getName().'</span><br>
            <span class="tel">'.$address->getTelephone().'</span>';
        }
        else {
            echo Mage::helper('customer')->__('You have not set a default shipping address.');
        }


    }
    public function getAdditionalAddressForBook($address){

            $regionId = $address->getData('region_id');
            $resource = Mage::getSingleton('core/resource');
            $read = $resource->getConnection('core_read');
            $result = $read->fetchAll("SELECT code FROM directory_country_region  where region_id ='" . $regionId . "' limit 1");
            foreach ($result as $code) {
                $regionCode = $code['code'];
            }
            $country = Mage::getModel('directory/country')->loadByCode($address->getCountryId());

            echo '<span class="caddress">
	            <span class="cname">' . $address->getFirstname() . ' ' . $address->getLastname() . '</span>' .
                $address->getData('street') .
                '<span>' . $address->getCity() . ', ' .
                $regionCode . ' ' .
                $address->getPostcode() .
                ',
                </span>
            </span>
            <span>' . $country->getName() . '</span><br>
            <span class="tel">' . $address->getTelephone() . '</span>';


    }


}
