var count = 0;
var status = "old";
var user_color_shade;
var logged_in;
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

$(document).ready(function () {
    //if (window.location.href.indexOf('https://') >= 0)
    //    _usesecureurl = true;
    //else
    //    _usesecureurl = false;
    var url = homeUrl + 'mycatalog/myproduct/checkforsignuppopup';
    //if (_usesecureurl)
    //    url = securehomeUrl + 'mycatalog/myproduct/checkforsignuppopup';
    jQuery.ajax({
        url: url,
        type: 'POST',
        success: function (data) {
            data = eval('(' + data + ')');
            var status = data.status;
            //status = "error";         // stop signup popup
            if (status == "success") {
                $(".your-color-block").hide();
                $("#signin_popup").fadeIn();
                $(".login-box").hide();
                $(".signin-block").fadeIn();

            }
        }
    });

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


$('document').ready(function () {
    submit_comment();
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
            statusdiv.html('<p>Processing...</p>');
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
                            statusdiv.html('<p class="ajax-success" >Blank comment are not allowed !</p>');
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

        }
        return false;
    });
}

$(document).ready(function () {
    $(".login_magento").keydown(function(e){
        if(e.keyCode==13){
            $("#sign-in-button").click();
            //alert("sign in");
        }
    });

    $(".register_new").keydown(function(e){
        if(e.keyCode==13){
            $("#sign-up-button").click();
            //alert("sign up");
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
        $("#signin_popup").fadeOut();
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
    $(".login_logout_link").click(function () {
        if ($(this).children("a").text() == "Sign In") {
            $(".signin-block").hide();
            $(".your-color-block").hide();
            $("#signin_popup").fadeIn();
            $(".login-box").fadeIn();
        }
    })
});


/* /////////////////////CREATE ACCOUNT FROM POPUP///////////////////////// */
function createCustomerAccount_from_popup() {
    var error = "";
    var fname = jQuery.trim(jQuery("#p_fname").val());
    var lname = jQuery.trim(jQuery("#p_lname").val());
    var email_id = jQuery.trim(jQuery("#p_signup_email").val());
    var pwd = jQuery.trim(jQuery("#p_s_password").val());

    if (fname!="First Name" && lname!="Last Name" && email_id!="Email Address" && fname.length > 0 && lname.length > 0 && email_id.length > 0) {
        function IsEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }
        if(IsEmail(email_id)){
            if (pwd!="Select a password" && pwd.length < 6 ) {
                error = "Password should be atleast 6 characters.";
            }
            else {
                var cpassword = pwd;
                //var is_subscribed = jQuery("#in_touch").val();
                //if (window.location.href.indexOf('https://') >= 0)
                //    _usesecureurl = true;
                //else
                //    _usesecureurl = false;
                var url = homeUrl + 'mycatalog/myproduct/registercustomer';
                //if (_usesecureurl)
                //    url = securehomeUrl + 'mycatalog/myproduct/registercustomer';

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
                        jQuery("#sign-up-form .err-msg").html("");
                        jQuery("#sign-up-form .loader").show();
                        jQuery("#signup").hide();
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
                            jQuery("#signin-block").fadeOut();
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
                            jQuery("#sign-up-form .loader").hide();
                            jQuery("#signup").show();
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
    //alert(pwd);
    var cpassword = pwd;
    //var is_subscribed = jQuery("#in_touch").val();
    //if (window.location.href.indexOf('https://') >= 0)
    //    _usesecureurl = true;
    //else
    //    _usesecureurl = false;
    var url = homeUrl + 'mycatalog/myproduct/registercustomer';
    //if (_usesecureurl)
    //    url = securehomeUrl + 'mycatalog/myproduct/registercustomer';

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
                jQuery(".login-box").fadeOut();
                //window.location=homeUrl+"rangoli";

                _islogedinuser = true;
                jQuery("#signin").html("SIGN OUT").attr({href: homeUrl + 'customer/account/logout/', id: "sign-out"});

                if (name != '') {
                    jQuery("#welcome-name").html("Hi " + name).attr("href", homeUrl + 'customer/account/');
                }
            }
            else {
                jQuery("#sign-up-button").parent().show();
                jQuery("#sign-up-form .form-loader").hide();
                jQuery("#sign-up-form .err-msg").html(data.errors).css("visibility", "visible");
            }
        }
    });
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


function doWordpressLogin(email, password, first_name, last_name, customer_id) {

    // now login to wordpress
    jQuery.ajax({
        url: root + 'rangoli/mage_wp_login.php',
        type: 'POST',
        data: 'user_login=' + email + '&password=' + password + '&first_name=' + first_name + '&last_name=' + last_name + '&customer_id=' + customer_id,
        dataType: 'json',
        success: function (result) {

            if (result != undefined && result.message != undefined && result.message == "success") {
                console.log("******* cannot login to Rangoli");
                //$("#signin_popup").fadeOut();
                ////window.location=homeUrl+"rangoli";
                //jQuery("#sign-in-form .form-loader").html("");
                //jQuery("#sign-in-button").parent().show();
                //
                //jQuery(".login_logout_link").html("<span style='cursor:pointer; margin-left:0;padding-left:0' onclick='wplogout()'>SIGN OUT</span>");
                //
                //jQuery("#sign-in-form .form-loader").html("");
                //jQuery("#signing_popup").fadeIn();
                //_islogedinuser = true;
                //if (name != '') {
                //    jQuery("#welcome-name").html("Hi " + name).attr("href", homeUrl + 'customer/account/');
                //}
                //
                //jQuery(".before-login").hide();
                //jQuery(".after-login").show();
                //jQuery(".after-login li.smogi-balance a span").html(somgiBal);
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
//alert(result.message == "alreadyloggedout");
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
            //alert(result.message);
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
                    //doWordpressLogin(email,name, first_name,last_name,customer_id);

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
    //alert(count);
    if(count >=3){
        $(".next-confirmation-page").text("Next");
    }else{
        $(".next-confirmation-page").text("Choose 3+");
    }
}

$(document).ready(function () {
    init();
    $("#signup_signin_btn").click(function () {
        $(".login_logout_link").click();
    });
    $(".interest_listing li a").click(function (e) {
        e.preventDefault();

        var current_obj = $(this);
        var link = $(this).attr("href");
        var cls = $(this).attr("class");
        //alert("class : "+cls);
        $.ajax({
            url: link + '&s=' + new Date().getSeconds(),
            type: 'GET',
            success: function (response) {

                current_obj.attr("href", response);
                if (cls == "user-interest add") {
                    current_obj.removeClass("add");
                    current_obj.addClass("remove");
                    //alert(user_color_shade);
                    current_obj.find("path").css("fill", user_color_shade).css("stroke", user_color_shade);
                }
                else {
                    current_obj.removeClass("remove");
                    current_obj.addClass("add");
                    current_obj.find("path").css("fill", "transparent").css("stroke", "#fff");
                }

                count_interests();
            }
        })
    });
});

$(window).resize(function () {
    var wh = $(window).height();
    var ww = $(window).width();
    $(".wh").css('min-height', wh);
    var one_three = ww / 3;
    var tile_height = one_three * 0.75;
    //$(".wp_page").css('min-width', ww);

    $(".one-three").height(tile_height);
    $(".two-three").height(tile_height * 2);
    $(".fixed-container").css("min-height",wh/2);

    //$(".wp_page_banner").height(wh-50);
});

$(window).load(function () {
    $(".wp_page").animate({
        'opacity': '1'
    }, 300, function () {
        $(".rangoli_logo").addClass("fadeInDown").addClass("animated");
    });
    var wh = $(window).height();
    $(".wp_page_banner").height(wh - 70);
})
$(window).resize(function () {
    var wh = $(window).height();
    $(".wp_page_banner").height(wh - 70);
    //$(".wp_page_banner").css({"background":"cover"});
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
                                $(".your-color-block .color-traingle").css("border-bottom", "74px solid" + user_color_shade);
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
                $(this).css({'background': 'rgba(' + color + ',0.5)', 'transition-duration': '500ms'})
            }, function () {
                $(this).css({
                    'background': '-webkit-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    'background': '-o-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    'background': '-moz-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    'background': 'linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    'transition-duration': '100ms'
                });
            });
            $(".two-three .overlay-text").hover(function () {
                $(this).css({'background': 'rgba(' + color + ',0.5)', 'transition-duration': '500ms'})
                $(this).find("p").css({'color': '#fff', 'transition-duration': '500ms'})
                $(this).find(".post_category").css({"border-color": "#fff", 'transition-duration': '500ms'})
            }, function () {
                $(this).css({
                    'background': '-webkit-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    'background': '-o-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    'background': '-moz-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    'background': 'linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                    'transition-duration': '100ms'
                })
                $(this).find("p").css({'color': '#555', 'transition-duration': '500ms'})
                $(this).find(".post_category").css({"border-color": "#555", 'transition-duration': '500ms'})
            });


            fillcolor();

        }
    });
}

function fillcolor() {
    $(".user-color-shade").css({'background': 'rgba(' + color + ',0.9)'});
    $(".color-game polygon:nth-child(2)").css("fill", user_color_shade);
    $(".color-game polygon").css("stroke", user_color_shade);
    $(".menu-btn rect").css("fill", user_color_shade);
    $(".wpfp-link.remove path").css("fill", user_color_shade).css("stroke", user_color_shade);
    $(".smogi .like.subscribed path").css("fill", user_color_shade).css("stroke", user_color_shade);
}


$(document).ready(function () {
    $("#menu-category a").click(function (e) {
        e.preventDefault();
        $(".close-menu-btn").click();
        ajax_load_pages($(this).attr('href'));
    });
    $(".author_post .overlay-text").css({
        'background': '-webkit-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
        'background': '-o-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
        'background': '-moz-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
        'background': 'linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
        'transition-duration': '100ms'
    });
})


function ajax_load_pages(link) {
    //$(".fixed-container").addClass("fadeOutDownBig").addClass("animated");
    //$(".fixed-container").load(link + ' #fixed_container');
    $page = $(document).find(".fixed-container > div");
    $page.removeAttr("class");
    $.ajax({
        url: link,
        success: function (response) {
            //alert(response.find(""));
            var newTitle = $(response).filter('title').text();
            $page.html("");
            var newData = $(response).find("#fixed_container").html();
            //alert(newData);
            $(window).scrollTop(0);
            $page.html(newData).addClass("fadeIn").addClass("animated");
            get_bulls_eye();
            init();
            $("#filter").unbind();
            filter();
            //$(document).find(".flexslider").flexslider();
            $a = $(document).find(".ajax-load");
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
                'background': '-webkit-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                'background': '-o-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                'background': '-moz-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                'background': 'linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                'transition-duration': '100ms'
            });
            $(document).find(".two-three .overlay-text").css({
                'background': '-webkit-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                'background': '-o-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                'background': '-moz-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                'background': 'linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                'transition-duration': '100ms'
            });
            $(document).find(".author_post .overlay-text").css({
                'background': '-webkit-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                'background': '-o-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                'background': '-moz-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
                'background': 'linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
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
                play();
                $(".play_video").fadeIn();
                $(document).find(".wp_page_banner .play-video").remove();
            });

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


            $(".user-color-shade").css({'background': 'rgba(' + color + ',0.9)'});
            $(".color-game polygon:nth-child(2)").css("fill", user_color_shade);
            $(".color-game polygon").css("stroke", user_color_shade);
            $(".menu-btn rect").css("fill", user_color_shade);
            $(".wpfp-link.remove path").css("fill", user_color_shade).css("stroke", user_color_shade);
            $(".smogi .like.subscribed path").css("fill", user_color_shade).css("stroke", user_color_shade);

        }
    })

    $(".close-menu-btn").click();


}
function play() {
    var player = $(document).find(".featured_video_plus").find("iframe");
    var src = player.attr("src");
    src = src.replace("autoplay=0", "autoplay=1&yt:crop=16:9");
    player.attr("src", src);
}

