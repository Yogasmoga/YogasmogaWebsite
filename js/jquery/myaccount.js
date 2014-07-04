var _refercount = 1;
_usesecureurl = true;
jQuery(document).ready(function($){

    if(_enablediscounttype == 'giftcard')
    {
        $("div.smogi-bucks").append("<div class='disableme'></div>");
        $("div.smogi-bucks").append("<input class='discounttoggler' type='radio' name='discounttoggle' id='rdbtnsmogi' />");
        $("div.gift-card").append("<input class='discounttoggler' type='radio' name='discounttoggle' id='rdbtngifty' checked='checked' />");
    }    
    if(_enablediscounttype == 'smogibucks')
    {
        $("div.gift-card").append("<div class='disableme'></div>");
        $("div.gift-card").append("<input class='discounttoggler' type='radio' name='discounttoggle' id='rdbtngifty' />");
        $("div.smogi-bucks").append("<input class='discounttoggler' type='radio' name='discounttoggle' id='rdbtnsmogi' checked='checked' />");
        
    }
    
    $("#rdbtngifty").live('change', function(){
        $("#rdbtnsmogi").removeAttr("checked");
        $("body").append('<div class="namaskar-overlay1" style="">&nbsp;</div>');
        window.location = homeUrl + 'checkout/cart?active=giftcard';
    });
    
    $("#rdbtnsmogi").live('change', function(){
        $("#rdbtngifty").removeAttr("checked");
        $("body").append('<div class="namaskar-overlay1" style="">&nbsp;</div>');
        window.location = homeUrl + 'checkout/cart?active=smogibucks';
    });
    
    setTimeout(function(){
        $("#password_password, #password_confirmation").attr("autocapitalize","off").attr("autocorrect","off");
        $("#email_address").attr("autocapitalize","off");
    }, 500);
        
    $("button.gotologin").click(function(){
        window.location = securehomeUrl + 'customer/account/login?goto=cart';
    });
    
    $("#login-form").submit(function(){
        return validateLoginForm();
        //alert($("#login-form").serialize());
        //console.log($("#login-form").serialize());
        //return false;
    });
    
    $("#forgot-password-form").submit(function(){
        return validateForgotPasswordForm();
    });
    
    $("#register-form").submit(function(){
        if(validateRegistrationForm())
        {
            $("#register-form #firstname").val(ucFirstAllWords($("#register-form #firstname").val()));
            $("#register-form #lastname").val(ucFirstAllWords($("#register-form #lastname").val()));
            return true;
        }
        else
            return false;
    });
    
    $("#wishlist-view-form").submit(function(){
        $(this).find("textarea").each(function(){
            if($(this).val() == "")
                $(this).val(' ');
        });
    });
    
    $("#form-share-wishlist").submit(function(){
        return validateWishlistForm();
    });
    
    $("#edit-accountinfo").submit(function(){
        if(validateAccountEditForm())
        {
            $("#edit-accountinfo #firstname").val(ucFirstAllWords($("#edit-accountinfo #firstname").val()));
            $("#edit-accountinfo #lastname").val(ucFirstAllWords($("#edit-accountinfo #lastname").val()));
            return true;
        }
        else
            return false;
    });
    $("#change_password").click(function(){
        // togglePasswordChangeOption();
    });
    if($("#change_password").length > 0)
        // togglePasswordChangeOption();
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
    
    $("#giftcardformmyaccount").submit(function(){
        
        return validateGiftCardForm($("#giftcardformmyaccount table.gfredeem"));
        //return false;
    });
    $("div#addanotherreferral").click(function(){        
        $("table.referfriendforms tbody#main").append("<tr id='" + (++_refercount) + "'>" + $("table.referfriendforms tr#template").html() + "</tr>");        
        //$("table.referfriendforms tbody#main td.remove").show();
        $("table.referfriendforms tbody#main tr[id]").each(function(){
            //console.log($(this).find("td.btninvite").css('display'));
            if($(this).find("td.btninvite").css('display') != 'none')
            {
                $(this).find('td.remove').show();
            }
        });
        //console.log('adf');
    });
    
    $("table.referfriendforms td.remove img").live('click', function(){
        if($(this).parents("table:first").find("tbody#main>tr").length > 2)
        {
            $(this).parents("tr:first").remove();
            if($("table.referfriendforms tbody#main>tr").length <= 2)
                $("table.referfriendforms tbody#main td.remove").hide();
        }   
    });
    
    $("table.referfriendforms td.btninvite div").live('click', function(){
        var tr = $(this).parents('tr:first');
        if(validatereferform(tr))
            referafriend(tr.find('td.name input').val(), tr.find('td.email input').val(), tr.attr('id'));
    });
    
    $("table.referfriendforms input").live('keypress', function(event){
        if (event.which == 13) {
            var tr = $(this).parents('tr[id]:first');
            if(validatereferform(tr))
                referafriend(tr.find('td.name input').val(), tr.find('td.email input').val(), tr.attr('id'));
        }
    });
    
    $("div#copyurl").click(function(){
        $("input#uniquelink").select();
    });
    
    $("#createcardform").submit(function(){
        if(validateCreateGiftCardForm())
        {
            _addingtocart = true;
            createcard();   
        }
        return false;
    });
    
    $("#cardbalanceform").submit(function(){
        if(validateGiftCardForm($("#cardbalanceform table.gfredeem")))
        {
            _addingtocart = true;
            getcardbalance();   
        }
        return false;
    });
    
    $("#cardredeemform").submit(function(){
        if(validateGiftCardRedeemForm())
        {
            _addingtocart = true;
            redeemcard();   
        }
        return false;
    });
    
    $("#form-validate-resetpassword").submit(function(){
        return validateResetPasswordForm();
    });
    
    $("#discountFormPoints2").submit(function(){
        return validateSmogibuckpoints();
    });
    
    $("#giftcard-form").submit(function(){
        if(validateGiftCardForm($("#giftcard-form table.gfredeem")))
        {
            $('#giftcard_use').attr("checked","checked");// .checked = "checkbox";
            $('#giftcard_use').val('1');//ue = "1";
            return true;
        }
        return false;
    });
    
    //if($("#giftcardActive #giftcard_use:checked").length == 0)
//    {
//        $('#giftcard_use').attr("checked","checked");
//        $("#giftcardActive").submit();
//    }
});

