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
 * Customer dashboard addresses section
 *
 * @category   Mage
 * @package    Mage_Customer
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Mage_Customer_Block_Account_Dashboard_Address extends Mage_Core_Block_Template
{
    public function getCustomer()
    {
        return Mage::getSingleton('customer/session')->getCustomer();
    }

    public function getPrimaryShippingAddressHtml()
    {
        $address = $this->getCustomer()->getPrimaryShippingAddress();

        if( $address instanceof Varien_Object ) {
            return $address->format('html');
        } else {
            return Mage::helper('customer')->__('You have not set a default shipping address.');
        }
    }

    public function getPrimaryBillingAddressHtml()
    {
        $address = $this->getCustomer()->getPrimaryBillingAddress();

        if( $address instanceof Varien_Object ) {
            return $address->format('html');
        } else {
            return Mage::helper('customer')->__('You have not set a default billing address.');
        }
    }

    public function getPrimaryShippingAddressEditUrl()
    {
        return Mage::getUrl('customer/address/edit', array('id'=>$this->getCustomer()->getDefaultShipping()));
    }

    public function getPrimaryBillingAddressEditUrl()
    {
        return Mage::getUrl('customer/address/edit', array('id'=>$this->getCustomer()->getDefaultBilling()));
    }

    public function getAddressBookUrl()
    {
        return $this->getUrl('customer/address/');
    }
    public function getShippingAddressForAccount(){

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
    public function getBillingAddressForAccount(){

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
}
