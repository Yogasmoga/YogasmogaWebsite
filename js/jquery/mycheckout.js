_stripecheck = false;
_usesecureurl = true;
jQuery(document).ready(function($){
    //if($("div#checkout div:nth-child(2)").html().indexOf("support@intellectlabs.com") > 0)
//        $("div#checkout div:nth-child(2)").hide();
    //if($("div.myheader:first").next().html().indexOf("support@intellectlabs.com") > 0)
//        $("div.myheader:first").next().hide();
    if($("#checkout-shipping-form").length == 0)
    {
        $("#co-billing-form").show();
        //jQuery('select').customSelect();
    }
    $("#checkout-login-form").submit(function(){
        return validateCheckoutLoginForm();
    });
    
    //.html('Select State');
    //window.onbeforeunload = function() {
//        if(!_allowcheckoutexit)
//            if(_checkoutdatachanged)
//                return "If you leave the cart all information will be lost.";
//    }
    
    $('#tblcheckoutsteps input,#tblcheckoutsteps select').live('change', function(){
        _checkoutdatachanged = true;
    });
    
    $("div#checkout-guest-continue").click(function(){
        _checkoutmethod = 'register';
        $("div#billing-password").show();
        $("billing\\:customer_password").addClass('requiredfield');
        $("billing\\:confirm_password").addClass('requiredfield');
        saveCheckoutMethod();
    });
    
    $("div.checkoutsubstep.inactive:not(.disabled)").live('click', function(){
        reordersubsteps($(this));
    });
    
    $("div.checkoutsteps.inactive:not(.disabled)").live('click', function(){
        reordersteps($(this));
    });
    
    if($("select#shipping\\:country_id").length > 0)
    {
        $("select#shipping\\:country_id").attr("class","").addClass('requiredfield').attr("defaulterrormsg","Country is required").removeAttr("title").css("width","156px");
        $("select#shipping\\:country_id").change(function(){
            //console.log('hello');    
            fillShippingState();
        });
        fillShippingState(_curshippingstate);
    }
    
    if($("select#billing\\:country_id").length > 0)
    {
        $("select#billing\\:country_id").attr("class","").addClass('requiredfield').attr("defaulterrormsg","Country is required").removeAttr("title").css("width","156px");
        $("select#billing\\:country_id").change(function(){
            //console.log('hello');    
            fillBillingState();
        });
        fillBillingState(_curbillingstate);
    }
    
    $("#checkout-shipping-form").submit(function(){
        if(validateShippingAddressForm())
        {
            $("#shipping\\:firstname").val(ucFirstAllWords($("#shipping\\:firstname").val()));
            $("#shipping\\:lastname").val(ucFirstAllWords($("#shipping\\:lastname").val()));
            saveShippingAddress();
        }
        return false;
    });
    
    $("#co-shippingmethod-form").live('submit', function(){
        if(jQuery('input:radio[name="shipping_method"]:checked').length > 0)
        {
            $("#shippingmethoderrormsg").html("");
            saveShippingMethod();
        }
        else
        {
            $("#shippingmethoderrormsg").html("Please Choose a Shipping Method.");
        }
        return false;
    });
    
    $("#savestripepayment").live('click', function(){
        savePayment();
    });
    
    $("#co-billing-form").submit(function(){
        if(validateBillingAddressForm())
        {
            //saveShippingAddress();
            $("#billing\\:firstname").val(ucFirstAllWords($("#billing\\:firstname").val()));
            $("#billing\\:lastname").val(ucFirstAllWords($("#billing\\:lastname").val()));
            saveBillingAddress();
        }
        return false;
    });
    
    $("#payment_form").live('submit', function(){
        if(jQuery("#payment_form input[value='free']").length > 0)
        {
            savePayment();
            return false;
        }
        if(validatePaymentForm())
        {
            if(_ischeckoutprocessing)
                return false;
            _ischeckoutprocessing = true;
            jQuery("#payment_form input[type=submit]").hide();
            jQuery("#payment_form input[type=submit]").after("<img id='procImg' src='" + skinUrl + "images/checkout/checkout-loader.gif' />");
            if(_stripecheck)
            {
                if(jQuery("#payment_form input[type='text']").length == 0)
                    savePayment();
                else            
                    CreateStripeToken();   
            }
            else
                savePayment();
        }
        return false;
    });
    designCartTotal();
    $("div#checkout-submit").live('click', function(){
        submitcheckout();
    });
    getCartSummary();
    $("select#shipping-address-select").removeAttr('onchange');
    $("select#shipping-address-select").change(function(){
        if($(this).val() == "")
        {
            $("#checkout-shipping-address-new").show();
            $("#shippingaddressselectionblock").addClass('addressselector');    
			
			//jQuery('select').customSelect();
        }
        else
        {
            $("#checkout-shipping-address-new").hide();
            $("#shippingaddressselectionblock").removeClass('addressselector');
        }
    });
    
    $("select#billing-address-select").removeAttr('onchange');
    $("select#billing-address-select").change(function(){
        checkbillingnewaddress();
        //jQuery('select').customSelect();
    });
    //$("#stripe-update-payment").live
    $("#stripe-update-payment").live('click', function(){
        //console.log("gere");
        if($(this).hasClass('use'))
        {
            $("#change-stripe-detail").show();
            $("#stripe-payment-details").hide();
            $(this).removeClass('use').addClass('unuse');
            $(this).html('Use Existing Payment Information');
            $('#stripe_create_stripe_customer').val("1");
        }
        else
        {
            $("#change-stripe-detail").hide();
            $("#stripe-payment-details").show();
            $(this).removeClass('unuse').addClass('use');
            $(this).html('Change Payment Information');
            $('#stripe_create_stripe_customer').val('0');
        }
    });
    
    $(window).resize(function(){
       positionordersummary(); 
    });    
           
    jQuery("input[type='radio'][value='paypal_express']").live('click', function(){            
            jQuery("ul#payment_form_paypal_express").show();
            jQuery("div#stripe-payment-details").hide();        
    });
    jQuery("input[type='radio'][value='stripe']").live('click', function(){ 
            jQuery("div#stripe-payment-details").show();    
            jQuery("ul#payment_form_paypal_express").hide();    
    }); 
});

