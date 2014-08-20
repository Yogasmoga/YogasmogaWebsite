_stripecheck = false;
_usesecureurl = true;
jQuery(document).ready(function($){

    setTimeout(function(){
        jQuery("input[type='radio'][value='stripe']").attr("checked","checked");
        checkpaymentmethod();
    }, 0);


    dynAddressVal();
    dfdfdffgf();
    changeFlag();
    getSelectval();
    //trimDetailTxt();
    createNewElement();
    removeNameLabel();

    $(".showShippingOpt").focusout(function () {
        $(".showShippingOpt").slideUp("fast");
    })

    $(".selectAddress .addVal, .showUpadd").on("click", function(event){
        event.stopPropagation();
        slideAddCont();
        jQuery(".showShpOpt").removeClass("reverse");
        jQuery(".showShippingOpt").slideUp("slow");
    });

    addUpdTxt();
    getShippingID();
    $(".shippingOption .addVal, .showShpOpt").on("click", function(event){
        event.stopPropagation();
        slideShpCont(); 
        jQuery(".showUpadd").removeClass("reverse");
        jQuery(".listadd").slideUp("slow");       
    });

    $(".showShippingOpt").on("click", "li", function(){
        var selectedVal = $(this).text();

        $("form#checkout-shipping-form").find("input[type='submit']").show();

        $("#shippingDetails").css("background", "").addClass("active").removeClass("reverseShip");

        $("#billingDetails, #reviewDetails").removeClass("active");
        // $("#billingDetails .ovrlay-bg, #reviewDetails .ovrlay-bg").show();
        $("#reviewDetails .ovrlay-bg").show();
        $("#billingDetails").css("background","rgba(0, 0, 0, 0.0784314)");
        $("#billing-new-address-form, #cobillingaddress").hide();

        $(".billingAdd a.checkBCre").removeClass("reverse unuse").addClass("use");
        $("form#payment_form input[type=submit]").addClass("mar0").removeClass("marbtm745");
        $("li#shippingDetails .headD span").html("1");

        $(".showShippingOpt li").removeClass("selected");
        $(this).addClass("selected");
        $(".shippingOption").find(".addVal").text(selectedVal);
        slideShpCont();
    });
    
    $("#payment_form .paymentmethoddiv,#payment_form .paymentmethoddiv,.checkBCre").live("click", function(){
        $("#reviewDetails .ovrlay-bg").show();
        $("#shippingDetails").css("background","rgba(0, 0, 0, 0.0784314)");
        $("#billingDetails").css("background","");
        $("#billingDetails .checkoutcontinuebtn").show();
    });

    if($("#checkout-shipping-form").length == 0)
    {
        $("#co-billing-form").show();
    }

    $("#checkout-login-form").submit(function(){
        return validateCheckoutLoginForm();
    });

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
        $("select#shipping\\:country_id").attr("class","").addClass('requiredfield').attr("defaulterrormsg","Country is required").removeAttr("title");
        $("select#shipping\\:country_id").change(function(){
            fillShippingState();
        });
        fillShippingState(_curshippingstate);
    }

    if($("select#billing\\:country_id").length > 0)
    {
        $("select#billing\\:country_id").attr("class","").addClass('requiredfield').attr("defaulterrormsg","Country is required").removeAttr("title");
        $("select#billing\\:country_id").change(function(){
            fillBillingState();
        });
        fillBillingState(_curbillingstate);
    }

    $("#checkout-shipping-form").submit(function(){
        if(validateShippingAddressForm())
        {
            $("#shipping\\:firstname").val(ucFirstAllWords($("#shipping\\:firstname").val()));
            $("#shipping\\:lastname").val(ucFirstAllWords($("#shipping\\:lastname").val()));

            if($("#checkout-shipping-address-new").is(":visible")){
                virtualsaveshippingaddress();
                $(".edit-curr-shipng-add").removeClass("dnone");
            }
            saveShippingAddress();
        }
        return false;
    });

    // $("#checkout-shipping-form").submit(function(){

    //    if($("#checkout-shipping-address-new").is(":visible")){
    //        if(validateShippingAddressForm()){
    //            $("#shipping\\:firstname").val(ucFirstAllWords($("#shipping\\:firstname").val()));
    //            $("#shipping\\:lastname").val(ucFirstAllWords($("#shipping\\:lastname").val()));
    //            $("#shipping\\:region_id").val(ucFirstAllWords($("#shipping\\:region_id").val()));
    //            virtualsaveshippingaddress();
    //            saveShippingAddress();
    //        }
    //    }

    //     return false;
    // });

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
            jQuery("#payment_form input[type=submit]").after("<img id='procImg' src='" + skinUrl + "images/new-loader.gif' />");
            jQuery("#billing-new-address-form").hide();
            if(_stripecheck)
            {
                if(jQuery("#payment_form input[type='text']").length == 0){
                    savePayment();
                    saveBillingAddress();
                }

                else{
                    CreateStripeToken();
                }

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
        }
        else
        {
            $("#checkout-shipping-address-new").hide();
            $("#shippingaddressselectionblock").removeClass('addressselector');
        }
    });

    $(".edit-curr-shipng-add").live("click", function(){
        $(".edit-curr-shipng-add").addClass("dnone");
        $("select#shipping-address-select").val('');
        $("select#shipping-address-select").trigger("change");
        $("#updateNameAdd").hide();
        $("#shippingaddressselectionblock").hide();
        sameasBlankSelect();
        removeReviewActiveState();
    });

    $("#shipping-address-select li").live("click", function(){
        if($(this).attr("value") == "") {
            $(".edit-curr-shipng-add").addClass("dnone");
            $("select#shipping-address-select").val('');
            $("select#shipping-address-select").trigger("change");
            $("#updateNameAdd").hide();
            $("#shippingaddressselectionblock").hide();
            sameasBlankSelect();
            removeReviewActiveState();
            resetCheckoutForm();
        }
        else if($(this).attr("value") == "9999"){
            $(".edit-curr-shipng-add").removeClass("dnone");
            var selectedAdd = $(this).text();
            $("select#shipping-address-select").val('');
            $("select#shipping-address-select").trigger("change");
            $("#checkout-shipping-address-new").hide();

            sameasBlankSelect();
            removeReviewActiveState();

            var selectedAdd = $(this).text();

            $("#shipping-address-select li").removeAttr('id');
            $(this).attr('id', 'selected');

            $(this).parent().slideUp();
            $(".showUpadd").toggleClass("reverse");

            $('#updateNameAdd').find('.address').html(selectedAdd.replace(/,/g, "<br>"));
            $('#updateNameAdd').find('.address').contents().first().wrap('<span>To: </span>');

            $("form#checkout-shipping-form").find("input[type='submit']").show();
            $("#shippingDetails").css("background", "").addClass("active");
            $("#billingDetails").removeClass("active");
            // $("#billingDetails .ovrlay-bg").show();
            $("#billingDetails").css("background","");
            $("#billing-new-address-form, #cobillingaddress").hide();
            $(".billingAdd a.checkBCre").removeClass("reverse unuse").addClass("use");
            $("form#payment_form input[type=submit]").addClass("mar0").removeClass("marbtm745");

            trimDetailTxt();
            addUpdTxt();
            getShippingID();
        }
        else {
            var selectedAdd = $(this).text();

            $(".edit-curr-shipng-add").addClass("dnone");
            $("#shipping-address-select li").removeAttr('id');
            $(this).attr('id', 'selected');

            $(this).parent().slideUp();
            $(".showUpadd").toggleClass("reverse");
            sameasBlankSelect();
            removeReviewActiveState();
            $('#updateNameAdd').find('.address').html(selectedAdd.replace(/,/g, "<br>"));
            $('#updateNameAdd').find('.address').contents().first().wrap('<span>To: </span>');

            $("form#checkout-shipping-form").find("input[type='submit']").show();
            $("#shippingDetails").css("background", "").addClass("active");
            $("#billingDetails").removeClass("active");
            // $("#billingDetails .ovrlay-bg").show();
            $("#billingDetails").css("background","");
            $("#billing-new-address-form, #cobillingaddress").hide();
            $(".billingAdd a.checkBCre").removeClass("reverse unuse").addClass("use");
            $("form#payment_form input[type=submit]").addClass("mar0").removeClass("marbtm745");

            $("#checkout-shipping-address-new").hide();
            $("#updateNameAdd").show();
            $("#shippingaddressselectionblock").show().removeClass('addressselector');
            var valueLi = $(this).attr("value");
            $("select#shipping-address-select").val(valueLi);
            $("select#shipping-address-select").trigger("change");
            var fdfsdf = $("select#shipping-address-select").val(valueLi);

            trimDetailTxt();
            addUpdTxt();
            getShippingID();
        }
    });

    $("select#billing-address-select").removeAttr('onchange');
    $("select#billing-address-select").change(function(){
        checkbillingnewaddress();
    });
    $("#stripe-update-payment").live('click', function(){
        if($(this).hasClass('use'))
        {
            $("#change-stripe-detail").show();
            $("#stripe-payment-details").hide();
            $(this).removeClass('use').addClass('unuse');
            $(this).addClass("reverse");
            $(this).html('Use Existing Payment Information');
            $('#stripe_create_stripe_customer').val("1");
        }
        else
        {
            $("#change-stripe-detail").hide();
            $("#stripe-payment-details").show();
            $(this).removeClass('unuse').addClass('use');
            $(this).removeClass("reverse");
            $(this).html('Change Payment Information');
            $('#stripe_create_stripe_customer').val('0');
        }
    });


    $(".billingAdd a").live('click', function(){
        if($(this).hasClass('use'))
        {
            $("select#billing-address-select").val("");
            $("select#billing-address-select").trigger("change");
            $("#cobillingaddress").show().addClass("martop35");
            $("form#payment_form input[type=submit]").addClass("marbtm745");
            $("#billing-new-address-form").show().addClass("mar0");
            $("#co-billing-form input.checkoutcontinuebtn[type='submit']").hide();
            $(this).addClass("reverse");
            $(this).removeClass('use').addClass('unuse');
            $(this).html($("form#checkout-shipping-form input#shipping\\:street1").val() + "<br>" + "<span>is also my billing address</span>");
        }
        else
        {
            $("#billing-new-address-form").hide();
            $("#cobillingaddress").hide().addClass("mar0").removeClass("martop35");
            $("form#payment_form input[type=submit]").addClass("mar0").removeClass("marbtm745");
            $("#co-billing-form input.checkoutcontinuebtn[type='submit']").hide();
            $(this).removeClass("reverse");
            $(this).removeClass('unuse').addClass('use');
            $(this).html($("form#checkout-shipping-form input#shipping\\:street1").val() + "<br>" + "<span>is also my billing address</span>");
        }
    });


    $(window).resize(function(){
        positionordersummary();
    });

    jQuery("input[type='radio'][value='paypal_express']").live('click', function(){
        checkpaymentmethod();
    });
    jQuery("input[type='radio'][value='stripe']").live('click', function(){

        checkpaymentmethod();
    });

    // doc click event
    $(document).click( function(){
        $(".showShippingOpt").hide();
        $(".listadd").hide();

        $(".showUpadd").removeClass("reverse");
        $(".showShpOpt").removeClass("reverse");
    });

});

