var count = 0;
var status = "old";
var is_red_popup_open = false;
var wh = $(window).height();
var logged_in=false;
var logged_in_id;
var user_email;
var current_user_img_url;
var template_directory;
var root = homeUrl;
var post_id;
var smogi_balance;
var email;
var current_date = today_date;
var date = new Date();
var s = date.getSeconds();
var playing_video = false;
var is_login_box_open = false;
$(document).ready(function () {

    $(".menu-heading1").hover(function () {
        $(".first-list").addClass("inner-links1");
    }, function () {
        $(".first-list").removeClass("inner-links1");
        $(".first-list").removeClass("inner-links1");
    });

    $(".menu-heading2").hover(function () {
        $(".second-list").addClass("inner-links2");
    }, function () {
        $(".second-list").removeClass("inner-links2");
    });


});

$(window).load(function(){
    if(logged_in==false) {
	
        $.ajax({
            url: root+'rangoli/checkfornewcustomer.php',
            dataType: 'json',
            success: function(response){
                var  customer = response.customer;
                var  bullseye = response.bullseye;
                if(customer == "new"){
                    $(".your-color-block").fadeOut();
                    $(".login-box").fadeOut();
					//alert(redpopup_timing);
                    if(true == rangoli_press_type){
					$("#signin_popup").delay(7000).fadeIn();
					//alert();
					}
					else{
					$("#signin_popup").fadeIn();
					}					
                    $(".signin-block").fadeIn();
                    is_login_box_open = false
                }
                if(bullseye =="open"){
                    setTimeout(function(){
                        if(is_login_box_open == false) {
                            open_bulls_popup();
                        }
                    },60000);
                }
            }
        });
    }

});

$('document').ready(function () {
    submit_comment();
    jQuery("#signup").css("background","url('"+root+"/skin/frontend/yogasmoga/yogasmoga-theme/images/sign-up-btn.png')");
});

function submit_comment() {
    current_user_img_url = $("span[rel='current_user_img_url']").html();
    logged_in = $("span[rel='logged-in-user']").html();
    template_directory = $("span[rel='template_directory']").html();
    post_id = $("span[rel='post_id']").html();
    var commentform = $('#commentform'); // find the comment form
    commentform.prepend('<div id="comment-status" ></div>'); // add info panel before the form to provide feedback or errors
    var statusdiv = $('#comment-status'); // define the infopanel

    commentform.submit(function () {
        if (logged_in != null && logged_in != '' && logged_in != undefined) {
            //serialize and store form data in a variable
            var formdata = commentform.serialize();
            //Add a status message
            statusdiv.html('<p><img src="/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif" style="width:16px;" /></p>');
            //Extract action URL from commentform
            var formurl = commentform.attr('action');
            //Post Form with data
            $.ajax({
                type: 'post',
                url: formurl,
                data: formdata,
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    statusdiv.html('<p class="ajax-error" >You might have left one of the fields blank, or be posting too quickly</p>');
                },
                success: function (data, textStatus) {
                    if (data == "success" || textStatus == "success") {
                        if ($("#comment").val() == "") {
                            statusdiv.html('<p class="ajax-success" >Blank comment is not allowed !</p>');
                            get_bulls_eye();
                        }
                        else {

                            var img_div = '<div class="row"><div class="span2">';
                            img_div = img_div + '<div class="profile-img-small" style="background:' + " url('" + current_user_img_url + "'); background-size:100%;" + '"></div></div>';
                            var comment = '<div class="span9"><p class="comment_author">' + logged_in + '</p><p class="comment">' + ($("#comment").val()).replace("\n", "<br/>") + '</p> </div>';
                            var date = '<div class="span1"><p class="comment_time">' + current_date + '</p></div></div>';
                            statusdiv.html('<p class="ajax-success" ><!--Thanks for your comment. We appreciate your response.--></p>');
                            $("#post_comments_listing").prepend(img_div + comment + date);
                        }
                        $("#comment").val('');
                    } else {
                        statusdiv.html('<p class="ajax-error" >Please wait a while before posting your next comment</p>');
                        $("#comment").val('');
                    }
                }
            });
        }
        else {
            //statusdiv.html('<p>You must be logged in to share a comment...</p>');

            $("#signin_popup").fadeIn();
            $(".signin-block").hide();
            $(".login-box").fadeIn();
            is_login_box_open = true;

        }
        return false;
    });
}

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
    $(".close_signin_popup").click(function () {
		$('.login-box').fadeOut();
        $("#signin_popup").fadeOut();
        $(".gender_p span").removeClass("selected");
    })
});


$(document).ready(function () {

    checkIsUserLogged();

    $("#sign-up-button").click(function () {
        createCustomerAccount();
    });

    $("#sign-in-button").click(function () {
        loginCustomer();
    });
    $(window).load(function(){
        $(".login_logout_link").click(function () {
            if ($(this).children("a").text() == "Sign In") {
                $(".signin-block").hide();
                $(".your-color-block").hide();
                $("#signin_popup").fadeIn();
                $(".login-box").fadeIn();
                is_login_box_open = true;
            }
            $(".bullseye_popup_container").fadeOut();
        })
    });
});


/* /////////////////////CREATE ACCOUNT FROM POPUP///////////////////////// */
function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

function createCustomerAccount_from_popup() {
    var error = "";
    var fname = jQuery.trim(jQuery("#p_fname").val());
    var lname = jQuery.trim(jQuery("#p_lname").val());
    var email_id = jQuery.trim(jQuery("#p_signup_email").val());
    var pwd = jQuery.trim(jQuery("#p_s_password").val());
    var gender = jQuery.trim(jQuery(".gender_p.gender_popup span.selected input").val());
    var location_city = jQuery.trim(jQuery("#p_location_city").val());
    var location_state = jQuery.trim(jQuery("#p_location_state").val());
    var location_zip = jQuery.trim(jQuery("#p_location_zip").val());

    if (fname!="First Name" && lname!="Last Name" && email_id!="Email Address" && fname.length > 0 && lname.length > 0 && email_id.length > 0) {
        if(IsEmail(email_id)){
            if (pwd=="Select a password" || pwd.length < 6 ) {
                error = "Password requires 6 or more characters.";
            }
            else if(!if_gender_is_selected()){
                error = "Please select a Gender.";
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
                        'is_subscribed': "on",
                        'gender' : gender,
                        'location_city':location_city,
                        'location_state':location_state,
                        'location_zip':location_zip
                    },
                    beforeSend: function () {
                        jQuery("#sign-up-form .err-msg").html("");
                        jQuery("#signup").val("Signing up...");

                    },
                    success: function (data) {

                        data = eval('(' + data + ')');
                        var status = data.status;
                        if (status == "success") {
                            var name = data.fname;

                            var first_name = data.first_name;
                            var last_name = data.last_name;
                            var customer_id = data.customer_id;


                            /**************** code added by ys team *****************/
                            createRangoliUser(email_id, pwd, first_name, last_name, customer_id);
                            /**************** code added by ys team *****************/

                                // console.log(data.status);
                            jQuery(".signin-block").fadeOut();
							jQuery("#signin_popup").fadeTo('',0);
                            //                          window.location=homeUrl+"rangoli";

                            _islogedinuser = true;
                            jQuery("#signin").html("SIGN OUT").attr({
                                href: homeUrl + 'customer/account/logout/',
                                id: "sign-out"
                            });

                            if (name != '') {
                                jQuery("#welcome-name").html("Hi " + name).attr("href", homeUrl + 'customer/account/');
                            }
                        }
                        else {
                            //jQuery("#sign-up-form .loader").hide();
                            jQuery("#signup").css("Sign up");
                            jQuery("#sign-up-form .err-msg").html(data.errors).css("visibility", "visible");
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


function createCustomerAccount() {
    var fname = jQuery.trim(jQuery("#fname").val());
    var lname = jQuery.trim(jQuery("#lname").val());
    var email_id = jQuery.trim(jQuery("#signup_email").val());
    var pwd = jQuery.trim(jQuery("#s_password").val());
    var cpassword = pwd;
    var gender = $(".gender_p span.selected input").val();
    var location_city = jQuery.trim(jQuery("#location_city").val());
    var location_state = jQuery.trim(jQuery("#location_state").val());
    var location_zip = jQuery.trim(jQuery("#location_zip").val());

    var url = homeUrl + 'mycatalog/myproduct/registercustomer';
    if (fname != "First Name" && lname != "Last Name" && pwd != undefined &&email_id != "" && email_id!="Email"&& pwd != undefined && pwd != "" && pwd!="Password") {
        if( !isValidEmailAddress(email_id)){

            jQuery(".err-msg.signup_err").html("Enter valid email address.").css("visibility", "visible");
        }
        else if(pwd=="Select a password"){
            jQuery(".err-msg.signup_err").html("All fields are required.").css("visibility", "visible");
        }
        else if(pwd.length<6){
            jQuery(".err-msg.signup_err").html("Password requires 6 or more characters.").css("visibility", "visible");
        }
        else if(!if_gender_is_selected()){
            jQuery(".err-msg.signup_err").html("Please select a Gender.").css("visibility", "visible");
        }
        else {
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
                    'gender':gender,
                    'location_city':location_city,
                    'location_state':location_state,
                    'location_zip':location_zip
                },
                beforeSend: function () {
                    jQuery("#sign-up-form .form-loader").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='width:16px;' />");
                    jQuery("#sign-up-button").parent().hide();
                    jQuery(".err-msg.signup_err").html("");
                    jQuery("#sign-up-form .form-loader").show();
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
                        /**************** code added by ys team *****************/
                        createRangoliUser(email_id, pwd, first_name, last_name, customer_id);
                        /**************** code added by ys team *****************/

                            // console.log(data.status);
                        jQuery(".login-box").fadeOut();
                        is_login_box_open = false;
                        //window.location=homeUrl+"rangoli";

                        _islogedinuser = true;
                        jQuery("#signin").html("SIGN OUT").attr({
                            href: homeUrl + 'customer/account/logout/',
                            id: "sign-out"
                        });

                        if (name != '') {
                            jQuery("#welcome-name").html("Hi " + name).attr("href", homeUrl + 'customer/account/');
                        }
                    }
                    else {
                        jQuery("#sign-up-button").parent().show();
                        jQuery("#sign-up-form .form-loader").hide();
                        jQuery(".err-msg.signup_err").html(data.errors).css("visibility", "visible");

                    }
                }
            });
        }
    }
    else{
        jQuery(".err-msg.signup_err").html("All fields are required.").css("visibility", "visible");
    }
}




function createRangoliUser(email, password, first_name, last_name, customer_id) {

    var data = 'email=' + email + '&password=' + password + '&first_name=' + first_name + '&last_name=' + last_name + '&customer_id=' + customer_id;

    jQuery.ajax({
        url: root + 'rangoli/mage_wp_create_user.php',
        data: data,
        type: 'POST',
        success: function (r) {
            getloggedinuser();
            //window.location=root+"rangoli/journey";
        }
    });
}

/**************** ys team functions *****************/

function loginCustomer() {

    var email_id = jQuery.trim(jQuery("#si_email").val());
    var pwd = jQuery.trim(jQuery("#si_password").val());
    //if (window.location.href.indexOf('https://') >= 0)
    //    _usesecureurl = true;
    //else
    //    _usesecureurl = false;
    var url = homeUrl + 'mycatalog/myproduct/logincustomer';
    //if (_usesecureurl)
    //    url = securehomeUrl + 'mycatalog/myproduct/logincustomer';
    jQuery("#sign-in-form .err-msg").html("").css("visibility", "visible");

    if (email_id != undefined && email_id != "" && email_id!="Email" && pwd != undefined && pwd != "" && pwd!="Password") {

        if( !isValidEmailAddress(email_id)){
            jQuery("#sign-in-form .form-loader").html("");
            jQuery("#sign-in-button").parent().show();
            jQuery("#sign-in-form .err-msg").html("Enter valid email address.   ").css("visibility", "visible");
            jQuery(".signin-loader").html("");
            jQuery("#sign-in-button").parent().show();
            jQuery("#sign-in-form .form-loader").hide();
        }
        else if(pwd.length<6){
            jQuery("#sign-in-form .err-msg").html("Password requires 6 or more characters.").css("visibility", "visible");
        }
        else {
            jQuery.ajax({

                url: url,
                type: 'POST',
                data: {'email': email_id, 'pwd': pwd},
                beforeSend: function () {
                    jQuery(".err-msg").html("");
                    jQuery("#sign-in-form .form-loader").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='width:16px;' />");
                    jQuery("#sign-in-button").parent().hide();
                    jQuery("#sign-in-form .form-loader").show();
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

                    }
                    else {

                        jQuery("#sign-in-form .form-loader").html("");
                        jQuery("#sign-in-button").parent().show();

                        //if (_smogiPageLogin) {
                        //    jQuery("#sb-sign-in-form .err-msg").html(data.errors).css("visibility", "visible");
                        //    jQuery(".signin-loader").html("");
                        //} else
                        {
                            jQuery("#sign-in-form .err-msg").html(data.errors).css("visibility", "visible");
                            jQuery(".signin-loader").html("");
                            jQuery("#sign-in-button").parent().show();
                            jQuery("#sign-in-form .form-loader").hide();
                        }
                    }
                }

            });
        }
    }
    else{
        jQuery("#sign-in-form .form-loader").html("");
        jQuery("#sign-in-button").parent().show();
        jQuery("#sign-in-form .err-msg").html("All fields are required.").css("visibility", "visible");
        jQuery(".signin-loader").html("");
        jQuery("#sign-in-button").parent().show();
        jQuery("#sign-in-form .form-loader").hide();

    }
}


function doWordpressLogin(email, password, first_name, last_name, customer_id) {

    // now login to wordpress
    jQuery.ajax({
        url: root + 'rangoli/mage_wp_login.php',
        type: 'POST',
        data: 'user_login=' + email + '&password=' + password + '&first_name=' + first_name + '&last_name=' + last_name + '&customer_id=' + customer_id,
        dataType: 'json',
        success: function (result) {

            if (result != undefined && result.message != undefined && result.message == "success") {
                //console.log("******* cannot login to Rangoli");
                location.reload(true);
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

                window.location = url;
            }
            else if (result.message == "alreadyloggedout") {
                var url = root + "customer/account/logout/";

                window.location = url;
            }
        }
    });
}

function wplogoutonly() {
    jQuery.ajax({
        url: root + 'rangoli/wp_logout.php',
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

                    wplogoutonly();  // if magento user is not logged in and wordpress user is logged

                }
                else if (result.message == "logged") {

                    var name = result.first_name;

                    var email = result.email;
                    var name = result.name;
                    var first_name = result.first_name;
                    var last_name = result.last_name;
                    var customer_id = result.user_id;

                    jQuery("#welcome-name").html("Hi " + first_name).attr("href", homeUrl + 'customer/account/');
                    jQuery(".login_logout_link").html("<span style='cursor:pointer; margin-left:0;padding-left:0' onclick='wplogout()'>SIGN OUT</span>");

                }
            }
        }
    });
}
/**************** logout logic added by ys team *****************/



function getSelectedInterestCount(){
    var count = $(".interest_listing li a.remove").length;
    return count;
}
function count_interests(){
    var count = getSelectedInterestCount();

    if(count >=3){
        $(".next-confirmation-page").text("Next");
    }else{
        $(".next-confirmation-page").text("Choose 3+");
    }
}
function get_cookie(Name) {
    var search = Name + "="
    var returnvalue = "";
    if (document.cookie.length > 0) {
        var offset = document.cookie.indexOf(search)
        // if cookie exists
        if (offset != -1) {
            offset += search.length
            // set index of beginning of value
            var end = document.cookie.indexOf(";", offset);
            // set index of end of cookie value
            if (end == -1) end = document.cookie.length;
            returnvalue=unescape(document.cookie.substring(offset, end))
        }
    }
    return returnvalue;
}
$(document).ready(function () {
    init();
    if (logged_in == false)
        $(".homepage_slider .home_signup").css("top", wh - 157);
    else{
        $(".homepage_slider .home_signup").css("top", wh - 112);
    }
    $("#signup_signin_btn").click(function () {
        $(".login_logout_link").click();
    });
    $(".interest_listing li a").click(function (e) {
        e.preventDefault();

        var current_obj = $(this);
        var link = $(this).attr("href");
        var cls = $(this).attr("class");
        if (cls == "user-interest add") {
            current_obj.removeClass("add");
            current_obj.addClass("remove");

            current_obj.find("path").css("fill", user_color_shade).css("stroke", user_color_shade);
        }
        else {
            current_obj.removeClass("remove");
            current_obj.addClass("add");
            current_obj.find("path").css("fill", "transparent").css("stroke", "#fff");
        }

        $.ajax({
            url: link + '&s=' + new Date().getSeconds(),
            type: 'GET',
            success: function (response) {

                current_obj.attr("href", response);

                count_interests();
            }
        })
    });
});

$(window).resize(function () {
    var wh = $(window).height();
    var ww = $(window).width();

    if(logged_in==false)
        $(".homepage_slider .home_signup").css("top",wh-157);
    else {
        $(".homepage_slider .home_signup").css("top", wh - 112);
    }

    $(".fixed-container").css("min-height",wh/2);

    //$(".wp_page_banner").height(wh-50);
});

$(window).load(function () {
    $(".wp_page").animate({
        'opacity': '1'
    }, 300, function () {
        $(".flexslider .rangoli_logo").addClass("fadeInDown").addClass("animated");
    });
    var wh = $(window).height();
    var ww = $(window).width();
    $(".wp_page_banner").height(wh-70);

    //var ht = $(".play_video").height();
    //$(".featured-video-plus").css("height", ht + "px");
    //$(".featured-video-plus").height(ht);

    //$(".wp_page_banner").height(ww*0.5625)
});
$(window).resize(function () {
    var wh = $(window).height();
    var ww = $(window).width();
    $(".wp_page_banner").height(wh-70);
    if(playing_video == true) {
        $(".wp_page_banner").height(ww * 0.5625);
    }

    var ht = $(".play_video").height();
    $(".featured-video-plus").css("height", ht + "px");
    $(".featured-video-plus").height(ht);


});

/* ////////////////////////////////////GET CUSTOMER COLOR////////////////////////////// */


function hexToRgb(h) {
    var r = parseInt((cutHex(h)).substring(0, 2), 16);
    var g = parseInt((cutHex(h)).substring(2, 4), 16);
    var b = parseInt((cutHex(h)).substring(4, 6), 16);
    return r + ',' + g + ',' + b;
    function cutHex(h) {
        var i = h;
        if (h == undefined) {
            i = "#555555";
        }
        return (i.charAt(0) == "#") ? i.substring(1, 7) : i;
    }
}


$(document).ready(function () {
    getloggedinuser();
    filter();
});

function bindHeartLink(obj) {
    $(obj).click(function (e) {
        e.preventDefault();
        var link = $(obj).attr("href");

        var parent = $(obj).parent();

        $(parent).load(link + '&ajax=1', function () {
            var lnk = $(parent).find(".wpfp-link");
            bindHeartLink(lnk);
            $(".wpfp-link.remove path").css("fill", user_color_shade).css("stroke", user_color_shade);
        });
    });
}

