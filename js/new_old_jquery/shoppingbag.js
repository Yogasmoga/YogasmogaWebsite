jQuery(document).ready(function($){

    showShoppingBagHtml();
//    openShoppingCart();
    inputFocus();
    //checkAppliedPromotion();


    
    
    // check applied promotion get alert
    // function checkAppliedPromotion(){
    // }
    // window resize
   
    /* ===========  code for all events in shopping for appy smogi bucks in the cart  =========*/
    // check if user click on sign in from the drop down menu
    
    $("#signin").on("click",function(){
        _isClickSigninMenu = true;
    });
    $("#hidemsg").live("click",function(){
         $('#redeemresult').empty().hide();
    });
    $("#continuelink,.pageoverlay").live("click",function(){
        $(".pageoverlay").hide();
        $(".page").animate({ left: '0' }).css("");
        $(".header-container").animate({ left: "0" });
        $("body, html").removeClass("hdnHgt");          
    });
    $("div.adddields span").live("click",function(){  
         if(!$(this).attr('class')){
//             showerror('You cannot use Smogi Bucks and Promo Code / Gift Card Code together.');   
            // showerror("Gift Card, SMOGI Bucks and Promo Code cannot be combined. Please choose one and continue CheckOut."); 
             if($(this).prev('input').attr('id')=='smogi'){
                 if($(this).prev('input').attr('available') < 1) showerror('You do not have enough SMOGI Bucks in your Account.');
                 else showerror($(this).prev('input').attr('placeholder'));
             }
             else if($(this).prev('input').attr('id')=='giftcartcode'){
                  if($(this).prev('input').data('used') =='yes') showerror('You cannot use another Promo Code / Gift Card Code.');
                  else showerror('You cannot use Smogi Bucks and Promo Code / Gift Card Code together.');
             }
         }
    });
    
    
    //if(!_islogedinuser) {
        $(document).on("click","#continuecheckout",function(e){
            if(!_islogedinuser) {
                e.preventDefault(); 
             //   console.log('Test-'+_islogedinuser);
                _isClickSigninMenu = true;
                $("#signing_popup").dialog( "open" );  
            }
        });
   // }        
//    $(document).live("click","#continuecheckout",function(e){
//        e.prevenDefault();
//        alert('22');
//    });
    

    // add bracelet in cart
    var pid = '';
    var colorattributeid = '';
    var sizeattributeid = '';
    jQuery(".addbracelet").live("click",function(){
        jQuery(this).html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' />");
        pid = (jQuery(this).parent("span").parent("li").attr("productid")).trim();
        colorattributeid = (jQuery(this).parent("span").parent("li").attr("colorattributeid")).trim();
        sizeattributeid =  (jQuery(this).parent("span").parent("li").attr("sizeattributeid")).trim();
        addbracelettobag(pid,colorattributeid,sizeattributeid );
    });
    // end add bracelet in cart

    // delete product from cart
    jQuery(".close").live("click",function(e){
        e.preventDefault();
        var deleteproductid = (jQuery(this).parent("li").attr("id")).trim();
        jQuery(this).parent("li").html("<img style='margin:20px 0;' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' />");
        deleteproduct(deleteproductid);
    });

    // open login popup for click on sign in on shopping bag
    $(".shoppingbag-login").live("click",function(){
        _isClickShoppingbagSignin = true;
        $("#signing_popup").dialog( "open" );

    });
    // open login popup for click on smogi login (+)  in on shopping bag
    $(".smogi-login").live("click",function(){
        _isClickSmogiLogin = true;
        $("#signing_popup").dialog( "open" );

    });

    // open login popup for click on sign in on shopping bag
    $(document).on('keypress', '#smogi',function( event ) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == 13) {
            smogicart();
        }
    });
    $(".applysmogi").live("click",function(){
        //var disPromoNGift = jQuery(".smogi span.f-right").attr("usedpoints");
        smogicart();
          
    });
    // remove smogi bucks from cart
    $('.removesmogi').live("click", function(e){
        e.preventDefault();
        $(this).html("<img style='height: 12px' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' />");
        removesmogibucks();
    });
    // remove gift card from cart
    $(".removegiftcart").live("click",function(){
        $(this).html("<img style='height: 12px' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' />");
        _isClickRemoveGiftYS = 0;
        redeemgiftcardcode();
    });
    /* =========== END  code for all events in shopping for appy smogi bucks in the cart  =========*/



    /* ===========  code for all events in shopping for appy Promotion code  in the cart  =========*/

    $(".promo-login").live("click",function(){
        _isClickSmogiLogin = true;
        $("#signing_popup").dialog( "open" );

    });
