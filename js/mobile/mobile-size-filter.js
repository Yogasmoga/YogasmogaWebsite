//	var productColorIndex;

jQuery(function(){

    filterSizes();

		jQuery(".chk-size").click(function(e){
			e.preventDefault();
			
			jQuery(this).closest("ul").prev(".clear-txt").addClass("clearon");
			
			
            jQuery("#no-product-found").hide();

            if(jQuery(this).hasClass('chk-size-selected'))
			{
                jQuery(this).removeClass('chk-size-selected');
				jQuery('.toggle_csp.active').addClass('on');
            }
			else{
                jQuery(this).addClass('chk-size-selected');
				jQuery('.toggle_csp.active').removeClass('on');
			}
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

            if(arSizesToCheck.length>0) {              
				// if any of the checkbox is checked
				/*** csp ***/
				jQuery('.toggle_csp.active').addClass('on');
                var productsDisplayed = false;

                jQuery(".productRep").each(function () {

                    var strSizes = jQuery(this).attr('rel');

                    if (strSizes != undefined && strSizes.length > 0) {
                        var arColorSizes = strSizes.split(",");

                        if (arColorSizes.length > 0) {
                            var sizesFound = false;
                            for (var i = 0; i < arSizesToCheck.length; i++) {
                                for (var j = 0; j < arColorSizes.length; j++) {
                                    if (arSizesToCheck[i]==arColorSizes[j]) {
                                        sizesFound = true;
                                        break;
                                    }
                                }

                                if(sizesFound) {
                                    break;
                                }
                            }

							//if category selected
							if (sizesFound) {
									jQuery(this).addClass('chk-size-opened');
							}
							if(arCatsToCheck.length>0) {

								if (sizesFound && jQuery(this).hasClass('chk-cat-opened')) {
									jQuery(this).show();
									jQuery(this).addClass('chk-size-opened');
									productsDisplayed = true;
								}else{
									if (sizesFound) {
										jQuery(this).addClass('chk-size-opened');
									}else{
										jQuery(this).removeClass('chk-size-opened');
									}
									jQuery(this).hide();
								}

							}
							else
							{
								if (sizesFound) {
									jQuery(this).show();
									jQuery(this).addClass('chk-size-opened');
									productsDisplayed = true;
								}
								else{
									jQuery(this).removeClass('chk-size-opened');
									jQuery(this).hide();
								}
							}
                        }
                    }
                    else
                        jQuery(this).hide();
                });

                if(productsDisplayed)
                    jQuery("#no-product-found").hide();
                else
                    jQuery("#no-product-found").show();
            }
            else
			{
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


                //jQuery(".productRep").show();
			}

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

					//adjust griding 
					var loop = 1;
					jQuery(".productCont").each(function () {
						if(jQuery(this).css('display') != 'none'){

							if(loop % 2 == 0){ //alert(loop)
								jQuery(this).css('clear','none');
							}else{
								jQuery(this).css('clear','left');
							}
							loop++;
						}else{
							jQuery(this).css('clear','none');
						}
					});
					//adjust griding
        });
});

function filterSizes(){

    if(arAllSizes.length==0){
        jQuery("#div_sizes").hide();
        return;
    }

    //var sizes = "<b>FILTER BY SIZE: </b> ";
	var sizes = "";

    for(var i=0;i<arAllSizes.length;i++){

        for(var j=0;j<arProductSizes.length;j++){

            if(arAllSizes[i]==arProductSizes[j]){
                //sizes += "<span class='chk-size' rel='" + arAllSizes[i] + "'>" + arAllSizes[i] + "</span>";
				sizes += "<a href='#' class='chk-size' rel='" + arAllSizes[i] + "'>" + arAllSizes[i] + "</a>";
                break;
            }
        }
    }

    //sizes += "<div id='no-product-found' style='display:none;'>No Products Available</div>";

    jQuery("#div_sizes").html(sizes).show();
}









