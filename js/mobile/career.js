jQuery.noConflict();
var type = window.location.hash.substr(1);
jQuery(".sign-in-box h1").html("JOBS");
jQuery(document).ready(function ($) {

 var questionPos = type.indexOf("?");
 if (questionPos > -1)
  type = type.substring(0, questionPos);

 if (type == "") {
  type = "career1";
 }
 $(".career-page").hide();
 $(".career-page#" + type).show();
 /******* code for accordian ***/
/*  $(".career-page li .toggle").click(function (e) {
  e.preventDefault();
  $(this).parent().siblings().find(".toggle").removeClass('active');
  $(this).toggleClass('active');
  $(this).parent('li').toggleClass('active');
  $(this).parent('li').find(".answer_content").slideUp('fast');
  $(this).parent('li.active').find(".answer_content").slideDown('fast');
 }); */
 /******* code for accordian ***/
 /* $(".sub-nav li a").click(function (e) {
  e.preventDefault();
  var target = $(this).attr('rel');
  $("#"+target).show().siblings(".career-page").hide();

 }); */

 /*===========ajax career data========*/
 if(window.location.href.indexOf('https://') >= 0)
  _usesecureurl = true;
 else
  _usesecureurl = false;
 var url = homeUrl;
 if(_usesecureurl)
  url = securehomeUrl;

 $('.sub-nav li a').click(function(e){
  e.preventDefault();
  var state = $(this).attr('rel');
  jQuery.ajax({
   type: 'POST',
   url: url+ 'careers/index/mobilestatejobs',
   data: {'state': state},
   beforeSend:function (data) {
    jQuery("#content-loader").show();
	jQuery(".career-page").hide();
   },
   success: function (data) {
    jQuery("#content-loader").hide();
	jQuery(".career-page").show();
    jQuery(".career-page").html(data);
    /******* code for accordian ***/
    $(".career-page li .toggle").click(function (e) {
     e.preventDefault();
     $(".career-page li .toggle").not(this).parent('li').removeClass('active');
		$(".career-page li .toggle").not(this).parent('li').find('.toggle').removeClass('active');
		$(".career-page li .toggle").not(this).parent('li').find(".answer_content").slideUp('fast');
		$(this).parent('li').toggleClass('active');
		$(this).parent('li').find('.toggle').toggleClass('active');
		$(this).parent('li').find(".answer_content").slideToggle('fast');
    });
    /******* code for accordian ***/
    $(".sub-nav li a").click(function (e) {
     e.preventDefault();
     var target = $(this).attr('rel');
     $("#"+target).show().siblings(".career-page").hide();

    });

   },
   error: function() {
    alert('Sorry for inconvinious try after some time');
   },

  });
 });

 jQuery.ajax({
  type: 'POST',
  url: url+ 'careers/index/mobiledefaultstatejobs',
  data: {'state': 1},
  beforeSend:function (data) {
   jQuery("#content-loader").show();
   jQuery(".career-page").hide();
  },
  success: function (data) {
   jQuery("#content-loader").hide();
   jQuery(".career-page").show();
   jQuery(".career-page").html(data);
   /******* code for accordian ***/
   $(".career-page li .toggle").click(function (e) {
    e.preventDefault();
		$(".career-page li .toggle").not(this).parent('li').removeClass('active');
		$(".career-page li .toggle").not(this).parent('li').find('.toggle').removeClass('active');
		$(".career-page li .toggle").not(this).parent('li').find(".answer_content").slideUp('fast');
		$(this).parent('li').toggleClass('active');
		$(this).parent('li').find('.toggle').toggleClass('active');
		$(this).parent('li').find(".answer_content").slideToggle('fast');
	
   });
   /******* code for accordian ***/
   $(".sub-nav li a").click(function (e) {
    e.preventDefault();
    var target = $(this).attr('rel');
    $("#"+target).show().siblings(".career-page").hide();

   });

  },
  error: function() {
   alert('Sorry for inconvinious try after some time');
  },

 });

});