//    $(document).on('keypress', '#promocode',function( event ) {
//        var keycode = (event.keyCode ? event.keyCode : event.which);
//        if(keycode == 13) {
//            promocodecart();
//        }
//    });
//    $(".applypromo").live("click",function(){
//            promocodecart();
//    });
    $(".removepromotion").live("click",function(){
        $(this).html("<img style='height: 12px' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' />");
        removepromocode();
    });

    /* ===========  END code for all events in shopping for appy Promotion code  in the cart  =========*/

    /* ===========  code for all events in shopping for appy Gift of YS   in the cart  =========*/

    $(".giftcardlogin").live("click",function(){
        _isClickSmogiLogin = true;
        $("#signing_popup").dialog( "open" );

    });
    $(".applygiftcard").live("click",function(e){
        e.preventDefault(); 
        count= occurrences($('#giftcartcode').val(),'-');
        // if($('#giftcartcode').val().indexOf('-') == -1 )
        if(count < 2)
        {
            promocodecart();
        }
        else{
            giftcart();
        }        
    });
    $(document).on('keypress', '#giftcartcode',function( event ) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == 13) {
            count= occurrences($('#giftcartcode').val(),'-');
           // console.log(count);
           // if($('#giftcartcode').val().indexOf('-') == -1 )
           if(count < 2)
            {
                promocodecart();
            }
            else{
                giftcart();
            }
        }
    });
    $(".giftcardcheckbox").live("click",function(){
        jQuery('.zindexH').show();
        redeemgiftcardcode();
    });

    /* ===========  END code for all events in shopping for appy Gift of YS   in the cart  =========*/
    // reset page to default state
    $("#continuelink").live("click", function(){
        $(this).parent(".shopping-cart").addClass("hdnovr");
        $(".page").animate({ left: '0' }).css("");
        $(".header-container").animate({ left: "0" });
        $("body, html").removeClass("hdnHgt");
        setInterval(function() {
                if(_islogedinuser){
                    if($(".checkoutshow").css('display','none')) $(".checkoutshow").show();
                }
        }, 30000);
        return false;
    });

    // $(".addedItem li").find(".close").live("click", function(){
    //     $(this).parent("li").remove();
    // });

    // check when click on continue checkout button on top of shopping bag
    $(document).on("click", ".continuecheckout", function(event){

        if(!_islogedinuser)
        {
            event.preventDefault();
            _isClickContinueNotLogedin = true;
            _isClickSigninMenu = true;
            $("#signing_popup").dialog( "open" );
        }
    });
});
jQuery(window).resize(function(){
    var bodyHght = jQuery(window).height();
    jQuery(".shopping-cart").css({
        "height": bodyHght
    });
});
//check shopping bag input focus/blur 
    function inputFocus(){
        jQuery("#giftcartcode").live("focus", function () {
             if (jQuery(this).val() == jQuery(this).attr("placeholder")) {
                 jQuery(this).val("");
             }
         });
        jQuery("#giftcartcode").live("blur", function () {
             if (jQuery(this).val() == "") {
                 jQuery(this).attr("placeholder","Add a Promo Code / Gift Card Code");
             }
         });
//        jQuery("#promocode").live("focus", function () {
//             if (jQuery(this).val() == "Add a promo code") {
//                 jQuery(this).val("");
//             }
//         });
//        jQuery("#promocode").live("blur", function () {
//             if (jQuery(this).val() == "") {
//                 jQuery(this).val("Add a promo code");
//             }
//         });
        jQuery("#smogi").live("blur", function () {
            var storeVal = jQuery(this).attr("available")? jQuery(this).attr("available"):0;
            var appliedvalue = jQuery(".smogi span.f-right").attr("usedpoints")?jQuery(".smogi span.f-right").attr("usedpoints"):0;
            //var availablesmogi = '';
            var availablesmogi = (jQuery("#smogi").attr("available")).trim()? (jQuery("#smogi").attr("available")).trim():0;
            
//            if(availablesmogi !='')
//            {
//                availablesmogi = (jQuery("#smogi").attr("available")).trim();
//            }

            if(availablesmogi !='' && appliedvalue  !='')
            {
                appliedvalue = parseInt(appliedvalue);
                availablesmogi = parseInt(availablesmogi);
                    if (jQuery(this).val() == "") {
                       // smogipoints= availablesmogi - appliedvalue;
                        if(availablesmogi > 0) jQuery(this).attr('placeholder','Use Your '+availablesmogi+' SMOGI Bucks Toward This Purchase');
                    }
            }else{
                if (jQuery(this).val() == "" && storeVal !="") {
                    jQuery(this).attr('placeholder','Use Your '+storeVal+' SMOGI Bucks Toward This Purchase');
                }
            }
         });

    }