function getShippingID (){
    jQuery(".shippingOption").find("ul").find("li").removeClass("selected");
    jQuery(".shippingOption").find("ul.availableShip").find("li:first-child").addClass("selected");
}

function addUpdTxt(){
    var shippingVal = jQuery(".showShippingOpt").find(".availableShip").find("li:first-child").text();
    jQuery(".shippingOption").find(".addVal").text(shippingVal);
}

function dfdfdffgf(){
    var txtSl = jQuery('#shipping-address-select').find('option:selected').text();
    txtSl = txtSl.replace(/,/g, "<br>");
    jQuery("#updateNameAdd").find(".address").html(txtSl);


    jQuery('.address').each(function() {
        jQuery(this).contents().first().wrap('<span>To: </span>');
    });
}

function sameasBlankSelect(){
    jQuery("li#shippingDetails").removeClass("reverseShip").addClass("active").css("background", "transparent");
    jQuery("li#billingDetails .ovrlay-bg, li#reviewDetails .ovrlay-bg").show().removeClass("active");
    jQuery("#checkout-shipping-form input[type=submit]").show();
    jQuery("li#shippingDetails .headD span").html("1");
}

function changeFlag(){
    //var defaultvalue = jQuery("form#checkout-shipping-form select#shipping\\:country_id").find("option:selected").text();
    var flagVal = jQuery("#shipping\\:country_id").find("option:selected").text();
    var valSel = jQuery("#shipping\\:country_id").val();
    jQuery(".showShippingOpt").find("ul").removeClass("availableShip");

    if(flagVal == "United States" || valSel == "United States"){
        jQuery(".showShippingOpt").find("#us-shipping").addClass("availableShip");
        jQuery(".shipDetail").find(".country").find("img").addClass("dnone");
        jQuery(".shipDetail").find(".country").find("img.usflag").removeClass("dnone");
    }

    else if(flagVal == "Canada" || valSel == "Canada"){
        jQuery(".showShippingOpt").find("#canada-shipping").addClass("availableShip");
        jQuery(".shipDetail").find(".country").find("img").addClass("dnone");
        jQuery(".shipDetail").find(".country").find("img.cnflag").removeClass("dnone");
    }

    else{
        jQuery(".showShippingOpt").find("#other-shipping").addClass("availableShip");
        jQuery(".shipDetail").find(".country").find("img").addClass("dnone");
        jQuery(".shipDetail").find(".country").find("img.glflag").removeClass("dnone");
    }

}

