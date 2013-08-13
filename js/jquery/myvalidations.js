jQuery(document).ready(function($){
    
    jQuery("input[type='radio'][name='shipping_method']").click(function(){        
            jQuery("#update_order").trigger('click');
            jQuery("#chooseshippingmethod").hide();            
    });

});

function setOnError(element, errormsg)
{
    errormsg = (typeof errormsg === "undefined") ? "" : errormsg;
    jQuery(element.parents("table.inputtable:first")).addClass("error");
    jQuery(element.parents("table.inputtable:first")).find("td.errortext div").hide();
    jQuery(element.parents("table.inputtable:first")).find("td.errortext div").fadeIn('fast');
    if(errormsg != "")
        jQuery(element.parents("table.inputtable:first")).find("td.errortext div").html(errormsg);
    else
    {
        if(jQuery(element).attr('defaulterrormsg'))
            jQuery(element.parents("table.inputtable:first")).find("td.errortext div").html(jQuery(element).attr('defaulterrormsg'));
    }
}

function setAllOnError(element)
{
    element.find("table.inputtable").each(function(){
       jQuery(this).addClass("error");
       jQuery(this).find("td.errortext div").fadeIn('fast');    
    });
}

function validatefields(element)
{
    var flag = true;
    element.find("input.requiredfield, select.requiredfield").each(function(){
        if(jQuery(this).val() == "" || jQuery(this).val() == "0")
        {
            setOnError(jQuery(this));
            flag = false; 
        }
    });
    return flag;
}

function unsetAllError(element)
{
    element.find("table.inputtable").removeClass("error");
    element.find("td.errortext div").fadeOut('fast');
}

function unsetError(element)
{
    jQuery(element.parents("table.inputtable:first")).removeClass("error");
    jQuery(element.parents("table.inputtable:first")).find("td.errortext div").fadeOut('fast');
}

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validateZip(zip) { 
    var re = /(^[A-z0-9]{2,10}([\s]{0,1}|[\-]{0,1})[A-z0-9]{2,10}$)/;
    return re.test(zip);
}

function isInt(n) {
   return typeof n === 'number' && n % 1 == 0;
}

function isNormalInteger(str) {
    var n = ~~Number(str);
    return String(n) === str && n > 0;
}