// Show/Hide Shopping Cart Container
    /*function openShoppingCart(){
        var shoppingWdth = jQuery(".shopping-cart").width();
        var bodyHght = jQuery(window).height();

        jQuery(".open-cart").live("click", function(){
            jQuery(".shopping-cart").css({
                "height": bodyHght,
                "display": 'block'
            }).removeClass("hdnovr");
            jQuery(".page").css("position", "relative").animate({ left: -shoppingWdth });
            jQuery(".pageoverlay").css("min-height", bodyHght).css("width", jQuery(window).width()).animate({ left: -shoppingWdth }).show();
            jQuery(".header-container").animate({ left: -shoppingWdth });
            jQuery("body").addClass("hdnHgt");
           // alert(bodyHght);
            return false;
        });
    }*/
    jQuery(".open-cart").live("click", function(){
        openShoppingCart();
    });

function occurrences(string, substring){
    var n=0;
    var pos=0;
 
    while(true){
        pos=string.indexOf(substring,pos);
        if(pos!=-1){ n++; pos+=substring.length;}
        else{break;}
    }
    return(n);
}


function openShoppingCart()
{
var shoppingWdth = jQuery(".shopping-cart").width();
var bodyHght = jQuery(window).height();
jQuery(".shopping-cart").css({
    "height": bodyHght,
    "display": 'block'
}).removeClass("hdnovr");
jQuery(".page").css("position", "relative").animate({ left: -shoppingWdth });
jQuery(".pageoverlay").css("min-height", bodyHght).css("width", jQuery(window).width()).animate({ left: -shoppingWdth }).show();
jQuery(".header-container").animate({ left: -shoppingWdth });
jQuery("body, html").addClass("hdnHgt");
// alert(bodyHght);
return false;
}
function smogicart() {
    jQuery('#redeemresult').empty().hide();
    var smogi=jQuery.trim(jQuery('#smogi').val());
    if(!isNaN(smogi) || smogi=='') { 
            if(!_islogedinuser)
            {
                _isClickApplySmogiBucks = true;
                jQuery("#signing_popup").dialog( "open" );
            }

            if(_islogedinuser)
            {   

                    jQuery(".applysmogi").removeClass("applysmogi");
                    jQuery('#smogi').next('span').empty().append("<img style='height: 12px' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' />");
                    jQuery('.zindexH').show();
                    applysmogibucks();
            } 
    }
    else showerror('Please enter valid Smogi Bucks.');
}
function promocodecart(){
    jQuery('#redeemresult').empty().hide();
    var promocode=jQuery.trim(jQuery('#giftcartcode').val());
    if(promocode !='' && promocode != jQuery('#giftcartcode').attr('placeholder')) {
        if(!_islogedinuser)
            {
            //_isClickApplySmogiBucks = true;
                jQuery("#signing_popup").dialog( "open" );
            }

            if(_islogedinuser)
            {   
                
                    jQuery('.applygiftcard').removeClass("applygiftcard");
                    jQuery('#giftcartcode').next('span').empty().append("<img style='height: 12px' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' />");
                    jQuery('.zindexH').show();
                    applypromocode();
        }
    }
    else showerror('Please enter valid code.');
}
function giftcart() {
    jQuery('#redeemresult').empty().hide();
    var giftcartcode=jQuery.trim(jQuery('#giftcartcode').val());
    if(giftcartcode !='' && giftcartcode != jQuery('#giftcartcode').attr('placeholder')) {
        if(!_islogedinuser)
        {
           // _isClickApplySmogiBucks = true;
            jQuery("#signing_popup").dialog( "open" );
        }
        if(_islogedinuser)
        {
              
                jQuery('.applygiftcard').removeClass("applygiftcard");
                jQuery('#giftcartcode').next('span').empty().append("<img style='height: 12px' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' />");
                jQuery('.zindexH').show();
                applygiftcardcode();
        }
    }
    else showerror('Invalid gift of YS code.');
}
function showShoppingBagHtml()
{
    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mynewtheme/shoppingbag/showshoppingbaghtml';
    var checkouturl = homeUrl + 'checkout/onepage';
    if(_usesecureurl)
    {
        url = securehomeUrl + 'mynewtheme/shoppingbag/showshoppingbaghtml';
        checkouturl = securehomeUrl + 'checkout/onepage';
    }
    // check if user click on sign in from drop down menu
//    alert(_isClickSigninMenu);
    if(_isClickSigninMenu == true)
    {
        _showShoppingbagLoader = true;
        _isClickSigninMenu = false;
    }

    if(_showShoppingbagLoader)
        jQuery(".shopping-cart").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='margin:80% auto auto;' />");
    jQuery.ajax({url : checkouturl});
    setTimeout(function(){


            jQuery.ajax({
                url : url,
                type : 'POST',
                //data : {'blockid':blockid},
                cache : false,
                success : function(data){
                    data = eval('('+data + ')');
                    //console.log(data.html);
                   // alert(data.html);
                    jQuery(".shopping-cart").html(data.html);
                    jQuery(".cartitemcount").html(data.count);
                    if(data.countdiscount > 1)
                        showerror(data.discounttypeerror);
//                    ////alert(jQuery(".contfull2").outerHeight());
//                    jQuery(".bagerrormsg").height(jQuery(".contfull2").outerHeight());
//                    jQuery(".bagerrormsg").width(jQuery(".contfull2").outerWidth());
            }
        });
    },500);
}
function showerror(msg){
        jQuery('#redeemresult').empty().append(msg).show().delay('7000').hide(0);
}
function addbracelettobag(pid,colorattributeid,sizeattributeid )
{
    //alert(_productid);

    if((jQuery(".qtyselector").find('option:selected').val() * 1) > 0)
    {
        var braceletorderqty = '';
        _addingtocart = true;
        braceletorderqty = jQuery(".qtyselector").find('option:selected').val();
        var color = jQuery("#cmbcolor").val();
        var size = jQuery("#cmbsize").val();//alert(_productid);
        var addurl = homeUrl + 'mynewtheme/shoppingbag/add?product=' + pid + '&qty=' + braceletorderqty + '&super_attribute[' + colorattributeid + ']=' + color;
        if(sizeattributeid)
            addurl = addurl + '&super_attribute[' + sizeattributeid + ']=' + size;
        //var targetUrl = homeUrl + 'mycatalog/myproduct/setNamaskarError/qty/' + braceletorderqty;
        jQuery.ajax({
            type : 'POST',
            url : addurl,
            data : {},
            success : function(result){
                result = eval('(' + result + ')');
                _addingtocart = false;
                if(result.status == 'success')
                {
                    _isaddedtobracelet = true;
                    jQuery(".shopping-cart").html(result.html);
                    jQuery(".cartitemcount").html(result.count);

                }
            /*    else
                {
                    jQuery.ajax({
                        type : 'POST',
                        url : targetUrl,
                        data : {},
                        success : function(result){
                            _isaddedtobracelet = true;
                            jQuery("#bagform").submit();
                        }
                    });
                } */
            }
        });
        return false;
    }
}

