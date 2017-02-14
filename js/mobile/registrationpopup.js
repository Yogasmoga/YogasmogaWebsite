jQuery.noConflict();


//var root='http://staging.yogasmoga.com/';
//var root='http://ysstaging.com.local/';

/**************** logout logic added by ys team *****************/
jQuery(document).ready(function(jQuery){

    forgot_password();
    checkIsUserLogged();


    if(window.location.href.indexOf("refer-a-friend") > -1) {
            if(!_islogedinuser){
                openLogin();
            }
}

    jQuery(".sign_signup_form input").on("keyup",function(){
        isinputvalid();
    });
    jQuery("#ajaxlogin_form input").on("keyup",function(){
        isloginvalid();
    });
    jQuery("#ajaxlogin_close_icon").click(function(){
        jQuery("#ajaxlogin_button_send").removeClass("active");
    });
    /***login form for smogi buck page***/
    /******************Smogi Bucks Login For Mobile Page Start **********/
    jQuery("#sb-sign-in-form").submit(function(event){

        var status = checkSmogiLoginForm();
        if(status != "error")
            loginSmogiPage();
    });
    jQuery("#sign-in-form").on("click","#sign-in-button", function(){
        var errMsgCont = jQuery("#sign-in-form").find("p.err-msg");
        if(errMsgCont.css("visibility") == "visible")
        {
            errMsgCont.css("visibility","hidden");
        }
    });
	
	
	
	
	
});

function loginSmogiPage() {

    var email_id = jQuery.trim(jQuery("#sb_email").val());
    var pwd = jQuery.trim(jQuery("#sb_password").val());

    if (window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mycatalog/myproduct/logincustomer';
    if (_usesecureurl) {
        url = securehomeUrl + 'mycatalog/myproduct/logincustomer';
        homeUrl = securehomeUrl;
    }
    jQuery.ajax({

        url: url,
        type: 'POST',
        data: {'email': email_id, 'pwd': pwd},
        beforeSend: function () {
            jQuery("#sb-sign-in-form .form-loader").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='width:16px;' />");
            jQuery("#sb-sign-in-button").parent().hide();
            jQuery("#sb-sign-in-form .form-loader").show();
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

                /************** code update by ys team ******************/
                    //doWordpressLogin(email_id, pwd, name);
                doWordpressLogin(email_id, pwd, first_name, last_name, customer_id);
                /************** code update by ys team ******************/

            }
            else {
                _smogiPageLogin = false;
                jQuery("#sb-sign-in-form .err-msg").html(data.errors).css("visibility", "visible");
                jQuery(".signin-loader").html("");
                jQuery("#sb-sign-in-button").parent().show();
                jQuery("#sb-sign-in-form .form-loader").hide();
            }
        }

    });
}

function checkSmogiLoginForm(){

    var email_id = jQuery.trim(jQuery("#sb_email").val());
    var pwd = jQuery.trim(jQuery("#sb_password").val());
    jQuery("#smogi_message").html('');
    if(email_id.length==0){
        jQuery("#smogi_message").html('Please enter email.');
        return "error";

    }


    if(!validateSmogiEmail(email_id)){


        jQuery("#smogi_message").html('Please enter valid email.');
        return "error";
    }

    if(pwd.length<6){
        jQuery("#smogi_message").html('Please enter min six charachter.');
        return error;
    }

    return "correct";
}

function validateSmogiEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

/******************Smogi Bucks Login For Mobile Finished **********/

function init_watermark(){
    jQuery(".watermark_password_orignal").hide();
    jQuery(".watermark_password").show();
    jQuery(".watermark_password").focus(function () {
        jQuery(this).hide();
        jQuery(".watermark_password_orignal").show();
        jQuery(".watermark_password_orignal").focus();
    });
    jQuery(".watermark_password_orignal").blur(function(){
        var value = jQuery(this).val();
        if(value=="" && value.length==0) {
            jQuery(".watermark_password_orignal").hide();
            jQuery(".watermark_password").show();
        }
    });

    jQuery(":input[data-watermark]").each(function () {
        jQuery(this).val(jQuery(this).attr("data-watermark"));
        jQuery(this).bind('focus', function () {
            if (jQuery(this).val() == jQuery(this).attr("data-watermark")) jQuery(this).val('');
        });
        jQuery(this).bind('blur', function () {
            if (jQuery(this).val() == '') jQuery(this).val(jQuery(this).attr("data-watermark"));
        });
    });
}
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};

