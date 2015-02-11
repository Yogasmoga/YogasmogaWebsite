<?php
class Ys_Mod_SessionController extends Mage_Core_Controller_Front_Action {

    public function loggedemailAction(){

        $ar = array();

        if (Mage::getSingleton('customer/session')->isLoggedIn()) {

            $customer = Mage::getSingleton('customer/session')->getCustomer();

            $ar = array(
                'message' => 'logged',
                'user_id' => $customer->getId(),
                'email' => $customer->getEmail(),
                'name' => $customer->getName(),
                'gender' => $customer->getGender(),
                'first_name' => $customer->getFirstname(),
                'middle_name' => $customer->getMiddlename(),
                'last_name' => $customer->getLastname()
            );
        }
        else {
            $ar = array('message' => 'notlogged');
        }

        echo json_encode($ar);
    }
}
?>