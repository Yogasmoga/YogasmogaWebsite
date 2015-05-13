var root='http://staging.yogasmoga.com/';
//var root='http://ysstaging.com.local/';

/**************** logout logic added by ys team *****************/
jQuery(document).ready(function($){


    jQuery(".gender_p span").click(function(){
        jQuery(".gender_p span").removeClass("selected");
        jQuery(this).addClass("selected");
    });


    checkIsUserLogged();

    $("#sign-up-form").submit(function(event){
        var formid = "#sign-up-form";

        var status = popupGetSigningCreateaccountFormFieldsvalue(formid);

        if(status != "error") {

            if(!if_gender_is_selected()){
                event.preventDefault();
                jQuery(formid).find(".err-msg").css("visibility","visible");
                jQuery(formid).find(".err-msg").text("Please select gender");
                return;
            }
            else
                createCustomerAccount();
        }
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
    /***login form for smogi buck page***/
    $("#sb-sign-in-form").submit(function(event){
        _smogiPageLogin = true;
        var formid = "#sb-sign-in-form";
        var status = popGetSigningLoginFormFieldsvalue(formid);
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

    $(".ui-dialog .ui-dialog-titlebar-close span").click(function(){
        jQuery(".gender_radio").removeClass("selected");
    });


});

/*
 function  createCustomerAccount()
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
 */
/*setTimeout(function(){
 jQuery("#signing_popup").dialog("close");
 },3000);*//*

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
 // redirect from singing popup to track order or dashboard

 jQuery("#signing_popup").dialog({
 close: function( event, ui ) {
 if(_redirectFromSingingPopup != null)
 window.location.assign(_redirectFromSingingPopup);
 }
 });


 // for remove over state on feel smogi love
 if(!_islogedinuser){
 jQuery(".footer-block .smogi-love").removeClass("no-over-state");
 jQuery(".share-strip .sign-up-new a").removeClass("dnone");
 jQuery(".share-strip .sign-up-new span").text("& WE'LL SURPRISE YOU");
 }
 else{
 jQuery(".footer-block .smogi-love").addClass("no-over-state");
 jQuery(".share-strip .sign-up-new a").addClass("dnone");
 jQuery(".share-strip .sign-up-new span").text("Welcome To YOGASMOGA");
 // jQuery(".share-strip .sign-up-new span").text("Hi! Welcome To YOGASMOGA..");
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
 if(_smogiPageLogin){
 var email_id = jQuery.trim(jQuery("#sb_email").val());
 var pwd = jQuery.trim(jQuery("#sb_password").val());
 }else{
 var email_id = jQuery.trim(jQuery("#si_email").val());
 var pwd = jQuery.trim(jQuery("#si_password").val());
 }
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
 if(_smogiPageLogin){
 jQuery("#sb-sign-in-form .form-loader").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='width:16px;' />");
 jQuery("#sb-sign-in-button").parent().hide();
 jQuery("#sb-sign-in-form .form-loader").show();
 }else{
 jQuery("#sign-in-form .form-loader").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='width:16px;' />");
 jQuery("#sign-in-button").parent().hide();
 jQuery("#sign-in-form .form-loader").show();
 }
 },
 success :   function(data){

 data = eval('('+data + ')');
 var status = data.status;
 var error = data.error;
 var name = data.fname;
 var somgiBal = data.smogi;

 if(status == "success")
 {
 if(_redirectFromSingingPopup != null)
 window.location.assign(_redirectFromSingingPopup);
 jQuery("#signin").html("SIGN OUT").attr({href:homeUrl+'customer/account/logout/',id:"sign-out"});
 jQuery("#signing_popup").dialog( "close" );
 jQuery(".signin-loader").html("");
 _islogedinuser = true;
 if(name != '')
 jQuery("#welcome-name").html("Hi "+name).attr("href",homeUrl+'customer/account/');

 jQuery(".before-login").hide();
 jQuery(".after-login").show();
 jQuery(".after-login li.smogi-balance a span").html(somgiBal);
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
 window.location.assign(homeUrl+'customer/account/index');
 }

 // for remove over state on feel smogi love
 if(!_islogedinuser){
 jQuery(".footer-block .smogi-love").removeClass("no-over-state");
 jQuery(".share-strip .sign-up-new a").removeClass("dnone");
 jQuery(".share-strip .sign-up-new span").text("& WE'LL SURPRISE YOU");
 }
 else{
 jQuery(".footer-block .smogi-love").addClass("no-over-state");
 jQuery(".share-strip .sign-up-new a").addClass("dnone");
 jQuery(".share-strip .sign-up-new span").text("Welcome To YOGASMOGA");
 // jQuery(".share-strip .sign-up-new span").text("Hi! Welcome To YOGASMOGA..");
 }

 }
 else
 {
 if(_smogiPageLogin){
 _smogiPageLogin = false;
 jQuery("#sb-sign-in-form .err-msg").html(data.errors).css("visibility","visible");
 jQuery(".signin-loader").html("");
 jQuery("#sb-sign-in-button").parent().show();
 jQuery("#sb-sign-in-form .form-loader").hide();
 }else{
 jQuery("#sign-in-form .err-msg").html(data.errors).css("visibility","visible");
 jQuery(".signin-loader").html("");
 jQuery("#sign-in-button").parent().show();
 jQuery("#sign-in-form .form-loader").hide();
 }
 }
 }

 });
 }*/


function  createCustomerAccount()
{
    var fname = jQuery.trim(jQuery("#fname").val());
    var lname = jQuery.trim(jQuery("#lname").val());
    var email_id = jQuery.trim(jQuery("#signup_email").val());
    var pwd = jQuery.trim(jQuery("#s_password").val());
    var gender = jQuery.trim(jQuery(".gender_radio.selected input").val());

    var cpassword = pwd;
    var is_subscribed = jQuery("#in_touch").val();
    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mycatalog/myproduct/registercustomer';
    if(_usesecureurl)
        url = securehomeUrl + 'mycatalog/myproduct/registercustomer';

    //jQuery.ajax({
    //    url     :   url,
    //    type    :   'POST',
    //    data    :   {'firstname':fname,'lastname':lname,'email':email_id,'password':pwd,'confirmation':cpassword,'is_subscribed':is_subscribed},

    jQuery.ajax({
        url     :   url,
        type    :   'POST',
        data    :   {'firstname':fname,'lastname':lname,'email':email_id,'password':pwd,'confirmation':cpassword,'is_subscribed':is_subscribed,'gender':gender},
        beforeSend: function() {
            jQuery("#sign-up-form .form-loader").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='width:16px;' />");
            jQuery("#sign-up-button").parent().hide();
            jQuery("#sign-up-form .form-loader").show();
        },
        success: function (data) {

            data = eval('(' + data + ')');
            var status = data.status;
            var name = data.fname;

            var first_name = data.first_name;
            var last_name = data.last_name;
            var customer_id = data.customer_id;

            if (status == "success") {
                /**************** code added by ys team *****************/
                createRangoliUser(email_id, pwd, first_name, last_name, customer_id);
                /**************** code added by ys team *****************/
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
                // redirect from singing popup to track order or dashboard

                jQuery("#signing_popup").dialog({
                    close: function( event, ui ) {
                        if(_redirectFromSingingPopup != null)
                            window.location.assign(_redirectFromSingingPopup);

                    }
                });


                // for remove over state on feel smogi love
                if(!_islogedinuser){
                    jQuery(".footer-block .smogi-love").removeClass("no-over-state");
                    jQuery(".share-strip .sign-up-new a").removeClass("dnone");
                    jQuery(".share-strip .sign-up-new span").text("& WE'LL SURPRISE YOU");
                }
                else{
                    jQuery(".footer-block .smogi-love").addClass("no-over-state");
                    jQuery(".share-strip .sign-up-new a").addClass("dnone");
                    jQuery(".share-strip .sign-up-new span").text("Welcome To YOGASMOGA");
                    // jQuery(".share-strip .sign-up-new span").text("Hi! Welcome To YOGASMOGA..");
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

function createRangoliUser(email, password, first_name, last_name, customer_id){

    var data = 'email=' + email + '&password=' + password + '&first_name=' + first_name + '&last_name=' + last_name + '&customer_id=' + customer_id;

    jQuery.ajax({
        url: root + 'rangoli/mage_wp_create_user.php',
        data: data,
        type: 'POST',
        success: function(r){
        }
    });
}


/**************** ys team functions *****************/

function loginCustomer() {
    if (_smogiPageLogin) {
        var email_id = jQuery.trim(jQuery("#sb_email").val());
        var pwd = jQuery.trim(jQuery("#sb_password").val());
    } else {
        var email_id = jQuery.trim(jQuery("#si_email").val());
        var pwd = jQuery.trim(jQuery("#si_password").val());
    }
    if (window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mycatalog/myproduct/logincustomer';
    if (_usesecureurl)
        url = securehomeUrl + 'mycatalog/myproduct/logincustomer';

    jQuery.ajax({

        url: url,
        type: 'POST',
        data: {'email': email_id, 'pwd': pwd},
        beforeSend: function () {
            if (_smogiPageLogin) {
                jQuery("#sb-sign-in-form .form-loader").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='width:16px;' />");
                jQuery("#sb-sign-in-button").parent().hide();
                jQuery("#sb-sign-in-form .form-loader").show();
            } else {
                jQuery("#sign-in-form .form-loader").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='width:16px;' />");
                jQuery("#sign-in-button").parent().hide();
                jQuery("#sign-in-form .form-loader").show();
            }
        },
        success: function (data) {

            data = eval('(' + data + ')');
            var status = data.status;
            var error = data.error;

            if (status == "success") {
                var name = data.fname;
                var somgiBal = data.smogi;
                var first_name = data.first_name;
                var last_name = data.last_name;
                var customer_id = data.customer_id;

                jQuery(".login_logout_link").html("<span style='cursor:pointer; margin-left:0;padding-left:0' onclick='wplogout()'>SIGN OUT</span>");

                /************** code update by ys team ******************/
                    //doWordpressLogin(email_id, pwd, name);
                doWordpressLogin(email_id, pwd, first_name, last_name, customer_id);
                /************** code update by ys team ******************/

                if (_redirectFromSingingPopup != null)
                    window.location.assign(_redirectFromSingingPopup);

                //jQuery("#signin").html("SIGN OUT").attr({
                //    href: homeUrl + 'customer/account/logout/',
                //    id: "sign-out"
                //});

                jQuery(".signin-loader").html("");
                jQuery("#signing_popup").dialog("close");
                _islogedinuser = true;
                if (name != '')
                    jQuery("#welcome-name").html("Hi " + name).attr("href", homeUrl + 'customer/account/');

                jQuery(".before-login").hide();
                jQuery(".after-login").show();
                jQuery(".after-login li.smogi-balance a span").html(somgiBal);
                if (_isClickShareWithFriends) {
                    //_isClickShareWithFriends = false;
                    jQuery("#invite_friends").dialog("open");
                }
                //check for _isClickAddtowishlist and trigger wishlist link automatically
                if (_isClickAddtowishlist) {
                    jQuery(".wishlist-link a").trigger('click');
                }
                if (_isClickSigninMenu) {
                    showShoppingBagHtml();
                }

                if (_isClickShoppingbagSignin) {
                    _isClickShoppingbagSignin = false;
                    //automaticapplysmogibucks(); // automatically apply smogi bucks in the shopping cart
                    showShoppingBagHtml();// call showShoppingBagHtml() declared in shoppingbag.js whick is responsible for load shopping bag html

                }
                if (_isClickApplySmogiBucks) {
                    _isClickApplySmogiBucks = false;
                    applysmogibucks();// call applysmogibucks() declared in shoppingbag.js
                }
                if (_isClickSmogiLogin) {
                    _isClickSmogiLogin = false;
                    //automaticapplysmogibucks(); // automatically apply smogi bucks in the shopping cart
                    showShoppingBagHtml(); //call showShoppingBagHtml to load customer cart after login via smogi login button
                }
                if (_isClickContinueNotLogedin) {
                    //automaticapplysmogibucks();
                    showShoppingBagHtml();
                }

                if (_isClickSmogiBucksPageLogin) {
                    _isClickSmogiBucksPageLogin = false;
                    jQuery(".smogi-bucks-login").empty().append('<span>Just <a class="redTxt" href="customer/account/index/">view</a> your account to check your balance. </span>');
                    //jQuery(".smogi-view-account").show();

                }
                if (_isClickFooterWelcomeName) {
                    window.location.assign(homeUrl + 'customer/account/index');
                }
                if (_isClickFooterTrackOrder) {
                    window.location.assign(homeUrl + 'sales/order/history/');
                }
                if (jQuery("body").hasClass("cms-smogi-bucks")) {
                    jQuery(".gd-container1").hide();
                    window.location.assign(homeUrl + 'customer/account/index');
                }

                // for remove over state on feel smogi love
                if (!_islogedinuser) {
                    jQuery(".footer-block .smogi-love").removeClass("no-over-state");
                    jQuery(".share-strip .sign-up-new a").removeClass("dnone");
                    jQuery(".share-strip .sign-up-new span").text("& WE'LL SURPRISE YOU");
                }
                else {
                    jQuery(".footer-block .smogi-love").addClass("no-over-state");
                    jQuery(".share-strip .sign-up-new a").addClass("dnone");
                    jQuery(".share-strip .sign-up-new span").text("Welcome To YOGASMOGA");
                    // jQuery(".share-strip .sign-up-new span").text("Hi! Welcome To YOGASMOGA..");
                }

            }
            else {
                if (_smogiPageLogin) {
                    _smogiPageLogin = false;
                    jQuery("#sb-sign-in-form .err-msg").html(data.errors).css("visibility", "visible");
                    jQuery(".signin-loader").html("");
                    jQuery("#sb-sign-in-button").parent().show();
                    jQuery("#sb-sign-in-form .form-loader").hide();
                } else {
                    jQuery("#sign-in-form .err-msg").html(data.errors).css("visibility", "visible");
                    jQuery(".signin-loader").html("");
                    jQuery("#sign-in-button").parent().show();
                    jQuery("#sign-in-form .form-loader").hide();
                }
            }
        }

    });
}

function doWordpressLogin(email, password, first_name, last_name, customer_id) {

    // now login to wordpress
    jQuery.ajax({
        url: root + 'rangoli/mage_wp_login.php',
        type: 'POST',
        data: 'user_login=' + email + '&password=' + password + '&first_name=' + first_name + '&last_name=' + last_name + '&customer_id=' + customer_id,
        dataType: 'json',
        success: function (result) {

            if (result != undefined && result.message != undefined && result.message == "loginerror") {
                console.log("******* cannot login to wordpress");
                return;
            }
        }
    });
}


/**************** logout logic added by ys team *****************/
function wplogout() {

    jQuery.ajax({
        url: root + 'rangoli/mage_wp_login.php',
        type: 'POST',
        data: 'logout=1',
        dataType: 'json',
        success: function (result) {

            if (result.message == "loggedout") {
                var url = root + "customer/account/logout/";

                window.location.replace(url);
            }
            else if (result.message == "alreadyloggedout") {
                var url = root + "customer/account/logout/";

                window.location.replace(url);
            }
        }
    });
}

function wplogoutonly() {

    jQuery.ajax({
        url: root + 'rangoli/mage_wp_login.php',
        type: 'POST',
        data: 'logout=1',
        dataType: 'json',
        success: function (result) {
        }
    });
}

function checkIsUserLogged() {

    jQuery.ajax({
        url: root + 'ys/session/loggedcustomer',
        type: 'GET',
        dataType: 'json',
        success: function (result) {

            if (result.message != null && result.message != undefined) {

                if (result.message == "notlogged") {
                    jQuery(".login_logout_link").html("<a id='signin' href='javascript:void(0);'>Sign In</a>");
                    wplogoutonly();
                }
                else if (result.message == "logged") {

                    var name = result.first_name;

                    jQuery("#welcome-name").html("Hi " + name).attr("href", homeUrl + 'customer/account/');
                    jQuery(".login_logout_link").html("<span style='cursor:pointer; margin-left:0;padding-left:0' onclick='wplogout()'>SIGN OUT</span>");

                    //jQuery("#signin").unbind('click');
                    //jQuery("#signin").html("SIGN OUT").attr({href:'javascript:void(0)',id:"sign-out", onclick: 'wplogout()'});
                    //jQuery("#welcome-name").html("Hi "+name).attr("href",homeUrl+'customer/account/');
                }
            }
        }
    });








}


function if_gender_is_selected(){
    if(jQuery(".gender_p span").hasClass("selected")){
        return true;
    }
    else{
        return false;
    }
}


/**************** logout logic added by ys team *****************/


