jQuery(document).ready(function($){
    $("#txtNewsletterEmail").keypress(function (event) {
        if (event.which == 13) {
            SubscribeNewsletter('#txtNewsletterEmail','#footernotification');
            return false;
        }
    });
    
    $("#btnNewsletter").click(function(){
        SubscribeNewsletter('#txtNewsletterEmail','#footernotification');
    });
    
    $("#txtNewsletterEmail1").keypress(function (event) {
        if (event.which == 13) {
            SubscribeNewsletter('#txtNewsletterEmail1','#notification1');
            return false;
        }
    });
    
    $("#btnNewsletter1").click(function(){
        SubscribeNewsletter('#txtNewsletterEmail1','#notification1');
    });
});

function SubscribeNewsletter(input, notification)
{
    if(jQuery(input).val() == "" || jQuery(input).val() == jQuery(input).attr("watermark"))
    {
        jQuery(notification).html("Please provide your Email Address").removeClass("success").addClass("error").fadeIn();
        return;
    }
    if(!validateEmail(jQuery(input).val()))
    {
        jQuery(notification).html("Doesn't look like that's a valid Email Address").removeClass("success").addClass("error").fadeIn();
        return;
    }
    else
    {
        jQuery(notification).hide();
    }
    jQuery.ajax({
        type : 'POST',
        url : homeUrl + 'mynewsletter/mysubscriber/add',
        data : {'email': jQuery(input).val()},
        success : function(result){
            result = eval('(' + result + ')');
            if(result.status == "0")
                jQuery(notification).html(result.message).removeClass("success").addClass("error").fadeIn();
            else
                jQuery(notification).html(result.message).removeClass("error").addClass("success").fadeIn();
            //setTimeout(function(){ rremovenotifications(); }, 5000);
        }
    });
}