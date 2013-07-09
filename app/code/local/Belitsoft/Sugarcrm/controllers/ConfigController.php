<?php
/**
 * Mageplace Magento-Sugarcrm bridge
 *
 * @category	Belitsoft_Sugarcrm
 * @package		Belitsoft_Sugarcrm
 * @copyright	Copyright (c) 2011 Mageplace. (http://www.mageplace.com)
 * @license		http://www.mageplace.com/disclaimer.html
 */

class Belitsoft_Sugarcrm_ConfigController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->loadLayout()
			->_setActiveMenu('sugarcrm/config')
			->_addBreadcrumb($this->__('Connection Settings'), $this->__('Connection Settings'));

		return $this;
	}

	public function indexAction()
	{
		$this->_title($this->__('SugarCRM'))->_title($this->__('Connection Settings'));

		try {
			$config_data = array();
			$collection = Mage::getResourceModel('sugarcrm/config_collection')->load();
			foreach($collection as $attribute) {
				$data = $attribute->getData();
				$config_data[$data['name']] = $data['value'];
			}

			Mage::register('sugarcrm_config_data', $config_data);

			$this->_initAction()
				->_addContent($this->getLayout()->createBlock('sugarcrm/adminhtml_config'))
				->renderLayout();

		} catch(Exception $e) {
			$this->_getSession()->addError($e->getMessage());
			$this->_redirect('*/*/index');
		}
	}

	public function saveAction()
	{
		$config_data = array(
			'server'	=> $this->getRequest()->getPost('sugarcrm_soap_server'),
			'wsdl'		=> intval($this->getRequest()->getPost('sugarcrm_soap_wsdl')),
			'namespace'	=> $this->getRequest()->getPost('sugarcrm_soap_namespace'),
			'use'		=> $this->getRequest()->getPost('sugarcrm_soap_use'),
			'style'		=> $this->getRequest()->getPost('sugarcrm_soap_style'),
			'username'	=> $this->getRequest()->getPost('sugarcrm_soap_username'),
		);

		$password = $this->getRequest()->getPost('sugarcrm_soap_password');
		if($password) {
			$config_data['password'] = md5($password);
		}

		if(!$config_data['server'] || !$config_data['username']) {
			Mage::getSingleton('core/session')->addError('Please fill all required fields.');
			$this->getResponse()->setRedirect($this->getUrl('*/*/index', array('_secure' => true)));
			return;
		}

		if($this->getRequest()->getPost('start_test')) {
			try {
				Mage::getSingleton('sugarcrm/connection', array('do_init'=>false))->test(true, $config_data);
			} catch(Belitsoft_Sugarcrm_Exception $bse) {
				if($bse->getCode() == Belitsoft_Sugarcrm_Exception::FATAL_ERROR) {
					throw $bse;
				} else {
					Mage::getSingleton('core/session')->addError($bse->getMessage());
					$this->getResponse()->setRedirect($this->getUrl('*/*/index', array('_secure' => true)));
					return;
				}
			} catch(SoapFault $sf) {
				Mage::getSingleton('core/session')->addError($sf->getMessage());
				$this->getResponse()->setRedirect($this->getUrl('*/*/index', array('_secure' => true)));
				return;
			} catch(Exception $e) {
				throw $e;
			}

			$this->_getSession()->addSuccess($this->__('Test connection was successful.'));
		}

		$sugarcrm_config_data = array();
		foreach($config_data as $name=>$value) {
			Mage::getModel('sugarcrm/config')->setConfigData($name, $value)->save();
			$sugarcrm_config_data[$name] = $value;
		}

		Mage::unregister('sugarcrm_config_data');
		Mage::register('sugarcrm_config_data', $sugarcrm_config_data);

		$this->_getSession()->addSuccess($this->__('The connection settings have been saved.'));
		$this->_redirectSuccess($this->getUrl('*/*/index', array('_secure' => true)));
	}

	/**
	 * Simple access control
	 *
	 * @return boolean True if user is allowed to edit config
	 */
	protected function _isAllowed()
	{
		$action = $this->getRequest()->getActionName();
		if ($action && ($action != 'index')) {
			return Mage::getSingleton('admin/session')->isAllowed('admin/sugarcrm/config/actions/'.$action);
		}

		return Mage::getSingleton('admin/session')->isAllowed('admin/sugarcrm/config');
	}
}