/***************************** == New code for category filters == **********************************************/
jQuery(function(){

    filterCats();

		jQuery(".chk-cats").click(function(e){
			e.preventDefault();
			jQuery(this).closest("ul").prev(".clear-txt").addClass("clearon");
            jQuery("#no-product-found").hide();

            if(jQuery(this).hasClass('chk-cats-selected'))
			{
				jQuery('.toggle_csp.active').addClass('on');
			    jQuery(this).removeClass('chk-cats-selected');
			}            
            else{
				jQuery(this).addClass('chk-cats-selected');
				jQuery('.toggle_csp.active').removeClass('on');
			}
                

            var arCatsToCheck = Array();
            jQuery(".chk-cats").each(function(){

                if(jQuery(this).hasClass('chk-cats-selected'))
                    arCatsToCheck.push(jQuery(this).attr('rel'));
            });

			var arSizesToCheck = Array();
            jQuery(".chk-size").each(function(){

                if(jQuery(this).hasClass('chk-size-selected'))
                    arSizesToCheck.push(jQuery(this).attr('rel'));
            });

            if(arCatsToCheck.length>0) {                
				// if any of the checkbox is checked
				/*** csp ***/
				jQuery('.toggle_csp.active').addClass('on');
                var productsDisplayed = false;

                jQuery(".productRep").each(function () {

                    var strSizes = jQuery(this).attr('data');

                    if (strSizes != undefined && strSizes.length > 0) {
                        var arColorSizes = strSizes.split(",");

                        if (arColorSizes.length > 0) {
                            var sizesFound = false;
                            for (var i = 0; i < arCatsToCheck.length; i++) {
                                for (var j = 0; j < arColorSizes.length; j++) {
                                    if (arCatsToCheck[i]==arColorSizes[j]) {
                                        sizesFound = true;
                                        break;
                                    }
                                }

                                if(sizesFound) {
                                    break;
                                }
                            }
							//add size check
							
							if(arSizesToCheck.length>0) {
								if (sizesFound && jQuery(this).hasClass('chk-size-opened')) {
									jQuery(this).show();
									jQuery(this).addClass('chk-cat-opened');
									productsDisplayed = true;
								}
								else{
									if (sizesFound) {
										jQuery(this).addClass('chk-cat-opened');
									}else{
										jQuery(this).removeClass('chk-cat-opened');
									}
									
									jQuery(this).hide();
								}


							}else{
								if (sizesFound) {
									jQuery(this).show();
									jQuery(this).addClass('chk-cat-opened');
									productsDisplayed = true;
								}
								else{
									jQuery(this).removeClass('chk-cat-opened');
									jQuery(this).hide();
								}
								
							}
                        }
                    }
                    else
                        jQuery(this).hide();
                });

                if(productsDisplayed)
                    jQuery("#no-product-found").hide();
                else
                    jQuery("#no-product-found").show();
            }
            else
			{
				  jQuery(".productRep").each(function () {
					 jQuery(this).removeClass('chk-cat-opened');
					 //alert(arSizesToCheck.length);
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


                //jQuery(".productRep").show();
			}

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

					//adjust griding 
					var loop = 1;
					jQuery(".productCont").each(function () {
						if(jQuery(this).css('display') != 'none'){

							if(loop % 2 == 0){ //alert(loop)
								jQuery(this).css('clear','none');
							}else{
								jQuery(this).css('clear','left');
							}
							loop++;
						}else{
							jQuery(this).css('clear','none');
						}
					});
					//adjust griding
        });
		
		
		
});

function filterCats(){
    if(arAllCats.length==0){
        jQuery("#div_cats").hide();
        return;
    }

    //var Categories = "<b>FILTER BY CATEGORY: </b> ";
	var Categories = "";
    //for(var i=0;i<arAllCats.length;i++){

			jQuery.each(arProductCats, function (index, value) {
				//if(arAllCats[i]==index){
					Categories += "<a href='#' class='chk-cats' rel='" + index + "'>" + value + "</a>";
					//return false; 
				//}
			});
    //}


    //Categories += "<div id='no-product-found' style='display:none;'>Category not available</div>";

	
	
    jQuery("#div_cats").html(Categories).show();
	if(Categories == ""){
	jQuery(".ct_filter").hide();
	}
	
	
	
	
}