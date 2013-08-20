jQuery(document).ready(function($){
    
    jQuery("input[type='radio'][name='shipping_method']").click(function(){        
            jQuery("#update_order").trigger('click');                                 
    });

});