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
            jQuery("#sign-up-form .form-loader").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/loading1.gif' style='width:40px;' />");
            jQuery("#sign-up-button").parent().hide();
            jQuery("#sign-up-form .form-loader").show();
        },
        success :   function(data){

            data = eval('('+data + ')');
            var status = data.status;
            if(status == "success")
            {
                // console.log(data.status);
                jQuery(".signing_popup_wrapper").addClass("no-display");
                jQuery(".thank-you-block").removeClass("no-display");
                _islogedinuser = true;
                jQuery("#signin").html("SIGN OUT").attr({href:homeUrl+'customer/account/logout/',id:"sign-out"});
                setTimeout(function(){
                    jQuery("#signing_popup").dialog("close");                    
                },2000);

    console.log("success");
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
            jQuery("#sign-in-form .form-loader").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/loading1.gif' style='width:40px;' />");
            jQuery("#sign-in-button").parent().hide();
            jQuery("#sign-in-form .form-loader").show();
        },
        success :   function(data){

            data = eval('('+data + ')');
            var status = data.status;
            var error = data.error;

            if(status == "success")
            {
                jQuery("#signin").html("SIGN OUT").attr({href:homeUrl+'customer/account/logout/',id:"sign-out"});
                jQuery("#signing_popup").dialog( "close" );
                jQuery(".signin-loader").html("");
                _islogedinuser = true;
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