function checkbillingnewaddress()
{
    if(jQuery("select#billing-address-select").length == 0)
        return;
    if(jQuery("select#billing-address-select").val() == "")
    {
        jQuery("#billing-new-address-form").show();
        jQuery("#billingaddressselectionblock").addClass('addressselector');    
    }
    else
    {
        jQuery("#billing-new-address-form").hide();
        jQuery("#billingaddressselectionblock").removeClass('addressselector');
    }
}

function getCartSummary()
{
    var url = homeUrl + 'mycheckout/mycart/getCartSummary';
    if(_usesecureurl)
        url = securehomeUrl + 'mycheckout/mycart/getCartSummary';
    jQuery.ajax({
        type : 'POST',
        url : url,
        data : {},
        success : function(result){
            jQuery("div#ordersummary").html(result);
            positionordersummary();
        }
    });
	//jQuery('select').customSelect();
}

function submitcheckout()
{
    if(_ischeckoutprocessing)
        return;
    _ischeckoutprocessing = true;
    jQuery("#checkout-submit").hide();
    jQuery("#checkout-submit").after("<img id='procImg' src='" + skinUrl + "images/checkout/checkout-loader.gif' />");
    var url = homeUrl + 'checkout/onepage/saveOrder';
    if(_usesecureurl)
        url = securehomeUrl + 'checkout/onepage/saveOrder';
    jQuery.ajax({
        type : 'POST',
        url : url,
        data : jQuery("#payment_form").serialize(),
        success : function(result){
            result = eval('(' + result + ')');
            if(typeof result['error_messages'] !== "undefined")
                jQuery("#submiterrormsg").html(result['error_messages']);
            else
            {
                jQuery("#submiterrormsg").html('');
                _allowcheckoutexit = true;
                window.location = homeUrl + 'checkout/onepage/success';
            }
            _ischeckoutprocessing = false;
            jQuery("#checkout-submit").show();
            jQuery("#orderreview #procImg").remove();
        }
    });
}