function getSelectval(){
    jQuery("form#checkout-shipping-form select#shipping\\:country_id").change(function(){
        var getVal = jQuery(this).find("option:selected").text();
        jQuery(".showShippingOpt").find("ul").removeClass("availableShip");

        if(getVal == "United States"){
            jQuery(".showShippingOpt").find("#us-shipping").addClass("availableShip");
            jQuery(".shipDetail").find(".country").find("img").addClass("dnone");
            jQuery(".shipDetail").find(".country").find("img.usflag").removeClass("dnone");
        }

        else if(getVal == "Canada"){
            jQuery(".showShippingOpt").find("#canada-shipping").addClass("availableShip");
            jQuery(".shipDetail").find(".country").find("img").addClass("dnone");
            jQuery(".shipDetail").find(".country").find("img.cnflag").removeClass("dnone");
        }

        else{
            jQuery(".showShippingOpt").find("#other-shipping").addClass("availableShip");
            jQuery(".shipDetail").find(".country").find("img").addClass("dnone");
            jQuery(".shipDetail").find(".country").find("img.glflag").removeClass("dnone");
        }

        addUpdTxt();
        getShippingID();
    });
}

function trimDetailTxt(){
    var usrDetail = jQuery("ul#shipping-address-select").find("li#selected").text();
    var textAftrBr = (usrDetail.substring(usrDetail.lastIndexOf(',') + 1)).trim();
    jQuery(".showShippingOpt").find("ul").removeClass("availableShip");

    if(textAftrBr == "United States"){
        jQuery(".showShippingOpt").find("ul").removeClass("availableShip");
        jQuery(".showShippingOpt").find("#us-shipping").addClass("availableShip");
    }
    else if(textAftrBr == "Canada"){
        jQuery(".showShippingOpt").find("ul").removeClass("availableShip");
        jQuery(".showShippingOpt").find("#canada-shipping").addClass("availableShip");
    }
    else{
        jQuery(".showShippingOpt").find("ul").removeClass("availableShip");
        jQuery(".showShippingOpt").find("#other-shipping").addClass("availableShip");
    }
}