function validateSmogibuckpoints()
{
    jQuery("#points_error").html();
    jQuery("#points_to_be_used").removeClass('error');
    if(jQuery("#discountFormPoints2 input[type='text']").length > 0)
    {
        var flag = true;
        if(jQuery("#points_to_be_used").val().length == 0)
        {
            jQuery("#points_error").html('Amount is required.').fadeIn('fast');
            jQuery("#points_to_be_used").addClass('error');
            flag = false;
        }
        if(jQuery("#points_to_be_used").val().length > 0)
        {
            if(!isNormalInteger(jQuery("#points_to_be_used").val()))
            {
                jQuery("#points_error").html('Invalid Amount. Must be an integer.').fadeIn('fast');
                jQuery("#points_to_be_used").addClass('error');
                flag = false;
            }
            else
            {
                if((jQuery("#points_to_be_used").val() * 1) > (jQuery("span#tpoints").html() * 1))
                {
                    jQuery("#points_error").html('Insufficient Points. Maximum points is ' + jQuery("span#tpoints").html()).fadeIn('fast');
                    jQuery("#points_to_be_used").addClass('error');
                    //setOnError(jQuery("#card-amount"),"Maximum value of a Card is 1000");
                    flag = false;    
                }
            }
        }
        return flag;
    }
    else
        return true;
}

function validateResetPasswordForm()
{
    unsetAllError(jQuery("#form-validate-resetpassword"));
    var flag = validatefields(jQuery("#form-validate-resetpassword"));
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
    return flag;
}