function isinputvalid(){
    var fname = jQuery.trim(jQuery(".singup_form input[name='fname']").val());
    var lname = jQuery.trim(jQuery(".singup_form input[name='lname']").val());
    var email_id = jQuery.trim(jQuery(".singup_form input[name='email']").val());
    var pwd = jQuery.trim(jQuery(".singup_form input[name='password']").val());
    var gender_link = jQuery(".gender-link");
    var gender = jQuery(".f-right .current input").val();
    //jQuery("create_account").removeClass("active");
    if(fname=="" || fname=="First Name"){
        jQuery("#create_account").removeClass("active");
    }
    else if(lname=="" || lname=="Last Name"){
        jQuery("#create_account").removeClass("active");
    }
    else if(email_id=="" || email_id=="Email"){
        jQuery("#create_account").removeClass("active");
    }
    /*else if(!isValidEmailAddress(email_id)){
        jQuery("#create_account").removeClass("active");
    }*/
    else if(pwd==""){
        jQuery("#create_account").removeClass("active");
    }
    /*else if(pwd.length<6){
        jQuery("#create_account").removeClass("active");
    }*/
    else if(!gender_link.find(".f1").hasClass("current") && !gender_link.find(".f2").hasClass("current")){
        jQuery("#create_account").removeClass("active");
    }
    else{
        jQuery("#error_msg").html("");
        jQuery("#create_account").addClass("active");
    }
}



function createCustomerAccount() {
    var fname = jQuery.trim(jQuery(".singup_form input[name='fname']").val());
    var lname = jQuery.trim(jQuery(".singup_form input[name='lname']").val());
    var email_id = jQuery.trim(jQuery(".singup_form input[name='email']").val());
    var pwd = jQuery.trim(jQuery(".singup_form input[name='password']").val());
    var location_city = jQuery.trim(jQuery("#location_city").val());
    var location_state = jQuery.trim(jQuery("#location_state").val());
    var location_zip = jQuery.trim(jQuery("#location_zip").val());

    var cpassword = pwd;
    var url = homeUrl + 'mycatalog/myproduct/registercustomer';
    var button_html = jQuery(".create_account").html();
    var gender_link = jQuery(".gender-link");
    var gender = jQuery(".f-right .current input").val();
    //alert(gender);
    if(fname=="" || fname=="First Name"){
        jQuery("#error_msg").html("Please fill in your first name");
    }
    else if(lname=="" || lname=="Last Name"){
        jQuery("#error_msg").html("Please fill in your Last Name");
    }
    else if(email_id=="" || email_id=="Email"){
        jQuery("#error_msg").html("Please fill in your Email ID");
    }
    else if(!isValidEmailAddress(email_id)){
        jQuery("#error_msg").html("Please enter a valid Email ID");
    }
    else if(pwd==""){
        jQuery("#error_msg").html("Please choose a password");
    }
    else if(pwd.length<6){
        jQuery("#error_msg").html("Password should be of 6 characters");
    }

    else if(!gender_link.find(".f1").hasClass("current") && !gender_link.find(".f2").hasClass("current")){
        jQuery("#error_msg").html("Select Gender");
    }

    else{
        jQuery.ajax({
            url: url,
            type: 'POST',
            data: {
                'firstname': fname,
                'lastname': lname,
                'email': email_id,
                'password': pwd,
                'confirmation': cpassword,
                'is_subscribed': "on",
                'gender' : gender,
                'location_city':location_city,
                'location_state':location_state,
                'location_zip':location_zip
            },
            beforeSend: function () {
                jQuery(".create_account").html("signing up...");
                jQuery(".err_msg").html("");
            },
            success: function (data) {
                data = eval('(' + data + ')');
                var status = data.status;
                var name = data.fname;

                var first_name = data.first_name;
                var last_name = data.last_name;
                var customer_id = data.customer_id;
                jQuery("#sign-up-form .err-msg").html("");
                if (status == "success") {
                    createRangoliUser(email_id, pwd, first_name, last_name, customer_id);
                    _islogedinuser = true;
					if(_islogedinuser){
						//closeSignup();
						//jQuery("#invite_friends").show();
					}
                    //For refer a friend link redirection.
                    if(window.location.href.indexOf("refer-a-friend") > -1) {
                        window.location.assign(homeUrl + 'rewardpoints/index/referral');
                    }
                    else{
                        location.reload(true) ;
                    }
                }
                else {
                    jQuery("#error_msg").html("Email already exists");
                    jQuery(".create_account").html(button_html);

                    return false;
                }
            }
        });
    }

}

