jQuery(document).ready(function($){

   $(".swatch").click(function(){
      $(this).find("span.swatch_checked").toggleClass("selected");
      alert($(this).find("span.swatch_checked").attr("class"));
   });
   $(".size").click(function(){
      $(this).toggleClass("selected");
   });
   $(".texture").click(function(){
      $(this).toggleClass("selected");
   });





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
      $(this).toggleClass("active");
      $(this).next().slideToggle();
   });
});