function getloggedinuser() {

    $.ajax({
        url: root + 'ys/session/getloggedrangoliprofile',
        type: 'POST',
        dataType: 'json',
        success: function (result) {
            if (result.message == 'found') {
                user_color_shade = '#' + result.color_shade;
                var id = result.user_id;
                status = result.status;
                user_email = result.email;

                //get_magento_cstomerID(user_email);

                if (user_color_shade != "#555555") {

                    if (status == "new") {
                        $("#signin_popup").fadeIn();
                        $.ajax({
                            url: root + 'ys/session/updaterangoliuserstatus',
                            data: 'user_id=' + id,
                            type: 'POST',
                            dataType: 'json',
                            success: function (result) {
                                $(".signin-block").hide();
                                $(".login-box").hide();
                                $(".your-color-block").fadeIn();
                                fillcolor();
                            }
                        });

                    }
                    else if (status == "registered") {
                        $.ajax({
                            url: root + 'ys/session/updaterangoliuserstatus',
                            data: 'user_id=' + id,
                            type: 'POST',
                            dataType: 'json',
                            success: function (result) {
                                window.location = root + "rangoli/journey";
                            }
                        });

                    }
                }
            }
            else {
                user_color_shade = "#555555";
                color = "85,85,85";
                //wplogout();
            }
            $(".one-three .overlay-text").hover(function () {
                //$(this).css({'background-color': 'rgba(' + color + ',0.5)', 'transition-duration': '500ms'});
                $(this).css({'background-color': user_color_shade, 'transition-duration': '500ms'})
            }, function () {
                $(this).css({
                    'background':'rgba(0,0,0,0.25)',
                    //'background': '-webkit-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    //'background': '-o-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    //'background': '-moz-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    //'background': 'linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    'transition-duration': '100ms'
                });
            });
            $(".two-three .overlay-text").hover(function () {
                //$(this).css({'background-color': 'rgba(' + color + ',0.5)', 'transition-duration': '500ms'});
                $(this).css({'background-color': user_color_shade, 'transition-duration': '500ms'});
                //$(this).find("p").css({'color': '#fff', 'transition-duration': '500ms'});
                //$(this).find(".post_category").css({"border-color": "#fff", 'transition-duration': '500ms'})
            }, function () {
                $(this).css({
                    'background':'rgba(0,0,0,0.25)',
                    //'background': '-webkit-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    //'background': '-o-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    //'background': '-moz-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    //'background': 'linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    'transition-duration': '100ms'
                })
                //$(this).find("p").css({'color': '#555', 'transition-duration': '500ms'})
                //$(this).find(".post_category").css({"border-color": "#555", 'transition-duration': '500ms'})
            });


            fillcolor();

        }
    });
}

function fillcolor() {
    //$(".user-color-shade").css({'background-color': 'rgba(' + color + ',0.9)'});
    $(".user-color-shade").css({'background-color': 'rgba(' + color + ',0.9)', 'transition-duration': '500ms'});
    $(".color-game polygon:nth-child(2)").css("fill", user_color_shade);
    $(".color-game polygon").css("stroke", user_color_shade);
    $(".menu-btn rect").css("fill", user_color_shade);
    $(".wpfp-link.remove path").css("fill", user_color_shade).css("stroke", user_color_shade);
    $(".smogi .like.subscribed path").css("fill", user_color_shade).css("stroke", user_color_shade);

    $(document).find(".author_recent_activity .img_in_circle").each(function(){
        $(this).html("<span style='background:rgba(" + color + ",0.9)'></span>");
    });
}


$(document).ready(function () {
    $("#menu-category a").click(function (e) {
        e.preventDefault();
        $(".close-menu-btn").click();
        ajax_load_pages($(this).attr('href'));
    });
    $(".author_post .overlay-text").css({
        'background':'rgba(0,0,0,0.25)',
        //'background': '-webkit-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
        //'background': '-o-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
        //'background': '-moz-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
        //'background': 'linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
        'transition-duration': '100ms'
    });
});


function ajax_load_pages(link) {
    var $page = $(document).find(".fixed-container > div");
    $page.removeAttr("class");
    $(".close-menu-btn").click();

    $.ajax({
        url: link,
        success: function (response) {
            var newTitle = $(response).filter('title').html();
            $page.html("");

            var newData = $(response).find("#fixed_container").html();

            $(window).scrollTop(0);
            $page.html(newData).addClass("fadeIn").addClass("animated");
            get_bulls_eye();
            init();
            $("#filter").unbind();
            filter();
            //$(document).find(".flexslider").flexslider();
            var $a = $(document).find(".ajax-load");
            $a.unbind("click");
            $a.click(function (e) {
                e.preventDefault();
                $(".close-menu-btn").click();
                $(".close-popup").click();
                var link = $(this).attr("href");
                ajax_load_pages(link);
            });
            raty_init();
            $(document).find(".one-three .overlay-text").css({
                'background':'rgba(0,0,0,0.25)',
                //'background': '-webkit-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                //'background': '-o-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                //'background': '-moz-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                //'background': 'linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                'transition-duration': '100ms'
            });
            $(document).find(".two-three .overlay-text").css({
                'background':'rgba(0,0,0,0.25)',
                //'background': '-webkit-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                //'background': '-o-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                //'background': '-moz-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                //'background': 'linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                'transition-duration': '100ms'
            });
            $(document).find(".author_post .overlay-text").css({
                'background':'rgba(0,0,0,0.25)',
                //'background': '-webkit-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                //'background': '-o-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                //'background': '-moz-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                //'background': 'linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                'transition-duration': '100ms'
            });

            $(".wp_page").animate({
                'opacity': 1
            }, 500);

            submit_comment();
            save_shares();

            $(document).find(".wp_page_banner .play-video").unbind("click");
            $(document).find(".wp_page_banner .play-video").click(function () {
                $(document).find(".wp_page_banner .play-video").hide();

                var ht = $(".play_video").height();
                $(".featured-video-plus").css("height", ht + "px");
                //$(".featured-video-plus").height(ht);

                play();
                $(".play_video").fadeIn();
                $(document).find(".wp_page_banner .play-video").remove();
            });

            //$(window).load(function(){
            //animate_tiles();
            //});


            $(document).find(".homepage_page_banner .play-video").unbind("click");
            $(document).find(".homepage_page_banner .play-video").click(function () {
                $(document).find(".homepage_page_banner .play-video").hide();
                play();
                $(".play_video").fadeIn();

                $(document).find(".rangoli_logo").remove();
                $(document).find("#signup_signin_btn").remove();
                $(document).find(".homepage_page_banner .play-video").remove();
            });

            $(".single_post.span4").addClass("fadeInUp").addClass("animated");
            window.history.pushState({path: link}, null, link);
            document.title = newTitle;


            $(".user-color-shade").css({'background-color': 'rgba(' + color + ',0.9)'});
            //$(".user-color-shade").css({'background-color': user_color_shade});
            $(".color-game polygon:nth-child(2)").css("fill", user_color_shade);
            $(".color-game polygon").css("stroke", user_color_shade);
            $(".menu-btn rect").css("fill", user_color_shade);
            $(".wpfp-link.remove path").css("fill", user_color_shade).css("stroke", user_color_shade);
            $(".smogi .like.subscribed path").css("fill", user_color_shade).css("stroke", user_color_shade);

        }
    });
    $(".close-menu-btn").click();


}
function play() {
    //var player = $(document).find(".featured_video_plus").find("iframe");
    var player = $(document).find(".featured-video-plus").find("iframe");
    var src = player.attr("src");
    src = src.replace("autoplay=0", "autoplay=1");
    player.attr("src", src);
    var ww=$(window).width();
    playing_video = true;
    //$(".wp_page_banner").height(ww*0.5625);
    $(".homepage_slider .slides li").height(ww*0.5625);
}

function init() {

    var wh = $(window).height();
    var ww = $(window).width();
    $(".fixed-container").css("min-height",wh/2);
    $(".wp_page_banner").height(wh-70);
    //$(".wp_page_banner").height(ww*0.5625);

    $(".post_category a").each(function () {

        var href = $(this).attr("href");
        href = href.toLowerCase();
        $(this).attr("href", href);
        $(this).click(function (e) {
            e.preventDefault();
        });
    })
    $(".wp_page_banner").css("min-height", wh - 70);
    $(".smogi-list").height(wh - 100);

    $(".post_category a").each(function () {

        var str = $(this).attr('href');

        if (str.indexOf('learn') > -1 || str.indexOf('look') > -1 || str.indexOf('read') > -1)
            $(this).remove();
    });


    /*
     $(".wp_page_banner .play-video").click(function () {
     $(".play_video").fadeIn();

     var ht = $(".play_video").height();
     $(".play_video").find(".featured-video-plus").height(ht);

     console.log("****** " + $(".play_video").height() + " , " + $(".play_video").find(".featured-video-plus").height());

     play();

     $(this).remove();
     });
     */


    $(".wp_page_banner .play-video").click(function () {
        $(".play_video").fadeIn();

        $(".wp_page_banner").css("background", "none");
//        var h = $(".wp_page_banner").height();
//        $(".featured-video-plus.fvp-center").css("height", h + "px");

        var ht = $(".play_video").height();
        $(".featured-video-plus").css("height", ht + "px");
        $(".featured-video-plus").height(ht);

        play();

        $(this).remove();
    });

    //$(".featured-video-plus").css("height", "100% !important");

    $(".homepage_page_banner .play-video").click(function () {
        $(".play_video").fadeIn();
        $(".rangoli_logo").remove();
        $("#signup_signin_btn").remove();
        play();

        $(this).remove();
    });
    $('.video-popup .close').click(function () {
        $('.video-popup').fadeOut();
        $('.video-popup video').fadeOut();
        $('.video-popup video').attr('src', '');
    });

    $(".like-btn .wpfp-link").each(function () {
        bindHeartLink($(this));
    });
    $(".single_post_like .wpfp-link").each(function () {
        bindHeartLink($(this));
    });
    $(".not-logged-in").click(function (e) {
        e.preventDefault();
        $("#signin_popup").fadeIn();
        $(".signin-block").hide();
        $(".login-box").fadeIn();
        is_login_box_open = true;
    });
    $(".author_post .overlay-text").hover(function () {
        if (user_color_shade == '') {
            user_color_shade = '#555555';
        }
        var color = hexToRgb(user_color_shade);
        //$(".author_post:hover .overlay-text").css({'background-color': 'rgba('+color+',0.5)','transition-duration':"500ms"});
        $(".author_post:hover .overlay-text").css({'background-color': user_color_shade,'transition-duration':'500ms'});
    }, function () {
        $(".author_post .overlay-text").css({
            'background':'rgba(0,0,0,0.25)',
            //'background': '-webkit-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
            //'background': '-o-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
            //'background': '-moz-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
            //'background': 'linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
            'transition-duration': '100ms'
        });
    });


    $(".show_more_comments").click(function () {
        $(".more_comments").slideDown();
        $(this).text("");
        $(this).parent().parent().remove();
    });
    fillcolor();
}


function filter() {
    $("#filter").on("click", function () {
        $(this).next().slideToggle(300);
    });
    $(".filter-container ul li p").unbind();
    $(".filter-container ul li p").click(function () {
        $(this).find("span").toggleClass("activeli");
        $(this).parent().siblings().find("ul").slideUp(300);
        $(this).parent().find("ul").slideToggle(300);
    });
    $(".filter-container a").unbind();
    $(".filter-container a").click(function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        $(".filter-container a").removeClass("active");
        $(this).addClass("active");

        $.ajax({
            url: link,

            success: function (data) {

                var $newData = $(data).find("#posts");

                $newData.find(".single_post").addClass("fadeInUp").addClass("animated")
                $(".post_listing").html($newData.html());


                init();

                $(".author_post .overlay-text").css({
                    'background':'rgba(0,0,0,0.25)',
                    //'background': '-webkit-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    //'background': '-o-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    //'background': '-moz-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    //'background': 'linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    'transition-duration': '100ms'
                });
                $(".liked_reads").flexslider();
                $(".liked_watchs").flexslider();
                $(".liked_learns").flexslider();

                if($newData.find(".single_post").length==""){

                    $(".post_listing").html("<br/><br/><br/><p class='align-center' style='font-family: ITCAvantGardeStd-Bk; font-size:20px'>No post found !</p>");
                }


            }
        });
        $(".filter-container").slideUp();
    });
}


$(document).ready(function () {
    raty_init();

	/*var mbxH = $(window).height();
	var mbxW = $('menu-box').width();*/
    $(".menu-btn").click(function () {
		/*$(".menu-box").addClass('box-open');
		$(".menu-box").removeClass('box-close');*/
		
		
        $(".menu-box").css({visibility: "visible"}).animate({
            'margin-left': '0',			
			'width':'321px',
            'opacity': 1			
        }, 200, "easeOutCirc");
        $(this).animate({"opacity": 0}, 200);
        $("#smogis").hide();
        $("#connect").hide();
        $("#stores").hide();
        $("#popup").fadeOut();
        //$("body").css("overflow", "auto");
        $("#invite_friend").hide();
    });
    $(".close-menu-btn").click(function () {
		/*$(".menu-box").addClass('box-close');
		$(".menu-box").removeClass('box-open');*/
        $(".menu-box").animate({
            'margin-left': '0',
			'width':0			
        }, 200, "easeOutCirc");
        $(".menu-btn").animate({"opacity": 1}, 200);
    });
    $(".close-popup").click(function () {
        $(".smogi").removeClass("fadeInUp").removeClass("animated");
        //$("body").css("overflow", "auto");
        $("#popup").fadeOut();
        $("#stores").fadeOut();
        $("#smogis").fadeOut();

    });

    $("a[rel='ys-stores']").click(function (e) {
        e.preventDefault();
        $("#connect").hide();
        $("#popup").fadeIn();
        $("#stores").show();
        $("#smogis").hide();
        $("#invite_friend").hide();
        //$("body").css("overflow", "hidden");
        $(".smogi").addClass("fadeInUp").addClass("animated");
        $(".menu-btn").css("opacity", 1);
        $(".close-menu-btn").click();
    });

    $(".smogi-content").height(wh - 230);

    $("a[rel='smogis']").click(function (e) {
        e.preventDefault();
        $("#connect").hide();
        $("#popup").fadeIn();
        $("#smogis").show();
        //$("body").css("overflow", "hidden");
        $("#invite_friend").hide();
        $(".smogi").addClass("fadeInUp").addClass("animated");
        $("#stores").hide();

        $(".close-menu-btn").click();
    });



});
function raty_init() {

    //$(".rating").raty({
    //    path: root + 'rangoli/wp-content/themes/rangoli/images'
    //})
    $('.do_rating').raty({
        path: root + 'rangoli/wp-content/themes/rangoli/images',
        click: function (score, evt) {
            if (logged_in != null && logged_in != '' && logged_in != undefined) {
                var subject_id = $(this).attr("post_id");
                $.ajax({
                    url: root + "rangoli/rating.php",
                    type: 'GET',
                    data: 'rating_value=' + score + '&subject_type=post&subject_id=' + subject_id,
                    success: function (result) {
                    }
                });
            }
            else {
                $("#signin_popup").fadeIn();
                $(".signin-block").hide();
                $(".login-box").fadeIn();
                is_login_box_open = true;
            }
        }
    });
    $(".rating").each(function () {
        $(this).raty({
            score: $(this).attr('rel'),
            path: root + 'rangoli/wp-content/themes/rangoli/images',
            readOnly: true
        });
    });
}

$(document).ready(function () {
    $(".invite_signup").click(function(){
        $("a[rel='connect']").click();
    });
    $("a[rel='connect']").click(function (e) {
        e.preventDefault();
        if (logged_in != null && logged_in != '' && logged_in != undefined) {
            $("#smogis").hide();
            $("#connect").hide();
            $("#stores").hide();
            $("#popup").fadeIn();
            $("#invite_friend").fadeIn();
            $(".close-menu-btn").click();
            $(".invite_friend li").hover(function () {
                $(this).css({
                    "background": user_color_shade,
                    "transition-duration": "500ms"
                });
            }, function () {
                $(this).css({
                    "background": "#f2f2f2",
                    "transition-duration": "500ms"
                });
            });
        }
        else {
            $("#signin_popup").fadeIn();
            $(".signin-block").hide();
            $(".login-box").fadeIn();
            is_login_box_open = true;
        }
    });
    $(".link").load(root + "profile/manage/referralurl");
    $(".switch").click(function () {
        $(this).toggleClass("active");
    });


    $(".invite-friends").click(function () {
        if (logged_in != null && logged_in != '' && logged_in != undefined) {
            $(".close-menu-btn").click();
            $("#smogis").hide();
            $("#connect").hide();
            $("#stores").hide();
            $("#popup").fadeIn();
            //$("body").css("overflow", "hidden");
            $("#invite_friend").fadeIn();
            $(".invite_friend li").hover(function () {
                $(this).css({
                    "background": user_color_shade,
                    "transition-duration": "500ms"
                });
            }, function () {
                $(this).css({
                    "background": "#f2f2f2",
                    "transition-duration": "500ms"
                });
            });
        }
        else {
            $("#signin_popup").fadeIn();
            $(".signin-block").hide();
            $(".login-box").fadeIn();
            is_login_box_open = true;
        }
    });


    $("li[rel='facebook']").click(function () {
        var shareUrl = $(document).find(".link").html();
        var url = "https://www.facebook.com/dialog/send?app_id=909386705751971&link=" + shareUrl + "&redirect_uri=http://yogasmoga.com";
        window.open(url, "Invite friends on facebook", "height=500, width=700");
    });
    $("li[rel='email']").click(function () {
        var shareUrl = $(document).find(".link").html();
        var url = "mailto:?subject=I wanted you to see this site&body=Check out the color game at " + shareUrl;
        window.open(url, "Invite friends on facebook", "height=500, width=700");
    });
    $("li[rel='twitter']").click(function () {
        var shareUrl = $(document).find(".link").html();
        window.open(root + "rangoli/wp-content/themes/rangoli/twt_redirect.php?l=" + shareUrl);
    });


    save_shares();


});


function save_shares() {
    $(".sharing_icons li a").click(function (e) {
        if (logged_in != null && logged_in != '' & logged_in != undefined) {
            var post_id = $(this).attr("rel");
            var user_id = $(this).attr("user");
            var time = new Date();
            var sec = time.getSeconds();

            $.ajax({
                url: root + "/rangoli/save_shares.php",
                data: "post_id=" + post_id + "&user_id=" + user_id + "&s=" + sec,
                type: "GET",
                success: function (response) {
                    if (response) {

                    }
                }
            });
        }
    });

}

$(window).load(function(){

    $(".confirmed_interests li a").click(function(e){
        e.preventDefault();
    });


    copytoClipboard();
});

function copytoClipboard(){
    var link =$(".link").html();
    $(".copy").attr("data-clipboard-text",link);
    var client = new ZeroClipboard($(".copy"));

    client.on( "ready", function( readyEvent ) {

        client.on( "aftercopy", function( event ) {

        } );
    } );


}





//////////////////////////// INFINITY SCROLL /////////////////////


$(window).load(function(){
    infinity_scroll();
});
function infinity_scroll(){
    $(window).scroll(function(){
        if($(document).find(".navigation.paging-navigation").length>0) {
            var offsetTopOfNav = $(document).find(".navigation.paging-navigation").offset().top;
            if (offsetTopOfNav - $(window).scrollTop() <= ($(window).height()+400)) {
                if($(document).find("a.next").length>0) {
                    var link = $(document).find("a.next").attr("href");
                    $(document).find(".navigation.paging-navigation").remove();

                    $.ajax({
                        url: link,
                        success: function (data) {


                            var $newData = $(data).find("#posts .author_posts");
                            $newData.find(".single_post").addClass("fadeInUp").addClass("animated")
                            $(".post_listing .author_posts").append($newData.html());


                            init();

                            $(".author_post .overlay-text").css({
                                'background':'rgba(0,0,0,0.25)',
                                //'background': '-webkit-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                                //'background': '-o-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                                //'background': '-moz-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                                //'background': 'linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                                'transition-duration': '100ms'
                            });


                        }
                    });
                }
            }
        }
    })

}

/*

 $(document).ready(function(){
 history_pop();
 });


 function history_pop(){
 $(window).bind('popstate', function(event){
 window.location = document.location;
 });
 }*/




$(document).ready(function(){
    $.ajax({
        url:root +"ys/session/getcartcount",
        success : function(response){
            $("#cart span").html(response);
        }
    })



    /*
     // read page
     $(".post_content a img").not(".get_the_look a img").each(function(){
     $(this).parent().removeAttr("href");
     });
     */

});

$(window).load(function(){
    setTimeout( function() {
        window.onpopstate = function (event) {
            var link = document.location.href;
            window.location = link;
            //change_url = false;
        };
    },500);
    animate_tiles();

});

var winH = $(window).height();
function animate_tiles(){
    $(".section_animate").each(function(){
        //var element = $(this);
        var top = $(this).offset().top;
        var scrollTop = $(window).scrollTop();
        if (($(this).offset().top -  scrollTop) <= (winH - 100)) {
            $(this).removeClass("section_animate");
            $(this).addClass("fadeInUp").addClass("animated");
        }
    });
}

