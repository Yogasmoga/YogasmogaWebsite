<?php
include_once("Mage/Customer/controllers/AccountController.php");
class Ysindia_Customer_AccountController extends Mage_Customer_AccountController
{
    public function editPostAction()
    {

        if (!$this->_validateFormKey()) {
            return $this->_redirect('*/*/edit');
        }

        if ($this->getRequest()->isPost()) {
            /*echo '<pre/>';
            print_r($this->getRequest()->getPost());die;*/
            /** @var $customer Mage_Customer_Model_Customer */
            $customer = $this->_getSession()->getCustomer();

            /** @var $customerForm Mage_Customer_Model_Form */
            $customerForm = Mage::getModel('customer/form');
            $customerForm->setFormCode('customer_account_edit')
                ->setEntity($customer);

            $customerData = $customerForm->extractData($this->getRequest());

            $errors = array();
            $customerErrors = $customerForm->validateData($customerData);
            if ($customerErrors !== true) {
                $errors = array_merge($customerErrors, $errors);
            } else {
                $customerForm->compactData($customerData);
                $errors = array();

                // If password change was requested then add it to common validation scheme
                if ($this->getRequest()->getParam('change_password')) {
                    $currPass   = $this->getRequest()->getPost('current_password');
                    $newPass    = $this->getRequest()->getPost('password');
                    $confPass   = $this->getRequest()->getPost('confirmation');

                    $oldPass = $this->_getSession()->getCustomer()->getPasswordHash();
                    if (Mage::helper('core/string')->strpos($oldPass, ':')) {
                        list($_salt, $salt) = explode(':', $oldPass);
                    } else {
                        $salt = false;
                    }

                    if ($customer->hashPassword($currPass, $salt) == $oldPass) {
                        if (strlen($newPass)) {
                            /**
                             * Set entered password and its confirmation - they
                             * will be validated later to match each other and be of right length
                             */
                            $customer->setPassword($newPass);
                            $customer->setConfirmation($confPass);
                        } else {
                            $errors[] = $this->__('New password field cannot be empty.');
                        }
                    } else {
                        $errors[] = $this->__('Invalid current password');
                    }
                }

                // Validate account and compose list of errors if any
                $customerErrors = $customer->validate();
                if (is_array($customerErrors)) {
                    $errors = array_merge($errors, $customerErrors);
                }
            }

            if (!empty($errors)) {
                $this->_getSession()->setCustomerFormData($this->getRequest()->getPost());
                foreach ($errors as $message) {
                    $this->_getSession()->addError($message);
                }
                $this->_redirect('*/*/edit');
                return $this;
            }

            try {
                $customer->setConfirmation(null);
                $customer->save();
                $this->_getSession()->setCustomer($customer)
                    ->addSuccess($this->__('The account information has been saved.'));

                $root = Mage::getBaseUrl();

                $customer_id = $customer->getId();

                $path = $root . 'rangoli/wp_update_user_password.php?customer_id=' . $customer_id . '&password=' . $newPass;

                file_get_contents($path);

                $this->_redirect('customer/account');
                return;
            } catch (Mage_Core_Exception $e) {
                print_r($e);
                $this->_getSession()->setCustomerFormData($this->getRequest()->getPost())
                    ->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->setCustomerFormData($this->getRequest()->getPost())
                    ->addException($e, $this->__('Cannot save the customer.'));
            }
        }

        $this->_redirect('*/*/edit');
        Mage::log('AccountController overriden: ', null,'AccountController.log',true);
        //return parent::editPostAction();

    }

    public function forgotPasswordPostAction()
    {
        $email = (string) $this->getRequest()->getPost('email');
        if ($email) {
            if (!Zend_Validate::is($email, 'EmailAddress')) {
                $this->_getSession()->setForgottenEmail($email);
                echo 'Invalid email address.';
                return;
            }

            /** @var $customer Mage_Customer_Model_Customer */
            $customer = Mage::getModel('customer/customer')
                ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                ->loadByEmail($email);

            if ($customer->getId()) {
                try {
                    $newResetPasswordLinkToken = Mage::helper('customer')->generateResetPasswordLinkToken();
                    $customer->changeResetPasswordLinkToken($newResetPasswordLinkToken);
                    $customer->sendPasswordResetConfirmationEmail();

                    echo "Sent";
                } catch (Exception $exception) {
                    echo "Error sending email";
                }
            }
            else
            {
                echo "Email does not exist.";
            }

        } else {
            echo "No email";
        }
    }

    public function resetPasswordPostAction()
    {
        $resetPasswordLinkToken = (string) $this->getRequest()->getQuery('token');
        $customerId = (int) $this->getRequest()->getQuery('id');
        $password = (string) $this->getRequest()->getPost('password');
        $passwordConfirmation = (string) $this->getRequest()->getPost('confirmation');

        try {
            $this->_validateResetPasswordLinkToken($customerId, $resetPasswordLinkToken);
        } catch (Exception $exception) {
            echo 'Your password reset link has expired.';
            return;
        }

        $errorMessages = array();
        if (iconv_strlen($password) <= 0) {
            array_push($errorMessages, Mage::helper('customer')->__('New password field cannot be empty.'));
        }
        /** @var $customer Mage_Customer_Model_Customer */
        $customer = Mage::getModel('customer/customer')->load($customerId);

        $customer->setPassword($password);
        $customer->setConfirmation($passwordConfirmation);
        $validationErrorMessages = $customer->validate();
        if (is_array($validationErrorMessages)) {
            $errorMessages = array_merge($errorMessages, $validationErrorMessages);
        }

        if (!empty($errorMessages)) {
            $this->_getSession()->setCustomerFormData($this->getRequest()->getPost());
            foreach ($errorMessages as $errorMessage) {
                echo $errorMessage . "<br/>";
            }
            return;
        }

        try {
            // Empty current reset password token i.e. invalidate it
            $customer->setRpToken(null);
            $customer->setRpTokenCreatedAt(null);
            $customer->setConfirmation(null);
            $customer->save();

/**************************** email sending ********************/
            $storeId = Mage::app()->getStore()->getStoreId();

            $templateId = 10;
            $customerEmail = $customer->getEmail();
            $customerName = $customer->getName();

            $emailTemplate = Mage::getModel('core/email_template')->load($templateId);
            $senderName = Mage::getStoreConfig('trans_email/ident_general/name',$storeId);
            $senderEmail = Mage::getStoreConfig('trans_email/ident_general/email',$storeId);

            $emailTemplateVariables = array('name' => $customerName,'email' => $customerEmail);
            $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);

            $mail = Mage::getModel('core/email')
                ->setToName($senderName)
                ->setToEmail($customerEmail)
                ->setBody($processedTemplate)
                ->setSubject('Your YOGASMOGA password has been updated')
                ->setFromEmail($senderEmail)
                ->setFromName($customerName)
                ->setType('html');

            $mail->send();
/**************************** email sending ********************/			
			
            echo 'Your password has been updated.';

        } catch (Exception $exception) {
            echo 'Cannot save a new password.';
        }
    }
}