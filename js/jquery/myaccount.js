var _refercount = 1;
_usesecureurl = true;
jQuery(document).ready(function($){
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
        return validateRegistrationForm();
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
        return validateAccountEditForm();
    });
    $("#change_password").click(function(){
        togglePasswordChangeOption();
    });
    if($("#change_password").length > 0)
        togglePasswordChangeOption();
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
        return validateGiftCardForm();
    });
    $("div#addanotherreferral").click(function(){
        $("table.referfriendforms tbody#main").append("<tr id='" + ++_refercount + "'>" + $("table.referfriendforms tr#template").html() + "</tr>");
        $("table.referfriendforms tbody#main td.remove").show();
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
        _addingtocart = true;
        getcardbalance();
        return false;
    });
    
    $("#form-validate-resetpassword").submit(function(){
        return validateResetPasswordForm();
    }); 
});

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

function sharereferlink(sharetype)
{
    var shareurl = jQuery("input#uniquelink").val();
    if(_curshareimgurl == '')
        _curshareimgurl = 'https://yogasmoga.com/yogasmoga_gold.jpg';
    switch(sharetype)
    {
    case 'mail':
        window.location = "mailto:?Subject=" + encodeURIComponent("My Referral link!!") + "&body=" + encodeURIComponent("My referral link on YOGASMOGA : " + shareurl);
        break;
    case 'facebook':
        window.open('http://www.facebook.com/sharer.php?s=100&p[url]=' + encodeURIComponent(shareurl) + '&p[images][0]=' + _curshareimgurl + '&p[title]=My Referral Link' + '&p[summary]=My Referral Link on YOGASMOGA','Share_on_Faceook','toolbar=0,status=0,menubar=0,width=600,height=300,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 300) / 2);
        break;
    case 'twitter':
        window.open('http://www.twitter.com/share?url=' + encodeURIComponent(shareurl),'Share_on_Twitter','toolbar=0,status=0,menubar=0,width=600,height=450,left=' + (_winW - 600) / 2 + ',top=' + (_winH - 450) / 2);
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
        data : {'name[]':name,'email[]':email,'id':id},
        beforeSend : function(){
            var tr = jQuery("table.referfriendforms tr#" + id);
            tr.find('td.btninvite').hide();
            tr.find('td.remove').hide();
            tr.find('td.processing').show();
        },
        success : function(result){
            console.log('success');
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

function validateGiftCardForm()
{
    jQuery("#giftcardformmyaccount").find('table.inputtable td.errortext').html('<div></div>');
    unsetAllError(jQuery("#giftcardformmyaccount"));
    var flag = validatefields(jQuery("#giftcardformmyaccount"));
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
    jQuery.ajax({
        type : 'POST',
        url : homeUrl + 'mycatalog/myproduct/getgiftcardbalance',
        data : jQuery("#cardbalanceform").serialize(),
        success : function(result){
            result = eval('(' + result + ')');
            _addingtocart = false;
            if(result.status == 'success')
            {
                alert("Your balance is :" + result.balance);
            }
            else
            {
                alert(result.message);
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