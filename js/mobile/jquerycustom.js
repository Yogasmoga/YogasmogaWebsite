jQuery(document).ready(function($){
    
   
    
    setTimeout(function(){
        jQuery("input[type='radio'][name='shipping_method']").live('click', function(){
            jQuery("#update_order").trigger('click');
        });
    }, 500);

});