function designCartTotal()
{
    jQuery("table.co-ov-table tfoot tr:first").addClass('first');
    jQuery("table.co-ov-table tfoot tr:last").addClass('last');
    jQuery("table.co-ov-table tfoot tr").each(function(){
        jQuery(this).find("td:last").addClass('total');
    });
    //jQuery("table.co-ov-table tfoot tr td:last").addClass('total');
}

function reordersubsteps(stp)
{
    var temp = stp;
    while(true)
    {
        if(temp.prev().length > 0)
        {
            temp = temp.prev();
            temp.addClass('inactive').addClass('codivider');
            temp.find("form").hide();
        }
        else
            break;
    }
    temp = stp;
    var isfirst = false;
    while(true)
    {
        if(temp.next().length > 0)
        {
            temp = temp.next();
            temp.addClass('inactive').addClass('disabled').removeClass('codivider');
            temp.find("form").hide();
            temp.hide();
            isfirst = true;
        }
        else
            break;
    }
    if(isfirst)
        stp.removeClass('codivider');
    stp.removeClass('inactive');
    stp.show();
    stp.find("form").show(0, function(){
		//jQuery('select').customSelect();
	});
    //console.log(stp.offset());
//    console.log(jQuery("html").scrollTop());
//    console.log(stp.offset().top - jQuery("html").scrollTop() - _headerHeight);
    //
    
    
    try{
        if((stp.offset().top - jQuery("html").scrollTop() - _headerHeight) < 0)
        {
            //console.log('entered');
            jQuery("html").scrollTop(jQuery("html").scrollTop() + (stp.offset().top - jQuery("html").scrollTop() - _headerHeight));
        }   
    }
    catch(err)
    {
        
    }
}

function reordersteps(stp)
{
    var temp = stp;
    while(true)
    {
        if(temp.prev().length > 0)
        {
            temp = temp.prev();
            temp.addClass('inactive').removeClass('disabled');
            temp.find("div.checkoutsubstep").addClass('inactive');
            temp.find("form").hide();
        }
        else
            break;
    }
    temp = stp;
    while(true)
    {
        if(temp.next().length > 0)
        {
            temp = temp.next();
            temp.addClass('inactive').addClass('disabled');
            temp.find("div.checkoutsubstep").addClass('inactive');
            temp.find("form").hide();
        }
        else
            break;
    }
    stp.removeClass('inactive');
    stp.find("div.checkoutsubstep").addClass('inactive');
    reordersubsteps(stp.find("div.checkoutsubstep:first"));
}

