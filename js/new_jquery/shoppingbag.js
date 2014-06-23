jQuery(document).ready(function($){
    showShoppingBagHtml();
    openShoppingCart();


    // Show/Hide Shopping Cart Container
    function openShoppingCart(){
        var shoppingWdth = $(".shopping-cart").width();
        var bodyHght = $(window).height();

        $(".open-cart").on("click", function(){
            $(".shopping-cart").css({
                "height": bodyHght,
                "display": 'block'
            }).removeClass("hdnovr");
            $(".page").css("position", "relative").animate({ left: -shoppingWdth });
            $(".header-container").animate({ left: -shoppingWdth });
            $("body").addClass("hdnHgt");
            return false;
        });
    };
    // window resize
    $(window).resize(function(){
        var bodyHght = $(window).height();
        $(".shopping-cart").css({
            "height": bodyHght
        });
    });
    /* ===========  code for all events in shopping for appy smogi bucks in the cart  =========*/
    // check if user click on sign in from the drop down menu
    $("#signin").live("click",function(){
        _isClickSigninMenu = true;
    });

    // add bracelet in cart
    var pid = '';
    var colorattributeid = '';
    var sizeattributeid = '';
    $(".addbracelet").live("click",function(){
        jQuery(this).html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' />");
        pid = ($(this).parent("span").parent("li").attr("productid")).trim();
        colorattributeid = ($(this).parent("span").parent("li").attr("colorattributeid")).trim();
        sizeattributeid =  ($(this).parent("span").parent("li").attr("sizeattributeid")).trim();
        addbracelettobag(pid,colorattributeid,sizeattributeid );
    });
    // end add bracelet in cart

    // delete product from cart
    $(".close").live("click",function(){
        var deleteproductid = ($(this).parent("li").attr("id")).trim();
        jQuery(this).parent("li").html("<img style='margin:20px 0;' src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' />");
        deleteproduct(deleteproductid);
    });

    // open login popup for click on sign in on shopping bag
    $(".shoppingbag-login").live("click",function(){
        _isClickShoppingbagSignin = true;
        $("#signing_popup").dialog( "open" );

    });
    // open login popup for click on smogi login (+)  in on shopping bag
    $(".smogi-login").live("click",function(){
        _isClickSmogiLogin = true;
        $("#signing_popup").dialog( "open" );

    });

    // open login popup for click on sign in on shopping bag
    $(".applysmogi").live("click",function(){
        if(!_islogedinuser)
        {
            _isClickApplySmogiBucks = true;
            $("#signing_popup").dialog( "open" );
        }
        if(_islogedinuser)
        {   
            applysmogibucks();

        }
    });
    // remove smogi bucks from cart
    $(".removesmogi").live("click",function(){
        removesmogibucks();
    });
    /* =========== END  code for all events in shopping for appy smogi bucks in the cart  =========*/



    /* ===========  code for all events in shopping for appy Promotion code  in the cart  =========*/

    $(".promo-login").live("click",function(){
        _isClickSmogiLogin = true;
        $("#signing_popup").dialog( "open" );

    });
    $(".applypromo").live("click",function(){
        if(!_islogedinuser)
        {
            //_isClickApplySmogiBucks = true;
            $("#signing_popup").dialog( "open" );
        }
        if(_islogedinuser)
        {
            applypromocode();

        }

    });
    $(".removepromotion").live("click",function(){
        removepromocode();
    });

    /* ===========  END code for all events in shopping for appy Promotion code  in the cart  =========*/

    /* ===========  code for all events in shopping for appy Gift of YS   in the cart  =========*/

    $(".giftcardlogin").live("click",function(){
        _isClickSmogiLogin = true;
        $("#signing_popup").dialog( "open" );

    });
    $(".applygiftcard").live("click",function(){
        if(!_islogedinuser)
        {
           // _isClickApplySmogiBucks = true;
            $("#signing_popup").dialog( "open" );
        }
        if(_islogedinuser)
        {
            applygiftcardcode();

        }

    });
    $(".giftcardcheckbox").live("click",function(){
        redeemgiftcardcode();
    });

    /* ===========  END code for all events in shopping for appy Gift of YS   in the cart  =========*/
    // reset page to default state
    $("#continuelink").live("click", function(){
        $(this).parent(".shopping-cart").addClass("hdnovr");
        $(".page").animate({ left: '0' }).css("");
        $(".header-container").animate({ left: "0" });
        $("body").removeClass("hdnHgt");
        return false;
    });

    // $(".addedItem li").find(".close").on("click", function(){
    //     $(this).parent("li").remove();
    // });
});