function deleteproduct(deletedproducid)
{
    if(deletedproducid >0)
    {
        var addurl = homeUrl + 'mynewtheme/shoppingbag/delete/';
        jQuery.ajax({
            type : 'POST',
            url : addurl,
            data : {'id':deletedproducid},
            success : function(result){
                result = eval('(' + result + ')');

                if(result.status == 'success')
                {
                    _showShoppingbagLoader = false;
                    showShoppingBagHtml();
                    jQuery(".cartitemcount").html(result.count);
                    if(result.count < 1 )  jQuery(".checkoutshow").hide();

                }

            }
        });
    }
}

function applysmogibucks()
{
    
    var availablesmogi = jQuery("#smogi").attr("available");
    var smogivalue = jQuery.trim(jQuery("#smogi").val());
//    if(smogivalue > availablesmogi) {
//        jQuery('#smogi').next('span').addClass("applysmogi").empty().append("+");
//        showerror('Please enter valid Smogi Bucks or available Smogi Bucks balance in your account is not sufficient.');
//        return false;
//    }
    //smogivalue = parseInt(smogivalue);
    var appliedvalue = jQuery(".smogi span.f-right").attr("usedpoints");
    if(smogivalue=='') {
        smogivalue=availablesmogi;
         //alert(availablesmogi);
       // alert(smogivalue);
    }
    else if(isNaN(smogivalue) && smogivalue !='') {
        jQuery('#smogi').next('span').addClass("applysmogi").empty().append("+");
        showerror('Please enter valid number.');
        return false;
    }




    if(availablesmogi)
    {
        availablesmogi = (jQuery("#smogi").attr("available")).trim();
    }
    ///////////alert(smogivalue+ '<=' +availablesmogi);
    if(parseInt(smogivalue) <= parseInt(availablesmogi))
    {
        if(appliedvalue)
        {
            appliedvalue = parseInt(appliedvalue);

            if(!(isNaN(appliedvalue)) && (appliedvalue > 0))
            {
                smogivalue = parseInt(smogivalue) + parseInt(appliedvalue);
            }
        }
        if(window.location.href.indexOf('https://') >= 0)
            _usesecureurl = true;
        else
            _usesecureurl = false;
        var url = homeUrl + 'mynewtheme/smogi/applysmogibucks';
        if(_usesecureurl)
            url = securehomeUrl + 'mynewtheme/smogi/applysmogibucks';
        jQuery.ajax({
            url : url,
            type : 'POST',
            data : {'points_to_be_used':smogivalue},
 
            success : function(data){
                data = eval('('+data + ')');

                if(data.status == "success")
                {
                    _showShoppingbagLoader = false;
                    showShoppingBagHtml();
                }
                else
                {
                    showerror('There is some error while applying smogi bucks.');
                    showerror(data.error);
                    jQuery('#smogi').next('span').addClass("applysmogi").empty().append("+");
                    jQuery('.zindexH').hide();
                }



            }
        });
    }
    else{
        jQuery('#smogi').next('span').addClass("applysmogi").empty().append("+");
        showerror('You do not have enough SMOGI Bucks in your Account.');
        jQuery('.zindexH').hide();
    }

}