function dynAddressVal(){
    var defaultvalue = jQuery("form#checkout-shipping-form select#shipping\\:country_id").find("option:selected").text();
    jQuery(".showShippingOpt").find("ul").removeClass("availableShip");

    if(defaultvalue == "United States"){
        jQuery(".showShippingOpt").find("ul").removeClass("availableShip");
        jQuery(".showShippingOpt").find("#us-shipping").addClass("availableShip");
    }
    else if(defaultvalue == "Canada"){
        jQuery(".showShippingOpt").find("ul").removeClass("availableShip");
        jQuery(".showShippingOpt").find("#canada-shipping").addClass("availableShip");
    }
    else{
        jQuery(".showShippingOpt").find("ul").removeClass("availableShip");
        jQuery(".showShippingOpt").find("#other-shipping").addClass("availableShip");
    }
}

function removeNameLabel(){
    jQuery(".customer-name").find("input.no-bg").removeClass("no-bg");
    jQuery(".customer-name").find("td.label").remove();
    jQuery(".customer-name").find("table.inputtable").addClass("wdth50");
    jQuery(".customer-name").find("table.inputtable:nth-child(2)").addClass("f-right");
}

function slideAddCont(){
    jQuery(".showUpadd").toggleClass("reverse");
    jQuery(".listadd").slideToggle("slow");
}

