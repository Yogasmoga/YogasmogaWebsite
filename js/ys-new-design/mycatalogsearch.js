jQuery(document).ready(function($){
    $("#btnSearch").click(function(){
        searchcatalog();
    });
    $("#txtSearch").keypress(function (event) {
        if (event.which == 13) {
            searchcatalog();
            return false;
        }
    });
    setSearchresultcount(); 
});

function searchcatalog()
{
    if(jQuery("#txtSearch").val() == "")
    {
        setOnError(jQuery("#txtSearch"));
        return;
    }
    unsetError(jQuery("#txtSearch"));
    window.location = homeUrl + 'catalogsearch/result?q=' + jQuery("#txtSearch").val();
}

function setSearchresultcount()
{
    var count = jQuery("div#mycategory_products div.item").length; 
    if(count > 1)
        jQuery("span#spresultcount").html(count + " PRODUCT MATCHES");
    else
        jQuery("span#spresultcount").html(count + " PRODUCT MATCH");
    
}