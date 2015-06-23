var count = 0;
var status = "old";
var is_red_popup_open = false;
var wh = $(window).height();
var logged_in=false;
var logged_in_id;
var user_email;
var current_user_img_url="";
var template_directory;
var post_id;
var smogi_balance;
var email;
var current_date;
var date = new Date();
var s = date.getSeconds();
var playing_video = false;
var is_login_box_open = false;
var message;

$(document).ready(function () {
    current_date = $(".current_date").html()
    logged_in = $(".logged_in").html();
    raty_init();
    $(".flexslider").flexslider({
        slideshow: false
    });
    init_menu();
    //init_watermark();
    $("a.no_load").click(function(e){
        e.preventDefault();
    });
    $(".post_category a").click(function(e){
        e.preventDefault();
    });
    $(".gender").click(function(){
        $(".gender").removeClass("selected");
        $(this).addClass("selected");
    });
    $(".cart").click(function(){window.location=root+"checkout/onepage/";})
    $(".author_post_read > .overlay-text").click(function() {
        var content = $(this).parent();
        $(".post_content").not(content.next()).hide();

        if(content.next().css("display")!="block") {
            content.next().slideDown();
        }

        $(".author_post_read .close_post").hide();
        var close_post = content.find(".close_post");
        close_post.show();
        $(".share_post").hide();
        $("#back_to_top").fadeOut();
        var share_post = content.find(".share_post");
        share_post.show();
        var scroll_top = content.offset().top - $(window).scrollTop();

        $(window).scrollTop(content.offset().top-88);

        if(scroll_top<88){
            close_post.css({"top":"88px","position":"fixed"});
            share_post.css({"top":"132px","position":"fixed"});
        }
        $(window).scroll(function(){
            $(document).find(".close_post").hide();
            $(document).find(".share_post").hide();
            var close_post = content.find(".close_post");
            close_post.show();
            var share_post = content.find(".share_post");
            share_post.show();
            var scroll_top = content.offset().top - $(window).scrollTop();

            if(scroll_top<88){
                close_post.css({"top":"88px","position":"fixed"});
                share_post.css({"top":"132px","position":"fixed"});
            }
            else{
                close_post.css({"top":"0px","position":"absolute"});
                share_post.css({"top":"44px","position":"absolute"});
            }
        });
        $(".comment-form-comment textarea").attr("placeholder","Share your comments");
    });

    $(".smogi .author_post_read .overlay-text").click(function(e) {
        $(".author_posts").not($(this).closest(".smogi").next()).hide();
        $(this).closest(".smogi").next().slideDown();
    });

    $(".close_post").click(function(){
        $(window).unbind("scroll");
        $(".close_post").hide();
        $(".share_post").hide();
        $(".post_content .sharing_box").hide();
        $(this).parent().next().slideUp();
        var top_position = $(this).parent().offset().top;
        $(this).fadeOut();
        $("#back_to_top").fadeIn();
        $(".play_video").hide();
        $(".play-video").show();
        $(".overlay-text").show();
        $(".author_posts").slideUp();
        $(".author_picture").show();
        $(window).scroll(function(){
            $(".sharing_box").fadeOut();
            $(".signup-signin-block").fadeIn();
        });

        $(window).scrollTop(top_position+88);
        var src = $(".video_playing").attr("src");
        if(src) {
            src = src.replace("autoplay=1", "autoplay=0");
            $(".video_playing").attr("src", src);
        }
        $(".author_post_read").height("auto");
    });

    $(".share_post,.share_post_index").click(function(){
       $(".sharing_box").fadeIn();
        $(".signup-signin-block").fadeOut();
    });

    $(".sharing_box .wpfp-span a").each(function (e) {
        bindHeartLink($(this));
    });

    $(".submit").click(function(e){
        e.preventDefault();
        var textarea = $(this).parent().closest(".comment-form").find("textarea");
        submit_comment(textarea);
    });

    $(".show_more_comments").click(function(){
        $(this).hide();
        var more_comments = $(this).closest(".post_comments_listing").find(".more_comments");
        more_comments.slideDown();
    });
    $(".play-video").click(function(){
        play($(this));
    });

    $(".filter-container ul > li p").click(function(){
        $(".filter-container ul li").not($(this).parent()).find("ul").slideUp();
        $(this).next().slideToggle();
        $(this).find("span").toggleClass("active");
        if($(this).find("span").hasClass("active") ){
            $(this).find("span").css({"border-bottom":"none","transition-duration":"300ms"});
        }
        else{
            if(!$(this).parent().is(":last-child"));
            $(this).find("span").css({"border-bottom":"1px solid #fff","transition-duration":"300ms"});
        }
    });
    $(".filter-container ul li").click(function(){
        $(".filter-container ul li").not($(this)).removeClass("active");
        $(".filter-container ul li p").not($(this)).find("span").css({"border-bottom":"1px solid #fff","transition-duration":"300ms"});
        $(this).toggleClass("active");
        if($(this).is(":last-child")){
            $(this).find("span").css({"border-bottom":"1px solid #fff","transition-duration":"300ms"});
        }

    });

    $(".sharing_box .unknown").click(function(){
        var comment_box = $(this).parent().parent().find(".post_comments");
        comment_box.slideDown();
        var offset_top = comment_box.offset().top;
        $(window).scrollTop(offset_top);
        $(this).parent().fadeOut();
    });

    $(".open-filter").click(function(){
        $(".filter-wrapper").slideToggle();
        $(".filter-container").slideToggle();
        $(this).toggleClass("active");
    });

    $(".random").css("color","#"+get_random_color());

    $("#back_to_top").click(function(){
        $('html, body').animate({ scrollTop: 0 },200,"easeInCirc");
    });

    get_cart();

});

