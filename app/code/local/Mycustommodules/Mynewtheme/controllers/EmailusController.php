<?php
class Mycustommodules_Mynewtheme_EmailusController extends Mage_Core_Controller_Front_Action
{
    public $cusemail1 = "";
    public $cusname1 = "";
    public function testAction()
    {
        echo "Test";

    }
    public function sendMailAction()
    {
        $data = array();
        // print_r($this->getRequest()->getPost());
        if(!empty($_FILES))
        {
            $error = false;
            $files = array();
            $baseDir = Mage::getBaseDir();
            $uploaddir = $baseDir.DS.'tempreports'.DS.'uploads'.DS;
            foreach($_FILES as $file)
            {//print_r($file);echo $file['tmp_name'].'---';echo $uploaddir.basename($file['name']);
                if(move_uploaded_file($file['tmp_name'], $uploaddir.basename($file['name'])))
                {
                    $files[] = $uploaddir .$file['name'];
                }
                else
                {
                    $error = true;
                }
            }
            $data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
        }
//        else
//        {
//                $data = array('success' => 'Form was submitted', 'formData' => $_POST);
//        }
        $name= $this->getRequest()->getPost('name');
        $topic= $this->getRequest()->getPost('topic');
        $message= $this->getRequest()->getPost('message');
        if(!isset($message)) $message='';
        $email= $this->getRequest()->getPost('email');
        $from='hello@yogasmoga.com';
        $subject='Email Us Submission';
        $fileurl='';
        if(!empty($file['name'])){
            $fileurl=Mage::helper('core/url')->getHomeUrl().'tempreports'.DS.'uploads'.DS.$file['name'];
        }
        $html= array (
            'cusname'        => $name,
            'topic'       => $topic,
            'message'     => $message,
            'cusemail'       => $email,
            'fileurl'     => $fileurl,
            'ip'          => $_SERVER['REMOTE_ADDR'],
            'date'        => date('Y-m-d H:i:s')
        );
//        $style='style="width:50%;height:30px;text-align:left;font-weight:bold;"';
//        $html = '<html><body>';
//        $html .='<table cellspacing="0" cellpadding="0" width="700" style="color:#333;font-family:arial;font-size:12px;">';
//        $html .='<tr><td><img alt="YOGASMOGA logo" src="'.Mage::helper('core/url')->getHomeUrl().'/skin/frontend/new-yogasmoga/yogasmoga-theme/images/logo.png"></td><td width="50%" align="left" valign="middle" style="font-size:14px;"><strong>Help Query</strong></td></tr>';
//        $html .='<tr><td '.$style.'></td><td width="50%" align="left"></td></tr>';
//        $html .='<tr><td '.$style.'>Name:</td><td width="50%" align="left">'.$name.'</td></tr>';
//        $html .='<tr><td '.$style.'>Topic:</td><td width="50%" align="left">'.$topic.'</td></tr>';
//        $html .='<tr><td '.$style.'>Message:</td><td width="50%" align="left">'.$message.'</td></tr>';
//        $html .='<tr><td '.$style.'>Email:</td><td width="50%" align="left">'.$email.'</td></tr>';
//        $html .='<tr><td style="width:50%;height:30px;text-align:left;font-weight:bold;">Date/Time:</td><td width="50%" align="left">'.date('Y-m-d H:i:s').'</td></tr>';
//        $html .='<tr><td '.$style.'>IP:</td><td width="50%" align="left">'.$_SERVER['REMOTE_ADDR'].'</td></tr>';
//        if(!empty($file['name'])){
//            $fileurl=Mage::helper('core/url')->getHomeUrl().'uploads/'.$file['name'];
//            $html .='<tr><td '.$style.'>Uploaded File:</td><td width="50%" align="left">'.$fileurl.'</td></tr>';
//        }
//        $html .='</table>';
//        $html .= "</body></html>";
//        $toemail='neeraj@mobikasa.com';
//        $headers = "From: " . strip_tags($from) . "\r\n";
//        $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
//        $headers .= "MIME-Version: 1.0\r\n";
//        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
//        mail($toemail,$subject,$html,$headers);
        //echo $html;
        $this->cusemail1 = $email;
        Mage::getSingleton('core/session')->setSenderEmail($email);
        $this->cusname1 = $name;
        $this->sendemail($html,$email);
        echo json_encode($data);

    }

    public function sendemail($html,$senderEmail)
    {
        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);
        $email = Mage::getModel('core/email_template');
        $email->setReplyTo($senderEmail);
        $mail_collection = Mage::getModel('core/email_template')->getCollection()->addFieldToFilter('template_code','help_form');
        $template_id = $mail_collection->getFirstItem()->getTemplate_id();

        $recipient = array(
            //'email' => 'neha@mobikasa.com',
            'email' => 'manish@mobikasa.com',
            'name'  => 'YOGASMOGA'
        );
        $cusname = $this->cusname1;
        $cusemail = 'hello@yogasmoga.com';
        $sender  = array(
            //'name' => $this->cusname1,
            //'email' => $this->cusemail1
            'name' => $cusname,
            'email' => $cusemail
        );

        //echo "<pre>";print_r($email); die('test');
        $email->setDesignConfig(array('area'=>'frontend', 'store'=> Mage::app()->getStore()->getId()))

            ->sendTransactional(
                $template_id,
                $sender,
                'hello@yogasmoga.com',
                'YOGASMOGA',
                $html
            );
        $translate->setTranslateInline(true);
        return $email->getSentSuccess();
    }
    public function sendquerymailAction(){

        $response = array(
            "status" => 'error',
            "errors" => '',
            "success_message" => ""
        );


        $name= $this->getRequest()->getPost('name');
        $topic= $this->getRequest()->getPost('topic');
        $message= $this->getRequest()->getPost('message');
        if(!isset($message)) $message='';
        $email= $this->getRequest()->getPost('email');

        $templateId = "emailus_form";

        $emailTemplate = Mage::getModel('core/email_template')->loadByCode($templateId);

        $vars = array('name' => $name,'topic'=>$topic, 'message'=> $message, 'email'=> $email);

        $emailTemplate->getProcessedTemplate($vars);
        $emailTemplate->setSenderEmail(Mage::getStoreConfig('trans_email/ident_general/email', $storeId));
        $emailTemplate->setSenderName(Mage::getStoreConfig('trans_email/ident_general/name', $storeId));

            if(!empty($email)){
                $emailTemplate->send($email,$name, $vars);
                $response['status'] = "Thank Email has been sent";
                echo json_encode($response);
                return;
            }


        /*
        $templateId = 28;
        $sendername = Mage::getStoreConfig('trans_email/ident_general/name');
        $senderemail = Mage::getStoreConfig('trans_email/ident_general/email');
        $storeId = Mage::app()->getStore()->getId();
        $sender = Array('name' => $sendername,
            'email' => $senderemail);
        //recepient
        $vars = Array();
        $vars = Array('name'=>$name,'email'=>$email);
        $storeId = Mage::app()->getStore()->getId();
        $translate = Mage::getSingleton('core/translate');
        Mage::getModel('core/email_template')
            ->sendTransactional($templateId, $sender, $email, $name, $vars, $storeId);
        $translate->setTranslateInline(true);
        */
    }

}