function slideCreOpt(){
    jQuery(".showCreOpt").toggleClass("reverse");
    jQuery("#stripe-update-payment-holder").slideToggle("slow");
}

function slideShpCont(){
    jQuery(".showShpOpt").toggleClass("reverse");
    jQuery(".showShippingOpt").slideToggle("slow");
}

function createNewElement(){
    var selectID = jQuery("select#shipping-address-select").attr("id");
    var selectName = jQuery("select#shipping-address-select").attr("name");

    jQuery("select#shipping-address-select option").each(function(){
        var storeb = jQuery(this).html();
        var storeb1 = jQuery(this).attr("value");
        var selected = jQuery(this).attr("selected");

        if(storeb1 == ""){
            jQuery(".listadd").append('<li class="addnewBtn" value="' + storeb1 + '">+ Add New Address</li>');
        }
        else{
            jQuery(".listadd").append('<li id="' + selected + '" value="' + storeb1 + '">' + storeb +  '</li>');
        }
    });

    jQuery(".listadd").attr("id", selectID);
    jQuery(".listadd").attr("name", selectName);
}

function checkpaymentmethod()
{
    if(jQuery("input[type='radio'][value='paypal_express']").is(':checked'))
    {
        jQuery("label[for='p_method_paypal_express'] img").attr("src", "/skin/frontend/new-yogasmoga/yogasmoga-theme/images/checkout/paypaltabovr.png");
        jQuery("ul#payment_form_paypal_express").show();
        jQuery(".billingAdd").hide();
        jQuery("#paymentmethoderrormsg, #cobillingaddress").addClass("dnone");
        jQuery("#payment_form input[type='submit']").addClass("marginnone");
        jQuery("label[for='p_method_stripe'] img").attr("src", "/skin/frontend/new-yogasmoga/yogasmoga-theme/images/checkout/credittab.png");
        jQuery("div#stripe-payment-details,a#stripe-update-payment,div#change-stripe-detail").hide();
    }

    if(jQuery("input[type='radio'][value='stripe']").is(':checked'))
    {
        jQuery("ul#payment_form_paypal_express").hide();
        jQuery("#payment_form input[type='submit']").removeClass("marginnone");
        jQuery(".billingAdd").show();
        jQuery("#paymentmethoderrormsg, #cobillingaddress").removeClass("dnone");
        jQuery("label[for='p_method_stripe'] img").attr("src", "/skin/frontend/new-yogasmoga/yogasmoga-theme/images/checkout/credittabovr.png");
        jQuery("label[for='p_method_paypal_express'] img").attr("src", "/skin/frontend/new-yogasmoga/yogasmoga-theme/images/checkout/paypaltab.png");
        jQuery("a#stripe-update-payment").show();
        if(jQuery("a#stripe-update-payment").length == 0)
        {
            jQuery("div#change-stripe-detail").show();
        }
        else
        {

            if(jQuery("a#stripe-update-payment").hasClass("unuse"))
                jQuery("div#change-stripe-detail").show();
            else
                jQuery("div#stripe-payment-details").show();
        }
    }
}

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
}

