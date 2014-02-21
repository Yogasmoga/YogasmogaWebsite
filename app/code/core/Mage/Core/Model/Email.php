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
 * @package     Mage_Core
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Possible data fields:
 *
 * - subject
 * - to
 * - from
 * - body
 * - template (file name)
 * - module (for template)
 *
 */
class Mage_Core_Model_Email extends Varien_Object
{
    protected $_tplVars = array();
    protected $_block;

    public function __construct()
    {
        // TODO: move to config
        $this->setFromName('Magento');
        $this->setFromEmail('magento@varien.com');
        $this->setType('text');
    }

    public function setTemplateVar($var, $value = null)
    {
        if (is_array($var)) {
            foreach ($var as $index=>$value) {
                $this->_tplVars[$index] = $value;
            }
        }
        else {
            $this->_tplVars[$var] = $value;
        }
        return $this;
    }

    public function getTemplateVars()
    {
        return $this->_tplVars;
    }

    public function getBody()
    {
        $body = $this->getData('body');
        if (empty($body) && $this->getTemplate()) {
            $this->_block = Mage::getModel('core/layout')->createBlock('core/template', 'email')
                ->setArea('frontend')
                ->setTemplate($this->getTemplate());
            foreach ($this->getTemplateVars() as $var=>$value) {
                $this->_block->assign($var, $value);
            }
            $this->_block->assign('_type', strtolower($this->getType()))
                ->assign('_section', 'body');
            $body = $this->_block->toHtml();
        }
        return $body;
    }

    public function getSubject()
    {
        $subject = $this->getData('subject');
        if (empty($subject) && $this->_block) {
            $this->_block->assign('_section', 'subject');
            $subject = $this->_block->toHtml();
        }
        return $subject;
    }

    public function send()
    {
        if (Mage::getStoreConfigFlag('system/smtp/disable')) {
            return $this;
        }
        
        $my_smtp_host = 'email-smtp.us-east-1.amazonaws.com';  // Take it from Magento backoffice or you can specify it here
        $my_smtp_port = 587;
        $config = array(
        'ssl' => 'tls',
        'port' => $my_smtp_port, //optional - default 25
        'auth' => 'login',
        'username' => 'AKIAIQWMV5ZZ6Q6II64A',
        'password' => 'An5GlU3IJiQ9YZx8B4pdIptQxmyWcI+D4rl+K9DKqKtm'
        );
        
        $transport = new Zend_Mail_Transport_Smtp($my_smtp_host, $config);
        Zend_Mail::setDefaultTransport($transport);
        //$this->_mail = new Zend_Mail('utf-8');
        
        $mail = new Zend_Mail('utf-8');
        //$mail->setReturnPath('chetan.mangat@yogasmoga.com');
        $emailId = Mage::getModel('core/variable')->loadByCode('email_return_path')->getValue('plain');
        if($emailId != '')
            $mail->setReturnPath($emailId);
        
        //$mail = new Zend_Mail();

        if (strtolower($this->getType()) == 'html') {
            $mail->setBodyHtml($this->getBody());
        }
        else {
            $mail->setBodyText($this->getBody());
        }

        $mail->setFrom($this->getFromEmail(), $this->getFromName())
            ->addTo($this->getToEmail(), $this->getToName())
            ->setSubject($this->getSubject());
        $mail->send();

        return $this;
    }
}
