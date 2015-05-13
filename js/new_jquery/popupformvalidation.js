function popupGetSigningCreateaccountFormFieldsvalue(formid)
{
    var fname = jQuery.trim(jQuery("#fname").val());
    var lname = jQuery.trim(jQuery("#lname").val());
    var email_id = jQuery.trim(jQuery("#signup_email").val());
    var pwd = jQuery.trim(jQuery("#s_password").val());
    var cpassword = pwd;
    return popupformvalidation(fname,lname,email_id,pwd,formid);
}
function popupGetSigningLoginFormFieldsvalue(formid)
{
    var fname = "test";
    var lname = "test";
    var email_id = jQuery.trim(jQuery("#si_email").val());
    var pwd = jQuery.trim(jQuery("#si_password").val());

    return popupformvalidation(fname,lname,email_id,pwd,formid);
}
function popGetSigningLoginFormFieldsvalue(formid)
{
    var fname = "test";
    var lname = "test";
    var email_id = jQuery.trim(jQuery("#sb_email").val());
    var pwd = jQuery.trim(jQuery("#sb_password").val());

    return popupformvalidation(fname,lname,email_id,pwd,formid);
}
function sharewithfriendformvalidation(formid)
{
    var fname = jQuery.trim(jQuery("#friendname").val());

    var email_id = jQuery.trim(jQuery("#friendemail").val());
    if(fname == "" || fname == "Friend's Name")
    {

        jQuery(formid).find(".err-msg").css("visibility","visible");
        jQuery(formid).find(".err-msg").text("All fields are required.");

        return "error";
    }
    if(email_id == "" || email_id == "Friend's Email")
    {

        jQuery(formid).find(".err-msg").css("visibility","visible");
        jQuery(formid).find(".err-msg").text("All fields are required.");
        return "error";
    }
    if(email_id != "")
    {
        if(!validateEmail(email_id))
        {

            jQuery(formid).find(".err-msg").css("visibility","visible");
            jQuery(formid).find(".err-msg").text("Enter valid email address.");
            return "error";
        }
    }


    return "success" ;
}

function popupformvalidation(fname,lname,email_id,pwd,formid)
{

    if(fname == "" || fname == "First Name")
    {

        jQuery(formid).find(".err-msg").css("visibility","visible");
        jQuery(formid).find(".err-msg").text("All fields are required.");
        //jQuery(".err-msg").css("visibility","visible");
        //jQuery(".err-msg").text("All fields are required.");
        // jQuery("#pfirstname").focus();
        return "error";
    }
    if(lname == "" || lname == "Last Name")
    {

        jQuery(formid).find(".err-msg").css("visibility","visible");
        jQuery(formid).find(".err-msg").text("All fields are required.");
        // jQuery("#plastname").focus();
        return "error";
    }
    if(email_id == "" || email_id == "Email Address" || email_id == "Enter your email")
    {

        jQuery(formid).find(".err-msg").css("visibility","visible");
        jQuery(formid).find(".err-msg").text("All fields are required.");
        // jQuery("#pemail_address").focus();
        return "error";
    }
    if(email_id != "")
    {
        if(!validateEmail(email_id))
        {

            jQuery(formid).find(".err-msg").css("visibility","visible");
            jQuery(formid).find(".err-msg").text("Enter valid email address.");
            // jQuery("#pemail_address").focus();
            return "error";
        }
    }
    if(pwd == "" || pwd == "Select a password" || pwd == "Enter your password")
    {

        jQuery(formid).find(".err-msg").css("visibility","visible");
        jQuery(formid).find(".err-msg").text("All fields are required.");
        // jQuery("#p_password").focus();
        return "error";
    }

    var str = pwd;

    if(str.length < 6 )
    {

        jQuery(formid).find(".err-msg").css("visibility","visible");
        jQuery(formid).find(".err-msg").text("Password requires 6 or more characters.");

        return "error";
    }
    else
        return "correct";
}