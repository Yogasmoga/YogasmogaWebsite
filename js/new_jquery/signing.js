jQuery(document).ready(function($){

    $("#sign-up-form").submit(function(event){
        var formid = "#sign-up-form";
        var status = popupGetSigningCreateaccountFormFieldsvalue(formid);
        if(status != "error")
            createCustomerAccount();
        event.preventDefault();          
                  
    });
    $("#sign-up-form").on("click","#sign-up-button", function(){     
        var errMsgCont = $("#sign-up-form").find("p.err-msg");
        if(errMsgCont.css("visibility") == "visible")
        {
            errMsgCont.css("visibility","hidden");
        } 
    });
    $("#sign-in-form").submit(function(event){

        var formid = "#sign-in-form";
        var status = popupGetSigningLoginFormFieldsvalue(formid);
        if(status != "error")
            loginCustomer();
        event.preventDefault();
    });
    $("#sign-in-form").on("click","#sign-in-button", function(){     
        var errMsgCont = $("#sign-in-form").find("p.err-msg");
        if(errMsgCont.css("visibility") == "visible")
        {
            errMsgCont.css("visibility","hidden");
        } 
    });
});

function createCustomerAccount()
{
    var fname = jQuery.trim(jQuery("#fname").val());
    var lname = jQuery.trim(jQuery("#lname").val());
    var email_id = jQuery.trim(jQuery("#signup_email").val());
    var pwd = jQuery.trim(jQuery("#s_password").val());
    var cpassword = pwd;
    var is_subscribed = jQuery("#in_touch").val();
    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mycatalog/myproduct/registercustomer';
    if(_usesecureurl)
        url = securehomeUrl + 'mycatalog/myproduct/registercustomer';

    jQuery.ajax({

        url     :   url,
        type    :   'POST',
        data    :   {'firstname':fname,'lastname':lname,'email':email_id,'password':pwd,'confirmation':cpassword,'is_subscribed':is_subscribed},
        beforeSend: function() {            
            jQuery("#sign-up-form .form-loader").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='width:16px;' />");
            jQuery("#sign-up-button").parent().hide();
            jQuery("#sign-up-form .form-loader").show();
        },
        success :   function(data){

            data = eval('('+data + ')');
            var status = data.status;
            var name = data.fname;

            if(status == "success")
            {
                // console.log(data.status);
                jQuery(".signing_popup_wrapper").addClass("no-display");
                jQuery(".thank-you-block").removeClass("no-display");
                jQuery(".signinDialog").addClass("wdthauto");
                _islogedinuser = true;
                jQuery("#signin").html("SIGN OUT").attr({href:homeUrl+'customer/account/logout/',id:"sign-out"});

                if(name != ''){
                    jQuery("#welcome-name").html("Hi "+name).attr("href",homeUrl+'customer/account/');
                }
                /*setTimeout(function(){
                    jQuery("#signing_popup").dialog("close");                    
                },3000);*/
                if(_isClickShareWithFriends)
                {
                    setTimeout(function(){
                        jQuery("#invite_friends").dialog( "open" );
                    },4000);                    
                }

                //check for _isClickAddtowishlist and trigger wishlist link automatically
                if(_isClickAddtowishlist)
                {
                    jQuery(".wishlist-link a").trigger('click');
                }
                if(_isClickSigninMenu)
                {
                    //automaticapplysmogibucks();
                    showShoppingBagHtml();

                }

                if(_isClickShoppingbagSignin)
                {
                    _isClickShoppingbagSignin = false;
                    //automaticapplysmogibucks(); // automatically apply smogi bucks in the shopping cart
                    showShoppingBagHtml();// call showShoppingBagHtml() declared in shoppingbag.js whick is responsible for load shopping bag html

                }
                if(_isClickApplySmogiBucks)
                {
                    _isClickApplySmogiBucks = false;
                    applysmogibucks();// call applysmogibucks() declared in shoppingbag.js
                }
                if(_isClickSmogiLogin)
                {
                    _isClickSmogiLogin = false;
                    //automaticapplysmogibucks(); // automatically apply smogi bucks in the shopping cart
                    showShoppingBagHtml(); //call showShoppingBagHtml to load customer cart after login via smogi login button
                }
                if(_isClickSmogiBucksPageLogin)
                {
                    _isClickSmogiBucksPageLogin =false;
                    jQuery(".smogi-bucks-login").empty().append('<span>Just <a class="redTxt" href="customer/account/index/">view</a> your account to check your balance. </span>');
                    //jQuery(".smogi-view-account").show();

                }
                if(_isClickFooterWelcomeName)
                {
                    window.location.assign(homeUrl+'customer/account/index');
                }
                if(_isClickFooterTrackOrder)
                {
                    window.location.assign(homeUrl+'sales/order/history/');
                }


            }
            else
            {
                // console.log(data.errors);
                console.log("error");                
                jQuery("#sign-up-button").parent().show();
                jQuery("#sign-up-form .form-loader").hide();
                jQuery("#sign-up-form .err-msg").html(data.errors).css("visibility","visible");
            }
        }
    });
}

