jQuery(document).ready(function($){


$(".showUpadd").on("click", function(){
	slideAddCont();
});

$(".showUpdateAdd").on("click", "li", function(){
	$(".showUpdateAdd").find("li").removeClass("selected");
	$(this).addClass("selected");	
	var selectedAddVal = $(this).addClass("selected").text();
	slideAddCont();										  
});



var firstShpVal = $(".showShippingOpt").find("li:nth-child(1)").text(); 
$(".shippingOption").find(".addVal").text(firstShpVal);

$(".showShpOpt").on("click", function(){
	slideShpCont();										  
});

$(".showShippingOpt").on("click", "li", function(){
	var selectedVal = $(this).text();
	$(".shippingOption").find(".addVal").text(selectedVal);
	slideShpCont();										  
});

// Add New Address
$(".addnewBtn").on("click", function(){
	$("#updateNameAdd, .selectAddress").hide();
	$(".addNewAdd").slideDown("slow");
});

});

function slideAddCont(){
	jQuery(".showUpadd").toggleClass("reverse");											 
	jQuery(".showUpdateAdd").slideToggle("slow");
}

function slideShpCont(){
	jQuery(".showShpOpt").toggleClass("reverse");											 
	jQuery(".showShippingOpt").slideToggle("slow");
}