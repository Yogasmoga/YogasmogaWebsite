/*
var issearchanimating = false;
jQuery(document).ready(function($){
    var srch_speed=500;
    var srch_btn=true;
	$("#search_btn").click(function () {
		if(issearchanimating)
			return;
      if ($("#search_form").is(":hidden")) {
		//$("#search_form input[type=submit]").css("display", "none");
        $("#search_form").show().slideDown(srch_speed);
        issearchanimating = true;
		$("#search_form").animate({"top": "80px"}, srch_speed, function() {
			$("#search_text").focus();
			issearchanimating = false;
			});
      } else {
		//$("#search_form").fadeOut("fast");
		//$("#search_form").css({top: ""});
		//$("#search_form").slideUp(srch_speed);
		issearchanimating = true;
		$("#search_form").hide().animate({"top": "65px"}, 0, function() {
			issearchanimating = false;
		});
		//$("#search_form").animate({"bottom": "+=50px"}, srch_speed);
		//$("#search_form").animate({"right": "-=30px"}, "medium");
		srch_btn=true;
		btn=true;
      }
	});
	
	$('#search_text').keyup(function() {
	  if((($('#search_text').val().length>0)) && ($("#search_form input[type=submit]").is(":hidden")) )
	  {
		//$("#search_text").animate({"right": "+=100px"}, "medium");
		$("#search_form input[type=submit]").fadeIn();
		//$("#search_form").animate({"right": "+=64px"}, srch_speed);	
		//srch_btn=false;
	  }
	  if(($('#search_text').val().length==0) && (!$("#search_form input[type=submit]").is(":hidden")) )
	  {
		  //$("#search_form").animate({"right": "-=64px"}, srch_speed);
		  $("#search_form input[type=submit]").fadeOut();
	  }
	});
});

function close_search_box()
{
	if (!jQuery("#search_form").is(":hidden")) 
	{
    	issearchanimating = true;
    	jQuery("#search_form").hide().animate({"top": "65px"}, 0, function() {
    		issearchanimating = false;
    	});
    	//$("#search_form").animate({"bottom": "+=50px"}, srch_speed);
    	//$("#search_form").animate({"right": "-=30px"}, "medium");
    	srch_btn=true;
    	btn=true;
	}
}
*/

var issearchanimating = false;
jQuery(document).ready(function($){
    var srch_speed=500;
    var srch_btn=true;
	$("#search_btn").click(function () 
	{
	  if ($("#search_form").is(":hidden")) 
	  {
		$("#search_form").css('display','block');
	    $("#search_text").animate({
			width : 130
        }, function() {
			$(this).focus();
			$(this).select();
			
            });
      }
      else 
      {
    	
    	$("#search_text").animate({
			width : 0
        }, function() {
        	$("#search_form").css('display','none');
            });
    	
      }
	 
	});
	

});

function close_search_box()
{
	if (!jQuery("#search_form").is(":hidden")) 
	{	
		jQuery("#search_text").animate({
			width : 0
	    }, function() {
	    	jQuery("#search_form").css('display','none');
	        });
	}
}