function validatePaymentForm()
{
    _stripecheck = false;
    if(jQuery("#payment_form input.paymethod").length == 0)
    {
        _stripecheck = true;
    }
    else
    {
        if(jQuery("#payment_form input.paymethod:checked").length == 0)
        {
            jQuery("#paymentmethoderrormsg").html('Please choose a payment method.');
            return false;    
        }
        if(jQuery("#payment_form input.paymethod:checked").val() == "stripe")
        {
            _stripecheck = true;
        }
    }
    if(_stripecheck)
    {
        unsetAllError(jQuery("#payment_form"));
        if(jQuery("#stripe-update-payment").length > 0 && jQuery("#stripe-update-payment").hasClass('use'))
            return true;
        var flag = validatefields(jQuery("#payment_form"));
        if(jQuery("#stripe_cc_number").val() != "")
        {
            if(!Stripe.validateCardNumber(jQuery("#stripe_cc_number").val()))
            {
                flag = false;
                setOnError(jQuery("#stripe_cc_number"), "Invalid Credit Card Number");
            }
        }
        if(jQuery("#stripe_cc_cid").val() != "")
        {
            if(!Stripe.validateCVC(jQuery("#stripe_cc_cid").val()))
            {
                flag = false;
                setOnError(jQuery("#stripe_cc_cid"));
            }
        }
        if(jQuery("#stripe_expiration").val() != "" && jQuery("#stripe_expiration_yr").val() != "")
        {
            if(!Stripe.validateExpiry(jQuery("#stripe_expiration").val(), jQuery("#stripe_expiration_yr").val()))
            {
                flag = false;
                setOnError(jQuery("#stripe_expiration"), "Invalid Expiration Date.");
                setOnError(jQuery("#stripe_expiration_yr"));
            }
        }
        if(!flag)
            jQuery("#paymentmethoderrormsg").html('Please fill in the required fields in red to continue.');
        else
            jQuery("#paymentmethoderrormsg").html('');
        return flag;
    }
    else
        return true;
    
    
    
    
    //if(!(jQuery("#stripe-update-payment").length > 0 && jQuery("#stripe-update-payment").hasClass('unuse')))
//        return true;
    if(jQuery("#payment_form input[type='text']").length == 0)
        return true;
    unsetAllError(jQuery("#payment_form"));
    var flag = validatefields(jQuery("#payment_form"));
    if(jQuery("#stripe_cc_number").val() != "")
    {
        if(!Stripe.validateCardNumber(jQuery("#stripe_cc_number").val()))
        {
            flag = false;
            setOnError(jQuery("#stripe_cc_number"), "Invalid Credit Card Number");
        }
    }
    if(jQuery("#stripe_cc_cid").val() != "")
    {
        if(!Stripe.validateCVC(jQuery("#stripe_cc_cid").val()))
        {
            flag = false;
            setOnError(jQuery("#stripe_cc_cid"));
        }
    }
    if(jQuery("#stripe_expiration").val() != "" && jQuery("#stripe_expiration_yr").val() != "")
    {
        if(!Stripe.validateExpiry(jQuery("#stripe_expiration").val(), jQuery("#stripe_expiration_yr").val()))
        {
            flag = false;
            setOnError(jQuery("#stripe_expiration"), "Invalid Expiration Date.");
            setOnError(jQuery("#stripe_expiration_yr"));
        }
    }
    if(!flag)
        jQuery("#paymentmethoderrormsg").html('Please fill in the required fields in red to continue.');
    else
        jQuery("#paymentmethoderrormsg").html('');
    return flag;
}

function positionordersummary()
{
    return;
    var z = (_winW - jQuery("#tblcheckoutsteps").width()) / 2;
    var x = jQuery("div#tblcheckoutsteps").position().left;
    x = x - 75 - jQuery("div#ordersummary").width();
    if((z - 75 - jQuery("div#ordersummary").width()) < 0)
        jQuery("div#ordersummary").css('left', '0px');
    else
        jQuery("div#ordersummary").css('left', (z - 75 - jQuery("div#ordersummary").width()) + 'px');
    x = jQuery("div#tblcheckoutsteps").position().left + jQuery("div#tblcheckoutsteps").width() + 75;
    jQuery("div#shippingsummary").css('left', (z + jQuery("div#tblcheckoutsteps").width() + 75) + 'px');

    //var x = jQuery("div#tblcheckoutsteps").position().left;
//    x = x - 75 - jQuery("div#ordersummary").width();
//    jQuery("div#ordersummary").css('left', x + 'px');
//    x = jQuery("div#tblcheckoutsteps").position().left + jQuery("div#tblcheckoutsteps").width() + 75;
//    jQuery("div#shippingsummary").css('left', x + 'px');
}

