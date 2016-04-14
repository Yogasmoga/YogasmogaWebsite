/**
 * Created by BlankO on 13-04-2016.
 */
jQuery(function($){


    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl;
    if(_usesecureurl)
        url = securehomeUrl;


    jQuery.ajax({
        type: 'POST',
        url: url+ 'careers/index/getcaliforniajobs',
        data: {'state': '1'},
        beforeSend:function (data) {
            jQuery("#content-loader").show();

        },
        success: function (data) {
            jQuery("#content-loader").hide();
            jQuery("#jobdata").html(data);
            jQuery('.job-title-list a[href*="#"]:not([href="#"])').click(function() {
                //alert();
                if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                    if (target.length) {
                        $('html, body').animate({
                            scrollTop: target.offset().top-104
                        }, 1000);
                        return false;
                    }
                }
            });
        },
        error: function() {
            alert('Sorry for inconvinious try after some time');
        },

    });


    jQuery("#job-state-link ul.state-link li a").click(function(e){
        e.preventDefault();
        var state = jQuery(this).attr('rel');
        jQuery.ajax({
            type: 'POST',
            url: url + 'careers/index/getstatejobs',
            data: {'state': state},
            beforeSend:function (data) {
                jQuery("#content-loader").show();
                jQuery("#jobdata").hide();
            },
            success: function (data) {
                jQuery("#content-loader").hide();
                jQuery("#jobdata").show()
                jQuery("#jobdata").html(data);
                jQuery('.job-title-list a[href*="#"]:not([href="#"])').click(function() {
                    //alert();
                    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                        var target = $(this.hash);
                        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                        if (target.length) {
                            $('html, body').animate({
                                scrollTop: target.offset().top-104
                            }, 1000);
                            return false;
                        }
                    }
                });
            },
            error: function() {
                alert('Sorry for inconvinious try after some time');
            },

        });
    });



    $('#jobtabs .state-link a').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 400);
        $('#jobtabs .state-link a').removeClass('current');
        $(this).addClass('current');
    });
    $(window).scroll(function() {
        if(jQuery("body").hasClass("career-index-index")){
            var element = jQuery(".side-menu-bar-jobs");
            leftNav_scroll(element);
        }
    });

});