function showShoppingBagHtml()
{
    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mynewtheme/shoppingbag/showshoppingbaghtml';
    var checkouturl = homeUrl + 'checkout/onepage';
    if(_usesecureurl)
    {
        url = securehomeUrl + 'mynewtheme/shoppingbag/showshoppingbaghtml';
        checkouturl = securehomeUrl + 'checkout/onepage';
    }
    // check if user click on sign in from drop down menu
    if(_isClickSigninMenu == true)
    {
        _showShoppingbagLoader = true;
        _isClickSigninMenu = false;
    }

    if(_showShoppingbagLoader)
        jQuery(".shopping-cart").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='margin:50% auto auto;' />");
    jQuery.ajax({url : checkouturl});
    setTimeout(function(){


            jQuery.ajax({
                url : url,
                type : 'POST',
                //data : {'blockid':blockid},

                success : function(data){
                    data = eval('('+data + ')');
                    //console.log(data.html);
                   // alert(data.html);
                    jQuery(".shopping-cart").html(data.html);



            }
        });
    },100);
}

function addbracelettobag(pid,colorattributeid,sizeattributeid )
{
    //alert(_productid);

    if((jQuery(".qtyselector").find('option:selected').val() * 1) > 0)
    {
        var braceletorderqty = '';
        _addingtocart = true;
        braceletorderqty = jQuery(".qtyselector").find('option:selected').val();
        var color = jQuery("#cmbcolor").val();
        var size = jQuery("#cmbsize").val();//alert(_productid);
        var addurl = homeUrl + 'mynewtheme/shoppingbag/add?product=' + pid + '&qty=' + braceletorderqty + '&super_attribute[' + colorattributeid + ']=' + color;
        if(sizeattributeid)
            addurl = addurl + '&super_attribute[' + sizeattributeid + ']=' + size;
        //var targetUrl = homeUrl + 'mycatalog/myproduct/setNamaskarError/qty/' + braceletorderqty;
        jQuery.ajax({
            type : 'POST',
            url : addurl,
            data : {},
            success : function(result){
                result = eval('(' + result + ')');
                _addingtocart = false;
                if(result.status == 'success')
                {
                    _isaddedtobracelet = true;
                    jQuery(".shopping-cart").html(result.html);
                    jQuery(".cartitemcount").html(result.count);

                }
            /*    else
                {
                    jQuery.ajax({
                        type : 'POST',
                        url : targetUrl,
                        data : {},
                        success : function(result){
                            _isaddedtobracelet = true;
                            jQuery("#bagform").submit();
                        }
                    });
                } */
            }
        });
        return false;
    }
}

function deleteproduct(deletedproducid)
{
    if(deletedproducid >0)
    {
        var addurl = homeUrl + 'mynewtheme/shoppingbag/delete/';
        jQuery.ajax({
            type : 'POST',
            url : addurl,
            data : {'id':deletedproducid},
            success : function(result){
                result = eval('(' + result + ')');

                if(result.status == 'success')
                {
                    _showShoppingbagLoader = false;
                    showShoppingBagHtml();
                    jQuery(".cartitemcount").html(result.count);

                }

            }
        });
    }
}

function applysmogibucks()
{
    var availablesmogi = jQuery("#smogi").attr("available");
    var smogivalue = (jQuery("#smogi").attr("value")).trim();

    if(isNaN(smogivalue)) {
        alert("Enter Valid Number");
        return false;
    }

    var appliedvalue = jQuery(".smogi span.f-right").attr("usedpoints");

    if(appliedvalue)
    {
        appliedvalue = parseInt(appliedvalue);

        if(!(isNaN(appliedvalue)) && (appliedvalue > 0))
        {
            smogivalue = parseInt(smogivalue) + parseInt(appliedvalue);
        }
    }

    if(availablesmogi)
    {
        availablesmogi = (jQuery("#smogi").attr("available")).trim();
    }


    if(!(isNaN(smogivalue))&&(smogivalue > 0)&&(availablesmogi >= smogivalue))
    {
        if(window.location.href.indexOf('https://') >= 0)
            _usesecureurl = true;
        else
            _usesecureurl = false;
        var url = homeUrl + 'mynewtheme/smogi/applysmogibucks';
        if(_usesecureurl)
            url = securehomeUrl + 'mynewtheme/smogi/applysmogibucks';

        jQuery.ajax({
            url : url,
            type : 'POST',
            data : {'points_to_be_used':smogivalue},

            success : function(data){
                data = eval('('+data + ')');

                if(data.status == "success")
                {
                    _showShoppingbagLoader = false;
                    showShoppingBagHtml();
                }
                else
                {
                    alert('there is some error while applying smogi bucks');
                }



            }
        });
    }
    else{
        alert('Please input valid number/you have not sufficient points in account');
    }

}

