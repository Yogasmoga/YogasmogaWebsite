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