$(window).scroll(function(){
    var scrollTop = $(window).scrollTop();
    $(document).find(".section_animate").each(function() {
        if (($(this).offset().top -  scrollTop) <= (winH - 100)) {
            $(this).removeClass("section_animate");
            $(this).addClass("fadeInUp").addClass("animated");
        }
    });
});



/******************** BUlls eye random popup **********************/
var click_count=0;
var is_bullseye_popup_open = false;
function flip(){
    $("#card").toggleClass("flipped");
    if($("#card").hasClass("flipped"));
    setTimeout(randomize_images,200);
};
$(document).ready(function(){
    randomize_images();
    $(".close").click(function(){
        $(".bullseye_popup").fadeOut();
        $(".center_popup").fadeOut();
        $(".gender_p span").removeClass("selected");
        $(".bullseye_popup_container").fadeOut();
        is_bullseye_popup_open = false;
    });
    $("#ap_signup").click(function(){
        createCustomerAccount_from_animated_popup();
    });
});
function randomize_images(){
    var rand_no = Math.floor((Math.random() * 6) + 1);
    $(".front img").attr("src",root+"rangoli/wp-content/themes/rangoli/images/bullseye_0"+rand_no+".png");
}
function open_bulls_popup(){
    $(".err-msg").html("");
    $(".signin-block").fadeOut();
    $("#signin_popup").fadeOut();
    $("#card").removeClass("flipped");
    $(".bullseye_popup").fadeIn();
    $(".center_popup").fadeIn();
    $(".bullseye_popup_container").fadeIn();
}




