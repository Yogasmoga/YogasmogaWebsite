jQuery.noConflict();
var AjaxLoginForm = new VarienForm("ajaxlogin_form");

    jQuery(document).ready(function () {
        init_watermark();
        jQuery(".login_customer").click(function (e) {
            e.preventDefault();
            loginCustomer();
        });


    });

    AjaxLoginLoader = "<div class='ajax_login_loader'>&nbsp;</div>";
    AjaxLoginForm.insertLoader = function (element) {
        // show ajax image
        //element.insert({"after":AjaxLoginLoader});
    }

    AjaxLoginForm.hideLoader = function () {
        $$(".ajax_login_loader").each(function (elem) {
            elem.remove();
        });
    }

    AjaxLoginForm.showForgotPwdForm = function (pwdFieldId, forgotPwdFlagFieldId) {
        $(pwdFieldId).toggle("blind");
        $(forgotPwdFlagFieldId).value = 1;

        $$("li.ajaxlogin_forgot_pwd_actions").each(function (elem) {
            elem.toggle("blind");
        });

        $$("li.ajaxlogin_actions").each(function (elem) {
            elem.toggle("blind");
        });
    }

    AjaxLoginForm.showLoginForm = function (pwdFieldId, forgotPwdFlagFieldId) {
        $(pwdFieldId).toggle("blind");
        $(forgotPwdFlagFieldId).value = 0;

        $$("li.ajaxlogin_actions").each(function (elem) {
            elem.toggle("blind");
        });

        $$("li.ajaxlogin_forgot_pwd_actions").each(function (elem) {
            elem.toggle("blind");
        });
    }
    AjaxLoginForm.hideLoginContainer = function () {
        $$('ul.popup').each(function (containerEl) {
            containerEl.style.display = "none";
            document.getElementById("dullDiv").style.display = "none";
        });
    }

    AjaxLoginForm.hideResponseMessage = function () {
        $('ajaxlogin_form_message').toggle("blind");
        setTimeout("$('ajaxlogin_form_message').innerHTML = '';", 3000);
    }
    $$('ul.popup').each(function (containerEl) {
        containerEl.style.display = "none";
    });

    function openLogin() {
        init_watermark();
        document.getElementById("menu_container").style.display = "none";
        document.getElementById("cross-btn").style.display = "none";
        document.getElementById("dullDiv").style.display = "block";
        setDivPosition('loginPopupDiv');
    }
    function setDivPosition(divId) {  // USED TO SET POSITION OF DIV
        var DivShowed = document.getElementById(divId);
        var scrollTop = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop
        var myHeight = window.innerHeight ? window.innerHeight : (document.documentElement.clientHeight ? document.documentElement.clientHeight : (document.body.clientHeight ? document.body.clientHeight : 0))
        var clientWid = document.documentElement.clientWidth ? document.documentElement.clientWidth : document.body.clientWidth;
        //DivShowed.style.left = ((clientWid-DivShowed.offsetWidth)/2)+'px';
        //DivShowed.style.top = ((parseInt(myHeight) - DivShowed.offsetHeight)/2)+'px';
        document.getElementById(divId).style.display = "block";
    }