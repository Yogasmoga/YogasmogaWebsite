jQuery(document).ready(function($){
    $("#txtNewsletterEmail").keypress(function (event) {
        if (event.which == 13) {
            SubscribeNewsletter();
            return false;
        }
    });
    
    $("#btnNewsletter").click(function(){
        SubscribeNewsletter();
    });
    
});

function SubscribeNewsletter()
{
    if(jQuery("#txtNewsletterEmail").val() == "" || jQuery("#txtNewsletterEmail").val() == jQuery("#txtNewsletterEmail").attr("watermark"))
    {
        jQuery("#footernotification").html("Please provide your Email Address").removeClass("success").addClass("error").fadeIn();
        return;
    }
    if(!validateEmail(jQuery("#txtNewsletterEmail").val()))
    {
        jQuery("#footernotification").html("Doesn't look like that's a valid Email Address").removeClass("success").addClass("error").fadeIn();
        return;
    }
    else
    {
        jQuery("#footernotification").hide();
    }
    jQuery.ajax({
        type : 'POST',
        url : homeUrl + 'mynewsletter/mysubscriber/add',
        data : {'email': jQuery("#txtNewsletterEmail").val()},
        success : function(result){
            result = eval('(' + result + ')');
            if(result.status == "0")
                jQuery("#footernotification").html(result.message).removeClass("success").addClass("error").fadeIn();
            else
                jQuery("#footernotification").html(result.message).removeClass("error").addClass("success").fadeIn();
            //setTimeout(function(){ rremovenotifications(); }, 5000);
        }
    });
}