function createCustomerAccount_from_animated_popup() {
    var error = "";
    var fname = jQuery.trim(jQuery("#ap_fname").val());
    var lname = jQuery.trim(jQuery("#ap_lname").val());
    var email_id = jQuery.trim(jQuery("#ap_signup_email").val());
    var pwd = jQuery.trim(jQuery("#ap_s_password").val());
    var location_city = jQuery.trim(jQuery("#ap_location_city").val());
    var location_state = jQuery.trim(jQuery("#ap_location_state").val());
    var location_zip = jQuery.trim(jQuery("#ap_location_zip").val());

    if (fname!="First Name" && lname!="Last Name" && email_id!="Email" && fname.length > 0 && lname.length > 0 && email_id.length > 0 && pwd.length>0 && pwd!="Select a password") {
/*
        function IsEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }
*/

        if(IsEmail(email_id)){
            if (pwd=="Select a password" || pwd.length < 6 ) {
                error = "Password requires 6 or more characters.";
            }
            else if(!if_gender_is_selected()){
                error = "Please select a Gender.";
            }
            else {
                var gender = jQuery.trim(jQuery(".gender_p.gender_popup span.selected input").val());
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
                        'is_subscribed': "on",
                        'gender' : gender,
                        'location_city':location_city,
                        'location_state':location_state,
                        'location_zip':location_zip
                    },
                    beforeSend: function () {
                        jQuery("#ap_sign-up-form .err-msg").html("");
                        jQuery("#ap_signup").val("Signing up...");

                    },
                    success: function (data) {

                        data = eval('(' + data + ')');
                        var status = data.status;
                        if (status == "success") {
                            var name = data.fname;

                            var first_name = data.first_name;
                            var last_name = data.last_name;
                            var customer_id = data.customer_id;


                            /**************** code added by ys team *****************/
                            createRangoliUser(email_id, pwd, first_name, last_name, customer_id);
                            /**************** code added by ys team *****************/

                                // console.log(data.status);
                            jQuery(".bullseye_popup_container").fadeOut();
                            //                          window.location=homeUrl+"rangoli";

                            _islogedinuser = true;
                            jQuery("#signin").html("SIGN OUT").attr({
                                href: homeUrl + 'customer/account/logout/',
                                id: "sign-out"
                            });

                            if (name != '') {
                                jQuery("#welcome-name").html("Hi " + name).attr("href", homeUrl + 'customer/account/');
                            }
                        }
                        else {
                            //jQuery("#sign-up-form .loader").hide();
                            jQuery("#ap_signup").val("Sign up");
                            jQuery("#ap_sign-up-form .err-msg").html(data.errors).css("visibility", "visible");
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




function open_red_popup(){
    $(".your-color-block").fadeOut();
    is_login_box_open = false;
    $(".login-box").fadeOut();
    $("#signin_popup").fadeIn('',function(){
		
		//$("#signin_popup").addClass('c');
		$("#signin_popup").addClass('mc_signinpopup');
		
	});
    $(".signin-block").fadeIn();
}





$(document).ready(function(){

    $(".gender_p span").click(function(){
        $(".gender_p span").removeClass("selected");
        $(this).addClass("selected");
    });



    $("#update_username").click(function(){
        var text = $("input.change_username");
        var username = text.val();
        var user_id = text.attr("user_id");

        if(username!=undefined && username!="Choose your user name"){
            $.ajax({
                url : root + "rangoli/update_user_name.php",
                data : {"username":username,"user_id":user_id},
                success: function(response){
                    if(response=="updated"){
                        $(".confirmation-page h1").html("HI "+username.toUpperCase());
                        $(".username_update_msg").html("Username has been updated.");
                    }
                    else if(response == "exists"){
                        $(".username_update_msg").html("Sorry! username already taken.");
                    }
                    else {
                        $(".username_update_msg").html("An error occured during the process.");
                    }
                }
            });
        }
    });
});



function isValidEmailAddress(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}


function if_gender_is_selected(){
    if($(".gender_p span").hasClass("selected")){
        return true;
    }
    else{
        return false;
    }
}
/**************************** rangoli js logic *****************************/

/*
 Color animation 1.6.0
 */
'use strict';
(function (d) {
    function h(a, b, e) {
        var c = "rgb" + (d.support.rgba ? "a" : "") + "(" + parseInt(a[0] + e * (b[0] - a[0]), 10) + "," + parseInt(a[1] + e * (b[1] - a[1]), 10) + "," + parseInt(a[2] + e * (b[2] - a[2]), 10);
        d.support.rgba && (c += "," + (a && b ? parseFloat(a[3] + e * (b[3] - a[3])) : 1));
        return c + ")"
    }

    function f(a) {
        var b;
        return (b = /#([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})/.exec(a)) ? [parseInt(b[1], 16), parseInt(b[2], 16), parseInt(b[3], 16), 1] : (b = /#([0-9a-fA-F])([0-9a-fA-F])([0-9a-fA-F])/.exec(a)) ? [17 * parseInt(b[1], 16), 17 * parseInt(b[2], 16), 17 * parseInt(b[3], 16), 1] : (b = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(a)) ? [parseInt(b[1]), parseInt(b[2]), parseInt(b[3]), 1] : (b = /rgba\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9\.]*)\s*\)/.exec(a)) ? [parseInt(b[1], 10), parseInt(b[2], 10), parseInt(b[3], 10), parseFloat(b[4])] : l[a]
    }

    d.extend(!0, d, {
        support: {
            rgba: function () {
                var a = d("script:first"), b = a.css("color"), e = !1;
                if (/^rgba/.test(b))e = !0; else try {
                    e = b != a.css("color", "rgba(0, 0, 0, 0.5)").css("color"), a.css("color", b)
                } catch (c) {
                }
                return e
            }()
        }
    });
    var k = "color backgroundColor borderBottomColor borderLeftColor borderRightColor borderTopColor outlineColor".split(" ");
    d.each(k, function (a, b) {
        d.Tween.propHooks[b] = {
            get: function (a) {
                return d(a.elem).css(b)
            }, set: function (a) {
                var c = a.elem.style, g = f(d(a.elem).css(b)), m = f(a.end);
                a.run = function (a) {
                    c[b] = h(g, m, a)
                }
            }
        }
    });
    d.Tween.propHooks.borderColor = {
        set: function (a) {
            var b = a.elem.style, e = [], c = k.slice(2, 6);
            d.each(c, function (b, c) {
                e[c] = f(d(a.elem).css(c))
            });
            var g = f(a.end);
            a.run = function (a) {
                d.each(c, function (d, c) {
                    b[c] = h(e[c], g, a)
                })
            }
        }
    };
    var l = {
        aqua: [0, 255, 255, 1],
        azure: [240, 255, 255, 1],
        beige: [245, 245, 220, 1],
        black: [0, 0, 0, 1],
        blue: [0, 0, 255, 1],
        brown: [165, 42, 42, 1],
        cyan: [0, 255, 255, 1],
        darkblue: [0, 0, 139, 1],
        darkcyan: [0, 139, 139, 1],
        darkgrey: [169, 169, 169, 1],
        darkgreen: [0, 100, 0, 1],
        darkkhaki: [189, 183, 107, 1],
        darkmagenta: [139, 0, 139, 1],
        darkolivegreen: [85, 107, 47, 1],
        darkorange: [255, 140, 0, 1],
        darkorchid: [153, 50, 204, 1],
        darkred: [139, 0, 0, 1],
        darksalmon: [233, 150, 122, 1],
        darkviolet: [148, 0, 211, 1],
        fuchsia: [255, 0, 255, 1],
        gold: [255, 215, 0, 1],
        green: [0, 128, 0, 1],
        indigo: [75, 0, 130, 1],
        khaki: [240, 230, 140, 1],
        lightblue: [173, 216, 230, 1],
        lightcyan: [224, 255, 255, 1],
        lightgreen: [144, 238, 144, 1],
        lightgrey: [211, 211, 211, 1],
        lightpink: [255, 182, 193, 1],
        lightyellow: [255, 255, 224, 1],
        lime: [0, 255, 0, 1],
        magenta: [255, 0, 255, 1],
        maroon: [128, 0, 0, 1],
        navy: [0, 0, 128, 1],
        olive: [128, 128, 0, 1],
        orange: [255, 165, 0, 1],
        pink: [255, 192, 203, 1],
        purple: [128, 0, 128, 1],
        violet: [128, 0, 128, 1],
        red: [255, 0, 0, 1],
        silver: [192, 192, 192, 1],
        white: [255, 255, 255, 1],
        yellow: [255, 255, 0, 1],
        transparent: [255, 255, 255, 0]
    }
})(jQuery);

!function (s, l) {
    var i, e, a = s(l),
        t = s.event;
    i = t.special.debouncedresize = {
        setup: function () {
            s(this).on("resize", i.handler)
        },
        teardown: function () {
            s(this).off("resize", i.handler)
        },
        handler: function (s, l) {
            var a = this,
                c = arguments,
                d = function () {
                    s.type = "debouncedresize", t.dispatch.apply(a, c)
                };
            e && clearTimeout(e), l ? d() : e = setTimeout(d, i.threshold)
        },
        threshold: 150
    }, s.Rangoli = function (l, i) {
        this.elm = l instanceof s ? l : s(l), this.json = i
    }, s.Rangoli.prototype = {
        initGame: function () {
            var l = this;
            l.isHidden = !0, l.$gcontainer = s('<div class="game-container"/>'), l.$gbox = s('<div class="bulleye-box"/>'), l.$gubox = s('<div class="game-userbox"/>'), l.$closebox = s('<span class="closegame"/>'), l.$gcontainer.append(l.$gbox, l.$gubox).appendTo(l.elm), l.elm.append(l.$closebox), l._getGameData(l.json), l._gameDimentions(), l._gameEvents()
        },
        _getGameData: function (l) {
            var i = this;
            s.each(l, function (l, e) {
                var a = s('<div class="ring-color ring_' + l + '" rel="uinfo_' + l + '"><span style="background-color:#' + e.color + '"></span><span style="background-color:#' + e.shade + '" class="ovl"></span></div>'),
                    t = '<div class="uinfo" id="uinfo_' + l + '"><div class="abt-user"><div class="profile-image"><a href="' + e.url + '"><img src="' + e.profileImage + '"/></a></div><span class="charm color_' + e.color.toUpperCase() + " level_" + e.level + '"></span><div class="uname"><a href="' + e.url + '">' + e.name + '</a></div><p class="uplace">' + e.place + '</p><!-- p class="uinterests">e.interests</p --><p class="ubucks">' + e.smogiBucks + '</p></div><div class="act-user"><p class="udata">' + e.date + "</p>";
                t += "post" == e.type ? '<p class="uact"><a href="' + e.url + '">' + e.name + '</a> <span>posted a new article </span> <a href="' + e.postUrl + '">' + e.postTitle + "</a></p>" : '<p class="uact"><a href="' + e.url + '">' + e.name + '</a>  <span>commented on <!--article posted by--></span><!--a href=e.postAutherUrl > e.postAuther </a--><a href="' + e.postUrl + '">' + e.postTitle + "</a></p>", t += '<!-- a href="' + homeUrl + "rangoli/feeds/?color=" + e.color + '" class="all">See all</a --></div></div>';
                var c = s(t);
                i.$gbox.append(a), i.$gubox.append(c), i.$gubox.find(".uinfo:first").addClass("active")
            });
            var e = s('<div class="ring-color lucky ring_7"><a href="' + homeUrl + 'rangoli/lucky"><span>Lucky<br/>You</span></a></div>');
            e.appendTo(i.$gbox)
        },
        _gameEvents: function () {
            var l = this;
            a.on("debouncedresize.Rangoli", function () {
                l._gameDimentions()
            }), l.$closebox.click(function () {
                l.hideGame()
            }), s(document).on("click", ".ring-color", function () {
                if (s(this).attr("rel")) {
                    var i = "#" + s(this).attr("rel");
                    if (s(i).hasClass("active")) return;
                    l.$gubox.find(".uinfo.active").removeClass("active").fadeOut(300, function () {
                        s(i).fadeIn(300).addClass("active")
                    })
                }
            })
        },
        updateJson: function (s) {
            var l = this;
            l.isHidden && (l.$gbox.html(""), l.$gubox.html(""), l._getGameData(s))
        },
        isInActive: function () {
            return this.isHidden
        },
        showGame: function () {
            var s = this;
            s.isHidden = !1, s.elm.fadeIn()
        },
        hideGame: function () {
            var s = this;
            s.isHidden = !0, s.elm.fadeOut()
        },
        _gameDimentions: function () {
            var s = this,
                l = Math.round(a.height() - 150),
                i = Math.round(a.width() - 400),
                l = i > l ? l : i,
                e = 580 > l ? l : 580;
            s.$gcontainer.animate({
                width: e + "px",
                height: e + "px",
                marginLeft: 0 - e / 2 + "px",
                marginTop: 0 - e / 2 + "px"
            })
        },
        initColorSlider: function () {
            var s = this;
            s.animating = !1, s._setUp(), s._initEvents(), s.elm.css({
                backgroundColor: "#404040"
            })
        },
        _setUp: function () {
            var l = this;
            l.$slider = s('<div id="colors"><div class="arrow-next"><span class="arrow"></span></div><div class="arrow-prev"><span class="arrow"></span></div>'), l.$sliderList = s('<ul id="color-list" />'), s.each(l.json, function (i, e) {
                var color = i.split("_").pop();
                var a = '<li class="color" data-color="#' + color + '" data-bg="' + e.bg + '"><div class="primary">';
                a += l._getAnimData(e.animation, e.shades), a += '<span style="background-color: #' + color + ';">&nbsp;</span></div></li>', l.$sliderList.append(s(a))
            }), l.$slider.append(l.$sliderList).appendTo(l.elm), l.slength = l.$sliderList.children("li").length, l.current = 0, l._setDimentions(), l._initSlider()
        },
        _initSlider: function () {
            var s = this,
                l = s.$sliderList.find("li").eq(s.current),
                i = l.data("bg");
            s.$sliderList.find("li:first").before(s.$sliderList.find("li").slice(-2)), l.addClass("active"), l.prev().addClass("prev"), l.next().addClass("next"), s.elm.animate({
                backgroundColor: "#" + i
            }, 300), s.defaultLeftPos = l.width() / 2 - l.position().left, s.$sliderList.css({
                left: s.defaultLeftPos
            }), s.current = 2
        },
        slideAnimate: function (s) {
            var l = this,
                i = l.$sliderList.find("li").eq(l.current);
            l.animating || (l.animating = !0, s ? i.addClass("animate") : i.removeClass("animate"), l.animating = !1)
        },
        slide: function (s) {
            var l = this;
            if (!l.animating) {
                l.animating = !0;
                var i = "left" == s ? l.current - 1 : l.current + 1,
                    e = l.$sliderList.find("li").eq(i),
                    a = e.data("bg");
                l.$sliderList.find("li.active").removeClass("active"), l.$sliderList.find("li.prev").removeClass("prev"), l.$sliderList.find("li.next").removeClass("next"), l.$sliderList.find("li.animate").removeClass("animate"), e.addClass("active"), e.prev().addClass("prev"), e.next().addClass("next"), l.elm.animate({
                    backgroundColor: "#" + a
                }, 300, "easeInCirc"), l.$sliderList.animate({
                    left: e.width() / 2 - e.position().left
                }, 300, "easeOutCirc", function () {
                    "left" == s ? l.$sliderList.find("li:first").before(l.$sliderList.find("li:last")) : l.$sliderList.find("li:last").after(l.$sliderList.find("li:first")), l.$sliderList.css({
                        left: l.defaultLeftPos
                    }), l.animating = !1
                })
            }
        },
        _initEvents: function () {
            var l = this;
            a.on("debouncedresize.Rangoli", function () {
                l._setDimentions()
            }), s(document).on("click", "#colors .prev span", function () {
                l.slide("left")
            }), s(document).on("click", "#colors .next span", function () {
                l.slide("right")
            }), s(document).on("mouseover", "#colors .active span", function () {
                l.slideAnimate(!0)
            }), s(document).on("mouseleave", "#colors .active .primary", function () {
                l.slideAnimate(!1)
            })
        },
        _setDimentions: function () {
            var s = this,
                l = a.height() - 230,
                i = a.width() / 2,
                e = i > l ? l : i;
            s.elm.height(l), s.$sliderList.find("li").height(e), s.$sliderList.find("li").width(i), s.$sliderList.find("li .primary").width(e), s.$sliderList.width(i * s.slength), s._fixSliderPos()
        },
        _fixSliderPos: function () {
            var s = this,
                l = s.$sliderList.find("li").eq(s.current);
            s.defaultLeftPos = l.width() / 2 - l.position().left, s.$sliderList.css({
                left: s.defaultLeftPos
            })
        },
        _getAnimData: function (s, l) {
            var i = "";
            if ("flower" == s) var i = '<div class="shades" id="anim_' + s + '"><svg version="1.1" id="' + s + '" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 432 391"><path class="shade" fill="#' + l[0] + '" d="M128.347,195.682c0-35.442-28.732-64.174-64.174-64.174C28.732,131.507,0,160.239,0,195.682 c0,35.441,28.732,64.173,64.173,64.173C99.615,259.854,128.347,231.123,128.347,195.682"/><path class="shade" fill="#' + l[1] + '" d="M172.18,271.603c-30.693-17.721-69.941-7.204-87.662,23.489c-17.721,30.693-7.204,69.941,23.489,87.662 c30.694,17.722,69.941,7.205,87.662-23.489C213.391,328.571,202.874,289.323,172.18,271.603"/><path class="shade" fill="#' + l[2] + '" d="M259.847,271.603c-30.693,17.721-41.211,56.969-23.489,87.662c17.721,30.694,56.968,41.211,87.663,23.489 c30.693-17.721,41.209-56.969,23.488-87.662S290.54,253.882,259.847,271.603"/><path class="shade" fill="#' + l[3] + '" d="M303.68,195.682c0,35.441,28.731,64.173,64.173,64.173c35.442,0,64.173-28.731,64.173-64.173 c0-35.442-28.73-64.174-64.173-64.174C332.411,131.507,303.68,160.239,303.68,195.682"/><path class="shade" fill="#' + l[4] + '" d="M259.847,119.76c30.693,17.721,69.941,7.205,87.662-23.489c17.721-30.694,7.205-69.941-23.488-87.662 c-30.695-17.722-69.942-7.205-87.663,23.489C218.636,62.791,229.153,102.04,259.847,119.76"/><path class="shade" fill="#' + l[5] + '" d="M172.18,119.76c30.694-17.72,41.211-56.969,23.489-87.662C177.947,1.404,138.701-9.113,108.006,8.609 C77.313,26.33,66.796,65.577,84.518,96.271C102.238,126.965,141.486,137.48,172.18,119.76"/></svg><svg version="1.1" class="bgsvg" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 432 391"><path class="shade" fill="#' + l[0] + '" d="M128.347,195.682c0-35.442-28.732-64.174-64.174-64.174C28.732,131.507,0,160.239,0,195.682 c0,35.441,28.732,64.173,64.173,64.173C99.615,259.854,128.347,231.123,128.347,195.682"/><path class="shade" fill="#' + l[1] + '" d="M172.18,271.603c-30.693-17.721-69.941-7.204-87.662,23.489c-17.721,30.693-7.204,69.941,23.489,87.662 c30.694,17.722,69.941,7.205,87.662-23.489C213.391,328.571,202.874,289.323,172.18,271.603"/><path class="shade" fill="#' + l[2] + '" d="M259.847,271.603c-30.693,17.721-41.211,56.969-23.489,87.662c17.721,30.694,56.968,41.211,87.663,23.489 c30.693-17.721,41.209-56.969,23.488-87.662S290.54,253.882,259.847,271.603"/><path class="shade" fill="#' + l[3] + '" d="M303.68,195.682c0,35.441,28.731,64.173,64.173,64.173c35.442,0,64.173-28.731,64.173-64.173 c0-35.442-28.73-64.174-64.173-64.174C332.411,131.507,303.68,160.239,303.68,195.682"/><path class="shade" fill="#' + l[4] + '" d="M259.847,119.76c30.693,17.721,69.941,7.205,87.662-23.489c17.721-30.694,7.205-69.941-23.488-87.662 c-30.695-17.722-69.942-7.205-87.663,23.489C218.636,62.791,229.153,102.04,259.847,119.76"/><path class="shade" fill="#' + l[5] + '" d="M172.18,119.76c30.694-17.72,41.211-56.969,23.489-87.662C177.947,1.404,138.701-9.113,108.006,8.609 C77.313,26.33,66.796,65.577,84.518,96.271C102.238,126.965,141.486,137.48,172.18,119.76"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M367.755,223.273l22.571-29.15c1.438-2.022,2.283-4.495,2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378,5.542-12.378,12.378c0-6.836-5.542-12.378-12.38-12.378 c-6.836,0-12.377,5.542-12.377,12.378c0,2.671,0.846,5.144,2.283,7.166L367.755,223.273z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M64.074,223.273l22.572-29.15c1.438-2.022,2.283-4.495,2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378c-6.836,0-12.378,5.542-12.378,12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836,0-12.378,5.542-12.378,12.378c0,2.671,0.846,5.144,2.284,7.166L64.074,223.273z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M139.995,355.957l22.572-29.15c1.438-2.021,2.283-4.495,2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378,5.542-12.378,12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836,0-12.378,5.542-12.378,12.378c0,2.671,0.846,5.145,2.284,7.166L139.995,355.957z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M291.835,355.957l22.571-29.15c1.438-2.021,2.283-4.495,2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.379,5.542-12.379,12.378c0-6.836-5.541-12.378-12.379-12.378 c-6.836,0-12.377,5.542-12.377,12.378c0,2.671,0.846,5.145,2.283,7.166L291.835,355.957z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M139.995,92.336l22.572-29.15c1.438-2.022,2.283-4.495,2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378,5.542-12.378,12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836,0-12.378,5.542-12.378,12.378c0,2.671,0.846,5.144,2.284,7.166L139.995,92.336z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M291.835,92.336l22.571-29.15c1.438-2.022,2.283-4.495,2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.379,5.542-12.379,12.378c0-6.836-5.541-12.378-12.379-12.378 c-6.836,0-12.377,5.542-12.377,12.378c0,2.671,0.846,5.144,2.283,7.166L291.835,92.336z"/></svg></div>';
            else if ("circv" == s) var i = '<div class="shades" id="anim_' + s + '"><svg version="1.1" id="' + s + '" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 431 431"><path class="shade" fill="#' + l[0] + '" d="M12.575, 287.167C42.407, 370.865, 122.049, 430.75, 215.624, 430.75V287.167H12.575z"/><path class="shade" fill="#' + l[1] + '" d="M215.624, 143.583H12.144C4.288, 166.052, 0, 190.209, 0, 215.375c0, 25.166, 4.287, 49.322, 12.144, 71.792h203.48 V143.583z"/><path class="shade" fill="#' + l[2] + '" d="M215.624, 0C122.049, 0, 42.407, 59.886, 12.575, 143.583h203.049V0z"/><path class="shade" fill="#' + l[3] + '" d="M418.674, 287.666h-203.05v143.583C309.2, 431.249, 388.841, 371.362, 418.674, 287.666"/><path class="shade" fill="#' + l[4] + '" d="M215.624, 287.666h203.482c7.854-22.47, 12.143-46.626, 12.143-71.792c0-25.167-4.288-49.323-12.143-71.792 H215.624V287.666z"/><path class="shade" fill="#' + l[5] + '" d="M418.674, 144.082C388.841, 60.383, 309.2, 0.498, 215.624, 0.498v143.584H418.674z"/></svg><svg version="1.1" class="bgsvg" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 431 431"><path class="shade" fill="#' + l[0] + '" d="M12.575, 287.167C42.407, 370.865, 122.049, 430.75, 215.624, 430.75V287.167H12.575z"/><path class="shade" fill="#' + l[1] + '" d="M215.624, 143.583H12.144C4.288, 166.052, 0, 190.209, 0, 215.375c0, 25.166, 4.287, 49.322, 12.144, 71.792h203.48 V143.583z"/><path class="shade" fill="#' + l[2] + '" d="M215.624, 0C122.049, 0, 42.407, 59.886, 12.575, 143.583h203.049V0z"/><path class="shade" fill="#' + l[3] + '" d="M418.674, 287.666h-203.05v143.583C309.2, 431.249, 388.841, 371.362, 418.674, 287.666"/><path class="shade" fill="#' + l[4] + '" d="M215.624, 287.666h203.482c7.854-22.47, 12.143-46.626, 12.143-71.792c0-25.167-4.288-49.323-12.143-71.792 H215.624V287.666z"/><path class="shade" fill="#' + l[5] + '" d="M418.674, 144.082C388.841, 60.383, 309.2, 0.498, 215.624, 0.498v143.584H418.674z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M291.794, 117.012l22.571-29.15c1.438-2.022, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378s-12.378, 5.542-12.378, 12.378 c0, 2.671, 0.846, 5.144, 2.283, 7.166L291.794, 117.012z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M138.258, 117.012l22.571-29.15c1.438-2.022, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.378, 5.542-12.378, 12.378c0, 2.671, 0.846, 5.144, 2.284, 7.166L138.258, 117.012z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M291.794, 239.722l22.571-29.15c1.438-2.021, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378s-12.378, 5.542-12.378, 12.378 c0, 2.671, 0.846, 5.145, 2.283, 7.166L291.794, 239.722z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M138.258, 239.722l22.571-29.15c1.438-2.021, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.378, 5.542-12.378, 12.378c0, 2.671, 0.846, 5.145, 2.284, 7.166L138.258, 239.722z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M291.794, 368.094l22.571-29.15c1.438-2.021, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378s-12.378, 5.542-12.378, 12.378 c0, 2.671, 0.846, 5.145, 2.283, 7.166L291.794, 368.094z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M138.258, 368.094l22.571-29.15c1.438-2.021, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.378, 5.542-12.378, 12.378c0, 2.671, 0.846, 5.145, 2.284, 7.166L138.258, 368.094z"/></svg></div>';
            else if ("circh" == s) var i = '<div class="shades" id="anim_' + s + '"><svg version="1.1" id="' + s + '" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 431 431"><path class="shade" fill="#' + l[5] + '" d="M215.624,0C96.536,0,0,96.537,0,215.626h431.248C431.248,96.537,334.706,0,215.624,0z M74.156,215.419 c0-77.689,63.244-140.669,141.265-140.669c78.017,0,141.265,62.98,141.265,140.669H74.156z"/><path class="shade" fill="#' + l[4] + '" d="M215.826,149.703c36.949,0,66.904,29.42,66.906,65.716h73.953c0-77.689-63.248-140.669-141.265-140.669 c-78.021,0-141.265,62.98-141.265,140.669h74.764C148.922,179.123,178.875,149.703,215.826,149.703z"/><path class="shade" fill="#' + l[3] + '" d="M357.089,215.626c-0.112,77.597-63.315,140.466-141.263,140.466c-77.951,0-141.15-62.869-141.263-140.466H0 C0,334.71,96.536,431.248,215.624,431.248c119.081,0,215.624-96.537,215.624-215.622H357.089z"/><path class="shade" fill="#' + l[2] + '" d="M74.561,215.419c0,77.693,63.245,140.673,141.265,140.673c78.017,0,141.266-62.98,141.266-140.673H74.561z M215.421,281.138c-36.952,0-66.906-29.421-66.906-65.716h133.813C282.327,251.717,252.371,281.138,215.421,281.138z"/><path class="shade" fill="#' + l[1] + '" d="M148.92,215.422c0-36.297,29.954-65.719,66.906-65.719c36.951,0,66.906,29.422,66.906,65.719H148.92z"/><path class="shade" fill="#' + l[0] + '" d="M282.327,215.422c0,36.295-29.956,65.716-66.906,65.716c-36.952,0-66.906-29.421-66.906-65.716H282.327z"/></svg><svg version="1.1" class="bgsvg" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 431 431"><path class="shade" fill="#' + l[5] + '" d="M215.624,0C96.536,0,0,96.537,0,215.626h431.248C431.248,96.537,334.706,0,215.624,0z M74.156,215.419 c0-77.689,63.244-140.669,141.265-140.669c78.017,0,141.265,62.98,141.265,140.669H74.156z"/><path class="shade" fill="#' + l[4] + '" d="M215.826,149.703c36.949,0,66.904,29.42,66.906,65.716h73.953c0-77.689-63.248-140.669-141.265-140.669 c-78.021,0-141.265,62.98-141.265,140.669h74.764C148.922,179.123,178.875,149.703,215.826,149.703z"/><path class="shade" fill="#' + l[3] + '" d="M357.089,215.626c-0.112,77.597-63.315,140.466-141.263,140.466c-77.951,0-141.15-62.869-141.263-140.466H0 C0,334.71,96.536,431.248,215.624,431.248c119.081,0,215.624-96.537,215.624-215.622H357.089z"/><path class="shade" fill="#' + l[2] + '" d="M74.561,215.419c0,77.693,63.245,140.673,141.265,140.673c78.017,0,141.266-62.98,141.266-140.673H74.561z M215.421,281.138c-36.952,0-66.906-29.421-66.906-65.716h133.813C282.327,251.717,252.371,281.138,215.421,281.138z"/><path class="shade" fill="#' + l[1] + '" d="M148.92,215.422c0-36.297,29.954-65.719,66.906-65.719c36.951,0,66.906,29.422,66.906,65.719H148.92z"/><path class="shade" fill="#' + l[0] + '" d="M282.327,215.422c0,36.295-29.956,65.716-66.906,65.716c-36.952,0-66.906-29.421-66.906-65.716H282.327z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M214.822,418.341l22.572-29.15c1.438-2.022,2.283-4.495,2.283-7.166 c0-6.836-5.542-12.378-12.379-12.378c-6.836,0-12.377,5.542-12.377,12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836,0-12.378,5.542-12.378,12.378c0,2.671,0.846,5.144,2.284,7.166L214.822,418.341z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M215.728,342.735l22.571-29.149c1.438-2.022,2.283-4.495,2.283-7.166 c0-6.836-5.541-12.378-12.378-12.378c-6.836,0-12.378,5.542-12.378,12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836,0-12.378,5.542-12.378,12.378c0,2.671,0.846,5.144,2.284,7.166L215.728,342.735z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M214.822,272.627l22.572-29.15c1.438-2.021,2.283-4.494,2.283-7.166 c0-6.836-5.542-12.378-12.379-12.378c-6.836,0-12.377,5.542-12.377,12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836,0-12.378,5.542-12.378,12.378c0,2.672,0.846,5.145,2.284,7.166L214.822,272.627z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M214.822,207.667l22.572-29.15c1.438-2.022,2.283-4.495,2.283-7.166 c0-6.836-5.542-12.378-12.379-12.378c-6.836,0-12.377,5.542-12.377,12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836,0-12.378,5.542-12.378,12.378c0,2.671,0.846,5.144,2.284,7.166L214.822,207.667z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M214.822,137.885l22.572-29.15c1.438-2.022,2.283-4.495,2.283-7.166 c0-6.836-5.542-12.378-12.379-12.378c-6.836,0-12.377,5.542-12.377,12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836,0-12.378,5.542-12.378,12.378c0,2.671,0.846,5.144,2.284,7.166L214.822,137.885z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M214.822,63.551l22.572-29.15c1.438-2.022,2.283-4.495,2.283-7.166 c0-6.836-5.542-12.378-12.379-12.378c-6.836,0-12.377,5.542-12.377,12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836,0-12.378,5.542-12.378,12.378c0,2.671,0.846,5.144,2.284,7.166L214.822,63.551z"/></svg></div>';
            else if ("donut" == s) var i = '<div class="shades" id="anim_' + s + '"><svg version="1.1" id="' + s + '" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 431 431"><path class="shade" fill="#' + l[0] + '" d="M290.738, 215.624L290.738, 215.624l140.51, 0.001c0-78.999-39.127-146.501-107.812-186l-70.26, 121.213 C275.626, 163.774, 290.738, 187.934, 290.738, 215.624"/><path class="shade" fill="#' + l[1] + '" d="M215.623, 140.805c13.686, 0, 26.504, 3.663, 37.554, 10.032l70.26-121.212c-68.687-39.5-146.938-39.5-215.624, 0 l70.259, 121.211C189.12, 144.468, 201.939, 140.805, 215.623, 140.805"/><path class="shade" fill="#' + l[2] + '" d="M140.509, 215.624c0-27.691, 15.114-51.849, 37.562-64.787L107.813, 29.625C39.126, 69.124, 0, 136.625, 0, 215.625 L140.509, 215.624L140.509, 215.624z"/><path class="shade" fill="#' + l[3] + '" d="M140.509, 215.625H0c0, 78.998, 39.126, 146.5, 107.813, 186l70.258-121.213 C155.623, 267.474, 140.509, 243.313, 140.509, 215.625"/><path class="shade" fill="#' + l[4] + '" d="M215.623, 290.442c-13.684, 0-26.503-3.663-37.552-10.03l-70.259, 121.212 c68.685, 39.499, 146.938, 39.499, 215.624, 0l-70.26-121.213C242.127, 286.779, 229.309, 290.442, 215.623, 290.442"/><path class="shade" fill="#' + l[5] + '" d="M290.738, 215.625c0, 27.689-15.113, 51.848-37.562, 64.786l70.26, 121.214 c68.685-39.5, 107.812-107.002, 107.812-186H290.738z"/></svg><svg version="1.1" class="bgsvg" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 431 431"><path class="shade" fill="#' + l[0] + '" d="M290.738, 215.624L290.738, 215.624l140.51, 0.001c0-78.999-39.127-146.501-107.812-186l-70.26, 121.213 C275.626, 163.774, 290.738, 187.934, 290.738, 215.624"/><path class="shade" fill="#' + l[1] + '" d="M215.623, 140.805c13.686, 0, 26.504, 3.663, 37.554, 10.032l70.26-121.212c-68.687-39.5-146.938-39.5-215.624, 0 l70.259, 121.211C189.12, 144.468, 201.939, 140.805, 215.623, 140.805"/><path class="shade" fill="#' + l[2] + '" d="M140.509, 215.624c0-27.691, 15.114-51.849, 37.562-64.787L107.813, 29.625C39.126, 69.124, 0, 136.625, 0, 215.625 L140.509, 215.624L140.509, 215.624z"/><path class="shade" fill="#' + l[3] + '" d="M140.509, 215.625H0c0, 78.998, 39.126, 146.5, 107.813, 186l70.258-121.213 C155.623, 267.474, 140.509, 243.313, 140.509, 215.625"/><path class="shade" fill="#' + l[4] + '" d="M215.623, 290.442c-13.684, 0-26.503-3.663-37.552-10.03l-70.259, 121.212 c68.685, 39.499, 146.938, 39.499, 215.624, 0l-70.26-121.213C242.127, 286.779, 229.309, 290.442, 215.623, 290.442"/><path class="shade" fill="#' + l[5] + '" d="M290.738, 215.625c0, 27.689-15.113, 51.848-37.562, 64.786l70.26, 121.214 c68.685-39.5, 107.812-107.002, 107.812-186H290.738z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M215.525, 101.105l22.572-29.15c1.438-2.022, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.379-12.378c-6.836, 0-12.377, 5.542-12.377, 12.378c0-6.836-5.543-12.378-12.379-12.378 c-6.837, 0-12.379, 5.542-12.379, 12.378c0, 2.671, 0.847, 5.144, 2.284, 7.166L215.525, 101.105z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M342.113, 176.059l22.572-29.15c1.438-2.022, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.379, 5.542-12.379, 12.378c0, 2.671, 0.847, 5.144, 2.285, 7.166L342.113, 176.059z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M88.938, 176.059l22.571-29.15c1.438-2.022, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378s-12.378, 5.542-12.378, 12.378 c0, 2.671, 0.846, 5.144, 2.283, 7.166L88.938, 176.059z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M342.113, 309.758l22.572-29.15c1.438-2.021, 2.283-4.494, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.379, 5.542-12.379, 12.378c0, 2.672, 0.847, 5.145, 2.285, 7.166L342.113, 309.758z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M215.525, 384.177l22.572-29.15c1.438-2.021, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.379-12.378c-6.836, 0-12.377, 5.542-12.377, 12.378c0-6.836-5.543-12.378-12.379-12.378 c-6.837, 0-12.379, 5.542-12.379, 12.378c0, 2.671, 0.847, 5.145, 2.284, 7.166L215.525, 384.177z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M88.938, 309.758l22.571-29.15c1.438-2.021, 2.283-4.494, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378s-12.378, 5.542-12.378, 12.378 c0, 2.672, 0.846, 5.145, 2.283, 7.166L88.938, 309.758z"/></svg></div>';
            else if ("triangle" == s) var i = '<div class="shades" id="anim_' + s + '"><svg version="1.1" id="' + s + '" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 443 401"><path class="shade" fill="#' + l[0] + '" d="M125.559, 337.724c0, 34.673-28.108, 62.78-62.78, 62.78S0, 372.396, 0, 337.724 c0-34.672, 28.107-62.779, 62.779-62.779S125.559, 303.052, 125.559, 337.724"/><path class="shade" fill="#' + l[1] + '" d="M284.203, 62.78c0, 34.672-28.107, 62.78-62.78, 62.78c-34.672, 0-62.779-28.108-62.779-62.78 C158.644, 28.108, 186.75, 0, 221.423, 0C256.096, 0, 284.203, 28.108, 284.203, 62.78"/><path class="shade" fill="#' + l[2] + '" d="M205.02, 200.252c0, 34.672-28.108, 62.779-62.78, 62.779c-34.672, 0-62.779-28.107-62.779-62.779 c0-34.673, 28.107-62.78, 62.779-62.78C176.912, 137.472, 205.02, 165.579, 205.02, 200.252"/><path class="shade" fill="#' + l[3] + '" d="M364.178, 200.252c0, 34.672-28.107, 62.779-62.779, 62.779c-34.673, 0-62.78-28.107-62.78-62.779 c0-34.673, 28.107-62.78, 62.78-62.78C336.07, 137.472, 364.178, 165.579, 364.178, 200.252"/><path class="shade" fill="#' + l[4] + '" d="M284.203, 337.724c0, 34.673-28.107, 62.78-62.78, 62.78c-34.672, 0-62.779-28.107-62.779-62.78 c0-34.672, 28.107-62.779, 62.779-62.779C256.096, 274.944, 284.203, 303.052, 284.203, 337.724"/><path class="shade" fill="#' + l[5] + '" d="M442.847, 337.724c0, 34.673-28.108, 62.78-62.78, 62.78s-62.778-28.107-62.778-62.78 c0-34.672, 28.106-62.779, 62.778-62.779S442.847, 303.052, 442.847, 337.724"/></svg><svg version="1.1" class="bgsvg" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 443 401"><path class="shade" fill="#' + l[0] + '" d="M125.559, 337.724c0, 34.673-28.108, 62.78-62.78, 62.78S0, 372.396, 0, 337.724 c0-34.672, 28.107-62.779, 62.779-62.779S125.559, 303.052, 125.559, 337.724"/><path class="shade" fill="#' + l[1] + '" d="M284.203, 62.78c0, 34.672-28.107, 62.78-62.78, 62.78c-34.672, 0-62.779-28.108-62.779-62.78 C158.644, 28.108, 186.75, 0, 221.423, 0C256.096, 0, 284.203, 28.108, 284.203, 62.78"/><path class="shade" fill="#' + l[2] + '" d="M205.02, 200.252c0, 34.672-28.108, 62.779-62.78, 62.779c-34.672, 0-62.779-28.107-62.779-62.779 c0-34.673, 28.107-62.78, 62.779-62.78C176.912, 137.472, 205.02, 165.579, 205.02, 200.252"/><path class="shade" fill="#' + l[3] + '" d="M364.178, 200.252c0, 34.672-28.107, 62.779-62.779, 62.779c-34.673, 0-62.78-28.107-62.78-62.779 c0-34.673, 28.107-62.78, 62.78-62.78C336.07, 137.472, 364.178, 165.579, 364.178, 200.252"/><path class="shade" fill="#' + l[4] + '" d="M284.203, 337.724c0, 34.673-28.107, 62.78-62.78, 62.78c-34.672, 0-62.779-28.107-62.779-62.78 c0-34.672, 28.107-62.779, 62.779-62.779C256.096, 274.944, 284.203, 303.052, 284.203, 337.724"/><path class="shade" fill="#' + l[5] + '" d="M442.847, 337.724c0, 34.673-28.108, 62.78-62.78, 62.78s-62.778-28.107-62.778-62.78 c0-34.672, 28.106-62.779, 62.778-62.779S442.847, 303.052, 442.847, 337.724"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M301.299, 228.972l22.572-29.15c1.438-2.022, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.379, 5.542-12.379, 12.378c0, 2.671, 0.847, 5.144, 2.285, 7.166L301.299, 228.972z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M142.142, 228.972l22.572-29.15c1.438-2.022, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378c-6.836, 0-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.378, 5.542-12.378, 12.378c0, 2.671, 0.846, 5.144, 2.284, 7.166L142.142, 228.972z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M221.325, 92.279l22.572-29.15c1.438-2.022, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.378, 5.542-12.378, 12.378c0, 2.671, 0.846, 5.144, 2.284, 7.166L221.325, 92.279z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M62.681, 367.085l22.572-29.15c1.438-2.021, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.378, 5.542-12.378, 12.378c0, 2.671, 0.846, 5.145, 2.284, 7.166L62.681, 367.085z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M221.325, 367.085l22.572-29.15c1.438-2.021, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.378, 5.542-12.378, 12.378c0, 2.671, 0.846, 5.145, 2.284, 7.166L221.325, 367.085z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M379.969, 367.085l22.572-29.15c1.438-2.021, 2.282-4.495, 2.282-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.378, 5.542-12.378, 12.378c0, 2.671, 0.846, 5.145, 2.284, 7.166L379.969, 367.085z"/></svg></div>';
            else if ("pie" == s) var i = '<div class="shades" id="anim_' + s + '"><svg version="1.1" id="' + s + '" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 431 431"><path class="shade" fill="#' + l[0] + '" d="M215.624, 215.625l107.812-186c68.687, 39.499, 107.813, 107.001, 107.813, 186H215.624z"/><path class="shade" fill="#' + l[1] + '" d="M215.624, 215.625l-107.812, 186c68.686, 39.498, 146.939, 39.498, 215.624, 0L215.624, 215.625z"/><path class="shade" fill="#' + l[2] + '" d="M215.624, 215.625H0c0-78.999, 39.127-146.501, 107.812-186L215.624, 215.625z"/><path class="shade" fill="#' + l[3] + '" d="M215.624, 215.625l-107.812, 186C39.127, 362.124, 0, 294.622, 0, 215.625H215.624z"/><path class="shade" fill="#' + l[4] + '" d="M215.624, 215.625l107.812-186c-68.685-39.499-146.938-39.499-215.624, 0L215.624, 215.625z"/><path class="shade" fill="#' + l[5] + '" d="M215.624, 215.625h215.624c0, 78.998-39.127, 146.5-107.813, 186L215.624, 215.625z"/></svg><svg version="1.1" class="bgsvg" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 431 431"><path class="shade" fill="#' + l[0] + '" d="M215.624, 215.625l107.812-186c68.687, 39.499, 107.813, 107.001, 107.813, 186H215.624z"/><path class="shade" fill="#' + l[1] + '" d="M215.624, 215.625l-107.812, 186c68.686, 39.498, 146.939, 39.498, 215.624, 0L215.624, 215.625z"/><path class="shade" fill="#' + l[2] + '" d="M215.624, 215.625H0c0-78.999, 39.127-146.501, 107.812-186L215.624, 215.625z"/><path class="shade" fill="#' + l[3] + '" d="M215.624, 215.625l-107.812, 186C39.127, 362.124, 0, 294.622, 0, 215.625H215.624z"/><path class="shade" fill="#' + l[4] + '" d="M215.624, 215.625l107.812-186c-68.685-39.499-146.938-39.499-215.624, 0L215.624, 215.625z"/><path class="shade" fill="#' + l[5] + '" d="M215.624, 215.625h215.624c0, 78.998-39.127, 146.5-107.813, 186L215.624, 215.625z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M214.223, 371.131l22.572-29.15c1.438-2.022, 2.283-4.495, 2.283-7.166 c0-6.836-5.543-12.378-12.379-12.378s-12.377, 5.542-12.377, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.378, 5.542-12.378, 12.378c0, 2.671, 0.846, 5.144, 2.284, 7.166L214.223, 371.131z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M323.338, 301.884l22.571-29.15c1.438-2.021, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.379, 5.542-12.379, 12.378c0-6.836-5.541-12.378-12.379-12.378 c-6.836, 0-12.377, 5.542-12.377, 12.378c0, 2.671, 0.846, 5.145, 2.283, 7.166L323.338, 301.884z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M326.345, 183.106l22.572-29.15c1.438-2.022, 2.282-4.495, 2.282-7.166 c0-6.836-5.541-12.378-12.377-12.378s-12.379, 5.542-12.379, 12.378c0-6.836-5.541-12.378-12.379-12.378 c-6.836, 0-12.378, 5.542-12.378, 12.378c0, 2.671, 0.847, 5.144, 2.284, 7.166L326.345, 183.106z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M214.223, 109.996l22.572-29.15c1.438-2.022, 2.283-4.495, 2.283-7.166 c0-6.836-5.543-12.378-12.379-12.378s-12.377, 5.542-12.377, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.378, 5.542-12.378, 12.378c0, 2.671, 0.846, 5.144, 2.284, 7.166L214.223, 109.996z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M95.992, 183.106l22.572-29.15c1.438-2.022, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378c-6.836, 0-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.378, 5.542-12.378, 12.378c0, 2.671, 0.846, 5.144, 2.284, 7.166L95.992, 183.106z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M95.992, 301.884l22.572-29.15c1.438-2.021, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378c-6.836, 0-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.378, 5.542-12.378, 12.378c0, 2.671, 0.846, 5.145, 2.284, 7.166L95.992, 301.884z"/></svg></div>';
            else if ("hexa" == s) var i = '<div class="shades" id="anim_' + s + '"><svg version="1.1" id="' + s + '" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 432 374"><polygon class="shade" fill="#' + l[0] + '" points="107.927, 373.87 215.854, 186.935 323.78, 373.87 "/><polygon class="shade" fill="#' + l[1] + '" points="323.781, 373.87 215.854, 186.935 431.708, 186.935 "/><polygon class="shade" fill="#' + l[2] + '" points="431.708, 186.935 215.854, 186.935 323.781, 0 "/><polygon class="shade" fill="#' + l[3] + '" points="323.781, 0 215.854, 186.935 107.927, 0 "/><polygon class="shade" fill="#' + l[4] + '" points="107.927, 0 215.854, 186.935 0, 186.935 "/><polygon class="shade" fill="#' + l[5] + '" points="0, 186.935 215.854, 186.935 107.927, 373.871 "/></svg><svg version="1.1" class="bgsvg" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 432 374"><polygon class="shade" fill="#' + l[0] + '" points="107.927, 373.87 215.854, 186.935 323.78, 373.87 "/><polygon class="shade" fill="#' + l[1] + '" points="323.781, 373.87 215.854, 186.935 431.708, 186.935 "/><polygon class="shade" fill="#' + l[2] + '" points="431.708, 186.935 215.854, 186.935 323.781, 0 "/><polygon class="shade" fill="#' + l[3] + '" points="323.781, 0 215.854, 186.935 107.927, 0 "/><polygon class="shade" fill="#' + l[4] + '" points="107.927, 0 215.854, 186.935 0, 186.935 "/><polygon class="shade" fill="#' + l[5] + '" points="0, 186.935 215.854, 186.935 107.927, 373.871 "/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M215.755, 333.038l22.571-29.149c1.438-2.022, 2.283-4.495, 2.283-7.166 c0-6.836-5.541-12.378-12.378-12.378c-6.836, 0-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.378, 5.542-12.378, 12.378c0, 2.671, 0.847, 5.144, 2.284, 7.166L215.755, 333.038z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M215.755, 101.479l22.571-29.15c1.438-2.022, 2.283-4.495, 2.283-7.166 c0-6.836-5.541-12.378-12.378-12.378c-6.836, 0-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.378, 5.542-12.378, 12.378c0, 2.671, 0.847, 5.144, 2.284, 7.166L215.755, 101.479z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M107.828, 155.898l22.571-29.15c1.438-2.022, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378 c-6.836, 0-12.378, 5.542-12.378, 12.378c0, 2.671, 0.846, 5.144, 2.284, 7.166L107.828, 155.898z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M116.047, 271.767l22.571-29.15c1.438-2.021, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378s-12.378, 5.542-12.378, 12.378 c0, 2.671, 0.846, 5.145, 2.283, 7.166L116.047, 271.767z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M319.91, 151.639l22.571-29.15c1.438-2.022, 2.283-4.495, 2.283-7.166 c0-6.836-5.542-12.378-12.378-12.378s-12.378, 5.542-12.378, 12.378c0-6.836-5.542-12.378-12.379-12.378s-12.378, 5.542-12.378, 12.378 c0, 2.671, 0.846, 5.144, 2.283, 7.166L319.91, 151.639z"/><path class="heart" fill="none" stroke="#FFFFFF" stroke-miterlimit="10" d="M323.682, 271.767l22.572-29.15c1.438-2.021, 2.283-4.494, 2.283-7.166 c0-6.836-5.542-12.378-12.379-12.378c-6.836, 0-12.377, 5.542-12.377, 12.378c0-6.836-5.543-12.378-12.379-12.378 c-6.837, 0-12.379, 5.542-12.379, 12.378c0, 2.672, 0.847, 5.145, 2.284, 7.166L323.682, 271.767z"/></svg></div>';
            return i
        }
    }
}(jQuery, window);
var firstTime = false;
var $activity, game;
jQuery(document).ready(function ($) {
    var $gameContainer = $('<div id="color-game"/>');
    $('body').append($gameContainer);

    /* ***** UPDATE JSON ***** */
    //game.isInActive(); // Check if game is hidden or not, returns true/false;
    //game.updateJson(new_json_object); // Update game data; will work only if game is inactive;
    var d = new Date();
    var s = d.getSeconds();
    Pace.ignore(function () {
        $.get(homeUrl + 'rangoli/get_bullzia.php?s=' + s, function (data) {
            $activity = data;
        }, 'json').done(function () {
            game = new $.Rangoli($("#color-game"), $activity);
            game.initGame();
            $(".bullzai").fadeIn();
            $('.bullzai').click(function () {

                if(logged_in==false){
                    open_bulls_popup();
                }
                else{
                    game.showGame();
                }
            });
            firstTime = true;
        });
    });
});

function get_bulls_eye() {
    var d = new Date();
    var s = d.getSeconds();
    Pace.ignore(function () {
        $.get(homeUrl + 'rangoli/get_bullzia.php?s=' + s, function (data) {
            $activity = data;
        }, 'json').done(function () {
            //setTimeout(function () {
            //Pace.ignoreURLs(get_bulls_eye());
            if (game.isInActive()) {
                game.updateJson($activity);
                //get_bulls_eye();
            }
            else {
                //get_bulls_eye();
            }
            //}, 30000);
        });
    });
}


/******************************** smogi js ********************************/
var root = homeUrl;
var color_shade;
var message;
var color;
jQuery(document).ready(function () {

    getloggedinuser2();
    jQuery(".like").click(function () {

        if ($(this).attr("author") != "not-logged") {
            var author = jQuery(this).attr("author");
            var subscriber = jQuery(this).attr("user");
            //alert(message);
            if (message == "found") {
                if (jQuery(this).hasClass("unsubscribed")) {
                    jQuery(this).find("path").css({
                        "fill": "#fff",
                        "stroke": "#fff",
                        "transition-duration": "500ms"
                    });

                    subscribe_author(author, subscriber, jQuery(this));
                }
                else {
                    unsubscribe_author(author, subscriber, jQuery(this));
                    jQuery(this).find("path").css({
                        "fill": "transparent",
                        "stroke": "#fff"
                    })
                }
                //$(".user-color-shade").css({'background': 'rgba(' + color + ',0.9)'});
            }
            else {
                //jQuery("#signing_popup").dialog( "open" );

                $("#signing_popup").fadeIn();
                $(".login-box").fadeIn();
            }
        }
        else{
            $("#signin_popup").fadeIn();
            $(".signin-block").hide();
            $(".login-box").fadeIn();
        }
    });

})


function subscribe_author(author_id, subscriber_id, obj) {
    jQuery.ajax({
        url: root + 'ys/session/updaterangolisubscribedauthorsstatus?status=active&author_id=' + author_id + '&subscriber_id=' + subscriber_id,
        type: 'POST',
        dataType: 'json',
        success: function (result) {
            if (result.message == 'success') {
                jQuery(obj).css("display", "block");
                jQuery(obj).removeClass("unsubscribed");
                jQuery(obj).addClass("subscribed");
                jQuery(".subscribed").find("path").css({
                    "fill": user_color_shade, "stroke": user_color_shade,
                    "transition-duration": "500ms"
                });
                var color = hexToRgb("#"+user_color_shade);
                $("#popup").css('background', 'rgba(' + color + ',0.5)')
//                jQuery(obj).bind('click',unsubscribe_author(author_id,subscriber_id, obj));
            }

        }
    });
}

function unsubscribe_author(author_id, subscriber_id, obj) {
    jQuery.ajax({
        url: root + 'ys/session/updaterangolisubscribedauthorsstatus?status=inactive&author_id=' + author_id + '&subscriber_id=' + subscriber_id,
        type: 'POST',
        dataType: 'json',
        success: function (result) {
            if (result.message == 'success') {
                jQuery(obj).removeClass("subscribed");
                jQuery(obj).addClass("unsubscribed");
                //jQuery(".unsubscribed").find("path").css({"fill":"transparent", "stroke":"#ffffff"});
                // jQuery(obj).bind('click',subscribe_author(author_id,subscriber_id, obj));

                var color = hexToRgb("#"+user_color_shade);
                $("#popup").css('background', 'rgba(' + color + ',0.5)')
            }

        }
    });
}


function getloggedinuser2() {
    jQuery.ajax({
        url: root + 'ys/session/getloggedrangoliprofile',
        type: 'POST',
        dataType: 'json',
        success: function (result) {
            if (result.message == 'found') {
                message = "found";
                color_shade = '#' + result.color_shade;
                color = hexToRgb(color_shade);
            }
            else {
                color_shade = "#555555";
                message = "not logged in";
            }
            jQuery(".user-color-shade").css({'background': 'rgba(' + color + ',0.9)'});
            jQuery(".color-game polygon:nth-child(2)").css("fill", color_shade);
            jQuery(".color-game polygon").css("stroke", color_shade);
            jQuery(".menu-btn rect").css("fill", color_shade);
            jQuery(".wpfp-link.remove path").css("fill", color_shade).css("stroke", color_shade);
            jQuery(".subscribed").find("path").css({"fill": color_shade, "stroke": color_shade});
            jQuery(".overlay-cover").css({"background": color_shade});
            jQuery(".invite-friends").css({"background": color_shade});
        }
    });
}
function hexToRgb(h) {
    var r = parseInt((cutHex(h)).substring(0, 2), 16);
    var g = parseInt((cutHex(h)).substring(2, 4), 16);
    var b = parseInt((cutHex(h)).substring(4, 6), 16);
    return r + ',' + g + ',' + b;
    function cutHex(h) {
        var i = h;
        if (h == undefined) {
            i = "#555555";
        }
        return (i.charAt(0) == "#") ? i.substring(1, 7) : i;
    }
}

/**************************** jquery jraty *****************************************/
/*!
 * jQuery Raty - A Star Rating Plugin
 *
 * The MIT License
 *
 * @author  : Washington Botelho
 * @doc     : http://wbotelhos.com/raty
 * @version : 2.7.0
 *
 */

;
(function($) {
    'use strict';

    var methods = {
        init: function(options) {
            return this.each(function() {
                this.self = $(this);

                methods.destroy.call(this.self);

                this.opt = $.extend(true, {}, $.fn.raty.defaults, options);

                methods._adjustCallback.call(this);
                methods._adjustNumber.call(this);
                methods._adjustHints.call(this);

                this.opt.score = methods._adjustedScore.call(this, this.opt.score);

                if (this.opt.starType !== 'img') {
                    methods._adjustStarType.call(this);
                }

                methods._adjustPath.call(this);
                methods._createStars.call(this);

                if (this.opt.cancel) {
                    methods._createCancel.call(this);
                }

                if (this.opt.precision) {
                    methods._adjustPrecision.call(this);
                }

                methods._createScore.call(this);
                methods._apply.call(this, this.opt.score);
                methods._setTitle.call(this, this.opt.score);
                methods._target.call(this, this.opt.score);

                if (this.opt.readOnly) {
                    methods._lock.call(this);
                } else {
                    this.style.cursor = 'pointer';

                    methods._binds.call(this);
                }
            });
        },

        _adjustCallback: function() {
            var options = ['number', 'readOnly', 'score', 'scoreName', 'target'];

            for (var i = 0; i < options.length; i++) {
                if (typeof this.opt[options[i]] === 'function') {
                    this.opt[options[i]] = this.opt[options[i]].call(this);
                }
            }
        },

        _adjustedScore: function(score) {
            if (!score) {
                return score;
            }

            return methods._between(score, 0, this.opt.number);
        },

        _adjustHints: function() {
            if (!this.opt.hints) {
                this.opt.hints = [];
            }

            if (!this.opt.halfShow && !this.opt.half) {
                return;
            }

            var steps = this.opt.precision ? 10 : 2;

            for (var i = 0; i < this.opt.number; i++) {
                var group = this.opt.hints[i];

                if (Object.prototype.toString.call(group) !== '[object Array]') {
                    group = [group];
                }

                this.opt.hints[i] = [];

                for (var j = 0; j < steps; j++) {
                    var
                        hint = group[j],
                        last = group[group.length - 1];

                    if (last === undefined) {
                        last = null;
                    }

                    this.opt.hints[i][j] = hint === undefined ? last : hint;
                }
            }
        },

        _adjustNumber: function() {
            this.opt.number = methods._between(this.opt.number, 1, this.opt.numberMax);
        },

        _adjustPath: function() {
            this.opt.path = this.opt.path || '';

            if (this.opt.path && this.opt.path.charAt(this.opt.path.length - 1) !== '/') {
                this.opt.path += '/';
            }
        },

        _adjustPrecision: function() {
            this.opt.half = true;
        },

        _adjustStarType: function() {
            var replaces = ['cancelOff', 'cancelOn', 'starHalf', 'starOff', 'starOn'];

            this.opt.path = '';

            for (var i = 0; i < replaces.length; i++) {
                this.opt[replaces[i]] = this.opt[replaces[i]].replace('.', '-');
            }
        },

        _apply: function(score) {
            methods._fill.call(this, score);

            if (score) {
                if (score > 0) {
                    this.score.val(score);
                }

                methods._roundStars.call(this, score);
            }
        },

        _between: function(value, min, max) {
            return Math.min(Math.max(parseFloat(value), min), max);
        },

        _binds: function() {
            if (this.cancel) {
                methods._bindOverCancel.call(this);
                methods._bindClickCancel.call(this);
                methods._bindOutCancel.call(this);
            }

            methods._bindOver.call(this);
            methods._bindClick.call(this);
            methods._bindOut.call(this);
        },

        _bindClick: function() {
            var that = this;

            that.stars.on('click.raty', function(evt) {
                var
                    execute = true,
                    score   = (that.opt.half || that.opt.precision) ? that.self.data('score') : (this.alt || $(this).data('alt'));

                if (that.opt.click) {
                    execute = that.opt.click.call(that, +score, evt);
                }

                if (execute || execute === undefined) {
                    if (that.opt.half && !that.opt.precision) {
                        score = methods._roundHalfScore.call(that, score);
                    }

                    methods._apply.call(that, score);
                }
            });
        },

        _bindClickCancel: function() {
            var that = this;

            that.cancel.on('click.raty', function(evt) {
                that.score.removeAttr('value');

                if (that.opt.click) {
                    that.opt.click.call(that, null, evt);
                }
            });
        },

        _bindOut: function() {
            var that = this;

            that.self.on('mouseleave.raty', function(evt) {
                var score = +that.score.val() || undefined;

                methods._apply.call(that, score);
                methods._target.call(that, score, evt);
                methods._resetTitle.call(that);

                if (that.opt.mouseout) {
                    that.opt.mouseout.call(that, score, evt);
                }
            });
        },

        _bindOutCancel: function() {
            var that = this;

            that.cancel.on('mouseleave.raty', function(evt) {
                var icon = that.opt.cancelOff;

                if (that.opt.starType !== 'img') {
                    icon = that.opt.cancelClass + ' ' + icon;
                }

                methods._setIcon.call(that, this, icon);

                if (that.opt.mouseout) {
                    var score = +that.score.val() || undefined;

                    that.opt.mouseout.call(that, score, evt);
                }
            });
        },

        _bindOver: function() {
            var that   = this,
                action = that.opt.half ? 'mousemove.raty' : 'mouseover.raty';

            that.stars.on(action, function(evt) {
                var score = methods._getScoreByPosition.call(that, evt, this);

                methods._fill.call(that, score);

                if (that.opt.half) {
                    methods._roundStars.call(that, score, evt);
                    methods._setTitle.call(that, score, evt);

                    that.self.data('score', score);
                }

                methods._target.call(that, score, evt);

                if (that.opt.mouseover) {
                    that.opt.mouseover.call(that, score, evt);
                }
            });
        },

        _bindOverCancel: function() {
            var that = this;

            that.cancel.on('mouseover.raty', function(evt) {
                var
                    starOff = that.opt.path + that.opt.starOff,
                    icon    = that.opt.cancelOn;

                if (that.opt.starType === 'img') {
                    that.stars.attr('src', starOff);
                } else {
                    icon = that.opt.cancelClass + ' ' + icon;

                    that.stars.attr('class', starOff);
                }

                methods._setIcon.call(that, this, icon);
                methods._target.call(that, null, evt);

                if (that.opt.mouseover) {
                    that.opt.mouseover.call(that, null);
                }
            });
        },

        _buildScoreField: function() {
            return $('<input />', { name: this.opt.scoreName, type: 'hidden' }).appendTo(this);
        },

        _createCancel: function() {
            var icon   = this.opt.path + this.opt.cancelOff,
                cancel = $('<' + this.opt.starType + ' />', { title: this.opt.cancelHint, 'class': this.opt.cancelClass });

            if (this.opt.starType === 'img') {
                cancel.attr({ src: icon, alt: 'x' });
            } else {
                // TODO: use $.data
                cancel.attr('data-alt', 'x').addClass(icon);
            }

            if (this.opt.cancelPlace === 'left') {
                this.self.prepend('&#160;').prepend(cancel);
            } else {
                this.self.append('&#160;').append(cancel);
            }

            this.cancel = cancel;
        },

        _createScore: function() {
            var score = $(this.opt.targetScore);

            this.score = score.length ? score : methods._buildScoreField.call(this);
        },

        _createStars: function() {
            for (var i = 1; i <= this.opt.number; i++) {
                var
                    name  = methods._nameForIndex.call(this, i),
                    attrs = { alt: i, src: this.opt.path + this.opt[name] };

                if (this.opt.starType !== 'img') {
                    attrs = { 'data-alt': i, 'class': attrs.src }; // TODO: use $.data.
                }

                attrs.title = methods._getHint.call(this, i);

                $('<' + this.opt.starType + ' />', attrs).appendTo(this);

                if (this.opt.space) {
                    this.self.append(i < this.opt.number ? '&#160;' : '');
                }
            }

            this.stars = this.self.children(this.opt.starType);
        },

        _error: function(message) {
            $(this).text(message);

            $.error(message);
        },

        _fill: function(score) {
            var hash = 0;

            for (var i = 1; i <= this.stars.length; i++) {
                var
                    icon,
                    star   = this.stars[i - 1],
                    turnOn = methods._turnOn.call(this, i, score);

                if (this.opt.iconRange && this.opt.iconRange.length > hash) {
                    var irange = this.opt.iconRange[hash];

                    icon = methods._getRangeIcon.call(this, irange, turnOn);

                    if (i <= irange.range) {
                        methods._setIcon.call(this, star, icon);
                    }

                    if (i === irange.range) {
                        hash++;
                    }
                } else {
                    icon = this.opt[turnOn ? 'starOn' : 'starOff'];

                    methods._setIcon.call(this, star, icon);
                }
            }
        },

        _getFirstDecimal: function(number) {
            var
                decimal = number.toString().split('.')[1],
                result  = 0;

            if (decimal) {
                result = parseInt(decimal.charAt(0), 10);

                if (decimal.slice(1, 5) === '9999') {
                    result++;
                }
            }

            return result;
        },

        _getRangeIcon: function(irange, turnOn) {
            return turnOn ? irange.on || this.opt.starOn : irange.off || this.opt.starOff;
        },

        _getScoreByPosition: function(evt, icon) {
            var score = parseInt(icon.alt || icon.getAttribute('data-alt'), 10);

            if (this.opt.half) {
                var
                    size    = methods._getWidth.call(this),
                    percent = parseFloat((evt.pageX - $(icon).offset().left) / size);

                score = score - 1 + percent;
            }

            return score;
        },

        _getHint: function(score, evt) {
            if (score !== 0 && !score) {
                return this.opt.noRatedMsg;
            }

            var
                decimal = methods._getFirstDecimal.call(this, score),
                integer = Math.ceil(score),
                group   = this.opt.hints[(integer || 1) - 1],
                hint    = group,
                set     = !evt || this.move;

            if (this.opt.precision) {
                if (set) {
                    decimal = decimal === 0 ? 9 : decimal - 1;
                }

                hint = group[decimal];
            } else if (this.opt.halfShow || this.opt.half) {
                decimal = set && decimal === 0 ? 1 : decimal > 5 ? 1 : 0;

                hint = group[decimal];
            }

            return hint === '' ? '' : hint || score;
        },

        _getWidth: function() {
            var width = this.stars[0].width || parseFloat(this.stars.eq(0).css('font-size'));

            if (!width) {
                methods._error.call(this, 'Could not get the icon width!');
            }

            return width;
        },

        _lock: function() {
            var hint = methods._getHint.call(this, this.score.val());

            this.style.cursor = '';
            this.title        = hint;

            this.score.prop('readonly', true);
            this.stars.prop('title', hint);

            if (this.cancel) {
                this.cancel.hide();
            }

            this.self.data('readonly', true);
        },

        _nameForIndex: function(i) {
            return this.opt.score && this.opt.score >= i ? 'starOn' : 'starOff';
        },

        _resetTitle: function(star) {
            for (var i = 0; i < this.opt.number; i++) {
                this.stars[i].title = methods._getHint.call(this, i + 1);
            }
        },

        _roundHalfScore: function(score) {
            var integer = parseInt(score, 10),
                decimal = methods._getFirstDecimal.call(this, score);

            if (decimal !== 0) {
                decimal = decimal > 5 ? 1 : 0.5;
            }

            return integer + decimal;
        },

        _roundStars: function(score, evt) {
            var
                decimal = (score % 1).toFixed(2),
                name    ;

            if (evt || this.move) {
                name = decimal > 0.5 ? 'starOn' : 'starHalf';
            } else if (decimal > this.opt.round.down) {               // Up:   [x.76 .. x.99]
                name = 'starOn';

                if (this.opt.halfShow && decimal < this.opt.round.up) { // Half: [x.26 .. x.75]
                    name = 'starHalf';
                } else if (decimal < this.opt.round.full) {             // Down: [x.00 .. x.5]
                    name = 'starOff';
                }
            }

            if (name) {
                var
                    icon = this.opt[name],
                    star = this.stars[Math.ceil(score) - 1];

                methods._setIcon.call(this, star, icon);
            }                                                         // Full down: [x.00 .. x.25]
        },

        _setIcon: function(star, icon) {
            star[this.opt.starType === 'img' ? 'src' : 'className'] = this.opt.path + icon;
        },

        _setTarget: function(target, score) {
            if (score) {
                score = this.opt.targetFormat.toString().replace('{score}', score);
            }

            if (target.is(':input')) {
                target.val(score);
            } else {
                target.html(score);
            }
        },

        _setTitle: function(score, evt) {
            if (score) {
                var
                    integer = parseInt(Math.ceil(score), 10),
                    star    = this.stars[integer - 1];

                star.title = methods._getHint.call(this, score, evt);
            }
        },

        _target: function(score, evt) {
            if (this.opt.target) {
                var target = $(this.opt.target);

                if (!target.length) {
                    methods._error.call(this, 'Target selector invalid or missing!');
                }

                var mouseover = evt && evt.type === 'mouseover';

                if (score === undefined) {
                    score = this.opt.targetText;
                } else if (score === null) {
                    score = mouseover ? this.opt.cancelHint : this.opt.targetText;
                } else {
                    if (this.opt.targetType === 'hint') {
                        score = methods._getHint.call(this, score, evt);
                    } else if (this.opt.precision) {
                        score = parseFloat(score).toFixed(1);
                    }

                    var mousemove = evt && evt.type === 'mousemove';

                    if (!mouseover && !mousemove && !this.opt.targetKeep) {
                        score = this.opt.targetText;
                    }
                }

                methods._setTarget.call(this, target, score);
            }
        },

        _turnOn: function(i, score) {
            return this.opt.single ? (i === score) : (i <= score);
        },

        _unlock: function() {
            this.style.cursor = 'pointer';
            this.removeAttribute('title');

            this.score.removeAttr('readonly');

            this.self.data('readonly', false);

            for (var i = 0; i < this.opt.number; i++) {
                this.stars[i].title = methods._getHint.call(this, i + 1);
            }

            if (this.cancel) {
                this.cancel.css('display', '');
            }
        },

        cancel: function(click) {
            return this.each(function() {
                var self = $(this);

                if (self.data('readonly') !== true) {
                    methods[click ? 'click' : 'score'].call(self, null);

                    this.score.removeAttr('value');
                }
            });
        },

        click: function(score) {
            return this.each(function() {
                if ($(this).data('readonly') !== true) {
                    score = methods._adjustedScore.call(this, score);

                    methods._apply.call(this, score);

                    if (this.opt.click) {
                        this.opt.click.call(this, score, $.Event('click'));
                    }

                    methods._target.call(this, score);
                }
            });
        },

        destroy: function() {
            return this.each(function() {
                var self = $(this),
                    raw  = self.data('raw');

                if (raw) {
                    self.off('.raty').empty().css({ cursor: raw.style.cursor }).removeData('readonly');
                } else {
                    self.data('raw', self.clone()[0]);
                }
            });
        },

        getScore: function() {
            var score = [],
                value ;

            this.each(function() {
                value = this.score.val();

                score.push(value ? +value : undefined);
            });

            return (score.length > 1) ? score : score[0];
        },

        move: function(score) {
            return this.each(function() {
                var
                    integer  = parseInt(score, 10),
                    decimal  = methods._getFirstDecimal.call(this, score);

                if (integer >= this.opt.number) {
                    integer = this.opt.number - 1;
                    decimal = 10;
                }

                var
                    width   = methods._getWidth.call(this),
                    steps   = width / 10,
                    star    = $(this.stars[integer]),
                    percent = star.offset().left + steps * decimal,
                    evt     = $.Event('mousemove', { pageX: percent });

                this.move = true;

                star.trigger(evt);

                this.move = false;
            });
        },

        readOnly: function(readonly) {
            return this.each(function() {
                var self = $(this);

                if (self.data('readonly') !== readonly) {
                    if (readonly) {
                        self.off('.raty').children('img').off('.raty');

                        methods._lock.call(this);
                    } else {
                        methods._binds.call(this);
                        methods._unlock.call(this);
                    }

                    self.data('readonly', readonly);
                }
            });
        },

        reload: function() {
            return methods.set.call(this, {});
        },

        score: function() {
            var self = $(this);

            return arguments.length ? methods.setScore.apply(self, arguments) : methods.getScore.call(self);
        },

        set: function(options) {
            return this.each(function() {
                $(this).raty($.extend({}, this.opt, options));
            });
        },

        setScore: function(score) {
            return this.each(function() {
                if ($(this).data('readonly') !== true) {
                    score = methods._adjustedScore.call(this, score);

                    methods._apply.call(this, score);
                    methods._target.call(this, score);
                }
            });
        }
    };

    $.fn.raty = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist!');
        }
    };

    $.fn.raty.defaults = {
        cancel       : false,
        cancelClass  : 'raty-cancel',
        cancelHint   : 'Cancel this rating!',
        cancelOff    : 'cancel-off.png',
        cancelOn     : 'cancel-on.png',
        cancelPlace  : 'left',
        click        : undefined,
        half         : false,
        halfShow     : true,
        hints        : ['bad', 'poor', 'regular', 'good', 'gorgeous'],
        iconRange    : undefined,
        mouseout     : undefined,
        mouseover    : undefined,
        noRatedMsg   : 'Not rated yet!',
        number       : 5,
        numberMax    : 20,
        path         : undefined,
        precision    : false,
        readOnly     : false,
        round        : { down: 0.25, full: 0.6, up: 0.76 },
        score        : undefined,
        scoreName    : 'score',
        single       : false,
        space        : true,
        starHalf     : 'star-half.png',
        starOff      : 'star-off.png',
        starOn       : 'star-on.png',
        starType     : 'img',
        target       : undefined,
        targetFormat : '{score}',
        targetKeep   : false,
        targetScore  : undefined,
        targetText   : '',
        targetType   : 'hint'
    };

})(jQuery);

/***************** ajaxify js logic ***********/

$(document).ready(function(){
    $(".smogi-content .author-link").click(function(e){
        e.preventDefault();
        $(".close-popup").click();
        var link = $(this).attr("href");
        $(".close-popup").click();
        ajax_load_pages(link);
    });
    $(".about-rangoli a").click(function(e){
        e.preventDefault();
        $(".close-menu-btn").click();
        $(".close-popup").click();
        var link = $(this).attr("href");
        ajax_load_pages(link);
    });

    $(document).find(".ajax-load").click(function(e){
        e.preventDefault();
        //alert();
        $(".close-menu-btn").click();
        $(".close-popup").click();
        var link = $(this).attr("href");
        ajax_load_pages(link);
    });

    $(".liked-ajax-load").click(function(e){
        e.preventDefault();
        $(".close-menu-btn").click();
        $(".close-popup").click();
        var link = $(this).attr("href");
        ajax_load_pages(link);
    });
    $(".back_to_parent").click(function(e){
        e.preventDefault();
        $(".close-menu-btn").click();
        $(".close-popup").click();
        var link = $(this).attr("href");
        ajax_load_pages(link);
    });
});


/************************ zero clipboard js *********************************/
/*!
 * ZeroClipboard
 * The ZeroClipboard library provides an easy way to copy text to the clipboard using an invisible Adobe Flash movie and a JavaScript interface.
 * Copyright (c) 2009-2014 Jon Rohan, James M. Greene
 * Licensed MIT
 * http://zeroclipboard.org/
 * v2.2.0
 */
!function(a,b){"use strict";var c,d,e,f=a,g=f.document,h=f.navigator,i=f.setTimeout,j=f.clearTimeout,k=f.setInterval,l=f.clearInterval,m=f.getComputedStyle,n=f.encodeURIComponent,o=f.ActiveXObject,p=f.Error,q=f.Number.parseInt||f.parseInt,r=f.Number.parseFloat||f.parseFloat,s=f.Number.isNaN||f.isNaN,t=f.Date.now,u=f.Object.keys,v=f.Object.defineProperty,w=f.Object.prototype.hasOwnProperty,x=f.Array.prototype.slice,y=function(){var a=function(a){return a};if("function"==typeof f.wrap&&"function"==typeof f.unwrap)try{var b=g.createElement("div"),c=f.unwrap(b);1===b.nodeType&&c&&1===c.nodeType&&(a=f.unwrap)}catch(d){}return a}(),z=function(a){return x.call(a,0)},A=function(){var a,c,d,e,f,g,h=z(arguments),i=h[0]||{};for(a=1,c=h.length;c>a;a++)if(null!=(d=h[a]))for(e in d)w.call(d,e)&&(f=i[e],g=d[e],i!==g&&g!==b&&(i[e]=g));return i},B=function(a){var b,c,d,e;if("object"!=typeof a||null==a||"number"==typeof a.nodeType)b=a;else if("number"==typeof a.length)for(b=[],c=0,d=a.length;d>c;c++)w.call(a,c)&&(b[c]=B(a[c]));else{b={};for(e in a)w.call(a,e)&&(b[e]=B(a[e]))}return b},C=function(a,b){for(var c={},d=0,e=b.length;e>d;d++)b[d]in a&&(c[b[d]]=a[b[d]]);return c},D=function(a,b){var c={};for(var d in a)-1===b.indexOf(d)&&(c[d]=a[d]);return c},E=function(a){if(a)for(var b in a)w.call(a,b)&&delete a[b];return a},F=function(a,b){if(a&&1===a.nodeType&&a.ownerDocument&&b&&(1===b.nodeType&&b.ownerDocument&&b.ownerDocument===a.ownerDocument||9===b.nodeType&&!b.ownerDocument&&b===a.ownerDocument))do{if(a===b)return!0;a=a.parentNode}while(a);return!1},G=function(a){var b;return"string"==typeof a&&a&&(b=a.split("#")[0].split("?")[0],b=a.slice(0,a.lastIndexOf("/")+1)),b},H=function(a){var b,c;return"string"==typeof a&&a&&(c=a.match(/^(?:|[^:@]*@|.+\)@(?=http[s]?|file)|.+?\s+(?: at |@)(?:[^:\(]+ )*[\(]?)((?:http[s]?|file):\/\/[\/]?.+?\/[^:\)]*?)(?::\d+)(?::\d+)?/),c&&c[1]?b=c[1]:(c=a.match(/\)@((?:http[s]?|file):\/\/[\/]?.+?\/[^:\)]*?)(?::\d+)(?::\d+)?/),c&&c[1]&&(b=c[1]))),b},I=function(){var a,b;try{throw new p}catch(c){b=c}return b&&(a=b.sourceURL||b.fileName||H(b.stack)),a},J=function(){var a,c,d;if(g.currentScript&&(a=g.currentScript.src))return a;if(c=g.getElementsByTagName("script"),1===c.length)return c[0].src||b;if("readyState"in c[0])for(d=c.length;d--;)if("interactive"===c[d].readyState&&(a=c[d].src))return a;return"loading"===g.readyState&&(a=c[c.length-1].src)?a:(a=I())?a:b},K=function(){var a,c,d,e=g.getElementsByTagName("script");for(a=e.length;a--;){if(!(d=e[a].src)){c=null;break}if(d=G(d),null==c)c=d;else if(c!==d){c=null;break}}return c||b},L=function(){var a=G(J())||K()||"";return a+"ZeroClipboard.swf"},M=function(){return null==a.opener&&(!!a.top&&a!=a.top||!!a.parent&&a!=a.parent)}(),N={bridge:null,version:"0.0.0",pluginType:"unknown",disabled:null,outdated:null,sandboxed:null,unavailable:null,degraded:null,deactivated:null,overdue:null,ready:null},O="11.0.0",P={},Q={},R=null,S=0,T=0,U={ready:"Flash communication is established",error:{"flash-disabled":"Flash is disabled or not installed. May also be attempting to run Flash in a sandboxed iframe, which is impossible.","flash-outdated":"Flash is too outdated to support ZeroClipboard","flash-sandboxed":"Attempting to run Flash in a sandboxed iframe, which is impossible","flash-unavailable":"Flash is unable to communicate bidirectionally with JavaScript","flash-degraded":"Flash is unable to preserve data fidelity when communicating with JavaScript","flash-deactivated":"Flash is too outdated for your browser and/or is configured as click-to-activate.\nThis may also mean that the ZeroClipboard SWF object could not be loaded, so please check your `swfPath` configuration and/or network connectivity.\nMay also be attempting to run Flash in a sandboxed iframe, which is impossible.","flash-overdue":"Flash communication was established but NOT within the acceptable time limit","version-mismatch":"ZeroClipboard JS version number does not match ZeroClipboard SWF version number","clipboard-error":"At least one error was thrown while ZeroClipboard was attempting to inject your data into the clipboard","config-mismatch":"ZeroClipboard configuration does not match Flash's reality","swf-not-found":"The ZeroClipboard SWF object could not be loaded, so please check your `swfPath` configuration and/or network connectivity"}},V=["flash-unavailable","flash-degraded","flash-overdue","version-mismatch","config-mismatch","clipboard-error"],W=["flash-disabled","flash-outdated","flash-sandboxed","flash-unavailable","flash-degraded","flash-deactivated","flash-overdue"],X=new RegExp("^flash-("+W.map(function(a){return a.replace(/^flash-/,"")}).join("|")+")$"),Y=new RegExp("^flash-("+W.slice(1).map(function(a){return a.replace(/^flash-/,"")}).join("|")+")$"),Z={swfPath:L(),trustedDomains:a.location.host?[a.location.host]:[],cacheBust:!0,forceEnhancedClipboard:!1,flashLoadTimeout:3e4,autoActivate:!0,bubbleEvents:!0,containerId:"global-zeroclipboard-html-bridge",containerClass:"global-zeroclipboard-container",swfObjectId:"global-zeroclipboard-flash-bridge",hoverClass:"zeroclipboard-is-hover",activeClass:"zeroclipboard-is-active",forceHandCursor:!1,title:null,zIndex:999999999},$=function(a){if("object"==typeof a&&null!==a)for(var b in a)if(w.call(a,b))if(/^(?:forceHandCursor|title|zIndex|bubbleEvents)$/.test(b))Z[b]=a[b];else if(null==N.bridge)if("containerId"===b||"swfObjectId"===b){if(!nb(a[b]))throw new Error("The specified `"+b+"` value is not valid as an HTML4 Element ID");Z[b]=a[b]}else Z[b]=a[b];{if("string"!=typeof a||!a)return B(Z);if(w.call(Z,a))return Z[a]}},_=function(){return Tb(),{browser:C(h,["userAgent","platform","appName"]),flash:D(N,["bridge"]),zeroclipboard:{version:Vb.version,config:Vb.config()}}},ab=function(){return!!(N.disabled||N.outdated||N.sandboxed||N.unavailable||N.degraded||N.deactivated)},bb=function(a,d){var e,f,g,h={};if("string"==typeof a&&a)g=a.toLowerCase().split(/\s+/);else if("object"==typeof a&&a&&"undefined"==typeof d)for(e in a)w.call(a,e)&&"string"==typeof e&&e&&"function"==typeof a[e]&&Vb.on(e,a[e]);if(g&&g.length){for(e=0,f=g.length;f>e;e++)a=g[e].replace(/^on/,""),h[a]=!0,P[a]||(P[a]=[]),P[a].push(d);if(h.ready&&N.ready&&Vb.emit({type:"ready"}),h.error){for(e=0,f=W.length;f>e;e++)if(N[W[e].replace(/^flash-/,"")]===!0){Vb.emit({type:"error",name:W[e]});break}c!==b&&Vb.version!==c&&Vb.emit({type:"error",name:"version-mismatch",jsVersion:Vb.version,swfVersion:c})}}return Vb},cb=function(a,b){var c,d,e,f,g;if(0===arguments.length)f=u(P);else if("string"==typeof a&&a)f=a.split(/\s+/);else if("object"==typeof a&&a&&"undefined"==typeof b)for(c in a)w.call(a,c)&&"string"==typeof c&&c&&"function"==typeof a[c]&&Vb.off(c,a[c]);if(f&&f.length)for(c=0,d=f.length;d>c;c++)if(a=f[c].toLowerCase().replace(/^on/,""),g=P[a],g&&g.length)if(b)for(e=g.indexOf(b);-1!==e;)g.splice(e,1),e=g.indexOf(b,e);else g.length=0;return Vb},db=function(a){var b;return b="string"==typeof a&&a?B(P[a])||null:B(P)},eb=function(a){var b,c,d;return a=ob(a),a&&!vb(a)?"ready"===a.type&&N.overdue===!0?Vb.emit({type:"error",name:"flash-overdue"}):(b=A({},a),tb.call(this,b),"copy"===a.type&&(d=Db(Q),c=d.data,R=d.formatMap),c):void 0},fb=function(){var a=N.sandboxed;if(Tb(),"boolean"!=typeof N.ready&&(N.ready=!1),N.sandboxed!==a&&N.sandboxed===!0)N.ready=!1,Vb.emit({type:"error",name:"flash-sandboxed"});else if(!Vb.isFlashUnusable()&&null===N.bridge){var b=Z.flashLoadTimeout;"number"==typeof b&&b>=0&&(S=i(function(){"boolean"!=typeof N.deactivated&&(N.deactivated=!0),N.deactivated===!0&&Vb.emit({type:"error",name:"flash-deactivated"})},b)),N.overdue=!1,Bb()}},gb=function(){Vb.clearData(),Vb.blur(),Vb.emit("destroy"),Cb(),Vb.off()},hb=function(a,b){var c;if("object"==typeof a&&a&&"undefined"==typeof b)c=a,Vb.clearData();else{if("string"!=typeof a||!a)return;c={},c[a]=b}for(var d in c)"string"==typeof d&&d&&w.call(c,d)&&"string"==typeof c[d]&&c[d]&&(Q[d]=c[d])},ib=function(a){"undefined"==typeof a?(E(Q),R=null):"string"==typeof a&&w.call(Q,a)&&delete Q[a]},jb=function(a){return"undefined"==typeof a?B(Q):"string"==typeof a&&w.call(Q,a)?Q[a]:void 0},kb=function(a){if(a&&1===a.nodeType){d&&(Lb(d,Z.activeClass),d!==a&&Lb(d,Z.hoverClass)),d=a,Kb(a,Z.hoverClass);var b=a.getAttribute("title")||Z.title;if("string"==typeof b&&b){var c=Ab(N.bridge);c&&c.setAttribute("title",b)}var e=Z.forceHandCursor===!0||"pointer"===Mb(a,"cursor");Rb(e),Qb()}},lb=function(){var a=Ab(N.bridge);a&&(a.removeAttribute("title"),a.style.left="0px",a.style.top="-9999px",a.style.width="1px",a.style.height="1px"),d&&(Lb(d,Z.hoverClass),Lb(d,Z.activeClass),d=null)},mb=function(){return d||null},nb=function(a){return"string"==typeof a&&a&&/^[A-Za-z][A-Za-z0-9_:\-\.]*$/.test(a)},ob=function(a){var b;if("string"==typeof a&&a?(b=a,a={}):"object"==typeof a&&a&&"string"==typeof a.type&&a.type&&(b=a.type),b){b=b.toLowerCase(),!a.target&&(/^(copy|aftercopy|_click)$/.test(b)||"error"===b&&"clipboard-error"===a.name)&&(a.target=e),A(a,{type:b,target:a.target||d||null,relatedTarget:a.relatedTarget||null,currentTarget:N&&N.bridge||null,timeStamp:a.timeStamp||t()||null});var c=U[a.type];return"error"===a.type&&a.name&&c&&(c=c[a.name]),c&&(a.message=c),"ready"===a.type&&A(a,{target:null,version:N.version}),"error"===a.type&&(X.test(a.name)&&A(a,{target:null,minimumVersion:O}),Y.test(a.name)&&A(a,{version:N.version})),"copy"===a.type&&(a.clipboardData={setData:Vb.setData,clearData:Vb.clearData}),"aftercopy"===a.type&&(a=Eb(a,R)),a.target&&!a.relatedTarget&&(a.relatedTarget=pb(a.target)),qb(a)}},pb=function(a){var b=a&&a.getAttribute&&a.getAttribute("data-clipboard-target");return b?g.getElementById(b):null},qb=function(a){if(a&&/^_(?:click|mouse(?:over|out|down|up|move))$/.test(a.type)){var c=a.target,d="_mouseover"===a.type&&a.relatedTarget?a.relatedTarget:b,e="_mouseout"===a.type&&a.relatedTarget?a.relatedTarget:b,h=Nb(c),i=f.screenLeft||f.screenX||0,j=f.screenTop||f.screenY||0,k=g.body.scrollLeft+g.documentElement.scrollLeft,l=g.body.scrollTop+g.documentElement.scrollTop,m=h.left+("number"==typeof a._stageX?a._stageX:0),n=h.top+("number"==typeof a._stageY?a._stageY:0),o=m-k,p=n-l,q=i+o,r=j+p,s="number"==typeof a.movementX?a.movementX:0,t="number"==typeof a.movementY?a.movementY:0;delete a._stageX,delete a._stageY,A(a,{srcElement:c,fromElement:d,toElement:e,screenX:q,screenY:r,pageX:m,pageY:n,clientX:o,clientY:p,x:o,y:p,movementX:s,movementY:t,offsetX:0,offsetY:0,layerX:0,layerY:0})}return a},rb=function(a){var b=a&&"string"==typeof a.type&&a.type||"";return!/^(?:(?:before)?copy|destroy)$/.test(b)},sb=function(a,b,c,d){d?i(function(){a.apply(b,c)},0):a.apply(b,c)},tb=function(a){if("object"==typeof a&&a&&a.type){var b=rb(a),c=P["*"]||[],d=P[a.type]||[],e=c.concat(d);if(e&&e.length){var g,h,i,j,k,l=this;for(g=0,h=e.length;h>g;g++)i=e[g],j=l,"string"==typeof i&&"function"==typeof f[i]&&(i=f[i]),"object"==typeof i&&i&&"function"==typeof i.handleEvent&&(j=i,i=i.handleEvent),"function"==typeof i&&(k=A({},a),sb(i,j,[k],b))}return this}},ub=function(a){var b=null;return(M===!1||a&&"error"===a.type&&a.name&&-1!==V.indexOf(a.name))&&(b=!1),b},vb=function(a){var b=a.target||d||null,f="swf"===a._source;switch(delete a._source,a.type){case"error":var g="flash-sandboxed"===a.name||ub(a);"boolean"==typeof g&&(N.sandboxed=g),-1!==W.indexOf(a.name)?A(N,{disabled:"flash-disabled"===a.name,outdated:"flash-outdated"===a.name,unavailable:"flash-unavailable"===a.name,degraded:"flash-degraded"===a.name,deactivated:"flash-deactivated"===a.name,overdue:"flash-overdue"===a.name,ready:!1}):"version-mismatch"===a.name&&(c=a.swfVersion,A(N,{disabled:!1,outdated:!1,unavailable:!1,degraded:!1,deactivated:!1,overdue:!1,ready:!1})),Pb();break;case"ready":c=a.swfVersion;var h=N.deactivated===!0;A(N,{disabled:!1,outdated:!1,sandboxed:!1,unavailable:!1,degraded:!1,deactivated:!1,overdue:h,ready:!h}),Pb();break;case"beforecopy":e=b;break;case"copy":var i,j,k=a.relatedTarget;!Q["text/html"]&&!Q["text/plain"]&&k&&(j=k.value||k.outerHTML||k.innerHTML)&&(i=k.value||k.textContent||k.innerText)?(a.clipboardData.clearData(),a.clipboardData.setData("text/plain",i),j!==i&&a.clipboardData.setData("text/html",j)):!Q["text/plain"]&&a.target&&(i=a.target.getAttribute("data-clipboard-text"))&&(a.clipboardData.clearData(),a.clipboardData.setData("text/plain",i));break;case"aftercopy":wb(a),Vb.clearData(),b&&b!==Jb()&&b.focus&&b.focus();break;case"_mouseover":Vb.focus(b),Z.bubbleEvents===!0&&f&&(b&&b!==a.relatedTarget&&!F(a.relatedTarget,b)&&xb(A({},a,{type:"mouseenter",bubbles:!1,cancelable:!1})),xb(A({},a,{type:"mouseover"})));break;case"_mouseout":Vb.blur(),Z.bubbleEvents===!0&&f&&(b&&b!==a.relatedTarget&&!F(a.relatedTarget,b)&&xb(A({},a,{type:"mouseleave",bubbles:!1,cancelable:!1})),xb(A({},a,{type:"mouseout"})));break;case"_mousedown":Kb(b,Z.activeClass),Z.bubbleEvents===!0&&f&&xb(A({},a,{type:a.type.slice(1)}));break;case"_mouseup":Lb(b,Z.activeClass),Z.bubbleEvents===!0&&f&&xb(A({},a,{type:a.type.slice(1)}));break;case"_click":e=null,Z.bubbleEvents===!0&&f&&xb(A({},a,{type:a.type.slice(1)}));break;case"_mousemove":Z.bubbleEvents===!0&&f&&xb(A({},a,{type:a.type.slice(1)}))}return/^_(?:click|mouse(?:over|out|down|up|move))$/.test(a.type)?!0:void 0},wb=function(a){if(a.errors&&a.errors.length>0){var b=B(a);A(b,{type:"error",name:"clipboard-error"}),delete b.success,i(function(){Vb.emit(b)},0)}},xb=function(a){if(a&&"string"==typeof a.type&&a){var b,c=a.target||null,d=c&&c.ownerDocument||g,e={view:d.defaultView||f,canBubble:!0,cancelable:!0,detail:"click"===a.type?1:0,button:"number"==typeof a.which?a.which-1:"number"==typeof a.button?a.button:d.createEvent?0:1},h=A(e,a);c&&d.createEvent&&c.dispatchEvent&&(h=[h.type,h.canBubble,h.cancelable,h.view,h.detail,h.screenX,h.screenY,h.clientX,h.clientY,h.ctrlKey,h.altKey,h.shiftKey,h.metaKey,h.button,h.relatedTarget],b=d.createEvent("MouseEvents"),b.initMouseEvent&&(b.initMouseEvent.apply(b,h),b._source="js",c.dispatchEvent(b)))}},yb=function(){var a=Z.flashLoadTimeout;if("number"==typeof a&&a>=0){var b=Math.min(1e3,a/10),c=Z.swfObjectId+"_fallbackContent";T=k(function(){var a=g.getElementById(c);Ob(a)&&(Pb(),N.deactivated=null,Vb.emit({type:"error",name:"swf-not-found"}))},b)}},zb=function(){var a=g.createElement("div");return a.id=Z.containerId,a.className=Z.containerClass,a.style.position="absolute",a.style.left="0px",a.style.top="-9999px",a.style.width="1px",a.style.height="1px",a.style.zIndex=""+Sb(Z.zIndex),a},Ab=function(a){for(var b=a&&a.parentNode;b&&"OBJECT"===b.nodeName&&b.parentNode;)b=b.parentNode;return b||null},Bb=function(){var a,b=N.bridge,c=Ab(b);if(!b){var d=Ib(f.location.host,Z),e="never"===d?"none":"all",h=Gb(A({jsVersion:Vb.version},Z)),i=Z.swfPath+Fb(Z.swfPath,Z);c=zb();var j=g.createElement("div");c.appendChild(j),g.body.appendChild(c);var k=g.createElement("div"),l="activex"===N.pluginType;k.innerHTML='<object id="'+Z.swfObjectId+'" name="'+Z.swfObjectId+'" width="100%" height="100%" '+(l?'classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"':'type="application/x-shockwave-flash" data="'+i+'"')+">"+(l?'<param name="movie" value="'+i+'"/>':"")+'<param name="allowScriptAccess" value="'+d+'"/><param name="allowNetworking" value="'+e+'"/><param name="menu" value="false"/><param name="wmode" value="transparent"/><param name="flashvars" value="'+h+'"/><div id="'+Z.swfObjectId+'_fallbackContent">&nbsp;</div></object>',b=k.firstChild,k=null,y(b).ZeroClipboard=Vb,c.replaceChild(b,j),yb()}return b||(b=g[Z.swfObjectId],b&&(a=b.length)&&(b=b[a-1]),!b&&c&&(b=c.firstChild)),N.bridge=b||null,b},Cb=function(){var a=N.bridge;if(a){var d=Ab(a);d&&("activex"===N.pluginType&&"readyState"in a?(a.style.display="none",function e(){if(4===a.readyState){for(var b in a)"function"==typeof a[b]&&(a[b]=null);a.parentNode&&a.parentNode.removeChild(a),d.parentNode&&d.parentNode.removeChild(d)}else i(e,10)}()):(a.parentNode&&a.parentNode.removeChild(a),d.parentNode&&d.parentNode.removeChild(d))),Pb(),N.ready=null,N.bridge=null,N.deactivated=null,c=b}},Db=function(a){var b={},c={};if("object"==typeof a&&a){for(var d in a)if(d&&w.call(a,d)&&"string"==typeof a[d]&&a[d])switch(d.toLowerCase()){case"text/plain":case"text":case"air:text":case"flash:text":b.text=a[d],c.text=d;break;case"text/html":case"html":case"air:html":case"flash:html":b.html=a[d],c.html=d;break;case"application/rtf":case"text/rtf":case"rtf":case"richtext":case"air:rtf":case"flash:rtf":b.rtf=a[d],c.rtf=d}return{data:b,formatMap:c}}},Eb=function(a,b){if("object"!=typeof a||!a||"object"!=typeof b||!b)return a;var c={};for(var d in a)if(w.call(a,d))if("errors"===d){c[d]=a[d]?a[d].slice():[];for(var e=0,f=c[d].length;f>e;e++)c[d][e].format=b[c[d][e].format]}else if("success"!==d&&"data"!==d)c[d]=a[d];else{c[d]={};var g=a[d];for(var h in g)h&&w.call(g,h)&&w.call(b,h)&&(c[d][b[h]]=g[h])}return c},Fb=function(a,b){var c=null==b||b&&b.cacheBust===!0;return c?(-1===a.indexOf("?")?"?":"&")+"noCache="+t():""},Gb=function(a){var b,c,d,e,g="",h=[];if(a.trustedDomains&&("string"==typeof a.trustedDomains?e=[a.trustedDomains]:"object"==typeof a.trustedDomains&&"length"in a.trustedDomains&&(e=a.trustedDomains)),e&&e.length)for(b=0,c=e.length;c>b;b++)if(w.call(e,b)&&e[b]&&"string"==typeof e[b]){if(d=Hb(e[b]),!d)continue;if("*"===d){h.length=0,h.push(d);break}h.push.apply(h,[d,"//"+d,f.location.protocol+"//"+d])}return h.length&&(g+="trustedOrigins="+n(h.join(","))),a.forceEnhancedClipboard===!0&&(g+=(g?"&":"")+"forceEnhancedClipboard=true"),"string"==typeof a.swfObjectId&&a.swfObjectId&&(g+=(g?"&":"")+"swfObjectId="+n(a.swfObjectId)),"string"==typeof a.jsVersion&&a.jsVersion&&(g+=(g?"&":"")+"jsVersion="+n(a.jsVersion)),g},Hb=function(a){if(null==a||""===a)return null;if(a=a.replace(/^\s+|\s+$/g,""),""===a)return null;var b=a.indexOf("//");a=-1===b?a:a.slice(b+2);var c=a.indexOf("/");return a=-1===c?a:-1===b||0===c?null:a.slice(0,c),a&&".swf"===a.slice(-4).toLowerCase()?null:a||null},Ib=function(){var a=function(a){var b,c,d,e=[];if("string"==typeof a&&(a=[a]),"object"!=typeof a||!a||"number"!=typeof a.length)return e;for(b=0,c=a.length;c>b;b++)if(w.call(a,b)&&(d=Hb(a[b]))){if("*"===d){e.length=0,e.push("*");break}-1===e.indexOf(d)&&e.push(d)}return e};return function(b,c){var d=Hb(c.swfPath);null===d&&(d=b);var e=a(c.trustedDomains),f=e.length;if(f>0){if(1===f&&"*"===e[0])return"always";if(-1!==e.indexOf(b))return 1===f&&b===d?"sameDomain":"always"}return"never"}}(),Jb=function(){try{return g.activeElement}catch(a){return null}},Kb=function(a,b){var c,d,e,f=[];if("string"==typeof b&&b&&(f=b.split(/\s+/)),a&&1===a.nodeType&&f.length>0)if(a.classList)for(c=0,d=f.length;d>c;c++)a.classList.add(f[c]);else if(a.hasOwnProperty("className")){for(e=" "+a.className+" ",c=0,d=f.length;d>c;c++)-1===e.indexOf(" "+f[c]+" ")&&(e+=f[c]+" ");a.className=e.replace(/^\s+|\s+$/g,"")}return a},Lb=function(a,b){var c,d,e,f=[];if("string"==typeof b&&b&&(f=b.split(/\s+/)),a&&1===a.nodeType&&f.length>0)if(a.classList&&a.classList.length>0)for(c=0,d=f.length;d>c;c++)a.classList.remove(f[c]);else if(a.className){for(e=(" "+a.className+" ").replace(/[\r\n\t]/g," "),c=0,d=f.length;d>c;c++)e=e.replace(" "+f[c]+" "," ");a.className=e.replace(/^\s+|\s+$/g,"")}return a},Mb=function(a,b){var c=m(a,null).getPropertyValue(b);return"cursor"!==b||c&&"auto"!==c||"A"!==a.nodeName?c:"pointer"},Nb=function(a){var b={left:0,top:0,width:0,height:0};if(a.getBoundingClientRect){var c=a.getBoundingClientRect(),d=f.pageXOffset,e=f.pageYOffset,h=g.documentElement.clientLeft||0,i=g.documentElement.clientTop||0,j=0,k=0;if("relative"===Mb(g.body,"position")){var l=g.body.getBoundingClientRect(),m=g.documentElement.getBoundingClientRect();j=l.left-m.left||0,k=l.top-m.top||0}b.left=c.left+d-h-j,b.top=c.top+e-i-k,b.width="width"in c?c.width:c.right-c.left,b.height="height"in c?c.height:c.bottom-c.top}return b},Ob=function(a){if(!a)return!1;var b=m(a,null),c=r(b.height)>0,d=r(b.width)>0,e=r(b.top)>=0,f=r(b.left)>=0,g=c&&d&&e&&f,h=g?null:Nb(a),i="none"!==b.display&&"collapse"!==b.visibility&&(g||!!h&&(c||h.height>0)&&(d||h.width>0)&&(e||h.top>=0)&&(f||h.left>=0));return i},Pb=function(){j(S),S=0,l(T),T=0},Qb=function(){var a;if(d&&(a=Ab(N.bridge))){var b=Nb(d);A(a.style,{width:b.width+"px",height:b.height+"px",top:b.top+"px",left:b.left+"px",zIndex:""+Sb(Z.zIndex)})}},Rb=function(a){N.ready===!0&&(N.bridge&&"function"==typeof N.bridge.setHandCursor?N.bridge.setHandCursor(a):N.ready=!1)},Sb=function(a){if(/^(?:auto|inherit)$/.test(a))return a;var b;return"number"!=typeof a||s(a)?"string"==typeof a&&(b=Sb(q(a,10))):b=a,"number"==typeof b?b:"auto"},Tb=function(b){var c,d,e,f=N.sandboxed,g=null;if(b=b===!0,M===!1)g=!1;else{try{d=a.frameElement||null}catch(h){e={name:h.name,message:h.message}}if(d&&1===d.nodeType&&"IFRAME"===d.nodeName)try{g=d.hasAttribute("sandbox")}catch(h){g=null}else{try{c=document.domain||null}catch(h){c=null}(null===c||e&&"SecurityError"===e.name&&/(^|[\s\(\[@])sandbox(es|ed|ing|[\s\.,!\)\]@]|$)/.test(e.message.toLowerCase()))&&(g=!0)}}return N.sandboxed=g,f===g||b||Ub(o),g},Ub=function(a){function b(a){var b=a.match(/[\d]+/g);return b.length=3,b.join(".")}function c(a){return!!a&&(a=a.toLowerCase())&&(/^(pepflashplayer\.dll|libpepflashplayer\.so|pepperflashplayer\.plugin)$/.test(a)||"chrome.plugin"===a.slice(-13))}function d(a){a&&(i=!0,a.version&&(l=b(a.version)),!l&&a.description&&(l=b(a.description)),a.filename&&(k=c(a.filename)))}var e,f,g,i=!1,j=!1,k=!1,l="";if(h.plugins&&h.plugins.length)e=h.plugins["Shockwave Flash"],d(e),h.plugins["Shockwave Flash 2.0"]&&(i=!0,l="2.0.0.11");else if(h.mimeTypes&&h.mimeTypes.length)g=h.mimeTypes["application/x-shockwave-flash"],e=g&&g.enabledPlugin,d(e);else if("undefined"!=typeof a){j=!0;try{f=new a("ShockwaveFlash.ShockwaveFlash.7"),i=!0,l=b(f.GetVariable("$version"))}catch(m){try{f=new a("ShockwaveFlash.ShockwaveFlash.6"),i=!0,l="6.0.21"}catch(n){try{f=new a("ShockwaveFlash.ShockwaveFlash"),i=!0,l=b(f.GetVariable("$version"))}catch(o){j=!1}}}}N.disabled=i!==!0,N.outdated=l&&r(l)<r(O),N.version=l||"0.0.0",N.pluginType=k?"pepper":j?"activex":i?"netscape":"unknown"};Ub(o),Tb(!0);var Vb=function(){return this instanceof Vb?void("function"==typeof Vb._createClient&&Vb._createClient.apply(this,z(arguments))):new Vb};v(Vb,"version",{value:"2.2.0",writable:!1,configurable:!0,enumerable:!0}),Vb.config=function(){return $.apply(this,z(arguments))},Vb.state=function(){return _.apply(this,z(arguments))},Vb.isFlashUnusable=function(){return ab.apply(this,z(arguments))},Vb.on=function(){return bb.apply(this,z(arguments))},Vb.off=function(){return cb.apply(this,z(arguments))},Vb.handlers=function(){return db.apply(this,z(arguments))},Vb.emit=function(){return eb.apply(this,z(arguments))},Vb.create=function(){return fb.apply(this,z(arguments))},Vb.destroy=function(){return gb.apply(this,z(arguments))},Vb.setData=function(){return hb.apply(this,z(arguments))},Vb.clearData=function(){return ib.apply(this,z(arguments))},Vb.getData=function(){return jb.apply(this,z(arguments))},Vb.focus=Vb.activate=function(){return kb.apply(this,z(arguments))},Vb.blur=Vb.deactivate=function(){return lb.apply(this,z(arguments))},Vb.activeElement=function(){return mb.apply(this,z(arguments))};var Wb=0,Xb={},Yb=0,Zb={},$b={};A(Z,{autoActivate:!0});var _b=function(a){var b=this;b.id=""+Wb++,Xb[b.id]={instance:b,elements:[],handlers:{}},a&&b.clip(a),Vb.on("*",function(a){return b.emit(a)}),Vb.on("destroy",function(){b.destroy()}),Vb.create()},ac=function(a,d){var e,f,g,h={},i=Xb[this.id],j=i&&i.handlers;if(!i)throw new Error("Attempted to add new listener(s) to a destroyed ZeroClipboard client instance");if("string"==typeof a&&a)g=a.toLowerCase().split(/\s+/);else if("object"==typeof a&&a&&"undefined"==typeof d)for(e in a)w.call(a,e)&&"string"==typeof e&&e&&"function"==typeof a[e]&&this.on(e,a[e]);if(g&&g.length){for(e=0,f=g.length;f>e;e++)a=g[e].replace(/^on/,""),h[a]=!0,j[a]||(j[a]=[]),j[a].push(d);if(h.ready&&N.ready&&this.emit({type:"ready",client:this}),h.error){for(e=0,f=W.length;f>e;e++)if(N[W[e].replace(/^flash-/,"")]){this.emit({type:"error",name:W[e],client:this});break}c!==b&&Vb.version!==c&&this.emit({type:"error",name:"version-mismatch",jsVersion:Vb.version,swfVersion:c})}}return this},bc=function(a,b){var c,d,e,f,g,h=Xb[this.id],i=h&&h.handlers;if(!i)return this;if(0===arguments.length)f=u(i);else if("string"==typeof a&&a)f=a.split(/\s+/);else if("object"==typeof a&&a&&"undefined"==typeof b)for(c in a)w.call(a,c)&&"string"==typeof c&&c&&"function"==typeof a[c]&&this.off(c,a[c]);if(f&&f.length)for(c=0,d=f.length;d>c;c++)if(a=f[c].toLowerCase().replace(/^on/,""),g=i[a],g&&g.length)if(b)for(e=g.indexOf(b);-1!==e;)g.splice(e,1),e=g.indexOf(b,e);else g.length=0;return this},cc=function(a){var b=null,c=Xb[this.id]&&Xb[this.id].handlers;return c&&(b="string"==typeof a&&a?c[a]?c[a].slice(0):[]:B(c)),b},dc=function(a){if(ic.call(this,a)){"object"==typeof a&&a&&"string"==typeof a.type&&a.type&&(a=A({},a));var b=A({},ob(a),{client:this});jc.call(this,b)}return this},ec=function(a){if(!Xb[this.id])throw new Error("Attempted to clip element(s) to a destroyed ZeroClipboard client instance");a=kc(a);for(var b=0;b<a.length;b++)if(w.call(a,b)&&a[b]&&1===a[b].nodeType){a[b].zcClippingId?-1===Zb[a[b].zcClippingId].indexOf(this.id)&&Zb[a[b].zcClippingId].push(this.id):(a[b].zcClippingId="zcClippingId_"+Yb++,Zb[a[b].zcClippingId]=[this.id],Z.autoActivate===!0&&lc(a[b]));var c=Xb[this.id]&&Xb[this.id].elements;-1===c.indexOf(a[b])&&c.push(a[b])}return this},fc=function(a){var b=Xb[this.id];if(!b)return this;var c,d=b.elements;a="undefined"==typeof a?d.slice(0):kc(a);for(var e=a.length;e--;)if(w.call(a,e)&&a[e]&&1===a[e].nodeType){for(c=0;-1!==(c=d.indexOf(a[e],c));)d.splice(c,1);var f=Zb[a[e].zcClippingId];if(f){for(c=0;-1!==(c=f.indexOf(this.id,c));)f.splice(c,1);0===f.length&&(Z.autoActivate===!0&&mc(a[e]),delete a[e].zcClippingId)}}return this},gc=function(){var a=Xb[this.id];return a&&a.elements?a.elements.slice(0):[]},hc=function(){Xb[this.id]&&(this.unclip(),this.off(),delete Xb[this.id])},ic=function(a){if(!a||!a.type)return!1;if(a.client&&a.client!==this)return!1;var b=Xb[this.id],c=b&&b.elements,d=!!c&&c.length>0,e=!a.target||d&&-1!==c.indexOf(a.target),f=a.relatedTarget&&d&&-1!==c.indexOf(a.relatedTarget),g=a.client&&a.client===this;return b&&(e||f||g)?!0:!1},jc=function(a){var b=Xb[this.id];if("object"==typeof a&&a&&a.type&&b){var c=rb(a),d=b&&b.handlers["*"]||[],e=b&&b.handlers[a.type]||[],g=d.concat(e);if(g&&g.length){var h,i,j,k,l,m=this;for(h=0,i=g.length;i>h;h++)j=g[h],k=m,"string"==typeof j&&"function"==typeof f[j]&&(j=f[j]),"object"==typeof j&&j&&"function"==typeof j.handleEvent&&(k=j,j=j.handleEvent),"function"==typeof j&&(l=A({},a),sb(j,k,[l],c))}}},kc=function(a){return"string"==typeof a&&(a=[]),"number"!=typeof a.length?[a]:a},lc=function(a){if(a&&1===a.nodeType){var b=function(a){(a||(a=f.event))&&("js"!==a._source&&(a.stopImmediatePropagation(),a.preventDefault()),delete a._source)},c=function(c){(c||(c=f.event))&&(b(c),Vb.focus(a))};a.addEventListener("mouseover",c,!1),a.addEventListener("mouseout",b,!1),a.addEventListener("mouseenter",b,!1),a.addEventListener("mouseleave",b,!1),a.addEventListener("mousemove",b,!1),$b[a.zcClippingId]={mouseover:c,mouseout:b,mouseenter:b,mouseleave:b,mousemove:b}}},mc=function(a){if(a&&1===a.nodeType){var b=$b[a.zcClippingId];if("object"==typeof b&&b){for(var c,d,e=["move","leave","enter","out","over"],f=0,g=e.length;g>f;f++)c="mouse"+e[f],d=b[c],"function"==typeof d&&a.removeEventListener(c,d,!1);delete $b[a.zcClippingId]}}};Vb._createClient=function(){_b.apply(this,z(arguments))},Vb.prototype.on=function(){return ac.apply(this,z(arguments))},Vb.prototype.off=function(){return bc.apply(this,z(arguments))},Vb.prototype.handlers=function(){return cc.apply(this,z(arguments))},Vb.prototype.emit=function(){return dc.apply(this,z(arguments))},Vb.prototype.clip=function(){return ec.apply(this,z(arguments))},Vb.prototype.unclip=function(){return fc.apply(this,z(arguments))},Vb.prototype.elements=function(){return gc.apply(this,z(arguments))},Vb.prototype.destroy=function(){return hc.apply(this,z(arguments))},Vb.prototype.setText=function(a){if(!Xb[this.id])throw new Error("Attempted to set pending clipboard data from a destroyed ZeroClipboard client instance");return Vb.setData("text/plain",a),this},Vb.prototype.setHtml=function(a){if(!Xb[this.id])throw new Error("Attempted to set pending clipboard data from a destroyed ZeroClipboard client instance");return Vb.setData("text/html",a),this},Vb.prototype.setRichText=function(a){if(!Xb[this.id])throw new Error("Attempted to set pending clipboard data from a destroyed ZeroClipboard client instance");return Vb.setData("application/rtf",a),this},Vb.prototype.setData=function(){if(!Xb[this.id])throw new Error("Attempted to set pending clipboard data from a destroyed ZeroClipboard client instance");return Vb.setData.apply(this,z(arguments)),this},Vb.prototype.clearData=function(){if(!Xb[this.id])throw new Error("Attempted to clear pending clipboard data from a destroyed ZeroClipboard client instance");return Vb.clearData.apply(this,z(arguments)),this},Vb.prototype.getData=function(){if(!Xb[this.id])throw new Error("Attempted to get pending clipboard data from a destroyed ZeroClipboard client instance");return Vb.getData.apply(this,z(arguments))},"function"==typeof define&&define.amd?define(function(){return Vb}):"object"==typeof module&&module&&"object"==typeof module.exports&&module.exports?module.exports=Vb:a.ZeroClipboard=Vb}(function(){return this||window}());
//# sourceMappingURL=ZeroClipboard.min.map

/*####### new design ##########*/
//header Scroll();
jQuery(document).ready(function(){


	 jQuery(window).scroll(function() {
        var mainbody = jQuery(window).scrollTop();

       if (mainbody > 40) {
		
		jQuery("#ysheader").removeClass("scrolled-effect");
		jQuery("#ysheader").addClass("showhide");

		jQuery("#ysheader").stop().animate({top:'-50'},{ duration: 300, queue: false });
		jQuery("#ysheader .posRel img").addClass("resizable");
		jQuery(".bagshow").removeClass("active");
		jQuery("#globalheader").addClass("color-change");

	   }

	   else{
		jQuery("#ysheader").addClass("scrolled-effect");
		jQuery("#ysheader").stop().animate({top:'0'},{ duration: 300, queue: false });
		jQuery("#ysheader .posRel img").removeClass("resizable");
		jQuery(".bagshow").addClass("active");
		jQuery("#globalheader").removeClass("color-change");
		jQuery("#ysheader").removeClass("showhide");

       }

    });
	 jQuery("#ysheader").mouseover(function(){
        if (!jQuery("#ysheader").hasClass("scrolled-effect")) {
            jQuery(this).stop().animate({top:'0'});
			jQuery("#ysheader .posRel img").removeClass("resizable");
		}
    });
	 jQuery("#ysheader").mouseout(function(){

        //move Nav back up
        if (!jQuery("#ysheader").hasClass("scrolled-effect")) {
            jQuery(this).stop().animate({top:'-50'});
           jQuery("#ysheader .posRel img").addClass("resizable");

        }
    });
	
	
	

   });

// to fix elements which are going out of 1600px width
jQuery(document).ready(function(){
		
			var pageOffsetLeft = jQuery('#page').offset().left;
			var pageOffsetRight = (jQuery(window).width() - (jQuery('#page').offset().left + jQuery('#page').outerWidth()));		
			
			jQuery('.menu-btn').css({
				'margin-left':pageOffsetLeft
			});
			jQuery('.menu-box').css({
				'left':pageOffsetLeft
			});
			jQuery('.color-game').css({
				'margin-right':pageOffsetRight
			});
		
});

// to fix elements which are going out of 1600px width on resize
jQuery(window).resize(function(){
		
			var pageOffsetLeft = jQuery('#page').offset().left;
			var pageOffsetRight = (jQuery(window).width() - (jQuery('#page').offset().left + jQuery('#page').outerWidth()));		
			
			jQuery('.menu-btn').css({
				'margin-left':pageOffsetLeft
			});
			jQuery('.menu-box').css({
				'left':pageOffsetLeft
			});
			jQuery('.color-game').css({
				'margin-right':pageOffsetRight
			});
		
});
// to fix elements which are going out of 1600px width on keyboard zoomin zoomout
jQuery(window).on('keypress keydown',function(e){
	//alert();
   if((e.which == 61 && 17) || (e.which == 43 && 17) || (e.which == 45 && 17) || (e.which == 48 && 17) || (e.which == 96 && 17)){
       // 17 is Ctrl Keycode
	   //Ctrl + "+" is pressed, 61 is for =/+ anr 43 is for Numpad + key
	   //Ctrl + "-" is pressed, 45 is for -/- anr 45 is for Numpad - key
	   //Ctrl + "0" is pressed, 48 is for )/0 anr 96 is for Numpad 0 key
	   //alert(e.which);
	   
		var px = 0;
		
		var intervalID = setInterval(function () {
			// logic here			
			var pageOffsetLeft = jQuery('#page').offset().left;
			var pageOffsetRight = (jQuery(window).width() - (jQuery('#page').offset().left + jQuery('#page').outerWidth()));		
			
			jQuery('.menu-btn').css({
				'margin-left':pageOffsetLeft
			});
			jQuery('.menu-box').css({
				'left':pageOffsetLeft
			});
			jQuery('.color-game').css({
				'margin-right':pageOffsetRight
			});
			if (++px === 1) {
				console.info('px=' +px);
				window.clearInterval(intervalID);			
			}
		}, 400);
   }
	
   

});