var _braceletcost = 0;
var _isaddedtobracelet = false;
jQuery(document).ready(function($){
    $("#cmbcolor").change(function(){
        changeColor($("#cmbcolor").find(":selected").text());
    });
    changeColor($("#cmbcolor").find(":selected").text());
    
    $("#cmbsize").change(function(){
        _braceletcost = $(this).find(":selected").attr('price') * 1;
        jQuery("#spnbaseprice").html("$" + _braceletcost);
        calculatetotalcost();
    });
    
    $("#braceletcount").change(function(){
        calculatetotalcost();
    });
    
    $("#bagform").submit(function(){
        return addbracelettocart();
    });
});

function addbracelettocart()
{
    if(_isaddedtobracelet)
        return true;
    if(isNaN(jQuery("#braceletcount").val()))
        return true;
    if(!isInteger(jQuery("#braceletcount").val()))
        return true;
    if((jQuery("#braceletcount").val() * 1) > 0)
    {
        _addingtocart = true;
        _productorderqty = jQuery("#braceletcount").val();
        var color = jQuery("#cmbcolor").val();
        var size = jQuery("#cmbsize").val();
        var addurl = homeUrl + 'mycheckout/mycart/add?product=' + _productid + '&qty=' + _productorderqty + '&super_attribute[' + _colorattributeid + ']=' + color;
        if(_sizesuperattribute)
            addurl = addurl + '&super_attribute[' + _sizeattributeid + ']=' + size;
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
                    jQuery("#bagform").submit();
                }
                else
                {
                    alert('Oops! An unexpected error occured.');
                }
            }
        });
        return false;    
    }
}

function searchproductcolorinfoarrray(clr)
{
    for(i = 0; i < _productcolorinfo.length; i++)
    {
        if(_productcolorinfo[i].color == clr)
            return i;
    }
    return -1;
}

function isInteger(possibleInteger) {
    var intRegex = /^\d+$/;
    if(intRegex.test(possibleInteger)) {
       return true;
    }
    else
        return false;
}

function calculatetotalcost()
{
    if(isNaN(jQuery("#braceletcount").val()))
        return;
    if(!isInteger(jQuery("#braceletcount").val()))
        return;
    var price = Math.round((_braceletcost * (jQuery("#braceletcount").val() * 1))*100)/100 + "";
    if(price.indexOf('.') == -1)
        price += ".00";
    else
    {
        console.log(price.length - price.indexOf('.') - 1);
        //return;
        var temp = price;
        for(i = 0; i < ((temp.length - temp.indexOf('.') - 1) * 1); i++)
        {
            price += "0";
        }
    }
    jQuery("#spntotalprice").html("$" + price);
    
}

