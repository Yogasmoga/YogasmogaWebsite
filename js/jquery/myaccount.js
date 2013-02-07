_usesecureurl = true;
jQuery(document).ready(function($){
    $("#login-form").submit(function(){
        return validateLoginForm();
        //alert($("#login-form").serialize());
        //console.log($("#login-form").serialize());
        //return false;
    });
    
    $("#forgot-password-form").submit(function(){
        return validateForgotPasswordForm();
    });
    
    $("#register-form").submit(function(){
        return validateRegistrationForm();
    });
    
    $("#wishlist-view-form").submit(function(){
        $(this).find("textarea").each(function(){
            if($(this).val() == "")
                $(this).val(' ');
        });
    });
    
    $("#form-share-wishlist").submit(function(){
        return validateWishlistForm();
    });
    
    $("#edit-accountinfo").submit(function(){
        return validateAccountEditForm();
    });
    $("#change_password").click(function(){
        togglePasswordChangeOption();
    });
    if($("#change_password").length > 0)
        togglePasswordChangeOption();
    if($("select#country").length > 0)
    {
        $("select#country").attr("class","").addClass('requiredfield').attr("defaulterrormsg","Country is required").removeAttr("title").css("width","156px");
        $("select#country").change(function(){
            fillState();
        });
        fillState(_curstate);
        //if(StateCollection.hasOwnProperty(currentstate))
//        {
//            jQuery("select#region_id").show();
//            jQuery("input#region").hide();
//        }
//        else
//        {
//            jQuery("select#region_id").hide();
//            jQuery("input#region").show();   
//        }
    }
    $("#address-form").submit(function(){
        return validateAddressForm();
    });
    
    $("#giftcardformmyaccount").submit(function(){
        return validateGiftCardForm();
    });
    $("div#addanotherreferral").click(function(){
        $("table.referfriendforms tbody#main").append("<tr>" + $("table.referfriendforms tr#template").html() + "</tr>");
        $("table.referfriendforms tbody#main td.remove").show();
        //console.log('adf');
    });
    
    $("table.referfriendforms td.remove img").live('click', function(){
        if($(this).parents("table:first").find("tbody#main>tr").length > 2)
        {
            $(this).parents("tr:first").remove();
            if($(this).parents("table:first").find("tbody#main>tr").length <= 2)
                console.log($(this).parents("table:first").attr("id"));
        }   
    });
});

function validateGiftCardForm()
{
    unsetAllError(jQuery("#giftcardformmyaccount"));
    var flag = validatefields(jQuery("#giftcardformmyaccount"));
    return flag;
}

function validateWishlistForm()
{
    unsetAllError(jQuery("#form-share-wishlist"));
    var flag = validatefields(jQuery("#form-share-wishlist"));
    if(jQuery("#email_address").val() != "")
    {
        var valid_regexp = /^[a-z0-9\._-]{1,30}@([a-z0-9_-]{1,30}\.){1,5}[a-z]{2,4}$/i;
        var emails = jQuery("#email_address").val().split(',');
        for (var i=0; i<emails.length; i++) {
            if(!valid_regexp.test(emails[i].strip())) {
                flag = false;
                setOnError(jQuery("#email_address"), "Please enter valid email addresses, separated by commas");
                break;    
            }
        }
    }
    return flag;
}

function validateAddressForm()
{
    unsetAllError(jQuery("#address-form"));
    var flag = validatefields(jQuery("#address-form"));
    if(jQuery("zip").val() != "")
    {
        if(!validateZip(jQuery("zip").val()))
        {
            flag = false;
            setOnError(jQuery("zip"), "Invalid Zip Code.");
        }
    }
    return flag;
}

