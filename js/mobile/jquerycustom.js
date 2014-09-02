jQuery(document).ready(function($){
    
   
    
    setTimeout(function(){
        jQuery("input[type='radio'][name='shipping_method']").live('click', function(){
            jQuery("#update_order").trigger('click');
        });
    }, 500);

    jQuery("h2.IN").next().find(".price").css("color","rgba(255, 0, 0, 0.99)");
    jQuery(".product-name.IN").next().next().find("span.price").css("color","rgba(255, 0, 0, 0.99)");
    jQuery("ul#options-1-list li:nth-child(1)").hide();
    jQuery("ul#options-1-list li:nth-child(3) input[type='radio']").attr("checked","checked");

});