function createRangoliUser(email, password, first_name, last_name, customer_id) {

    var data = 'email=' + email + '&password=' + password + '&first_name=' + first_name + '&last_name=' + last_name + '&customer_id=' + customer_id;

    jQuery.ajax({
        url: homeUrl + 'rangoli/mage_wp_create_user.php',
        data: data,
        type: 'POST',
        success: function (r) {
            // getloggedinuser();
        }
    });
}



/**************** ys team functions *****************/
function forgotCustomer() {
    jQuery('#err_pass').html("");
    var email_id = jQuery.trim(jQuery(".login_form input[name='email']").val());

    if(email_id=="" || email_id=="Email"){
        jQuery('#err_pass').html('Please fill your email id');
        //alert(email_id);err_pass
        return false;
    }
    else if(!isValidEmailAddress(email_id)){
        jQuery('#err_pass').html('Please fill your email id');
        return false;
    }
    else {
        jQuery.ajax({
            url: homeUrl + '/profile/manage/sendpassword?email='+email_id,
            success: function (result) {
                jQuery('#err_pass').html(result);
            }
        });
        //jQuery("form").submit();
        return false; }

}

function isloginvalid(){
    var email_id = jQuery.trim(jQuery(".login_form input[name='email']").val());
    var pwd = jQuery.trim(jQuery(".login_form input[name='password']").val());
    //var url = homeUrl + 'mycatalog/myproduct/logincustomer';
    var button_html = jQuery(".login_customer").html();
    jQuery("#ajaxlogin_button_send").removeClass("active");
    if(email_id=="" || email_id=="Email"){
        jQuery("#ajaxlogin_button_send").removeClass("active");
    }
    /*else if(!isValidEmailAddress(email_id)){
        jQuery("#ajaxlogin_button_send").removeClass("active");
    }*/
    else if(pwd==""){
        jQuery("#ajaxlogin_button_send").removeClass("active");
    }
    else{
        jQuery("#err_msg").html("");
        jQuery("#ajaxlogin_button_send").addClass("active");
    }
}
function loginCustomer() {
    if (window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mycatalog/myproduct/logincustomer';
    if (_usesecureurl) {
        url = securehomeUrl + 'mycatalog/myproduct/logincustomer';
        homeUrl = securehomeUrl;
    }

    var email_id = jQuery.trim(jQuery(".login_form input[name='email']").val());
    var pwd = jQuery.trim(jQuery(".login_form input[name='password']").val());
    //var url = homeUrl + 'mycatalog/myproduct/logincustomer';
    var button_html = jQuery(".login_customer").html();

    if(email_id=="" || email_id=="Email"){
        jQuery("#err_msg").html("Please fill in your email id");
    }
    else if(!isValidEmailAddress(email_id)){
        jQuery("#err_msg").html("Invalid Email or Password");
    }
    else if(pwd=="" || pwd=="Last Name"){
        jQuery("#err_msg").html("Please enter your password");
    }
    else {
        jQuery.ajax({
            url: url,
            type: 'POST',
            data: {'email': email_id, 'pwd': pwd},
            beforeSend: function () {
                jQuery(".login_customer").html("Signing in...");
                jQuery("#err_msg").html("");
            },
            success: function (data) {

                data = eval('(' + data + ')');
                var status = data.status;
                var error = data.error;
                var name = data.fname;
                var somgiBal = data.smogi;
                var first_name = data.first_name;
                var last_name = data.last_name;
                var customer_id = data.customer_id;
                //var pwd = data.password;

                if (status == "success") {
                    /************** code update by ys team ******************/
                    doWordpressLogin(email_id, pwd, first_name, last_name, customer_id);
                    /************** code update by ys team ******************/
                    _islogedinuser = true;
					if(_islogedinuser){
						
						AjaxLoginForm.hideLoginContainer();
						
						location.reload(true);
						//jQuery("#invite_friends").show();
					}
					
                    if(window.location.href.indexOf("refer-a-friend") > -1) {
                        window.location.assign(homeUrl + 'rewardpoints/index/referral');
                    }

                }
                else {

                    jQuery(".login_customer").html('<span class="tick-mark"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 44 44" style="enable-background:new 0 0 44 44;" xml:space="preserve"><style type="text/css">.st0{fill:none;stroke:#FFFFFF;stroke-miterlimit:10;}</style><polyline class="st0" points="5.9,25.6 14.6,34.3 39.1,9.8 "/></svg></span>');
                    //alert(data.errors);
                    //jQuery("#err_msg").html(data.errors);
                    jQuery('#err_msg').html('Invalid Email or Password');
                }
            }

        });
    }
}


function doWordpressLogin(email, password, first_name, last_name, customer_id) {

    // now login to wordpress
    jQuery.ajax({
        url: homeUrl + 'rangoli/mage_wp_login.php',
        type: 'POST',
        data: 'user_login=' + email + '&password=' + password + '&first_name=' + first_name + '&last_name=' + last_name + '&customer_id=' + customer_id,
        dataType: 'json',
        success: function (result) {
            //alert(result.message + " , " + (result.message=="success"));
            if (result != undefined && result.message != undefined && result.message == "success") {
                //alert('hi');
                //console.log("******* cannot login to Rangoli");
                //For refer a friend redirection.
                if(window.location.href.indexOf("refer-a-friend") > -1) {
                }
                else{
                    location.reload(true);
                }
            }
        }
    });
}

/**************** logout logic added by ys team *****************/
function wplogout() {

    jQuery.ajax({
        url: homeUrl + 'rangoli/mage_wp_login.php',
        type: 'POST',
        data: 'logout=1',
        dataType: 'json',
        success: function (result) {

            if (result.message == "loggedout") {
                var url = homeUrl + "customer/account/logout/";

                window.location.replace(url);
            }
            else if (result.message == "alreadyloggedout") {
                var url = homeUrl + "customer/account/logout/";

                window.location.replace(url);
            }
        }
    });
}

function wplogoutonly() {

    jQuery.ajax({
        url: homeUrl + 'rangoli/mage_wp_login.php',
        type: 'POST',
        data: 'logout=1',
        dataType: 'json',
        success: function (result) {
        }
    });
}

function checkIsUserLogged() {

    if (window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'ys/session/loggedcustomer';
    if (_usesecureurl) {
        url = securehomeUrl + 'ys/session/loggedcustomer';
        homeUrl = securehomeUrl;
    }
    jQuery.ajax({
        url: homeUrl + 'ys/session/loggedcustomer',
        type: 'GET',
        dataType: 'json',
        success: function (result) {

            if (result.message != null && result.message != undefined) {

                if (result.message == "notlogged") {
                    jQuery(".login_logout_link").html("<a id='signin' href='javascript:void(0);'>Sign In</a>");
                    wplogoutonly();
                }
                else if (result.message == "logged") {

                    //alert('ravi123');

                    jQuery(".smogi-form").hide();

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
/**************** logout logic added by ys team *****************/


/**************** ys team functions *****************/

function forgot_password(){
    jQuery(".form_field_left  input").keyup(function(){
        if(jQuery(this).val()!=="" && jQuery(this).val()!=="Email"){
            jQuery(".ajaxlogin_forgot_pwd_actions").addClass("active");
        }
        else{
            jQuery(".ajaxlogin_forgot_pwd_actions").removeClass("active");
        }
    });
}