function submitcheckout()
{
    if(_ischeckoutprocessing)
        return;
    _ischeckoutprocessing = true;
    jQuery("#checkout-submit").hide();
    jQuery("#checkout-submit").after("<img id='procImg' src='" + skinUrl + "images/new-loader.gif' />");
    var url = homeUrl + 'checkout/onepage/saveOrder';
    if(_usesecureurl)
        url = securehomeUrl + 'checkout/onepage/saveOrder';
    jQuery.ajax({
        type : 'POST',
        url : url,
        data : jQuery("#payment_form").serialize(),
        success : function(result){
            result = eval('(' + result + ')');
            if(typeof result['error_messages'] !== "undefined"){
                jQuery("#submiterrormsg").html(result['error_messages']).removeClass("dnone");
                jQuery("#reviewDetails #procImg").remove();
            }

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
    });

    try{
        if((stp.offset().top - jQuery("html").scrollTop() - _headerHeight) < 0)
        {
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
}

function savePayment()
{
    var url = homeUrl + 'checkout/onepage/savePayment';
    if(_usesecureurl)
        url = securehomeUrl + 'checkout/onepage/savePayment';
    jQuery.ajax({
        type : 'POST',
        url : url,
        data : jQuery("#payment_form").serialize(),
        success : function(result){
            result = eval('(' + result + ')');
            if(typeof result['redirect'] !== "undefined"){
//                window.location.href = result['redirect'];

                    var payPalURL = result['redirect'];

                    jQuery("li#reviewDetails #paypal-checkout").removeClass("dnone").attr("href", payPalURL);
                    jQuery("li#reviewDetails #checkout-submit").addClass("dnone");

                    jQuery("#paymentmethoderrormsg").html('');
                    jQuery("form#co-billing-form").submit();
                    designCartTotal();

                    jQuery(".billingAdd a").removeClass("reverse unuse").addClass("use").html(jQuery("form#co-billing-form input#billing\\:street1").val() + "<br>" + "<span>is my billing address</span>");
                    jQuery("#billing-new-address-form").hide();
                    // jQuery("li#billingDetails .ovrlay-bg").show();
                    jQuery("li#billingDetails").css("background","rgba(0, 0, 0, 0.0784314)");
                    jQuery("li#billingDetails .headD span").html("&#10003;");
                    jQuery("li#shippingDetails .ovrlay-bg").show();
                    jQuery("li#shippingDetails").removeClass("reverseShip").css("background", "transparent");
                    jQuery("li#billingDetails.active").removeClass("active");
                    jQuery("li#reviewDetails .ovrlay-bg").hide();
                    jQuery("li#reviewDetails").addClass("active");
            }
            else if(typeof result['error'] !== "undefined"){
                jQuery("#paymentmethoderrormsg").html(result['error']);
            }
            else
            {
                jQuery("#paymentmethoderrormsg").html('');
                reordersteps(jQuery("#coreview"));
                jQuery("div#orderreview").html(result['update_section']['html']);
                jQuery("form#co-billing-form").submit();
                designCartTotal();

                jQuery(".billingAdd a").removeClass("reverse unuse").addClass("use").html(jQuery("form#co-billing-form input#billing\\:street1").val() + "<br>" + "<span>is my billing address</span>");
                jQuery("#billing-new-address-form").hide();
                // jQuery("li#billingDetails .ovrlay-bg").show();
                jQuery("li#billingDetails").css("background","rgba(0, 0, 0, 0.0784314)");
                jQuery("li#billingDetails .headD span").html("&#10003;");
                jQuery("li#shippingDetails .ovrlay-bg").show();
                jQuery("li#shippingDetails").removeClass("reverseShip").css("background", "transparent");
                jQuery("li#billingDetails.active").removeClass("active");
                jQuery("li#reviewDetails .ovrlay-bg").hide();
                jQuery("li#reviewDetails").addClass("active");
            }
            _ischeckoutprocessing = false;
            jQuery("#payment_form input[type=submit]").hide();
            jQuery("#payment_form #procImg").remove();
            showShppingStepScOne();
        }
    });
}

function showShppingStepScOne(){
    jQuery("li#shippingDetails").css("background", "rgba(0, 0, 0, 0.08)").addClass("reverseShip");
    jQuery("#updateNameAdd").find(".gryWrap ").css("background", "#ddd");
    jQuery("li#shippingDetails .ovrlay-bg").hide();
    jQuery("li#shippingDetails .headD span").html("&#10003;");
}

function showShppingStepScTwo(){
    jQuery("li#shippingDetails").css("background", "rgba(0, 0, 0, 0.08)").addClass("reverseShip");
    jQuery("#updateNameAdd").find(".gryWrap ").css("background", "#ddd");
    jQuery("li#shippingDetails .ovrlay-bg").hide();
    jQuery("li#shippingDetails .headD span").html("&#10003;");
}

function showShppingStepScThree(){
    jQuery("li#shippingDetails").css("background", "rgba(0, 0, 0, 0.08)").addClass("reverseShip");
    jQuery("#updateNameAdd").find(".gryWrap ").css("background", "#ddd");
    jQuery("li#shippingDetails .ovrlay-bg").hide();
    jQuery("li#shippingDetails .headD span").html("&#10003;");
}

function removeReviewActiveState(){
    jQuery("li#reviewDetails").removeClass("active");
}

function removeBillingActiveState(){
    jQuery("li#billingDetails").removeClass("active");
}

function removeShippingActiveState(){
    jQuery("li#shippingDetails").removeClass("active");
}

function saveBillingAddress(){
    var billingdata = jQuery("#co-billing-form").serialize();
    var url = homeUrl + 'checkout/onepage/saveBilling';
    if(_usesecureurl)
        url = securehomeUrl + 'checkout/onepage/saveBilling';
    jQuery.ajax({
        type : 'POST',
        url : url,
        data : billingdata,
        success : function(result){
            getCartSummary();
            result = eval('(' + result + ')');
            if(typeof result['error'] !== "undefined")
                jQuery("#billingaddresserrormsg").html(result['message']);
            else
            {
                reordersubsteps(jQuery("#copaymentmethods"));
                if(!_isshippable)
                    jQuery("div#paymentmethods").html(result['update_section']['html']);
            }
        }
    });
}

function virtualsaveshippingaddress() {
    var address = jQuery("form#checkout-shipping-form input#shipping\\:firstname").val() + " " + jQuery("form#checkout-shipping-form input#shipping\\:lastname").val() + ", " + jQuery("form#checkout-shipping-form input#shipping\\:street1").val();

    if(jQuery("form#checkout-shipping-form input#shipping\\:street2").val().length > 0)
        address += " " + jQuery("form#checkout-shipping-form input#shipping\\:street2").val();

    address += ", " + jQuery("form#checkout-shipping-form input#shipping\\:city").val() + ", " + jQuery("form#checkout-shipping-form select#shipping\\:region_id option[value='" + jQuery("form#checkout-shipping-form select#shipping\\:region_id").val() + "']").html() + " " + jQuery("form#checkout-shipping-form input#shipping\\:postcode").val() + ", " + jQuery("form#checkout-shipping-form select#shipping\\:country_id option[value='" + jQuery("form#checkout-shipping-form select#shipping\\:country_id").val() + "']").html();

    jQuery("form#checkout-shipping-form ul#shipping-address-select li").removeAttr("id");
    jQuery("form#checkout-shipping-form ul#shipping-address-select li[value='9999']").remove();
    jQuery("form#checkout-shipping-form ul#shipping-address-select li:last").before("<li id='selected' value='9999'>" + address + "</li>");
}

// function virtualsaveshippingaddress() {
//     var address = jQuery("form#checkout-shipping-form input#shipping\\:firstname").val() + " " + jQuery("form#checkout-shipping-form input#shipping\\:lastname").val() + ", " + jQuery("form#checkout-shipping-form input#shipping\\:street1").val() + ", ";

//     if(jQuery("form#checkout-shipping-form input#shipping\\:street2").val().length > 0)
//         address += jQuery("form#checkout-shipping-form input#shipping\\:street2").val() + ", ";

//     address += jQuery("form#checkout-shipping-form input#shipping\\:city").val() + ", ";

//     if(jQuery("form#checkout-shipping-form input#shipping\\:region").is(":visible")){
//         address += jQuery("form#checkout-shipping-form input#shipping\\:region").val() + ", ";
//     }else{
//         address += jQuery("form#checkout-shipping-form select#shipping\\:region_id option[value='" + jQuery("form#checkout-shipping-form select#shipping\\:region_id").val() + "']").html() + ", ";
//     }
//     address += jQuery("form#checkout-shipping-form input#shipping\\:postcode").val() + ", " + jQuery("form#checkout-shipping-form select#shipping\\:country_id option[value='" + jQuery("form#checkout-shipping-form select#shipping\\:country_id").val() + "']").html();

//     jQuery("form#checkout-shipping-form ul#shipping-address-select li").removeAttr("id");
//     jQuery("form#checkout-shipping-form ul#shipping-address-select li[value='9999']").remove();
//     jQuery("form#checkout-shipping-form ul#shipping-address-select li:last").before("<li id='selected' value='9999'>" + address + "</li>");
// }

function saveShippingMethod()
{
    if(_ischeckoutprocessing)
        return;
    _ischeckoutprocessing = true;
    jQuery("#co-shippingmethod-form input[type=submit]").hide();
    jQuery("#co-shippingmethod-form #cobillingaddress").after("<img id='procImg' src='" + skinUrl + "images/new-loader.gif' />");
    jQuery("#co-billing-form #procImg").remove();
    var url = homeUrl + 'checkout/onepage/saveShippingMethod';
    if(_usesecureurl)
        url = securehomeUrl + 'checkout/onepage/saveShippingMethod';
    jQuery.ajax({
        type : 'POST',
        url : url,
        data : {'shipping_method':jQuery('input:radio[name="shipping_method"]:checked').val()},
        success : function(result){
            _ischeckoutprocessing = false;
            result = eval('(' + result + ')');
            //console.log(result['update_section']['html']);
            jQuery("div#paymentmethods").html(result['update_section']['html']);


            jQuery(".billingAdd a").html(jQuery("form#checkout-shipping-form input#shipping\\:street1").val() + "<br>" + "<span>is also my billing address</span>");

            jQuery("form#co-billing-form").submit();

            //reordersteps(jQuery("#cobilling"));
            jQuery("#co-shippingmethod-form input[type=submit]").hide();
            jQuery("#co-billing-form input[type=submit]").hide();

            jQuery("#co-shippingmethod-form #procImg").remove();
            jQuery("#co-billing-form #procImg").remove();

            jQuery("input[type='radio'][value='stripe']").attr("checked","checked");
            checkpaymentmethod();

            // show/hide overlay for next step
            jQuery("li#shippingDetails").css("background", "rgba(0, 0, 0, 0.08)").addClass("reverseShip");
            jQuery("#updateNameAdd").find(".gryWrap ").css("background", "#ddd");
            jQuery("li#shippingDetails .ovrlay-bg").hide();
            jQuery("li#shippingDetails .headD span").html("&#10003;");
            jQuery("li#billingDetails .ovrlay-bg").hide();
            jQuery("li#shippingDetails.active").removeClass("active");
            jQuery("li#billingDetails").addClass("active");

            jQuery("#checkout-shipping-form input[type=submit]").hide();
            jQuery("#checkout-shipping-form #procImg").remove();
        }
    });
}

function saveShippingAddress()
{
    if(_ischeckoutprocessing)
        return;
    _ischeckoutprocessing = true;
    jQuery("#checkout-shipping-form input[type=submit]").hide();
    jQuery("#checkout-shipping-form input[type=submit]").after("<img id='procImg' src='" + skinUrl + "images/new-loader.gif' />");
    var shippingdata = jQuery("#checkout-shipping-form").serialize();
    var url = homeUrl + 'checkout/onepage/saveShipping';
    if(_usesecureurl)
        url = securehomeUrl + 'checkout/onepage/saveShipping';
    jQuery.ajax({
        type : 'POST',
        url : url,
        data : shippingdata,
        success : function(result){
            _ischeckoutprocessing = false;
            result = eval('(' + result + ')');
            //console.log(result['update_section']['html']);

            jQuery("div#shippingmethods").html(result['update_section']['html']);

            var getShpID = jQuery(".shippingOption").find("ul li.selected").attr("id");
            console.log(getShpID);

            jQuery("form#co-shippingmethod-form input#" + getShpID).attr("checked","checked");
            console.log(jQuery('form#co-shippingmethod-form input:checked').attr("id"));

            jQuery("form#co-shippingmethod-form").submit();


            //reordersubsteps(jQuery("div#shippingmethods").parents("div.checkoutsubstep"));
            jQuery("#shipping\\:use_for_billing").attr("checked","checked");
            if(jQuery("#shipping\\:use_for_billing").is(':checked'))
                replicateShippingAddress();

            // hiding shiipng divs
            var txtSl = jQuery('ul#shipping-address-select').find("li#selected").text();
            txtSl = txtSl.replace(/,/g, "<br>");

            jQuery('#updateNameAdd').find('.address').html(txtSl);
            jQuery('#updateNameAdd').find('.address').contents().first().wrap('<span>To: </span>');


            //jQuery("#checkout-shipping-form input[type=submit]").hide();
            jQuery("#checkout-shipping-address-new").hide();
            jQuery("#updateNameAdd").show();
            jQuery("#shippingaddressselectionblock").show();


            //jQuery("#checkout-shipping-form #procImg").remove();
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
    jQuery("select#billing\\:region_id option[value='']").html("ST");
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
    jQuery("select#shipping\\:region_id option[value='']").html("ST");
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

function resetCheckoutForm(){
    jQuery(':input','#checkout-shipping-form').not(':button, :submit, :reset, :hidden, :checkbox').val('').removeAttr('checked').removeAttr('selected');
    jQuery('#checkout-shipping-form #shipping\\:country_id').val( "US" );
    jQuery('#checkout-shipping-form #shipping\\:country_id').trigger( "change" );
}