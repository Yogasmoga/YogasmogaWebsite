<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="keywords"  content="" />
        <meta name="description" content="" />        
    </head>
    <body>
      
        <?php         
    $str ='10T'; 

if (preg_match('/^\d+$/',$str)){ 
     
    echo 'has number'; 
}else{ 
    echo 'no number'; 
     
}  
?>
    </body>
</html>