<?php
class Mailchimp_Mod_Model_Observer{

    public function sync(){

        $myfile = fopen("mailchimp_sync.txt", "w");
        fwrite($myfile, "Its working");
        fclose($myfile);
    }
}