function get_random_color(){
    var colors = ["ff9e00","86d95b","18b3d8","ff8cff","7759ac"];
    return colors[Math.floor(Math.random() * colors.length)];
}

function init_menu(){
    $(".menu_btn").click(function(){
       $(".menu-box").fadeIn();
    });
    $(".close_menu").click(function(){
        $(".menu-box").fadeOut();
    });
    $("span.menu_arrow").click(function(){
        $(this).toggleClass("active");
        $(this).parent().next().slideToggle(200);
    });

    $(".forgot_y_p").click(function(){
        $(".login_form").hide();
        $(".forgot_password_form").show();
    });
    $(".forgot_y_p.open_signin").click(function(){
        $(".login_form").show();
        $(".forgot_password_form").hide();
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

                if(user_color_shade != "#FFFFFF") {

                    if (status == "new") {
                        $(".signin_popup").fadeOut();
                        $.ajax({
                            url: root + 'ys/session/updaterangoliuserstatus',
                            data: 'user_id=' + id,
                            type: 'POST',
                            dataType: 'json',
                            success: function (result) {
                                $(".signin_popup").hide();
                                $(".popup").hide();
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
                user_color_shade = "#FFFFFF";
                color = "255,255,255";

            }

            //alert(user_color_shade);
            fillcolor();

        }
    });
}


function init_watermark(){
    $("input[rel='password']").val("");
    $("input[rel='password']").focus(function () {
        $(this).attr("type", "password");
    });
    $("input[rel='password']").blur(function () {
        if ($(this).val().length == 0 || ($(this).val()).toLowerCase()=="password")
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

}

function bindHeartLink(obj) {
    $(obj).click(function (e) {
        e.preventDefault();
        var link = $(obj).attr("href");
        if(link=="#login"){
            $(".open_signin").click();
        }
        else {
            var parent = $(obj).closest(".wpfp-span");

            $(parent).load(link + '&ajax=1', function () {
                var lnk = $(parent).find(".wpfp-link");
                bindHeartLink(lnk);

            });
        }
    });
}



function submit_comment(textarea) {
    $("#submit").html("Submitting...");
    current_user_img_url = $(".current_user_img_url").html();
    logged_in = $("span[rel='logged-in-user']").html();
    post_id = $("span[rel='post_id']").html();
    var commentform = textarea.closest(".comment-form"); // find the comment form
    //alert(commentform.find(".comment-status").length);
    if(commentform.find(".comment-status").length==0){

    commentform.prepend('<div class="comment-status" ></div>'); // add info panel before the form to provide feedback or errors

    }
    var statusdiv = commentform.find('.comment-status'); // define the infopanel

    if(logged_in_id!=0) {
            logged_in =$(".logged_in").html();
            var formdata = commentform.serialize();
            statusdiv.html('<p><img src="/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif" style="width:16px;" /></p>');
            var formurl = commentform.attr('action');

            $.ajax({
                type: 'post',
                url: formurl,
                data: formdata,
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    statusdiv.html('<p class="ajax-error" >You might have left one of the fields blank, or be posting too quickly</p>');
                },
                success: function (data, textStatus) {
                    if (data == "success" || textStatus == "success") {
                        if (commentform.find("textarea").val() == "") {
                            statusdiv.html('<p class="ajax-success" >Blank comment is not allowed !</p>');
                            get_bulls_eye();
                        }
                        else {
                            var img_div = '<div class="row">';
                            current_user_img_url = $("#current_user_img_url").html();
                            img_div = img_div + '<div class="profile-img-small"><img src="'+current_user_img_url+'" /></div>';
                            var comment = '<div class="span12"><p class="comment_author">' + logged_in + '</p><p class="comment">' + (textarea.val()).replace("\n", "<br/>") + '</p> </div>';
                            var date = '<div class="span12"><p class="comment_time">' + current_date + '</p></div></div>';
                            statusdiv.html('<p class="ajax-success" ><!--Thanks for your comment. We appreciate your response.--></p>');
                            $(".post_comments_listing").prepend(img_div + comment + date);
                        }
                        textarea.val('');
                    } else {
                        statusdiv.html('<p class="ajax-error" >Please wait a while before posting your next comment</p>');
                        textarea.val('');
                    }
                }
            });

        }
        else {
            statusdiv.html('<p>You must be logged in to share a comment...</p>');
            $("textarea").val("");
        }
    $("#submit").html("Submit");
        return false;
}



function play(obj) {
    var parent = obj.closest(".author_post_read");
    if(parent.length>0){
        var player = obj.next().find("iframe");
        player.addClass("video_playing");
        player.fadeIn();
        parent.find(".play_video").fadeIn();
        parent.find(".featured_video_plus").fadeIn();
        obj.hide();
        var overlay = parent.find(".overlay-text");
        overlay.click();
        overlay.hide();
        var author_img = parent.find(".author_picture");
        author_img.hide();
        var src = player.attr("src");
        src = src.replace("autoplay=0", "autoplay=1");
        player.attr("src", src);
        var ww = $(window).width();
        playing_video = true;
        parent.height(ww * 0.5625);
    }
}


$(window).scroll(function(){
    $(".sharing_box").fadeOut();
    $(".signup-signin-block").fadeIn();
    console.log("scrolled...");
});


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

function get_cart(){
    $.ajax({
        url:root +"ys/session/getcartcount",
        success : function(response)
        {
            if(response>0)
            {
                $("span.cart").html(response);
                $(".shopping_cart svg rect").css("fill","#fff");
                $(".shopping_cart svg path").css("fill","#fff");
            }
        }
    })
}

function fillcolor(){
    $(".user-color-shade").css("background-color",user_color_shade);
    $(".user-color-shade-trans").css("background-color","rgba("+hexToRgb(user_color_shade)+",0.95"+")");
    $(".user-color-shade-text").css("color",user_color_shade);
}

$(window).load(function(){
    if(logged_in==false) {
        $.ajax({
            url: root+'rangoli/checkfornewcustomer.php',
            dataType: 'json',
            success: function(response){
                var  customer = response.customer;
                var  bullseye = response.bullseye;
                if(customer == "new"){
                    $(".signin_popup").fadeOut();
                    $(".after_signup_popup").fadeOut();
                    clearForm();
                    $(".signup_popup").fadeIn();
                    $(".popup").fadeIn();
                    is_login_box_open = false
                }

            }
        });
    }

});



$(document).ready(function(){
    getloggedinuser();
    $(".close_login_popup").click(function(){
        $(".signin_popup").fadeOut();
        $(".signup_popup").fadeOut();
        $(".after_signup_popup").fadeOut();
        $(".popup").fadeOut();
    });
    $(".close_signup_popup").click(function(){
        $(".signin_popup").fadeOut();
        $(".signup_popup").fadeOut();
        $(".after_signup_popup").fadeOut();
        $(".popup").fadeOut();
    });
    $(".close_after_signup_popup").click(function(){
        $(".signup_popup").fadeOut();
        $(".signin_popup").fadeOut();
        $(".after_signup_popup").fadeOut();
        $(".popup").fadeOut();
    });
    $(".open_signin").click(function(){
        $(".signup_popup").fadeOut();
        $(".after_signup_popup").fadeOut();
        $(".signin_popup").fadeIn();
        $(".popup").fadeIn();
        clearForm();
        $(".login_form").show();
        $(".forgot_password_form").hide();
        $(".close_menu").click();
    });
    $(".open_signup").click(function(){
        $(".signin_popup").fadeOut();
        $(".after_signup_popup").fadeOut();
        $(".signup_popup").fadeIn();
        $(".popup").fadeIn();
        clearForm();
        $(".close_menu").click();
    });
});

function clearForm(){
    $("p.small.err_msg").html("");
    $("input[name='fame']").val("");
    $("input[name='lname']").val("");
    $("input[name='email']").val("");
    $("input[name='password']").val("");
    init_watermark();
}





$(document).ready(function () {

    checkIsUserLogged();

    $(".create_account").click(function () {
        createCustomerAccount();
    });

    $(".login_customer").click(function () {
        loginCustomer();
    });

});


/* //////////////////////////////LOGIN LOGIC FOR RANGOLI////////////////////////////////// */

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};

function createCustomerAccount() {
    var fname = jQuery.trim(jQuery(".singup_form input[name='fname']").val());

    var lname = jQuery.trim(jQuery(".singup_form input[name='lname']").val());

    var email_id = jQuery.trim(jQuery(".singup_form input[name='email']").val());

    var pwd = jQuery.trim(jQuery(".singup_form input[name='password']").val());

    var cpassword = pwd;

    var gender = $.trim($(".gender.selected input").val());

    var url = homeUrl + 'mycatalog/myproduct/registercustomer';
    var button_html = jQuery(".create_account").html();

    var gender_selected = false;
    $(".gender").each(function(){
        if($(this).hasClass("selected")){
            gender_selected = true;
        }
    });

    if(fname=="" || fname=="First Name"){
        $(".singup_form .err_msg").html("Please fill your first name");
    }
    else if(lname=="" || lname=="Last Name"){
        $(".singup_form .err_msg").html("Please fill your last name");
    }
    else if(email_id=="" || email_id=="Email"){
        $(".singup_form .err_msg").html("Please fill your email id");
    }
    else if(!isValidEmailAddress(email_id)){
        $(".singup_form .err_msg").html("Please enter a valid email id");
    }
    else if(pwd=="" || pwd=="Select a password"){
        $(".singup_form .err_msg").html("Please choose a password");
    }
    else if(pwd.length<6){
        $(".singup_form .err_msg").html("Password must be of 6 or more characters");
    }
    else if(gender_selected == false){
        $(".singup_form .err_msg").html("Select Gender");
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
                'gender':gender
            },
            beforeSend: function () {
                jQuery(".create_account").html("signing up...");
                $(".singup_form .err_msg").html("");
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
                }
                else {
                    jQuery(".create_account").html(button_html);
                    $(".singup_form .err_msg").html(data.errors);
                }
            }
        });
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
        }
    });
}

