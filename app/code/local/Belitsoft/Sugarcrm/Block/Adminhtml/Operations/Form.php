<?php
/**
 * Adminhtml Belitsoft Sugarcrm user operations form block
 *
 * @category   Belitsoft
 * @package    Belitsoft_Sugarcrm
 * @author     Belitsoft <bits@belitsoft.com>
 */

class Belitsoft_Sugarcrm_Block_Adminhtml_Operations_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();

		$operData = $this->getOperationsData();

		$fieldset_base = $form->addFieldset('base_fieldset',
			array(
				'legend'	=> $this->__('Which operations need to be processed'),
			)
		);

		$sugar_operations = $this->_getOperationsArray();
		$sugar_objects = $this->_getBeansArray();
		foreach($sugar_objects as $bean_value=>$bean_name) {
			$fieldset_bean = $fieldset_base->addFieldset($bean_value . '_fieldset',
				array(
					'legend'	=> $this->__($bean_name)
				)
			);

			foreach($sugar_operations as $oper_value=>$oper_name) {
				$oper = empty($operData[$bean_value][$oper_value]) ? 0 : 1;

				$fieldset_bean->addField('sugarcrm_oper_'.$bean_value.'_'.$oper_value,
					'radios',
					array(
						'label'		=> $this->__($oper_name),
						'title'		=> $this->__($oper_name),
						'name'		=> 'sugarcrm_oper_'.$bean_value.'_'.$oper_value,
						'value'		=> $oper,
						'values'	=> $this->_getOptionsArray()
					)
				);
			}
		}


		$fieldset_order = $fieldset_base->addFieldset('_fieldset', array(
			'legend'	=> $this->__('User orders'),
		));

		$fieldset_order->addField('enable_user_order_to_sugarcrm',
			'radios',
			array(
				'label'		=> $this->__('Enabled'),
				'title'		=> $this->__('Enabled'),
				'name'		=> 'enable_user_order_to_sugarcrm',
				'value'		=> $this->_getEnabledUserOrders(),
				'values'	=> $this->_getYesNoArray()
			)
		);

		$fieldset_order->addField($this->getStageTypeFieldName(),
			'select',
			array(
				'label'		=> $this->__('User orders to SugarCRM'),
				'title'		=> $this->__('User orders to SugarCRM'),
				'name'		=> $this->getStageTypeFieldName(),
				'value'		=> $this->_getSugarUserOrderBean(),
				'values'	=> $this->_getOrderOptionsArray()
			)
		);
		
		if(($accounts = $this->_getAccountsArray()) && is_array($accounts)) {
			$fieldset_order->addField('sugarcrm_account_id',
				'select', array(
					'label'		=> $this->__('SugarCRM Account'),
					'title'		=> $this->__('SugarCRM Account'),
					'name'		=> 'sugarcrm_account_id',
					'value'		=> (string)$this->_getSugarAccountId(),
					'options'	=> (array) $this->_getAccountsArray(),
				)
			);
		} else {
			$fieldset_order->addField('sugarcrm_account_id',
				'text', array(
					'label'		=> $this->__('SugarCRM Account'),
					'title'		=> $this->__('SugarCRM Account'),
					'name'		=> 'sugarcrm_account_id',
					'value'		=> (string)$this->_getSugarAccountId(),
					'options'	=> (array) $this->_getAccountsArray(),
				)
			);						
		}

		$opportunitiesSalesStageBlock = $this->getLayout()
			->createBlock(
				'sugarcrm/adminhtml_operations_userorder_stages',
				'',
				array(
					'stage_type' => $this->_getSugarUserOrderBean(),
				)
			);

		$fieldset_order->addField('stages_box',
			'note',
			array(
				'label'		=> $this->__('Stage Mapping'),
				'text'		=> '<div id="'.$this->getStagesDetailsAreaId().'">' . $opportunitiesSalesStageBlock->toHtml() . '</div>',
			)
		);


		$form->setUseContainer(true);
		$form->setId('edit_form');
		$form->setMethod('post');
		$form->setAction($this->getSaveUrl());

		$this->setForm($form);

		$js = "
			var stageType = function() {
				return {
					updateStages: function() {
						var elements = [$('{$this->getStageTypeFieldName()}')].flatten();
						$('{$this->getParentBlock()->getSaveButtonId()}').disabled = true;
						new Ajax.Updater('{$this->getStagesDetailsAreaId()}', '{$this->getUrl('*/*/loadStage')}',
							{
								parameters: Form.serializeElements(elements),
								evalScripts: true,
								onComplete: function(){
									$('{$this->getParentBlock()->getSaveButtonId()}').disabled = false;
								}
							}
						);
					}
				}
			}();

			Event.observe(window, 'load', function() {
				if ($('{$this->getStageTypeFieldName()}')) {
					Event.observe($('{$this->getStageTypeFieldName()}'), 'change', stageType.updateStages);
				}
			});

			function saveStageEdit(action_str) {
				if(!action_str) {
					action_str = '';
				}
				try {
					if(!mpSugarcrmOperations.save()) {
						return false;
					}
				} catch(e) {}

				editForm.submit(action_str);
			}
		";

		$this->getParentBlock()->addFormScripts($js);
	}

	protected function _getBeansArray()
	{
		$result = Mage::getSingleton('sugarcrm/operations')->getBeansArray();

		return $result;
	}

	protected function _getOperationsArray()
	{
		$result = Mage::getSingleton('sugarcrm/operations')->getOperationsArray();

		return $result;
	}

	protected function _getOptionsArray()
	{
		$options = array(
			0 => array(
				'value' => 0,
				'label' => $this->__('Disable')
			),
			1 => array(
				'value' => 1,
				'label' => $this->__('Enable')
			),
		);

		return $options;
	}

	protected function _getYesNoArray()
	{
		$options = array(
			0 => array(
				'value' => 0,
				'label' => Mage::helper('cms')->__('No')
			),
			1 => array(
				'value' => 1,
				'label' => Mage::helper('cms')->__('Yes')
			),
		);

		return $options;
	}

	protected function _getOrderOptionsArray()
	{
		$options = array(
			0 => array(
				'value' => Belitsoft_Sugarcrm_Model_Connection::OPPORTUNITIES,
				'label' => $this->__('Opportunities')
			),
			1 => array(
				'value' => Belitsoft_Sugarcrm_Model_Connection::CASES,
				'label' => $this->__('Cases')
			),
		);

		return $options;
	}

	protected function _getSugarUserOrderBean()
	{
		return Mage::helper('sugarcrm')->getSugarOrderBean();
	}

	protected function _getEnabledUserOrders()
	{
		return strval(Mage::getModel('sugarcrm/config')->isEnabledUserOrdersSynch());
	}

	protected function _getSugarAccountId()
	{
		$account_id = strval(Mage::getModel('sugarcrm/config')->getConfigData('sugarcrm_account_id'));

		return $account_id;
	}

	protected function _getAccountsArray()
	{
		$connection = Mage::getSingleton('sugarcrm/connection');
		try {
			$accounts = $connection->getAccounts();
		} catch(SoapFault $e) {
			return null;		
		} catch(Exception $e) {
			throw $e;
		}

		array_unshift($accounts, $this->__("Use customer account id for created order"));

		return $accounts;
	}

	public function getOperationsData()
	{
		return Mage::registry('sugarcrm_operations_data');
	}

	/**
	 * Helper function to get stage details area id
	 *
	 * @return string Returns id.
	 */
	public function getStagesDetailsAreaId()
	{
		return 'stages_details';
	}

	/**
	 * Helper function to get stage type field id
	 *
	 * @return string Returns id.
	 */
	public function getStageTypeFieldName()
	{
		return 'user_order_to_sugarcrm';
	}

	public function getSaveUrl()
	{
		return $this->getUrl('*/*/save');
	}
}