function removesmogibucks()
{
    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mynewtheme/smogi/removesmogibucks';
    if(_usesecureurl)
        url = securehomeUrl + 'mynewtheme/smogi/removesmogibucks';
    jQuery('.zindexH').show();
    jQuery.ajax({
        url : url,
        type : 'POST',
       // data : {'points_to_be_used':smogivalue},

        success : function(data){
            data = eval('('+data + ')');

            if(data.status == "success")
            {
                _showShoppingbagLoader = false;
                showShoppingBagHtml();
            }
            else
            {
                jQuery('.zindexH').hide();
                showerror('There is some error while removing smogi bucks.');
                
            }

        }
    });
}

function automaticapplysmogibucks()
{
    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mynewtheme/smogi/automaticapplysmogibucks';
    if(_usesecureurl)
        url = securehomeUrl + 'mynewtheme/smogi/automaticapplysmogibucks';
    jQuery.ajax({
        url : url,
        type : 'POST',
        // data : {'points_to_be_used':smogivalue},

        success : function(data){
            data = eval('('+data + ')');

            if(data.status == "success")
            {
                _showShoppingbagLoader = false;
                showShoppingBagHtml();
            }
            else
            {
                showerror('There is some error while apply auto smogi bucks.');
            }

        }
    });
}

function applypromocode()
{
    

    var promocode = (jQuery("#giftcartcode").attr("value")).trim();

        if(window.location.href.indexOf('https://') >= 0)
            _usesecureurl = true;
        else
            _usesecureurl = false;
        var url = homeUrl + 'mynewtheme/promotion/applycouponcode';
        if(_usesecureurl)
            url = securehomeUrl + 'mynewtheme/promotion/applycouponcode';

        jQuery.ajax({
            url : url,
            type : 'POST',
            data : {'coupon_code':promocode},

            success : function(data){
                data = eval('('+data + ')');

                if(data.status == "success")
                {
                    _showShoppingbagLoader = false;
                    showShoppingBagHtml();
                }
                else
                {   
                    showerror(''+data.errors+'');
                    jQuery('#giftcartcode').val('');
                    jQuery('#giftcartcode').next('span').addClass("applygiftcard").empty().append("+");
                    jQuery('.zindexH').hide();
                }



            }
        });



}