/**************** ys team functions *****************/

function loginCustomer() {

    var email_id = jQuery.trim(jQuery(".login_form input[name='email']").val());
    var pwd = jQuery.trim(jQuery(".login_form input[name='password']").val());
    var url = homeUrl + 'mycatalog/myproduct/logincustomer';
    var button_html = jQuery(".login_customer").html();

    if(email_id=="" || email_id=="Email"){
        $(".err_msg").html("Please fill your email id");
    }
    else {
        jQuery.ajax({
            url: url,
            type: 'POST',
            data: {'email': email_id, 'pwd': pwd},
            beforeSend: function () {
                jQuery(".login_customer").html("Signing in...");
                $(".err_msg").html("");
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

                    jQuery(".login_customer").html(button_html);
                    $(".err_msg").html(data.errors);
                }
            }

        });
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

/*
                    jQuery("#welcome-name").html("Hi " + first_name).attr("href", homeUrl + 'customer/account/');
                    jQuery(".login_logout_link").html("<span style='cursor:pointer; margin-left:0;padding-left:0' onclick='wplogout()'>SIGN OUT</span>");
*/

                }
            }
        }
    });
}


/* /////////////////////////////////////////////////////////////////////////////////////// */




$(document).ready(function(){

    $(".not_logged_in").click(function(){
        $(".signin_popup").fadeIn();
        $(".popup").fadeIn();
    });

    $(".like").click(function () {
        if(logged_in_id!=0){
            if ($(this).attr("author") != "not-logged") {
                var author = jQuery(this).attr("author");
                var subscriber = jQuery(this).attr("user");

                if ($(this).hasClass("unsubscribed")) {
                    $(this).find("path").css({
                        "fill": "#fff",
                        "stroke": "#fff",
                        "transition-duration": "500ms"
                    });

                    subscribe_author(author, subscriber, $(this));
                }
                else {
                    unsubscribe_author(author, subscriber, $(this));
                    $(this).find("path").css({
                        "fill": "transparent",
                        "stroke": "#fff"
                    })
                }
            }
        }
        else{
            $(".open_signin").click();
        }
    });
});


