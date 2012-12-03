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
});

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