function changeColor(clr)
{
    var colorindex = searchproductcolorinfoarrray(clr);
    if(colorindex == -1)
        return;
    jQuery("#cmbsize option").addClass('nodisplay');
    var cmbhtml = '';
    for(i = 0; i < _productcolorinfo[colorindex].sizes.length; i++)
    {
        var sizetemp = _productcolorinfo[colorindex].sizes[i].split("|");
        var size = sizetemp[0];
        var qty = sizetemp[1];
        var price = sizetemp[2];
        var rewardpoints = sizetemp[3];
        jQuery("#cmbsize option[size='" + size + "']").removeClass('nodisplay');
        jQuery("#cmbsize option[size='" + size + "']").attr("price", price);
        jQuery("#cmbsize option[size='" + size + "']").attr("rewardpoints", rewardpoints);    
    }
    jQuery("#cmbsize").val(jQuery("#cmbsize option:not(.nodisplay):first").val());
    jQuery("#spnsize").html(jQuery("#cmbsize option:not(.nodisplay):first").html());
    _braceletcost = jQuery("#cmbsize").find(":selected").attr('price') * 1;
    calculatetotalcost();
    jQuery("#spnbaseprice").html("$" + _braceletcost);
    if(jQuery("#cmbsize option:not(.nodisplay)").length <= 1)
    //if(_productcolorinfo[colorindex].sizes.length > 1)
    {
        jQuery("#cmbsize").hide();
		jQuery("#cmbsize").next('.customSelect').hide();
        jQuery("#spnsize").show();
    }
    else
    {
        jQuery("#cmbsize").show();
		jQuery("#cmbsize").next('.customSelect').show();
        jQuery("#spnsize").hide();  
    }
    
    return;
    jQuery("table.normalproductdetail table.selectedcolor td:last").html(clr);
    jQuery("table.normalproductdetail div#colorcontainer table td").removeClass("tdselectedcolor");
    jQuery("table.normalproductdetail div#colorcontainer table[color='" + clr + "'] tr:nth-child(2) td").addClass("tdselectedcolor");
    jQuery("div#sizecontainer div").removeClass("dvselectedsize");
    //jQuery("div#sizecontainer div").addClass("disabled");
    jQuery("div#sizecontainer div").parent().addClass("disabled");
    
    
    
    for(i = 0; i < _productcolorinfo[colorindex].sizes.length; i++)
    {
        var sizetemp = _productcolorinfo[colorindex].sizes[i].split("|");
        var size = sizetemp[0];
        var qty = sizetemp[1];
        var price = sizetemp[2];
        var rewardpoints = sizetemp[3];
        //var size = _productcolorinfo[colorindex].sizes[i].substr(0, _productcolorinfo[colorindex].sizes[i].indexOf('|'));
//        var qty = _productcolorinfo[colorindex].sizes[i].substr(_productcolorinfo[colorindex].sizes[i].indexOf('|') + 1, _productcolorinfo[colorindex].sizes[i].indexOf('|') + 1);
//        var price = _productcolorinfo[colorindex].sizes[i].substr(_productcolorinfo[colorindex].sizes[i].indexOf('|', _productcolorinfo[colorindex].sizes[i].indexOf('|') + 1) + 1);
        //console.log(qty);
        jQuery("div#sizecontainer div[size='" +  size + "']").parent().removeClass("disabled");
        jQuery("div#sizecontainer div[size='" +  size + "']").attr("qty", qty);
        jQuery("div#sizecontainer div[size='" +  size + "']").attr("price", price);
        jQuery("div#sizecontainer div[size='" +  size + "']").attr("rewardpoints", rewardpoints);
    }
    jQuery("#orderitem").show();
    jQuery("#preorderitem").hide();
    var smallimagehtml = '';
    if(_productdisplaymode == 'popup')
    {
        for(i = 0; i < _productcolorinfo[colorindex].smallimages.length; i++)
        {
            smallimagehtml = smallimagehtml + "<tr><td bigimageurl='" + _productcolorinfo[colorindex].bigimages[i] + "'><img src='" + _productcolorinfo[colorindex].smallimages[i] + "'></td></tr>";
        }
        jQuery("td#tdpopupproductbigimage, td#tdpopupproductsmallimages").hide();
        jQuery("td#tdpopupproductsmallimages table tbody").html(smallimagehtml);
        if(jQuery("td#tdpopupproductsmallimages td").length > 0)
        {
            if(jQuery("td#tdpopupproductbigimage img").length > 0)
                jQuery("td#tdpopupproductbigimage img").attr("src", jQuery("td#tdpopupproductsmallimages table tbody td:first").attr("bigimageurl"));
            else
                jQuery("td#tdpopupproductbigimage").html("<img src='" + jQuery("td#tdpopupproductsmallimages table tbody td:first").attr("bigimageurl") + "'>");
            jQuery("td#tdpopupproductsmallimages table tbody td:first").addClass('selectedimage');   
        }
        jQuery("td#tdpopupproductbigimage, td#tdpopupproductsmallimages").fadeIn('fast');
    }
    else
    {
        smallimagehtml = '<tr>';
        for(i = 0; i < _productcolorinfo[colorindex].smallimages.length; i++)
        {
            smallimagehtml = smallimagehtml + "<td bigimageurl='" + _productcolorinfo[colorindex].bigimages[i] + "' zoomimageurl='" + _productcolorinfo[colorindex].zoomimages[i] + "'><img src='" + _productcolorinfo[colorindex].smallimages[i] + "'></td>";
        }
        smallimagehtml = smallimagehtml + "</tr>";
        jQuery("table.productimagecontainer").hide();
        jQuery("table.smallimagecontiner tbody").html(smallimagehtml);
        if(jQuery("table.smallimagecontiner td").length > 0)
        {
            if(jQuery("table.tdbigimagecontainer img").length > 0)
                jQuery("table.tdbigimagecontainer img").attr("src", jQuery("table.smallimagecontiner td:first").attr("bigimageurl"));
            else
                jQuery("table.tdbigimagecontainer td").html("<img src='" + jQuery("table.smallimagecontiner td:first").attr("bigimageurl") + "'>");   
        }
        jQuery("table.smallimagecontiner td:first").addClass("selectedimage");
        jQuery("table.productimagecontainer").fadeIn('fast');   
    }
}