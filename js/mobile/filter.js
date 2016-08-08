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
    //  $(".csp_dropdown_content").slideToggle();
	  
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
			
			$(this).closest("ul").prev(".clear-txt").addClass("clearon");
			
			
		});
		$(".clear-txt").click(function(){
			$(this).removeClass("clearon");
			if ($('.bysize > a').hasClass('active') || $('.byrange > a').hasClass('active')) {
				$('.toggle_csp.active').addClass('on');
			}
			else{
			$('.toggle_csp.active').removeClass('on');					
			}
			
			 $(this).next().find("a").removeClass("active");
			});
			
			
			$('.toggle_csp').click(function(){
				if(!$('.csp_links .sub_cat a').hasClass('active')){
					$(this).removeClass('on');		
				}	
				
			});
   /******* csp filter task end *************************/
   
   
   
   
   
   
   
   
});