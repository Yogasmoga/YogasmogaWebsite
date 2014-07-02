var curr_input_value = '';
jQuery(document).ready(function($){
    $("input[type='text'][watermark],input[type='password']").blur(function () {
        if($(this).val() != curr_input_value)
            $(this).attr("usermodified","1");
        if($(this).val() == "")
            $(this).removeAttr("usermodified");
        //else
//            $(this).removeAttr("usermodified");
        if(!$(this).attr("usermodified"))
        {
            if ($(this).val().length == 0 || $(this).val() == $(this).attr("watermark"))
                $(this).val($(this).attr("watermark")).addClass('watermark');   
        }
    });
    $("input[type='text'][watermark],input[type='password']").focus(function () {       
        if(!$(this).attr("usermodified"))
        {
            if ($(this).val() == $(this).attr("watermark"))
                $(this).val('').removeClass('watermark');   
        }
        curr_input_value = $(this).val();
    });
    applywatermark();
});

function applywatermark() {
    jQuery.each(jQuery("input[type='text'][watermark]"), function () {
        if(!jQuery(this).attr("usermodified"))
        {
            if (jQuery(this).val() == '' || jQuery(this).val() == jQuery(this).attr("watermark"))
                jQuery(this).val(jQuery(this).attr("watermark")).addClass('watermark');
            else
                jQuery(this).removeClass('watermark');   
        }
    });
}

function removewatermarks() {
    jQuery.each(jQuery("input[type='text'][watermark]"), function () {
        if(!jQuery(this).attr("usermodified"))
        {
            if (jQuery(this).val() == '' || jQuery(this).val() == jQuery(this).attr("watermark"))
                jQuery(this).val('');   
        }
    });
}

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}