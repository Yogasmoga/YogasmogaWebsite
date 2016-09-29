<?php
require_once 'app/Mage.php';
Mage::app();
umask(0);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>YOGASMOGA</title>
    <link rel="stylesheet" href="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/yogasmoga2016/yogasmoga-theme/css/fonts.css";?>"/>
    <style>
        *{margin:0;padding:0;}
        .clr{clear:both}
        ul,ol{list-style-type:none; }
        a{color:#555; display: block}
        body{ color:#555;  font-family: 'GraphikRegular';}
        .container{width:100%}
        .header-container{width:1340px;position: relative; margin: 0 auto;}
        .header-container .f-block{padding: 12px 0px; border-bottom: 1px solid #555; overflow: hidden;position: relative;}
        .header-container .free-shipping,.header-container .offer{float:left;}
        .header-container .offer{width:870px;}
        .header-container .free-shipping{font-size: 12px;}
        .header-container .offer p{text-align: center; font-family:Graphik-Semibold;width:100%; font-size: 12px;position: absolute;left:0; right:0;}
        .f-block .right-links{float: right;}
        .f-block .right-links ul li{display: inline-block;}
        .f-block .right-links ul li a {display: block;padding:0 10px; text-transform: uppercase; font-size: 12px;color:#555; text-decoration: none}
        .f-block .right-links ul li a.last{padding-right: 0}
        .header-container .s-block{padding: 15px 0px;overflow: hidden;position: relative}
        .header-container .s-block .menu-links ul li{}
        .header-container .s-block .menu-links{float: left}
        .header-container .s-block .right-cms{float: right;}
        .header-container .s-block ul li{display: inline-block}
        .header-container .s-block ul li a{ font-family:Graphik-Semibold; }
        .header-container .s-block ul li a{padding-right: 22px; display: block; font-size: 12px; text-decoration: none; text-transform: uppercase}
        .header-container .s-block ul li a.last{padding: 0; }

        .header-container .s-block .logo{width:300px; float:left}
        .header-container .s-block .logo a{display: block; position: absolute;right:0;left:0 ; text-align: center;}
        .content{overflow: hidden}
        .content .product-image{width:870px;float:left}
        .content .product-image .p-img{width:100%}
        .content .product-image .p-img img{max-width:800px; width:100%;height:auto;}
        .content .product-details{width:465px;float:right}


    </style>
</head>
<body>
            <div class="container">

                <!--header-->
                <div class="header-container">
                    <div class="f-block">
                        <div class="free-shipping"><p>Free Shipping to US & Canada</p></div>
                        <div class="offer"><p>SIGN UP NOW TO INSTANTLY GET 25% OFF YOUR FIRST ORDER</p></div>
                        <div class="right-links">
                            <ul>
                                <li><a href="" class="first">Sign in</a></li>
                                <li><a href="">Bag(0)</a></li>
                                <li><a href="" class="last">Help</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clr"></div>
                    <div class="s-block">
                        <div class="menu-links">
                            <ul>
                                <li><a href="" class="first">Women</a></li>
                                <li><a href="" class="last">Men</a></li>
                            </ul>
                        </div>
                        <div class="logo"><a href=""><img src="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/yogasmoga2016/yogasmoga-theme/images/ys-logo-new1.svg'?>"/></a></div>
                        <div class="right-cms">
                            <ul>
                                <li><a href="" class="first">Ys Story</a></li>
                                <li><a href="" class="last">Ys Stores</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--content-->
                <div class="content">

                        <div class="product-image">
                                <div class="p-img"><img src="<?php echo Mage::getBaseUrl('media').'wysiwyg/new-design-images/women-page/new-desgin-img1.jpg'?>"></div>
                        </div>



                        <div class="product-details"></div>

                </div>
                <!--Footer-->
                <div class="footer-container">

                </div>
            </div>
</body>
</html>