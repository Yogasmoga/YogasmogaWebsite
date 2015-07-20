_stripecheck = false;
function slideAddCont(){
    jQuery(".showUpadd").toggleClass("reverse");
    jQuery(".listadd").slideToggle("slow");
}

function slideBillingCont(){
    jQuery(".showBillingadd").toggleClass("reverse");
    jQuery(".billingaddlist").slideToggle("slow");
}

function slideCreditCont(){
    jQuery(".showCrdtOpt").toggleClass("reverse");
    jQuery(".showcreditcardopt").slideToggle("slow");
}

function slideCreOpt(){
    jQuery(".showCreOpt").toggleClass("reverse");
    jQuery("#stripe-update-payment-holder").slideToggle("slow");
}

function slideShpCont(){
    jQuery(".showShpOpt").toggleClass("reverse");
    jQuery(".showShippingOpt").slideToggle("slow");
}


function checkpaymentmethod()
{
    if(jQuery("input[type='radio'][value='paypal_express']").is(':checked'))
    {
        jQuery("label[for='p_method_paypal_express'] img").attr("src", "/skin/frontend/new-yogasmoga/yogasmoga-theme/images/checkout/paypaltabovr.png");
        jQuery("ul#payment_form_paypal_express").show();
        if(_isshippable){
            jQuery("#billingDetails .billingAdd").hide();    
        }    
        jQuery("#paymentmethoderrormsg, #billingDetails #cobillingaddress, #stripe-update-payment-holder").addClass("dnone");
        jQuery("#payment_form input[type='submit']").addClass("marginnone");
        jQuery("label[for='p_method_stripe'] img").attr("src", "/skin/frontend/new-yogasmoga/yogasmoga-theme/images/checkout/credittab.png");
        jQuery("div#stripe-payment-details,a#stripe-update-payment,div#change-stripe-detail").hide();
    }

    if(jQuery("input[type='radio'][value='stripe']").is(':checked'))
    {
        jQuery("ul#payment_form_paypal_express").hide();
        jQuery("#payment_form input[type='submit']").removeClass("marginnone marbtm745");
        if(_isshippable){
            jQuery("#billingDetails .billingAdd").show();    
        }
        jQuery("#paymentmethoderrormsg, #billingDetails #cobillingaddress, #stripe-update-payment-holder").removeClass("dnone");
        jQuery("label[for='p_method_stripe'] img").attr("src", "/skin/frontend/new-yogasmoga/yogasmoga-theme/images/checkout/credittabovrnew.png");
        jQuery("label[for='p_method_paypal_express'] img").attr("src", "/skin/frontend/new-yogasmoga/yogasmoga-theme/images/checkout/paypaltabnew.png");
        if(jQuery("#billingDetails #cobillingaddress").is(":visible")){
            jQuery("#payment_form input[type='submit']").addClass("marbtm745");
        }
        //jQuery("a#stripe-update-payment").show();
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
        if(jQuery("#stripe_expiration").val() != "" && jQuery("#stripe_expiration_yr").val() == "")
        {
            flag = false;
            setOnError(jQuery("#stripe_expiration"), "Expiry Date is required");
            setOnError(jQuery("#stripe_expiration_yr"));
        }
        if(jQuery("#stripe_expiration").val() == "" && jQuery("#stripe_expiration_yr").val() != "")
        {
            flag = false;
            setOnError(jQuery("#stripe_expiration"), "Expiry Date is required");
            setOnError(jQuery("#stripe_expiration_yr"));
        }
        if(jQuery("#stripe_expiration").val() != "" && jQuery("#stripe_expiration_yr").val() != "")
        {
            if(!Stripe.validateExpiry(jQuery("#stripe_expiration").val(), jQuery("#stripe_expiration_yr").val()))
            {
                flag = false;
                setOnError(jQuery("#stripe_expiration"), "Invalid Expiration Date");
                setOnError(jQuery("#stripe_expiration_yr"));
            }
        }
        if(!flag)
            jQuery("#paymentmethoderrormsg").html('Please fill in the required fields in red to continue');
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
    if(jQuery("#stripe_expiration").val() != "" && jQuery("#stripe_expiration_yr").val() == "")
    {
        flag = false;
        setOnError(jQuery("#stripe_expiration"), "Expiry Date is required");
        setOnError(jQuery("#stripe_expiration_yr"));
    }
    if(jQuery("#stripe_expiration").val() == "" && jQuery("#stripe_expiration_yr").val() != "")
    {
        flag = false;
        setOnError(jQuery("#stripe_expiration"), "Expiry Date is required");
        setOnError(jQuery("#stripe_expiration_yr"));
    }
    if(jQuery("#stripe_expiration").val() != "" && jQuery("#stripe_expiration_yr").val() != "")
    {
        if(!Stripe.validateExpiry(jQuery("#stripe_expiration").val(), jQuery("#stripe_expiration_yr").val()))
        {
            flag = false;
            setOnError(jQuery("#stripe_expiration"), "Invalid Expiration Date");
            setOnError(jQuery("#stripe_expiration_yr"));
        }
    }
    if(!flag)
        jQuery("#paymentmethoderrormsg").html('Please fill in the required fields in red to continue');
    else
        jQuery("#paymentmethoderrormsg").html('');
    return flag;
}
