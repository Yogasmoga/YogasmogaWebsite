jQuery(document).ready(function($){

});

function setOnError(element)
{
    jQuery(element.parents("table.inputtable:first")).addClass("error");
    jQuery(element.parents("table.inputtable:first")).find("td.errortext div").fadeIn('fast');
}

function unsetError(element)
{
    jQuery(element.parents("table.inputtable:first")).removeClass("error");
    jQuery(element.parents("table.inputtable:first")).find("td.errortext div").fadeOut('fast');
}