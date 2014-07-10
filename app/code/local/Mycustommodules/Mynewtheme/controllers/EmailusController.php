<?php
class Mycustommodules_Mynewtheme_EmailusController extends Mage_Core_Controller_Front_Action
{
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
                $uploaddir = $baseDir.DS.'uploads'.DS;
                foreach($_FILES as $file)
                {
                        if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name'])))
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
        $html = '<html><body>';
        $html .='<table cellspacing="0" cellpadding="0" width="700" style="color:#333;font-family:arial;font-size:12px;">';
        $html .='<tr><td width="50%" align="left">Name:</td><td width="50%" align="left">'.$name.'</td></tr>';
        $html .='<tr><td width="50%" align="left">Topic:</td><td width="50%" align="left">'.$topic.'</td></tr>';
        $html .='<tr><td width="50%" align="left">Message:</td><td width="50%" align="left">'.$message.'</td></tr>';
        $html .='<tr><td width="50%" align="left">Email:</td><td width="50%" align="left">'.$email.'</td></tr>';
        $html .='<tr><td width="50%" align="left">Date/Time:</td><td width="50%" align="left">'.date('Y-m-d H:i:s').'</td></tr>';
        $html .='<tr><td width="50%" align="left">IP:</td><td width="50%" align="left">'.$_SERVER['REMOTE_ADDR'].'</td></tr>';
        if(!empty($file['name'])){  
            $fileurl=Mage::helper('core/url')->getHomeUrl().'uploads/'.$file['name'];
            $html .='<tr><td width="50%" align="left">Uploaded File:</td><td width="50%" align="left">'.$fileurl.'</td></tr>';
        }
        $html .='</table>';
        $html .= "</body></html>";
        $toemail='neeraj@mobikasa.com';
        $headers = "From: " . strip_tags($from) . "\r\n";
        $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        mail($toemail,$subject,$html,"From: $from\n");
        //echo $html;
       echo json_encode($data);

    }
}