$(document).ready(function() {
	
	var menu = 0;
	$("#menu-active").css("background","url(img/flecha.png) no-repeat");
	$("#menu-active").click(function(){ $("#menu-themes").click(); return false; });
	$("#menu-themes").click(function(){
		$("#switch").slideToggle(500);
		if(menu==0){
			$("#menu-active").css("background","url(img/flecha_active.png) no-repeat");
			menu = 1;
		}else{
			$("#menu-active").css("background","url(img/flecha.png) no-repeat");
			menu = 0;
		}
		return false;
	});
	
	$("[id^='theme-']").click(function() {
		type=$(this).attr("lang");
		$("p.iphone-recommendation").hide();
		$("#switch").fadeOut(500);
		$("#iframe").css("filter","alpha(opacity=0)");
		$("#iframe").css("opacity",".0");
		$("#load").fadeIn(1000);
		open = this.id.match("theme-(.*)");
		var html = "#theme-" + open[1];
		$("#menu-themes").html($(html).html());
		if (type=="wordpress"){
			$("#purchase").css("background-image","url(img/feedback_btn.png)").addClass("wp");
			$("#iframe").attr("src","http://ecloudthemes.com/demo/?themedemo=" + open[1] + "&hidebar");
			$("#feedback").find("span.this-theme").html(open[1]);
			if ($("#feedback .thanks").length){
				$("#feedback .thanks").remove();
				$("#feedback").append(form);
			}
			$("#feedback").show().animate({
				top:"56px",
			},2500,"easeOutElastic");
		}
		else{
			$("#feedback").hide().css("top","-1000px");
			$("#purchase").css("background-image","url(img/purchase_btn.gif)").removeClass("wp").attr("href","http://www.hellothemes.com/themes/" + open[1]);
			$("#iframe").attr("src","http://demos.hellothemes.com/" + open[1]);
		}
		$("#iframe").load(function(){
			$("#load").fadeOut(500);
			$("#iframe").css("filter","alpha(opacity=100)");
			$("#iframe").css("opacity","1.0");
			if(type=="iphone"){
				$("p.iphone-recommendation").slideDown(500);
			}
		});
		return false;
    });

	$("a.close").click(function(){
		$("#feedback").slideUp(500);
		return false;
	});

	$("#purchase.wp").live("click",function(){
		$("#feedback").slideDown(500);
		return false;
	});

	$("#feedback form").submit(function(){
		$.ajax({
			type:"post",
			dataType:"json",
			data:{
				feedback_name:$("#feedback #feedback-name").val(),
				feedback_e_mail:$("#feedback #feedback-e-mail").val(),
				feedback_comment:$("#feedback #feedback-comment").val(),
				feedback_theme:open[1]
			},
			url:"/demo/ajax-feedback.php",
			beforeSend:function(){
				form=$("#feedback form");
				$("#feedback form").remove();
				$("#feedback").append('<div class="thanks clearfix"><img class="feedback-thanks" src="./img/feedback-thanks.png" alt="feedback-thanks" /><br />').append('<img id="ajax-loader" src="./img/ajax-loader-2.gif" alt="ajax-loader" /></div>');
			},
			success:function(data){
				$("#feedback #ajax-loader").remove();
				if (data.msg)
					$("#feedback .thanks").append('<p class="feedback-thanks">Your feedback is greatly appreciated! Thanks!</p>');
				else
					$("#feedback .thanks").append('<p class="feedback-thanks">Your feedback was not sent correctly, please try again! Thanks.</p>');
			},
			error:function(data, error){
				$("#feedback #ajax-loader").remove();
				$("#feedback").append('<p class="feedback-thanks">Error processing request.</p>');
			},
			complete:function(){
			}
		});
		return false;
	});

	//$('#iframe').hide();
	$(window).load(function(){
		var h = $(window).height();
		h = h - 60;
		$(window).bind("resize", resizeWindow);
			function resizeWindow(e) {
				var newh = $(window).height();
				 newh = newh - 60; 
				$("#iframe").height(newh)
			}
		$("#iframe").height(h);
		$("#load").fadeOut(500);
		$("#iframe").css("filter","alpha(opacity=100)");
		$("#iframe").css("opacity","1.0");
	});
});
