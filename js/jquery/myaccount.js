jQuery(document).ready(function($){
    $("#login-form").submit(function(){
        return validateLoginForm();
    });
    
    $("#forgot-password-form").submit(function(){
        return validateForgotPasswordForm();
    });
    
    $("#register-form").submit(function(){
        return validateRegistrationForm();
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
});

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
    console.log(currentstate);
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

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validateZip(zip) { 
    var re = /(^[A-z0-9]{2,10}([\s]{0,1}|[\-]{0,1})[A-z0-9]{2,10}$)/;
    return re.test(zip);
}