function sharereferlink(sharetype, url)
{
    //var shareurl = jQuery("input#uniquelink").val();
    var shareurl = (typeof url === "undefined") ? jQuery("input#uniquelink").val() : url;
    if(_curshareimgurl == '')
        _curshareimgurl = 'https://yogasmoga.com/yogasmoga_gold.jpg';
    switch(sharetype)
    {
    case 'mail':
        window.location = "mailto:?Subject=" + encodeURIComponent("YOGASMOGA | Refer-A-Friend") + "&body=" + encodeURIComponent("Check out YOGASMOGA. They make things for Life. One breath at a time at " + shareurl);
        break;
    case 'facebook':
        window.open('http://www.facebook.com/sharer.php?s=100&p[url]=' + encodeURIComponent(shareurl) + '&p[images][0]=' + _curshareimgurl + '&p[title]=YOGASMOGA | Refer-A-Friend' + '&p[summary]=Check out YOGASMOGA. They make things for Life. One breath at a time.','Share_on_Faceook','toolbar=0,status=0,menubar=0,width=600,height=300,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 300) / 2);
        break;
    case 'twitter':
        //window.open('http://www.twitter.com/share?url=' + encodeURIComponent(shareurl),'Share_on_Twitter','toolbar=0,status=0,menubar=0,width=600,height=450,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 450) / 2);
        _twdesc = "Check out YOGASMOGA. They make things for Life. One breath at a time";
        window.open('http://www.twitter.com/home?status=' + _twdesc + ' via @yogasmoga at ' + encodeURIComponent(shareurl),'Share_on_Twitter','toolbar=0,status=0,menubar=0,width=600,height=450,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 450) / 2);
        break;
    case 'pinterest':
        window.open('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(shareurl) + '&media=' + _curshareimgurl + '&description=Yogasmoga Video','Share_on_Pinterest','toolbar=0,status=0,menubar=0,width=600,height=520,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 520) / 2);
        break;
    default:
    }
}

function validatereferform(elem)
{
    unsetAllError(elem);
    var flag = validatefields(elem);
    if(elem.find('td.email input').val() != "")
    {
        if(!validateEmail(elem.find('td.email input').val()))
        {
            setOnError(elem.find('td.email input'), "Please enter a valid Email Address.");
            flag = false;
        }
    }
    return flag;
}

function referafriend(name, email, id)
{
    jQuery.ajax({
        type : 'POST',
        url : securehomeUrl + 'mycatalog/myproduct/referfriend',
        //data : {'name[]':name,'email[]':email,'id':id},
        data : {'name':name,'email':email,'id':id},
        beforeSend : function(){
            var tr = jQuery("table.referfriendforms tr#" + id);
            tr.find('td.btninvite').hide();
            tr.find('td.remove').hide();
            tr.find('td.processing').show();
        },
        success : function(result){
            //console.log('success');
            result = eval('(' + result + ')');
            if(result.status == 'success')
            {
                var tr = jQuery("table.referfriendforms tr#" + result.id);
                tr.find('input').attr('readonly','true');
                tr.find('td.processing').hide();
                tr.find('td.btninvite').hide();
                tr.find('td.btninvited').show();
                tr.find('td.success').show();
                var html = "<tr><td class='name'><div>" + tr.find('td.name input').val() + "</div></td><td class='email'><div>" + tr.find('td.email input').val() + "</div></td><td class='status'></td></tr>";
                jQuery("table.referredfriendslist tbody#main").append(html);
                jQuery("table.referredfriendslist").show();
                jQuery("p#noreferralmsg").hide();
            }
            else
            {
                var tr = jQuery("table.referfriendforms tr#" + result.id);
                tr.find('td.email td.errortext div').html(result.message).show();
                tr.find('td.email table.inputtable').addClass('error');
                tr.find('td.btninvite').show();
                if(jQuery("table.referfriendforms tbody#main>tr").length > 2)
                    tr.find('td.remove').show();
                tr.find('td.processing').hide();
            }
        }
    });
}

function validateGiftCardForm(tbl)
{
    //jQuery("table.gfredeem td.inputholder input").removeClass('error');
    //var tbl = jQuery("table.gfredeem");
    tbl.find('td.errortext div').fadeOut('fast').removeAttr('class');
    var flag = 0;
    tbl.find('input[type="text"]').each(function(){
        if(jQuery(this).val() == '')
        {
            //console.log(jQuery(this).val());
            flag = flag + 1;
        }
    });
    if(flag == 3)
    {
        tbl.find('td.errortext div').html('Gift of YS Code is required.').fadeIn('fast');
    }
    else if(flag > 0)
    {
        tbl.find('td.errortext div').html('Invalid Gift of YS Code.').fadeIn('fast');
    }
    if(flag == 0)
        flag = true;
    else
        flag = false;
    if(flag)
    {
        jQuery("input#giftcard_code").val(jQuery("input#gf1").val() + "-" + jQuery("input#gf2").val() + "-" + jQuery("input#gf3").val());
        jQuery("input#cardno").val(jQuery("input#gf1").val() + "-" + jQuery("input#gf2").val() + "-" + jQuery("input#gf3").val());
    }
    else
    {
        //jQuery("table.gfredeem td.inputholder input").addClass('error');
    }
    return flag;
    
    jQuery("#giftcardformmyaccount").find('table.inputtable td.errortext').html('<div></div>');
    unsetAllError(jQuery("#giftcardformmyaccount"));
    var flag = validatefields(jQuery("#giftcardformmyaccount"));
    return flag;
}

function validateGiftCardRedeemForm()
{
    var tbl = jQuery("table#redeem");
    tbl.find('td.errortext div').fadeOut('fast').removeAttr('class');
    var flag = 0;
    tbl.find('input[type="text"]').each(function(){
        if(jQuery(this).val() == '')
        {
            //console.log(jQuery(this).val());
            flag = flag + 1;
        }
    });
    if(flag == 3)
    {
        tbl.find('td.errortext div').html('Gift of YS Code is required.').fadeIn('fast');
    }
    else if(flag > 0)
    {
        tbl.find('td.errortext div').html('Invalid Gift of YS Code.').fadeIn('fast');
    }
    if(flag == 0)
        flag = true;
    else
        flag = false;
    if(flag)
    {
        jQuery("input#giftcard_code").val(jQuery("input#gfr1").val() + "-" + jQuery("input#gfr2").val() + "-" + jQuery("input#gfr3").val());
    }
    return flag;
}

function validateWishlistForm()
{
    unsetAllError(jQuery("#form-share-wishlist"));
    var flag = validatefields(jQuery("#form-share-wishlist"));
    if(jQuery("#email_address").val() != "")
    {
        var valid_regexp = /^[a-z0-9\._-]{1,30}@([a-z0-9_-]{1,30}\.){1,5}[a-z]{2,4}$/i;
        var emails = jQuery("#email_address").val().split(',');
        for (var i=0; i<emails.length; i++) {
            if(!valid_regexp.test(emails[i].strip())) {
                flag = false;
                setOnError(jQuery("#email_address"), "Please enter valid email addresses, separated by commas");
                break;    
            }
        }
    }
    return flag;
}

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
    //console.log(currentstate);
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
    jQuery("select#region_id option[value='']").html("Select State");
}

