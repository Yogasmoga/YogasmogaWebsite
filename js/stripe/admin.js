Object.extend(AdminOrder.prototype, {
    loadAreaResponseHandler : function (response){
        if (response.error) {
            alert(response.message);
        }
        if(response.ajaxExpired && response.ajaxRedirect) {
            setLocation(response.ajaxRedirect);
        }
        if(!this.loadingAreas){
            this.loadingAreas = [];
        }
        if(typeof this.loadingAreas == 'string'){
            this.loadingAreas = [this.loadingAreas];
        }
        if(this.loadingAreas.indexOf('message'==-1)) this.loadingAreas.push('message');
        for(var i=0; i<this.loadingAreas.length; i++){
            var id = this.loadingAreas[i];
            if($(this.getAreaId(id))){
                if ('message' != id || response[id]) {
                    var wrapper = new Element('div');
                    wrapper.update(response[id] ? response[id] : '');
                    $(this.getAreaId(id)).update(wrapper);
                    checkStripeValidation();
                }
                if ($(this.getAreaId(id)).callback) {
                    this[$(this.getAreaId(id)).callback]();
                }
            }
        }
    },
	getPaymentData: function() {
		if (typeof (currentMethod) == 'undefined') {
	        if (this.paymentMethod) {
	            currentMethod = this.paymentMethod;
	        } else {
	            return false;
	        }
	    }
	    var data = {};
		    
	    var fields = $('payment_form_' + currentMethod).select('input', 'select');
	    for ( var i = 0; i < fields.length; i++) {
	        data[fields[i].name] = fields[i].getValue();
	    }

	    if ((typeof data['payment[stripe_customer_id]'])!='undefined') {
			if (data['payment[stripe_customer_id]'] != "" && data['payment[create_stripe_customer]']=="0") {
				return data;
			} 
			if (data['payment[stripe_customer_id]'] !="" && data['payment[create_stripe_customer]']=="1" && data['payment[stripe_token]']=="") {
				return false;
			}
		}		
	    
	    if ((typeof data['payment[cc_type]']) != 'undefined'
	            && (!data['payment[cc_type]'] || !data['payment[cc_number]'])) {
	        return false;
	    }
	    if ((typeof data['payment[cc_cid]']) != 'undefined') {
		    if (data['payment[cc_cid]']=="") {
			    return false;
		    }
	    }
	    
	    if (data['payment[cc_number]']=='' || data['payment[cc_exp_month]'] =="" || data['payment[cc_exp_year]'] == "") {
		    return false;
	    }
	    return data;
	},
	changePaymentData: function()
    {
		var elem = Event.element(event);
        if(elem && elem.method){
            var data = this.getPaymentData(elem.method);
    		createStripeToken((typeof data['send_address_data'])!='undefined',(typeof data['payment[cc_cid]']) != 'undefined');
        }
    }
});

$$('head').first().insert({
    bottom: new Element('script', {
        type: 'text/javascript',
        src: 'https://js.stripe.com/v1/'
    })
});

function createStripeToken(addr,cvv) {
	Stripe.setPublishableKey($F('publishable_key'));
	if (addr && cvv) {
		Stripe.createToken({
			name: $F("order-billing_address_firstname") + " " +  $F("order-billing_address_lastname"),
			address_line1: $F("order-billing_address_street1"),
			address_line2: $F("order-billing_address_street2"),
			address_state: $F("order-billing_address_region"),
			address_zip: $F("order-billing_address_postcode"),
			address_country: $F('order-billing_address_country_id'),
			number: $F('stripe_cc_number'),
			cvc: $F('stripe_cc_cid'),
			exp_month: $F('stripe_expiration'),
			exp_year: $F('stripe_expiration_yr')}, stripeResponseHandler);
	} 
	if (!addr&&cvv) {
		Stripe.createToken({
			name: $F("order-billing_address_firstname") + " " +  $F("order-billing_address_lastname"),
			number: $F('stripe_cc_number'),
			cvc: $F('stripe_cc_cid'),
			exp_month: $F('stripe_expiration'),
			exp_year: $F('stripe_expiration_yr')}, stripeResponseHandler);
	}
	if (!addr&&!cvv) {
		Stripe.createToken({
			name: $F("order-billing_address_firstname") + " " +  $F("order-billing_address_lastname"),
			number: $F('stripe_cc_number'),
			exp_month: $F('stripe_expiration'),
			exp_year: $F('stripe_expiration_yr')}, stripeResponseHandler);
	}
	
}

function stripeResponseHandler(status, response) {
    if (response.error) {
        alert(response.error.message);
    } else {
        var token = response['id'];
        $('stripe_token').value = token;
    }
}

function toggleValidation(state) {
	if (!state) {
		$('stripe-change-payment-form').select('input','select').each(function(e){
			if ($(e).hasClassName("stripe-toggle-valid")) {
				$(e).removeClassName('required-entry');
			}
		});
	} else {
		$('stripe-change-payment-form').select('input','select').each(function(e){
			if ($(e).hasClassName("stripe-toggle-valid")) {
				$(e).addClassName('required-entry');
			}
		});
	}
}	

function checkStripeValidation() {
	if ($('stripe_stripe_customer_id')) {
		if ($F("stripe_stripe_customer_id")!='') {
			toggleValidation(false);
		}
	}
	
	if ($("stripe_token")) {
		if ($F('stripe_token')) {
			toggleValidation(false);
		}
	}
}

document.observe('dom:loaded', function(){

	checkStripeValidation();
	
	if ($('stripe-update-payment')) {
		$('stripe-update-payment').observe('click',function(event){
			Event.stop(event);
			if ($('stripe-change-payment-form').visible()) {
				$('stripe-change-payment-form').hide();
				$('stripe-payment-details').show();
				$('stripe_create_stripe_customer').value = '0';
				toggleValidation(true);
				$(this).update("Change payment information");
			} else {
				toggleValidation(false);
				$(this).update("Use existing payment information");
				$('stripe-change-payment-form').show();
				$('stripe-payment-details').hide();
				$('stripe_create_stripe_customer').value = "1";
			}
		});	
	}

});