function subscribe_author(author_id, subscriber_id, obj) {
    $.ajax({
        url: root + 'ys/session/updaterangolisubscribedauthorsstatus?status=active&author_id=' + author_id + '&subscriber_id=' + subscriber_id,
        type: 'POST',
        dataType: 'json',
        success: function (result) {
            if (result.message == 'success') {
                $(obj).css("display", "block");
                $(obj).removeClass("unsubscribed");
                $(obj).addClass("subscribed");
                $(obj).find("path").css({
                    "fill": user_color_shade, "stroke": user_color_shade,
                    "transition-duration": "500ms"
                });
                $(obj).find("p").html(parseInt($(obj).find("p").html()) + 1);
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
                $(obj).removeClass("subscribed");
                $(obj).addClass("unsubscribed");
                $(obj).find("p").html(parseInt($(obj).find("p").html()) - 1);
            }

        }
    });
}






function raty_init() {

    if(logged_in_id!=0) {
        $(".rate_btn").click(function () {
            $(this).addClass('rated');
        });
    }



        $('.do_rating').raty({
            path: root + 'rangoli/wp-content/themes/rangoli_mobile/images',
            click: function (score, evt) {
                //if (logged_in != null && logged_in != '' && logged_in != undefined) {
                if(logged_in_id!=0) {
                    var subject_id = $(this).attr("post_id");
                    $.ajax({
                        url: root + "rangoli/rating.php",
                        type: 'GET',
                        data: 'rating_value=' + score + '&subject_type=post&subject_id=' + subject_id,
                        success: function (result) {
                        }

                    });
                }
                else{
                    $(".open_signin").click();
                }
            },
            starOn: 'star-on.png',
            starOff: 'star-off.png'
        });
        $(".rating").each(function () {
            $(this).raty({
                score: $(this).attr('rel'),
                path: root + 'rangoli/wp-content/themes/rangoli/images',
                readOnly: true
            });
        });



}