function loginCustomer()
{
    var email_id = jQuery.trim(jQuery("#si_email").val());
    var pwd = jQuery.trim(jQuery("#si_password").val());
    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mycatalog/myproduct/logincustomer';
    if(_usesecureurl)
        url = securehomeUrl + 'mycatalog/myproduct/logincustomer';

    jQuery.ajax({

        url     :   url,
        type    :   'POST',
        data    :   {'email':email_id,'pwd':pwd},
        beforeSend: function() {            
            jQuery("#sign-in-form .form-loader").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='width:16px;' />");
            jQuery("#sign-in-button").parent().hide();
            jQuery("#sign-in-form .form-loader").show();
        },
        success :   function(data){

            data = eval('('+data + ')');
            var status = data.status;
            var error = data.error;
            var name = data.fname;

            if(status == "success")
            {
                jQuery("#signin").html("SIGN OUT").attr({href:homeUrl+'customer/account/logout/',id:"sign-out"});
                jQuery("#signing_popup").dialog( "close" );
                jQuery(".signin-loader").html("");
                _islogedinuser = true;
                if(name != '')
                    jQuery("#welcome-name").html("Hi "+name).attr("href",homeUrl+'customer/account/');

                if(_isClickShareWithFriends)
                {
                    //_isClickShareWithFriends = false;
                    jQuery("#invite_friends").dialog( "open" );
                }
                //check for _isClickAddtowishlist and trigger wishlist link automatically
                if(_isClickAddtowishlist)
                {
                    jQuery(".wishlist-link a").trigger('click');
                }
                if(_isClickSigninMenu)
                {

                    //automaticapplysmogibucks();
                    showShoppingBagHtml();
                }

                if(_isClickShoppingbagSignin)
                {
                    _isClickShoppingbagSignin = false;
                    //automaticapplysmogibucks(); // automatically apply smogi bucks in the shopping cart
                    showShoppingBagHtml();// call showShoppingBagHtml() declared in shoppingbag.js whick is responsible for load shopping bag html

                }
                if(_isClickApplySmogiBucks)
                {
                    _isClickApplySmogiBucks = false;
                    applysmogibucks();// call applysmogibucks() declared in shoppingbag.js
                }
                if(_isClickSmogiLogin)
                {
                    _isClickSmogiLogin = false;
                    //automaticapplysmogibucks(); // automatically apply smogi bucks in the shopping cart
                    showShoppingBagHtml(); //call showShoppingBagHtml to load customer cart after login via smogi login button
                }
                if(_isClickContinueNotLogedin)
                {
                    //automaticapplysmogibucks();
                    showShoppingBagHtml();
                }

                if(_isClickSmogiBucksPageLogin)
                {
                    _isClickSmogiBucksPageLogin =false;
                    jQuery(".smogi-bucks-login").empty().append('<span>Just <a class="redTxt" href="customer/account/index/">view</a> your account to check your balance. </span>');
                    //jQuery(".smogi-view-account").show();

                }
                if(_isClickFooterWelcomeName)
                {
                    window.location.assign(homeUrl+'customer/account/index');
                }
                if(_isClickFooterTrackOrder)
                {
                    window.location.assign(homeUrl+'sales/order/history/');
                }
                if (jQuery("body").hasClass("cms-smogi-bucks")) {
                    jQuery(".gd-container1").hide();
                }

            }
            else
            {
                jQuery("#sign-in-form .err-msg").html(data.errors).css("visibility","visible");              
                jQuery(".signin-loader").html("");
                jQuery("#sign-in-button").parent().show();
                jQuery("#sign-in-form .form-loader").hide();
            }
        }

    });
}