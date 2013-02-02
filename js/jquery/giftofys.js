jQuery(document).ready(function($){
    $("#createcardform").submit(function(){
        _addingtocart = true;
        createcard();
        return false;
    });
    $("#cardbalanceform").submit(function(){
        _addingtocart = true;
        getcardbalance();
        return false;
    });
});

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