function fillState(currentstate)
{
    currentstate = (typeof currentstate === "undefined") ? "" : currentstate;
    //console.log(StateCollection['US']);
//    return;
//    for(var key in StateCollection)
//    {
//        if(key == jQuery("select#country").val())
//        {
//            console.log(key);
//            for(var key1 in key)
//            {
//                //console.log(key1);
//            }        
//        }
//    }
//    return;
    //console.log(currentstate);
    if(StateCollection.hasOwnProperty(jQuery("select#country").val()))
    {
        //console.log(StateCollection[currentstate]);
        var html = "<option value=''>Please select region, state or province</option>";
        for(var key in StateCollection[jQuery("select#country").val()])
        {
            html += "<option value='" + key + "' title='" + StateCollection[jQuery("select#country").val()][key].code + "'>" + StateCollection[jQuery("select#country").val()][key].name + "</option>";
            //console.log(key);
//            console.log(StateCollection[jQuery("select#country").val()][key].code);
//            console.log(StateCollection[jQuery("select#country").val()][key].name);
        }
        jQuery("select#region_id").html(html).show().addClass('requiredfield');
        jQuery("input#region").hide().removeClass('requiredfield');
        jQuery("select#region_id").val(currentstate);
    }
    else
    {
        jQuery("select#region_id").hide().removeClass('requiredfield');
        jQuery("input#region").show().addClass('requiredfield');
    }
    jQuery("select#region_id option[value='']").html("Select State");
}

function validateAccountEditForm()
{
    unsetAllError(jQuery("#edit-accountinfo"));
    var flag = validatefields(jQuery("#edit-accountinfo"));
    if(jQuery("#password").val() != "" && jQuery("#confirmation").val() != "")
    {
        if(jQuery("#password").val() != jQuery("#confirmation").val())
        {
            setOnError(jQuery("#confirmation"),"Please make sure your passwords match.");
            flag = false;
        }
    }
    if(jQuery("#email").val() != "")
    {
        if(!validateEmail(jQuery("#email").val()))
        {
            setOnError(jQuery("#email"), "Please enter a valid Email Address.");
            flag = false;    
        }
    }
    return flag;
}

function togglePasswordChangeOption()
{
    if(jQuery("#change_password").is(':checked'))
    {
        jQuery("#passwordchangeoptions").slideDown('fast');
        jQuery("#passwordchangeoptions input").addClass('requiredfield');
    }
    else
    {
        jQuery("#passwordchangeoptions").slideUp('fast');
        jQuery("#passwordchangeoptions input").removeClass('requiredfield');
    }
}

function validateRegistrationForm()
{
    unsetAllError(jQuery("#register-form"));
    var flag = validatefields(jQuery("#register-form"));
    if(jQuery("#password").val() != "")
    {
        if(jQuery.trim(jQuery("#password").val()).length < 6)
        {
            setOnError(jQuery("#password"),"Please enter 6 or more characters.");
            flag = false;
        }
    }
    if(jQuery("#password").val() != "" && jQuery("#confirmation").val() != "")
    {
        if(jQuery("#password").val() != jQuery("#confirmation").val())
        {
            setOnError(jQuery("#confirmation"),"Please make sure your passwords match.");
            flag = false;
        }
    }
    if(jQuery("#email_address").val() != "")
    {
        if(!validateEmail(jQuery("#email_address").val()))
        {
            setOnError(jQuery("#email_address"), "Please enter a valid Email Address.");
            flag = false;    
        }
    }
    return flag;
}


function validateLoginForm()
{
    unsetAllError(jQuery("#login-form"));
    var flag = true;
    if(jQuery("#email").val() == "")
    {
        setOnError(jQuery("#email"),"Email Address is required");
        flag = false;
    }
    else
    {
        if(!validateEmail(jQuery("#email").val()))
        {
            setOnError(jQuery("#email"),"Invalid Email Address");
            flag = false;    
        }
    }
    if(jQuery("#pass").val() == "")
    {
        setOnError(jQuery("#pass"), "Password is required");
        flag = false;
    }
    return flag;
}

function validateForgotPasswordForm()
{
    unsetAllError(jQuery("#forgot-password-form"));
    var flag = true;
    if(jQuery("#email_address").val() == "")
    {
        setOnError(jQuery("#email_address"), "Email Address is required");
        flag = false;
    }
    else
    {
        if(!validateEmail(jQuery("#email_address").val()))
        {
            setOnError(jQuery("#email_address"),"Invalid Email Address");
            flag = false;    
        }
    }
    return flag;
}