function removesmogibucks()
{
    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mynewtheme/smogi/removesmogibucks';
    if(_usesecureurl)
        url = securehomeUrl + 'mynewtheme/smogi/removesmogibucks';
    jQuery.ajax({
        url : url,
        type : 'POST',
       // data : {'points_to_be_used':smogivalue},

        success : function(data){
            data = eval('('+data + ')');

            if(data.status == "success")
            {
                _showShoppingbagLoader = false;
                showShoppingBagHtml();
            }
            else
            {
                alert('there is some error while removing smogi bucks');
            }

        }
    });
}

function automaticapplysmogibucks()
{
    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mynewtheme/smogi/automaticapplysmogibucks';
    if(_usesecureurl)
        url = securehomeUrl + 'mynewtheme/smogi/automaticapplysmogibucks';
    jQuery.ajax({
        url : url,
        type : 'POST',
        // data : {'points_to_be_used':smogivalue},

        success : function(data){
            data = eval('('+data + ')');

            if(data.status == "success")
            {
                _showShoppingbagLoader = false;
                showShoppingBagHtml();
            }
            else
            {
                alert('there is some error while apply auto smogi bucks');
            }

        }
    });
}

function applypromocode()
{

    var promocode = (jQuery("#promocode").attr("value")).trim();

        if(window.location.href.indexOf('https://') >= 0)
            _usesecureurl = true;
        else
            _usesecureurl = false;
        var url = homeUrl + 'mynewtheme/promotion/applycouponcode';
        if(_usesecureurl)
            url = securehomeUrl + 'mynewtheme/promotion/applycouponcode';

        jQuery.ajax({
            url : url,
            type : 'POST',
            data : {'coupon_code':promocode},

            success : function(data){
                data = eval('('+data + ')');

                if(data.status == "success")
                {
                    _showShoppingbagLoader = false;
                    showShoppingBagHtml();
                }
                else
                {
                    alert(data.errors);
                }



            }
        });



}

function removepromocode()
{
    var promocode = (jQuery("#promocode").attr("value")).trim();

    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mynewtheme/promotion/applycouponcode';
    if(_usesecureurl)
        url = securehomeUrl + 'mynewtheme/promotion/applycouponcode';

    jQuery.ajax({
        url : url,
        type : 'POST',
        data : {'remove':'1'},

        success : function(data){
            data = eval('('+data + ')');

            if(data.status == "success")
            {
                _showShoppingbagLoader = false;
                showShoppingBagHtml();
            }
            else
            {
                alert(data.errors);
            }
        }
    });


}

function applygiftcardcode()
{
    var giftcardcode = (jQuery("#giftcartcode").attr("value")).trim();

    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mynewtheme/giftofys/applyGiftCard';
    if(_usesecureurl)
        url = securehomeUrl + 'mynewtheme/giftofys/applyGiftCard';

    jQuery.ajax({
        url : url,
        type : 'POST',
        data : {'giftcard_code':giftcardcode},

        success : function(data){
            data = eval('('+data + ')');

            if(data.status == "success")
            {
                _showShoppingbagLoader = false;
                showShoppingBagHtml();
            }
            else
            {
                alert(data.errors);
            }
        }
    });
}
function redeemgiftcardcode()
{
    var redeemvalue = jQuery(".giftcardcheckbox").val();

    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mynewtheme/giftofys/giftcardactive';
    if(_usesecureurl)
        url = securehomeUrl + 'mynewtheme/giftofys/giftcardactive';

    jQuery.ajax({
        url : url,
        type : 'POST',
        data : {'giftcard_use':redeemvalue},

        success : function(data){
            data = eval('('+data + ')');

            if(data.status == "success")
            {
                _showShoppingbagLoader = false;
                showShoppingBagHtml();
            }
            else
            {
                alert(data.errors);
            }
        }
    });
}