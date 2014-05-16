jQuery(document).ready(function($){

    $("#sign-up-form").submit(function(event){

        var formid = "#sign-up-form";
        var status = popupGetSigningCreateaccountFormFieldsvalue(formid);
        if(status != "error")
            createCustomerAccount();
        event.preventDefault();
    });
    $("#sign-in-form").submit(function(event){

        var formid = "#sign-in-form";
        var status = popupGetSigningLoginFormFieldsvalue(formid);
        if(status != "error")
            loginCustomer();
        event.preventDefault();
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
            jQuery("#sign-up-form").css("background-image","url(<?php echo $this->getUrl()?>skin/frontend/new-yogasmoga/yogasmoga-theme/images/signing_up.png)");
            jQuery(".signup-loader").html("<img class='cms-loader' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/loading1.gif' />");
        },
        success :   function(data){

            data = eval('('+data + ')');
            if(status == "success")
            {
                alert(data.status);
            }
            else
            {
                alert(data.errors);
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
            jQuery("#sign-up-form").css("background-image","url(<?php echo $this->getUrl()?>skin/frontend/new-yogasmoga/yogasmoga-theme/images/signing_up.png)");
            jQuery(".signin-loader").html("<img class='cms-loader' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/loading1.gif' />");
        },
        success :   function(data){

            data = eval('('+data + ')');
            var status = data.status;
            var error = data.error;

            if(status == "success")
            {
                alert(data.status);
            }
            else
            {
                jQuery("#sign-in-form .err-msg").html(data.errors);
                jQuery("#sign-in-form .err-msg").css("visibility","visible");
                jQuery(".signin-loader").html("");
            }
        }

    });
}