function savePayment()
{
    var url = homeUrl + 'checkout/onepage/savePayment';
    if(_usesecureurl)
        url = securehomeUrl + 'checkout/onepage/savePayment';
    jQuery.ajax({
        type : 'POST',
        url : url,
        //data : jQuery("#paymentmethods").serialize(),
        //data : 'payment%5Bmethod%5D=stripe&payment%5Bcreate_stripe_customer%5D=0&payment%5Bstripe_token%5D=' + jQuery("#stripe_token").val() + '&payment%5Bcc_number%5D=4024007186804943&payment%5Bcc_exp_month%5D=2&payment%5Bcc_exp_year%5D=2013&payment%5Bcc_cid%5D=123&payment%5Bstripe_customer_id%5D=',
        data : jQuery("#payment_form").serialize(),
        success : function(result){
            result = eval('(' + result + ')');
            if(typeof result['redirect'] !== "undefined")
                window.location.href = result['redirect'];
                
            if(typeof result['error'] !== "undefined")
                jQuery("#paymentmethoderrormsg").html(result['error']);
            else
            {
                jQuery("#paymentmethoderrormsg").html('');
                reordersteps(jQuery("#coreview"));
                jQuery("div#orderreview").html(result['update_section']['html']);
                designCartTotal();
            }
            _ischeckoutprocessing = false;
            jQuery("#payment_form input[type=submit]").show();
            jQuery("#payment_form #procImg").remove();
        }
    });
}

function saveBillingAddress()
{
    if(_ischeckoutprocessing)
        return;
    _ischeckoutprocessing = true;
    jQuery("#co-billing-form input[type=submit]").hide();
    jQuery("#co-billing-form input[type=submit]").after("<img id='procImg' src='" + skinUrl + "images/checkout/checkout-loader.gif' />");
    var billingdata = jQuery("#co-billing-form").serialize();
    var url = homeUrl + 'checkout/onepage/saveBilling';
    if(_usesecureurl)
        url = securehomeUrl + 'checkout/onepage/saveBilling';
    jQuery.ajax({
        type : 'POST',
        url : url,
        data : billingdata,
        success : function(result){
            result = eval('(' + result + ')');
            if(typeof result['error'] !== "undefined")
                jQuery("#billingaddresserrormsg").html(result['message']);
            else
            {
                reordersubsteps(jQuery("#copaymentmethods"));
                if(!_isshippable)
                    jQuery("div#paymentmethods").html(result['update_section']['html']);   
            }
            _ischeckoutprocessing = false;
            jQuery("#co-billing-form input[type=submit]").show();
            jQuery("#co-billing-form #procImg").remove();
            //result = eval('(' + result + ')');
//            //console.log(result['update_section']['html']);
//            jQuery("div#shippingmethods").html(result['update_section']['html']);
        }
    });
}

function saveShippingMethod()
{
    if(_ischeckoutprocessing)
        return;
    _ischeckoutprocessing = true;
    jQuery("#co-shippingmethod-form input[type=submit]").hide();
    jQuery("#co-shippingmethod-form input[type=submit]").after("<img id='procImg' src='" + skinUrl + "images/checkout/checkout-loader.gif' />");
    var url = homeUrl + 'checkout/onepage/saveShippingMethod';
    if(_usesecureurl)
        url = securehomeUrl + 'checkout/onepage/saveShippingMethod';
    jQuery.ajax({
        type : 'POST',
        url : url,
        data : {'shipping_method':jQuery('input:radio[name="shipping_method"]:checked').val()},
        success : function(result){
            result = eval('(' + result + ')');
            //console.log(result['update_section']['html']);
            jQuery("div#paymentmethods").html(result['update_section']['html']);
            reordersteps(jQuery("#cobilling"));
            _ischeckoutprocessing = false;
            jQuery("#co-shippingmethod-form input[type=submit]").show();
            jQuery("#co-shippingmethod-form #procImg").remove();
            getCartSummary();
        }
    });
}