function init() {

    var wh = $(window).height();
    var ww = $(window).width();
    if (ww < 1024) {
        ww = 1024;
    }
    $(".wh").css('min-height', wh);
    $(".fixed-container").css("min-height",wh/2);
    var one_three = $(".one-three").width();
    var tile_height = one_three * 0.75;
    //$(".wp_page").css('min-width', ww);
    $(".one-three").height(tile_height);
    $(".two-three").height(tile_height * 2);
    $(".wp_page_banner").height(wh - 70);

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

    $(".menu-btn").click(function () {
        $(".menu-box").animate({
            'margin-left': 0,
            'opacity': 1
        }, 500, "easeOutCirc");
        $(this).animate({"opacity": 0}, 500);
        $("#smogis").hide();
        $("#connect").hide();
        $("#stores").hide();
        $("#popup").fadeOut();
        $("body").css("overflow", "auto");
        $("#invite_friend").hide();
    });
    $(".close-menu-btn").click(function () {
        $(".menu-box").animate({
            'margin-left': '-400px'
        }, 500, "easeOutCirc");
        $(".menu-btn").animate({"opacity": 1}, 500);
    });
    $(".close-popup").click(function () {
        $(".smogi").removeClass("fadeInUp").removeClass("animated");
        $("body").css("overflow", "auto");
        $("#popup").fadeOut();
        $("#stores").hide();
        $("#smogis").hide();

    });

    $("a[rel='ys-stores']").click(function (e) {
        e.preventDefault();
        $("#connect").hide();
        $("#popup").fadeIn();
        $("#stores").show();
        $("#smogis").hide();
        $("#invite_friend").hide();
        $("body").css("overflow", "hidden");
        $(".smogi").addClass("fadeInUp").addClass("animated");
        $(".menu-btn").css("opacity", 1);
        $(".menu-box").animate({
            'margin-left': '-400px'
        }, 300, 'easeInQuart', function () {
            $(".menu-btn").css("opacity", 1);
        });
    });
    $(".smogi-content").height(wh - 230);

    $("a[rel='smogis']").click(function (e) {
        e.preventDefault();
        $("#connect").hide();
        $("#popup").fadeIn();
        $("#smogis").show();
        $("body").css("overflow", "hidden");
        $("#invite_friend").hide();
        $(".smogi").addClass("fadeInUp").addClass("animated");
        $("#stores").hide();

        $(".menu-box").animate({
            'margin-left': '-400px'
        }, 500, 'easeOutCirc', function () {
            $(".menu-btn").css("opacity", 1);
        });
    });

    $(".post_category a").each(function () {

        var str = $(this).attr('href');

        if (str.indexOf('learn') > -1 || str.indexOf('look') > -1 || str.indexOf('read') > -1)
            $(this).remove();
    });



    $(".wp_page_banner .play-video").click(function () {
        $(".play_video").fadeIn();

        play();

        $(this).remove();
    });
    $(".homepage_page_banner .play-video").click(function () {
        //alert();
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
    });
    $(".author_post .overlay-text").hover(function () {
        if (user_color_shade == '') {
            user_color_shade = '#555555';
        }
        var color = hexToRgb(user_color_shade);
        $(".author_post:hover .overlay-text").css({'background': 'rgba(' + color + ',0.5)'});
    }, function () {
        $(".author_post .overlay-text").css({
            'background': '-webkit-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
            'background': '-o-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
            'background': '-moz-linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
            'background': 'linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent)',
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
        $(".post_listing").load(link + " #posts", function () {
            $(".liked_reads").flexslider();
            $(".liked_watchs").flexslider();
            $(".liked_learns").flexslider();
            //alert($(".post_listing").html());
        });
        $(".filter-container").slideUp();
    });
}


$(document).ready(function () {
    raty_init();

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
    $("a[rel='connect']").click(function (e) {
        e.preventDefault();
        $/*("#invite_friend").hide();
        $("#smogis").hide();
        $("#stores").hide();
        $("#popup").fadeIn();
        $("#connect").show();

        $(".menu-box").animate({
            'margin-left': '-400px'
        }, 500, 'easeOutCirc', function () {
            $(".menu-btn").css("opacity", 1);
        });*/
        if (logged_in != null && logged_in != '' && logged_in != undefined) {
        $("#smogis").hide();
        $("#connect").hide();
        $("#stores").hide();
        $("#popup").fadeIn();
        $(".close-menu-btn").click();
        $("body").css("overflow", "hidden");
        $("#invite_friend").show();
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
        }
    });
    $(".link").load(root + "profile/manage/referralurl");
    $(".switch").click(function () {
        $(this).toggleClass("active");
    });


    $(".invite-friends").click(function () {
        if (logged_in != null && logged_in != '' && logged_in != undefined) {
        $("#smogis").hide();
        $("#connect").hide();
        $("#stores").hide();
        $("#popup").fadeIn();
        $(".close-menu-btn").click();
        $("body").css("overflow", "hidden");
        $("#invite_friend").show();
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

            //alert(root + "/rangoli/save_shares.php");
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
//
//$(window).load(function(){
//    animate_post_grid();
//});
//
//function animate_post_grid(){
//    var offset = $(".posts_grid").offset();
//    var offsetTop = offset.top;
//    window.scroll(function(){
//        var content_offset = offset.top - $(window).scrollTop();
//    });
//}


$(window).load(function(){
    //alert(link);
    $(".confirmed_interests li a").click(function(e){
        e.preventDefault();
    });


    copytoClipboard();
});
//
//$(document).ready(function(){
//    infiniteScroll_load_pages();
//});
//
//function infiniteScroll_load_pages(){
//    $('#content').infinitescroll({
//
//        navSelector: "navigation.paging-navigation.row",
//        nextSelector: ".navigation.paging-navigation.row a.next",
//        itemSelector: "#content div.post",
//        //loadingImg: "/img/loading.gif",
//        loadingText: "Loading ...",
//        animate: true,
//        errorCallback: function () { }
//
//    });
//}
function copytoClipboard(){
    var link =$(".link").html();
    $(".copy").attr("data-clipboard-text",link);
    var client = new ZeroClipboard($(".copy"));

    client.on( "ready", function( readyEvent ) {
        //alert( "ZeroClipboard SWF is ready!" );

        client.on( "aftercopy", function( event ) {
            // `this` === `client`
            // `event.target` === the element that was clicked
            //event.target.style.display = "none";
            //alert("Copied text to clipboard: " + event.data["text/plain"] );
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
                    //alert(link);
                    $.ajax({
                        url: link,
                        success: function (data) {


                            $newData = $(data).find("#posts .author_posts");
                            $newData.find(".single_post").addClass("fadeInUp").addClass("animated")
                            $(".post_listing .author_posts").append($newData.html());


                            init();
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

});