$(document).ready(function(){
    animate_charms();
    save_shares();
    invite_friend();
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
                        $(".username_journey").html(username.toUpperCase());
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


    $(".read_more").click(function(){
        $(".dots_for_text").toggle();
        $(".extra-text").toggle();

        if($(".extra-text").css("display")=="inline"){
            $(this).html("Read Less");
        }
        else{
            $(this).html("Read More");
        }
    });
    $(".link").load(root + "profile/manage/referralurl");
    $(".email_invite").click(function () {
        var shareUrl = $(document).find(".link").html();
        var url = "mailto:?subject=I wanted you to see this site&body=Check out the color game at " + shareUrl;
        window.open(url, "Invite friends on facebook", "height=500, width=700");
    });
    $(".twitter_invite").click(function () {
        var shareUrl = $(document).find(".link").html();
        window.open(root + "rangoli/wp-content/themes/rangoli_mobile/twt_redirect.php?l=" + shareUrl);
    });

});

function animate_charms(){
    var scroll_top;
    $(".smogi_charm").each(function(){
        scroll_top = $(this).offset().top - $(window).scrollTop();
        if(scroll_top < 250){
            $(this).css("visibility","visible");
        }
        else{
            $(this).css("visibility","hidden");
        }
        console.log(scroll_top);
    });
}
$(window).scroll(function(){
   animate_charms();
});


function save_shares() {
    $(".sharing_box a").not($(".wpfp-span a")).click(function(){
        if (logged_in_id!=0) {
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
    copytoClipboard();
});

function copytoClipboard(){
    var link =$(".link").html();
    //alert(link);
    $(".copy_link").attr("data-clipboard-text",link);
    var client = new ZeroClipboard($(".copy_link"));

    client.on( "ready", function( readyEvent ) {
        //alert("done");
        client.on( "aftercopy", function( event ) {

        } );
    } );


}


function invite_friend(){
    $(".invite-friend").click(function(){
        if(logged_in_id == 0){
            $(".open_signin").click();
        }
        else{
            window.location = "/rangoli/connect";
        }
    });
}