function saveShippingAddress()
{
    if(_ischeckoutprocessing)
        return;
    _ischeckoutprocessing = true;
    jQuery("#checkout-shipping-form input[type=submit]").hide();
    jQuery("#checkout-shipping-form input[type=submit]").after("<img id='procImg' src='" + skinUrl + "images/checkout/checkout-loader.gif' />");
    var shippingdata = jQuery("#checkout-shipping-form").serialize();
    var url = homeUrl + 'checkout/onepage/saveShipping';
    if(_usesecureurl)
        url = securehomeUrl + 'checkout/onepage/saveShipping';
    jQuery.ajax({
        type : 'POST',
        url : url,
        data : shippingdata,
        success : function(result){
            result = eval('(' + result + ')');
            //console.log(result['update_section']['html']);
            jQuery("div#shippingmethods").html(result['update_section']['html']);
            reordersubsteps(jQuery("div#shippingmethods").parents("div.checkoutsubstep"));
            if(jQuery("#shipping\\:use_for_billing").is(':checked'))
                replicateShippingAddress();
            _ischeckoutprocessing = false;
            jQuery("#checkout-shipping-form input[type=submit]").show();
            jQuery("#checkout-shipping-form #procImg").remove();
            jQuery("#shipping\\:use_for_billing").removeAttr("checked");
        }
    });
}

function replicateShippingAddress()
{
    jQuery("#billing\\:firstname").val(jQuery("#shipping\\:firstname").val());
    jQuery("#billing\\:lastname").val(jQuery("#shipping\\:lastname").val());
    jQuery("#billing\\:street1").val(jQuery("#shipping\\:street1").val());
    jQuery("#billing\\:street2").val(jQuery("#shipping\\:street2").val());
    jQuery("#billing\\:city").val(jQuery("#shipping\\:city").val());
    jQuery("#billing\\:postcode").val(jQuery("#shipping\\:postcode").val());
    jQuery("#billing\\:country_id").val(jQuery("#shipping\\:country_id").val());
    fillBillingState();
    jQuery("#billing\\:region_id").val(jQuery("#shipping\\:region_id").val());
    jQuery("#billing\\:region").val(jQuery("#shipping\\:region").val());
    jQuery("#billing\\:telephone").val(jQuery("#shipping\\:telephone").val());
    jQuery("#billing-address-select").val(jQuery("#shipping-address-select").val());
    checkbillingnewaddress();
}

function validateCheckoutLoginForm()
{
    unsetAllError(jQuery("#checkout-login-form"));
    var flag = validatefields(jQuery("#checkout-login-form"));
    if(jQuery("#email").val() != "")
    {
        if(!validateEmail(jQuery("#email").val()))
        {
            setOnError(jQuery("#email"),"Invalid Email Address");
            flag = false;
        }
    }
    if(flag)
        _allowcheckoutexit = true;
    return flag;
}

function saveCheckoutMethod()
{
    if(_ischeckoutprocessing)
        return;
    _ischeckoutprocessing = true;
    var url = homeUrl + 'checkout/onepage/saveMethod';
    if(_usesecureurl)
        url = securehomeUrl + 'checkout/onepage/saveMethod';
    jQuery.ajax({
        type : 'POST',
        url : url,
        data : {'method': _checkoutmethod},
        success : function(result){
            jQuery("#tblcheckoutlogin").hide();
            jQuery("#tblcheckoutsteps").show();
            positionordersummary();
            _ischeckoutprocessing = false;
            //jQuery('select').customSelect();
        }
    });
}

function fillBillingState(currentstate)
{
    currentstate = (typeof currentstate === "undefined") ? "" : currentstate;
    //console.log(currentstate);
    if(StateCollection.hasOwnProperty(jQuery("select#billing\\:country_id").val()))
    {
        //console.log(StateCollection[currentstate]);
        var html = "<option value=''>Please select region, state or province</option>";
        for(var key in StateCollection[jQuery("select#billing\\:country_id").val()])
        {
            html += "<option value='" + key + "' title='" + StateCollection[jQuery("select#billing\\:country_id").val()][key].code + "'>" + StateCollection[jQuery("select#billing\\:country_id").val()][key].name + "</option>";
        }
        jQuery("select#billing\\:region_id").html(html).show().addClass('requiredfield');
        jQuery("input#billing\\:region").hide().removeClass('requiredfield');
        jQuery("select#billing\\:region_id").val(currentstate);
    }
    else
    {
        jQuery("select#billing\\:region_id").hide().removeClass('requiredfield');
        jQuery("input#billing\\:region").show().addClass('requiredfield');
    }
    jQuery("select#billing\\:region_id option[value='']").html("Select State");
}