function removepromocode()
{
    
    var promocode = (jQuery("#giftcartcode").attr("value")).trim();

    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mynewtheme/promotion/applycouponcode';
    if(_usesecureurl)
        url = securehomeUrl + 'mynewtheme/promotion/applycouponcode';
    jQuery('.zindexH').show();
    jQuery.ajax({
        url : url,
        type : 'POST',
        data : {'remove':'1'},

        success : function(data){
            data = eval('('+data + ')');

            if(data.status == "success")
            {
                _showShoppingbagLoader = false;
                showShoppingBagHtml();
            }
            else
            {
                jQuery('.zindexH').hide();
                showerror(''+data.errors+'');
            }
        }
    });


}

function applygiftcardcode()
{
     jQuery('#redeemresult').empty().hide();
     var giftcardcode = (jQuery("#giftcartcode").attr("value")).trim();

    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mynewtheme/giftofys/applyGiftCard';
    if(_usesecureurl)
        url = securehomeUrl + 'mynewtheme/giftofys/applyGiftCard';

    jQuery.ajax({
        url : url,
        type : 'POST',
        data : {'giftcard_code':giftcardcode},

        success : function(data){
            data = eval('('+data + ')');

            if(data.status == "success")
            {
                _showShoppingbagLoader = false;
                showShoppingBagHtml();
            }
            else
            {
                showerror(''+data.error+'');
                jQuery('#giftcartcode').val('');
                jQuery('#giftcartcode').next('span').addClass("applygiftcard").empty().append("+");
                jQuery('.zindexH').hide();
            }
        }
    });
}
function redeemgiftcardcode()
{
    jQuery('#redeemresult').empty().hide();
    
    var redeemvalue = '';

    if(_isClickRemoveGiftYS == 0){
        redeemvalue = 0;
    }else{
        if(jQuery(".giftcardcheckbox").is(":checked")){
            redeemvalue = 1;
        }else{
            redeemvalue = 0;
        }
    }
    _isClickRemoveGiftYS=1;


    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mynewtheme/giftofys/giftcardactive';
    if(_usesecureurl)
        url = securehomeUrl + 'mynewtheme/giftofys/giftcardactive';
    if(redeemvalue == 1) jQuery(".giftcarloader").empty().append("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' />");
    jQuery('.zindexH').show();
    jQuery.ajax({
        url : url,
        type : 'POST',
        data : {'giftcard_use':redeemvalue},

        success : function(data){
            data = eval('('+data + ')');

            if(data.status == "success")
            {
                _showShoppingbagLoader = false;
                showShoppingBagHtml();
            }
            else
            {
                showerror(data.error);
                if(jQuery(".giftcardcheckbox").is(":checked")) jQuery(".giftcardcheckbox").removeAttr('checked','checked');
                jQuery(".giftcarloader").empty();
                jQuery('.zindexH').hide();
            }
            
        }
    });
}