jQuery(document).ready(function($){
	removeNameLabel();


$(".showUpadd").on("click", function(){
	slideAddCont();
	
	// $('#shipping-address-select').slideToggle().attr("size", function() { 
	// 	return this.options.length; 
	// }).css("height", "auto");
});


// $(".showUpdateAdd").on("click", "li", function(){
// 	$(".showUpdateAdd").find("li").removeClass("selected");
// 	$(this).addClass("selected");	
// 	var selectedAddVal = $(this).addClass("selected").text();
// 	slideAddCont();										  
// });



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

// // Add New Address
// $(".addnewBtn").on("click", function(){
// 	$("#updateNameAdd, .selectAddress").hide();
// 	$(".addNewAdd").slideDown("slow");
// });

});

function removeNameLabel(){
	jQuery(".customer-name").find("input.no-bg").removeClass("no-bg");
	jQuery(".customer-name").find("td.label").remove();
	jQuery(".customer-name").find("table.inputtable").addClass("wdth50");	
	jQuery(".customer-name").find("table.inputtable:nth-child(2)").addClass("f-right");	
}

function slideAddCont(){
	jQuery(".showUpadd").toggleClass("reverse");											 
	jQuery(".listadd").slideToggle("slow");
}

function slideShpCont(){
	jQuery(".showShpOpt").toggleClass("reverse");											 
	jQuery(".showShippingOpt").slideToggle("slow");
}