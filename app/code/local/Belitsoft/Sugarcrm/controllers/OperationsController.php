<?php
/**
 * Mageplace Magento-Sugarcrm bridge
 *
 * @category	Belitsoft_Sugarcrm
 * @package		Belitsoft_Sugarcrm
 * @copyright	Copyright (c) 2011 Mageplace. (http://www.mageplace.com)
 * @license		http://www.mageplace.com/disclaimer.html
 */

class Belitsoft_Sugarcrm_OperationsController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->loadLayout()
			->_setActiveMenu('sugarcrm/operations')
			->_addBreadcrumb($this->__('User Operations'), $this->__('User Operations'));

		return $this;
	}

	public function indexAction()
	{
		$this->_title($this->__('SugarCRM'))->_title($this->__('User Operations'));

		try {
			$bean_operations = Mage::getModel('sugarcrm/operations')->getEnabledOperations();
			Mage::register('sugarcrm_operations_data', $bean_operations);

			$this->_registerStages(Mage::helper('sugarcrm')->getSugarOrderBean());

			$this->_initAction()
				->_addContent($this->getLayout()->createBlock('sugarcrm/adminhtml_operations'))
				->renderLayout();

		} catch(Exception $e) {
			$this->_getSession()->addError($e->getMessage());
			$this->_redirect('*/config/index');
		}
	}

	public function saveAction()
	{
		$model = Mage::getSingleton('sugarcrm/operations')->truncate();

		$beans		= Mage::getSingleton('sugarcrm/operations')->getBeansArray();
		$operations	= Mage::getSingleton('sugarcrm/operations')->getOperationsArray();
		foreach($beans as $bean_value=>$bean_name)
		{
			foreach($operations as $oper_value=>$oper_name)
			{
				$enable = $this->getRequest()->getPost('sugarcrm_oper_' . $bean_value . '_' . $oper_value);
				Mage::getModel('sugarcrm/operations')->setOperationItem($bean_value, $oper_value, $enable)->save();
			}
		}

		$user_order_to_sugarcrm = $this->getRequest()->getPost('user_order_to_sugarcrm');

		Mage::getModel('sugarcrm/config')->setConfigData('enable_user_order_to_sugarcrm', $this->getRequest()->getPost('enable_user_order_to_sugarcrm'))->save();
		Mage::getModel('sugarcrm/config')->setConfigData('user_order_to_sugarcrm', $user_order_to_sugarcrm)->save();
		Mage::getModel('sugarcrm/config')->setConfigData('sugarcrm_account_id', $this->getRequest()->getPost('sugarcrm_account_id'))->save();

		// process save order stage
		if($user_order_to_sugarcrm) {
			Mage::getResourceModel('sugarcrm/stages')->saveStages($user_order_to_sugarcrm, (array)$this->getRequest()->getPost('stages'));
		}


		$this->_getSession()->addSuccess($this->__('The user operations settings have been saved.'));
		$this->_redirectSuccess($this->getUrl('*/*/index', array('_secure' => true)));
	}

	/**
	 * Ajax action for get question field options
	 */
	public function loadStageAction()
	{
		try {
			$bean = $this->getRequest()->getParam('user_order_to_sugarcrm');

			$this->_registerStages($bean);

			$block = $this->getLayout()
				->createBlock(
					'sugarcrm/adminhtml_operations_userorder_stages',
					'',
					array(
						'stage_type' => $bean,
					)
				);

			$this->getResponse()->setBody($block->toHtml());
		} catch (Exception $e) {
			// just need to output text with error
			$this->_getSession()->addError($e->getMessage());
		}
	}

	protected function _registerStages($bean)
	{
		return Mage::helper('sugarcrm')->getStages($bean);
	}

	/**
	 * Simple access control
	 *
	 * @return boolean True if user is allowed to edit operations
	 */
	protected function _isAllowed()
	{
		$action = $this->getRequest()->getActionName();
		if ($action && ($action != 'index')) {
			return Mage::getSingleton('admin/session')->isAllowed('admin/sugarcrm/operations/actions/'.$action);
		}

		return Mage::getSingleton('admin/session')->isAllowed('admin/sugarcrm/operations');
	}
}