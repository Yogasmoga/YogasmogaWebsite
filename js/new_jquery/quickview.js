jQuery(document).ready(function($){


    $("table.normalproductdetail div#colorcontainer table").live("click", function(){
        $("table.normalproductdetail div#colorcontainer > div").removeClass("selected");
        $(this).parent("div").addClass("selected");
    });

    $(".quick-view").click(function(){
        showQuickViewPopup($(this).attr('id'));
    });


        
    // $(document).bind('keydown',function(e){ 
    //     if (e.which==37 || e.which==39) {
    //         e.preventDefault();
    //         if (e.which==37) {
    //             alert("going back");
    //         } else {
    //             alert("going forward");
    //         }
    //     }
    // });

    // $(".quick-view").keypress(function (e) {
    //       if (e.which == 37) {
    //              alert("dfsdfdsfds");
    //       }
    // });


    // $(".quick-prev").click(function(){
    //     alert("dsfsdf");
    // });

    // $(".quick-next").click(function(){
    //     showQuickViewPopup($(this).attr('id'));
    // });        

});

function showQuickViewPopup(productid, e)
{

   //alert(productid);
   //productid = parseInt(productid);

    jQuery("#productdetailpopup").html("<table style='width:100%;height : 530px;'><tr><td style='text-align:center;vertical-align:middle;'><img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' /></td></tr></table>");
    jQuery( "#productdetailpopup" ).dialog( "open" );
    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mycatalog/myproduct/details';
    if(_usesecureurl)
        url = securehomeUrl + 'mycatalog/myproduct/details';

    if(_quickViewObjectPage[productid]){
       
        //alert(_quickViewObjectPage[productid]);
        jQuery("#productdetailpopup").html(_quickViewObjectPage[productid]);
        insertBraOption();    
        jQuery("#productdetailpopup #colorcontainer > div:first-child > table").trigger('click');

        var nextIdView1 = jQuery("#" + productid).closest("li").next().children("a").attr("id");
        var prevIdView1 = jQuery("#" + productid).closest("li").prev().children("a").attr("id");

        if(typeof(nextIdView1) != 'undefined'){
            jQuery(".quick-next").attr("id", nextIdView1).css("display", "block");
        }

        if(typeof(prevIdView1) != 'undefined'){
            jQuery(".quick-prev").attr("id", prevIdView1).css("display", "block");
        }

        jQuery(".quick-next").click(function(){
            showQuickViewPopup(jQuery(this).attr('id'));
        });

        jQuery(".quick-prev").click(function(){
            showQuickViewPopup(jQuery(this).attr('id'));
        });

        jQuery(document).keydown(function(e){
        var nextIdView1 = jQuery("#" + productid).closest("li").next().children("a").attr("id");
        var prevIdView1 = jQuery("#" + productid).closest("li").prev().children("a").attr("id");
            //e.preventDefault();
             var PrevID = jQuery('.quick-prev').attr('id');
             if(typeof(PrevID) != 'undefined'){
            if (e.keyCode == 37) {
                //jQuery(".quick-prev").trigger('click');               
                 jQuery(".quick-prev").trigger('click')(function(){         
                    showQuickViewPopup(PrevID); 
                  });
                
                }
                
            }
            
             var NextID = jQuery('.quick-next').attr('id');
             if(typeof(NextID) != 'undefined'){
            if (e.keyCode == 39) {                      
                 //jQuery(".quick-next").trigger('click');              
                  jQuery(".quick-next").trigger('click')(function(){                                  
                     showQuickViewPopup(NextID);
                  });
                
                 }
                
                
            }
        });
    }
    else{
        var id = productid
        id = id.substring(0, id.length - 2);
        console.log(id);
        console.log(productid);
    jQuery.ajax({
        type : 'POST',
        url : url,
        data : {'id': id},
        success : function(data){          
            
            _quickViewObjectPage[productid] = data;
            
            jQuery("#productdetailpopup").html(data);
            insertBraOption();
            jQuery("#productdetailpopup #colorcontainer > div:first-child > table").trigger('click');

            InitializeProductQty();
            if(jQuery("div#colorcontainer table:first").length > 0)
                changeColor(_dressingroomselectedcolor);

            var nextIdView = jQuery("#" + productid).closest("li").next().children("a").attr("id");
            var prevIdView = jQuery("#" + productid).closest("li").prev().children("a").attr("id");
            console.log(nextIdView+' '+prevIdView);
//alert(nextIdView);
            if(typeof(nextIdView) != 'undefined'){
                jQuery(".quick-next").attr("id", nextIdView).css("display", "block");
            }

            if(typeof(prevIdView) != 'undefined'){
                jQuery(".quick-prev").attr("id", prevIdView).css("display", "block");
            }

            jQuery(".quick-next").click(function(){
                                             
                showQuickViewPopup(jQuery(this).attr('id'));
            });
            jQuery(".quick-prev").click(function(){
                showQuickViewPopup(jQuery(this).attr('id'));
            });
            
            jQuery(document).keydown(function(e){
                //e.preventDefault();
                 var PrevID = jQuery('.quick-prev').attr('id');
                 if(typeof(PrevID) != 'undefined'){
                if (e.keyCode == 37) {                  
                    //jQuery(".quick-prev").trigger('click');
                    jQuery(".quick-prev").trigger('click')(function(){                  
                    showQuickViewPopup(PrevID); 
                     });                
                                    
                    }   
                    
                }
                var NextID = jQuery('.quick-next').attr('id');             
                if(typeof(NextID)  != 'undefined'){
                if (e.keyCode == 39) {
                    //jQuery(".quick-next").trigger('click');
                    jQuery(".quick-next").trigger('click')(function(){                  
                     showQuickViewPopup(NextID);                                             
                      // showQuickViewPopup(jQuery(this).attr('id'));
                      });
                    
                                     
                }
                }
            });

        }
    });

    }
    
    
    

}