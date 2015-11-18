//	var productColorIndex;

jQuery(function(){

    filterSizes();

		jQuery(".chk-size").click(function(){

            if(jQuery(this).hasClass('chk-size-selected'))
                jQuery(this).removeClass('chk-size-selected')
            else
                jQuery(this).addClass('chk-size-selected')

            var arSizesToCheck = Array();
            jQuery(".chk-size").each(function(){

                if(jQuery(this).hasClass('chk-size-selected'))
                    arSizesToCheck.push(jQuery(this).attr('rel'));
            });

            if(arSizesToCheck.length>0) {                // if any of the checkbox is checked
                jQuery(".productCont").each(function () {

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

                            if (sizesFound)
                                jQuery(this).show();
                            else
                                jQuery(this).hide();
                        }
                    }
                    else
                        jQuery(this).hide();
                });
            }
            else
                jQuery(".productCont").show();

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
        });
});

function filterSizes(){

    var sizes = "<b>FILTER BY SIZE: </b> ";

    for(var i=0;i<arAllSizes.length;i++){

        for(var j=0;j<arProductSizes.length;j++){

            if(arAllSizes[i]==arProductSizes[j]){
                sizes += "<span class='chk-size' rel='" + arAllSizes[i] + "'>" + arAllSizes[i] + "</span>";
                break;
            }
        }
    }

    jQuery("#div_sizes").html(sizes);
}