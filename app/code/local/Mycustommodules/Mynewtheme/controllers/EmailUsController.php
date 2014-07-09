<?php

class Mycustommodules_Mynewtheme_EmailUsController extends Mage_Core_Controller_Front_Action
{
    public function sendMailAction()
    {
        $data = array();
      //  print_r($this->getRequest()->getPost());
        $name= $this->getRequest()->getPost('name');
        //$filedata= $this->getRequest()->getPost('filename');
        if(isset($name))
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
        else
        {
                $data = array('success' => 'Form was submitted', 'formData' => $_POST);
        }

        echo json_encode($data);

    }
}