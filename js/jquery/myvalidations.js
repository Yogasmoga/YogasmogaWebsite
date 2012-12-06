jQuery(document).ready(function($){

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
        if(jQuery(this).val() == "")
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