$(document).ready(function () {
    $(".login_magento").keydown(function(e){
        if(e.keyCode==13){
            $("#sign-in-button").click();
        }
    });

    $(".register_new").keydown(function(e){
        if(e.keyCode==13){
            $("#sign-up-button").click();
        }
    });
    $("input[rel='password']").focus(function () {
        $(this).attr("type", "password");
    });
    $("input[rel='password']").blur(function () {
        if ($(this).val().length == 0)
            $(this).attr("type", "text");
        else {
            $(this).attr("type", "password");
        }
    });

    $(":input[data-watermark]").each(function () {
        $(this).val($(this).attr("data-watermark"));
        $(this).bind('focus', function () {
            if ($(this).val() == $(this).attr("data-watermark")) $(this).val('');
        });
        $(this).bind('blur', function () {
            if ($(this).val() == '') $(this).val($(this).attr("data-watermark"));
        });
    });
    $("#signup").click(function () {

        /************************************SIGN UP FUNCTION GOES HERE*******************************/
        createCustomerAccount_from_popup();
        /********************************************************************************************/
    });

});




function createCustomerAccount_from_popup() {
    var error = "";
    var fname = jQuery.trim(jQuery("#fname").val());
    var lname = jQuery.trim(jQuery("#lname").val());
    var email_id = jQuery.trim(jQuery("#email").val());
    var pwd = jQuery.trim(jQuery("#password").val());

    if (fname!="First Name" && lname!="Last Name" && email_id!="Email" && fname.length > 0 && lname.length > 0 && email_id.length > 0) {
        function IsEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }
        if(IsEmail(email_id)){
            if (pwd!="Select password" && pwd.length < 6 ) {
                error = "Password should be atleast 6 characters.";
            }
            else {
                var cpassword = pwd;
                var url = homeUrl + 'mycatalog/myproduct/registercustomer';

                jQuery.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        'firstname': fname,
                        'lastname': lname,
                        'email': email_id,
                        'password': pwd,
                        'confirmation': cpassword,
                        'is_subscribed': "on"
                    },
                    beforeSend: function () {
                        jQuery(".registration_form .err-msg").html("");
                        //jQuery("#signup").val("Signing up...");

                    },
                    success: function (data) {

                        data = eval('(' + data + ')');
                        var status = data.status;
                        if (status == "success") {
                            var name = data.fname;

                            var first_name = data.first_name;
                            var last_name = data.last_name;
                            var customer_id = data.customer_id;

                            createRangoliUser(email_id, pwd, first_name, last_name, customer_id);

                            jQuery(".signin-block").fadeOut();

                        }
                        else {
                            jQuery("#signup").css("Sign up");
                            if(data.errors =="Already Logged In"){
                                $(".signup_form").hide();
                                $(".confirmation_message").slideDown();
                            }
                            else
                            jQuery(".registration_form .err-msg").html(data.errors).css("visibility", "visible");
                        }
                    }
                });

            }
        }
        else{
            error = "Enter valid email address.";
        }

    }
    else {
        error = "All fields are required.";
    }
    if(error!=""){

        $(".err-msg").html(error);
    }

}


function createRangoliUser(email, password, first_name, last_name, customer_id) {

    var data = 'email=' + email + '&password=' + password + '&first_name=' + first_name + '&last_name=' + last_name + '&customer_id=' + customer_id;

    jQuery.ajax({
        url: root + 'rangoli/mage_wp_create_user.php',
        data: data,
        type: 'POST',
        success: function (r) {
            if(r.message=="success"){
                $(".signup_form").hide();
                $(".confirmation_message").slideDown();
            }
        }
    });
}