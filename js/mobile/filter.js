jQuery(document).ready(function($){
   /* /////////////////// YS MENU ////////////////////// */
   $(".toggle_dropdown").click(function(){
      $(this).toggleClass("active");
      $(".dropdown_content").slideToggle();
   });
   $(".filter > p:first-child").click(function(){
      $(this).find("span").toggleClass("active");
      $(this).next().slideToggle();
   });
   $(".filter_bottom > p:first-child").click(function(){
      $(".filter_bottom > p span").removeClass("active");
      $(this).find("span").addClass("active");
      $("form[name='filter']").submit();
   });
   $(".filter_bottom > p:last-child").click(function(){
      $(".filter_bottom > p span").removeClass("active");
      $(this).find("span").addClass("active");
      $("form[name='filter']").reset();
   });
   $(".dropdown_links > ul>li>span").click(function(){
      $(".dropdown_links > ul>li>span").not($(this)).removeClass("active");
      $(this).toggleClass("active");
      $(".dropdown_links > ul>li>ul").not($(this).next()).slideUp();
      $(this).next().slideToggle();
   });
   /******* csp filter task start *************************/
    //  csp toggleClass
    $(".toggle_csp").click(function(){
      $(this).toggleClass("active");
      $(".csp_dropdown_content").slideToggle();
	  
   });
    $(".bysize > a").click(function(){
     // $(".bysize > a").not($(this)).removeClass("active");
      $(this).toggleClass("active");     
   });
   
    $(".byrange > a").click(function(){
    //  $(".byrange > a").not($(this)).removeClass("active");
      $(this).toggleClass("active");  
	
   
   });
   
		$(".csp_links a").click(function(){
			if ($('.bysize > a').hasClass('active') || $('.byrange > a').hasClass('active')) {			
			$('.toggle_csp.active').addClass('on');
		//	$(".csp_dropdown_content").slideUp();
			}
			
			
			
		});
		$(".clear-txt").click(function(){
			$(this).removeClass("clearon");

			var arSizesToCheck = Array();
            jQuery(".chk-size").each(function(){

                if(jQuery(this).hasClass('chk-size-selected'))
                    arSizesToCheck.push(jQuery(this).attr('rel'));
            });

			var arCatsToCheck = Array();
            jQuery(".chk-cats").each(function(){

                if(jQuery(this).hasClass('chk-cats-selected'))
                    arCatsToCheck.push(jQuery(this).attr('rel'));
            });

			if($(this).hasClass("clear_size")){

				jQuery(".productRep").each(function () {
					 jQuery(this).removeClass('chk-size-opened');
					 if(arCatsToCheck.length>0) {
						 if(jQuery(this).hasClass('chk-cat-opened'))
							jQuery(this).show();
						 else
							jQuery(this).hide();
					 }
					 else{
						jQuery(".productRep").show();
					 }
				 });

			}else{

				jQuery(".productRep").each(function () {
					 jQuery(this).removeClass('chk-cat-opened');
					 if(arSizesToCheck.length>0) {
						 if(jQuery(this).hasClass('chk-size-opened'))
							jQuery(this).show();
						 else
							jQuery(this).hide();
					 }
					 else{
						jQuery(".productRep").show();
					 }
				 });

			}

			if($(this).hasClass("clear_size2")){

				jQuery(".productCont").each(function () {
					 jQuery(this).removeClass('chk-size-opened');
					 if(arCatsToCheck.length>0) {
						 if(jQuery(this).hasClass('chk-cat-opened'))
							jQuery(this).show();
						 else
							jQuery(this).hide();
					 }
					 else{
						jQuery(".productCont").show();
					 }
				 });

			}

			//jQuery(".productCont").show();
			/*************** logic to check if all colors are hidden, then we need to hide the header as well ************/
            for(var i=1;i<=productColorIndex;i++){
                var hideHeader = true;
                jQuery(".product-color-" + i).each(function(){
                    if(jQuery(this).is(":visible")){
                        hideHeader = false;
                    }
                });

                if(hideHeader)
                    jQuery(".product-header-" + i).hide();
                else
                    jQuery(".product-header-" + i).show();
            }
			/*************** logic to check if all colors are hidden, then we need to hide the header as well ************/
			jQuery("#no-product-found").hide();

			if ($('.bysize > a').hasClass('chk-size-selected') || $('.byrange > a').hasClass('chk-cats-selected')) {
				$('.toggle_csp.active').addClass('on');
			}
			else{
			$('.toggle_csp.active').removeClass('on');					
			}
			
			 $(this).next().find("a").removeClass("chk-size-selected");
			 $(this).next().find("a").removeClass("chk-cats-selected");
			});
			
			
			$('.toggle_csp').click(function(){
				if(!$('.csp_links .sub_cat a').hasClass('chk-size-selected') && !$('.csp_links .sub_cat a').hasClass('chk-cats-selected')){
					$(this).removeClass('on');		
				}	
				
			});
 /******* csp filter task end *************************/
});