function fillShippingState(currentstate)
{
    currentstate = (typeof currentstate === "undefined") ? "" : currentstate;
    //console.log(currentstate);
    if(StateCollection.hasOwnProperty(jQuery("select#shipping\\:country_id").val()))
    {
        //console.log(StateCollection[currentstate]);
        var html = "<option value=''>Please select region, state or province</option>";
        for(var key in StateCollection[jQuery("select#shipping\\:country_id").val()])
        {
            html += "<option value='" + key + "' title='" + StateCollection[jQuery("select#shipping\\:country_id").val()][key].code + "'>" + StateCollection[jQuery("select#shipping\\:country_id").val()][key].name + "</option>";
        }
        jQuery("select#shipping\\:region_id").html(html).show().addClass('requiredfield');
        jQuery("input#shipping\\:region").hide().removeClass('requiredfield');
        jQuery("select#shipping\\:region_id").val(currentstate);
    }
    else
    {
        jQuery("select#shipping\\:region_id").hide().removeClass('requiredfield');
        jQuery("input#shipping\\:region").show().addClass('requiredfield');
    }
    jQuery("select#shipping\\:region_id option[value='']").html("Select State");
}

function validateBillingAddressForm()
{
    unsetAllError(jQuery("#co-billing-form"));
    var flag = validatefields(jQuery("#co-billing-form"));
    if(jQuery("#billing\\:postcode").val() != "")
    {
        if(!validateZip(jQuery("#billing\\:postcode").val()))
        {
            flag = false;
            setOnError(jQuery("#billing\\:postcode"), "Invalid Zip Code.");
        }
    }
    if(jQuery("#billing\\:email").length > 0)
    {
        if(jQuery("#billing\\:email").val() != "")
        {
            if(!validateEmail(jQuery("#billing\\:email").val()))
            {
                setOnError(jQuery("#billing\\:email"), "Please enter a valid Email Address.");
                flag = false;
            }
        }
    }
    if(jQuery("#billing\\:customer_password").val() != "")
    {
        if(jQuery.trim(jQuery("#billing\\:customer_password").val()).length < 6)
        {
            setOnError(jQuery("#billing\\:customer_password"),"Please enter 6 or more characters.");
            flag = false;
        }
    }
    if(jQuery("#billing\\:customer_password").val() != "" && jQuery("#billing\\:confirm_password").val() != "")
    {
        if(jQuery("#billing\\:customer_password").val() != jQuery("#billing\\:confirm_password").val())
        {
            setOnError(jQuery("#billing\\:confirm_password"),"Please make sure your passwords match.");
            flag = false;
        }
    }
    if(!flag)
        jQuery("#billingaddresserrormsg").html('Please fill in the required fields in red to continue.');
    else
        jQuery("#billingaddresserrormsg").html('');
    return flag;
}

function validateShippingAddressForm()
{
    unsetAllError(jQuery("#checkout-shipping-form"));
    var flag = validatefields(jQuery("#checkout-shipping-form"));
    if(jQuery("#shipping\\:postcode").val() != "")
    {
        if(!validateZip(jQuery("#shipping\\:postcode").val()))
        {
            flag = false;
            setOnError(jQuery("#shipping\\:postcode"), "Invalid Zip Code.");
        }
    }
    if(!flag)
        jQuery("#shippingaddresserrormsg").html('Please fill in the required fields in red to continue.');
    else
        jQuery("#shippingaddresserrormsg").html('');
    return flag;
}