function validateCreateGiftCardForm()
{
    unsetAllError(jQuery("#createcardform"));
    var flag = validatefields(jQuery("#createcardform"));
    if(jQuery("#mail-to-email").val() != "")
    {
        if(!validateEmail(jQuery("#mail-to-email").val()))
        {
            setOnError(jQuery("#mail-to-email"), "Please enter a valid Email Address.");
            flag = false;    
        }
    }
    if(jQuery("#mail-to-email-conf").val() != "")
    {
        if(!validateEmail(jQuery("#mail-to-email-conf").val()))
        {
            setOnError(jQuery("#mail-to-email-conf"), "Please enter a valid Email Address.");
            flag = false;    
        }
    }
    if(jQuery("#mail-to-email").val() != "" && jQuery("#mail-to-email-conf").val() != "")
    {
        if(jQuery("#mail-to-email").val() != jQuery("#mail-to-email-conf").val())
        {
            setOnError(jQuery("#mail-to-email-conf"),"Please make sure the Email Addresses match.");
            flag = false;
        }
    }
    if(jQuery("#card-amount").val().length > 0)
    {
        if(!isNormalInteger(jQuery("#card-amount").val()))
        {
            setOnError(jQuery("#card-amount"),"Invalid Amount. Must be an integer.");
            flag = false;
        }
        else
        {
            if((jQuery("#card-amount").val() * 1) > 1000)
            {
                setOnError(jQuery("#card-amount"),"Maximum value of a Card is 1000");
                flag = false;    
            }
        }
        //else if((jQuery("#card-amount").val() * 1) <= 0)
//        {
//            setOnError(jQuery("#card-amount"),"Invalid Amount. Must be an integer.");
//            flag = false;
//        }   
    }
    return flag;
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

function getcardbalance()
{
    var callurl = '';
    if(window.location.href.indexOf('https://') >= 0)
        callurl = securehomeUrl + 'mycatalog/myproduct/getgiftcardbalance'
    else
         callurl = homeUrl + 'mycatalog/myproduct/getgiftcardbalance'
    jQuery.ajax({
        type : 'POST',
        url : callurl,
        data : jQuery("#cardbalanceform").serialize(),
        success : function(result){
            result = eval('(' + result + ')');
            _addingtocart = false;
            if(result.status == 'success')
            {
                jQuery("table.gfredeem").find('td.errortext div').html('Your Gift of YS Card balance is: ' + result.balance + '.').fadeIn('fast').addClass('success');
                //alert("Your balance is: $" + result.balance);
            }
            else
            {
                //alert(result.message);
                jQuery("table.gfredeem").find('td.errortext div').html('Invalid Gift of YS Code.').fadeIn('fast');
            }
        }
    });
}

function redeemcard()
{
    var callurl = '';
    if(window.location.href.indexOf('https://') >= 0)
        callurl = securehomeUrl + 'myessentials/mylink/applycard'
    else
         callurl = homeUrl + 'myessentials/mylink/applycard'
    jQuery.ajax({
        type : 'POST',
        url : callurl,
        data : jQuery("#cardredeemform").serialize(),
        success : function(result){
            result = eval('(' + result + ')');
            if(result.result == 'success')
            {
                jQuery("#curbalance").html('$' + result.balance);
                jQuery("table#redeem").find('td.errortext div').html('Your Gift of YS Card has been added to your account.').fadeIn('fast').addClass('success');
                //alert('Gift of YS Card successfully redeemed.');
            }
            else
            {
                jQuery("table#redeem").find('td.errortext div').html(result.result).fadeIn('fast');
            }
        }
    });
}

function createcard()
{
    jQuery.ajax({
        type : 'POST',
        url : homeUrl + 'mycheckout/mycart/add',
        data : jQuery("#createcardform").serialize(),
        success : function(result){
            result = eval('(' + result + ')');
            _addingtocart = false;
            if(result.status == 'success')
            {
                if(_productdisplaymode == "popup")
                    jQuery( "#productdetailpopup" ).dialog( "close" );
                jQuery("span.cartitemcount").html(result.count);
                jQuery("div#myminicart").html(result.html);
                jQuery("div#myminicart").slideDown('slow', function(){
                    setTimeout(function(){ jQuery("div#myminicart").slideUp('slow'); }, 4000);
                });
            }
            else
            {
                alert('Oops! An unexpected error occured.');
            }
            //
//            result = eval('(' + result + ')');
//            if(result.status == "0")
//                jQuery("#footernotification").html(result.message).removeClass("success").addClass("error").fadeIn();
//            else
//                jQuery("#footernotification").html(result.message).removeClass("error").addClass("success").fadeIn();
            //setTimeout(function(){ rremovenotifications(); }, 5000);
        }
    });
}