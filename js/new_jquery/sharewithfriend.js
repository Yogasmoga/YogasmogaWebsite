jQuery(document).ready(function($){

    $("#invite-friend-form").submit(function(event){
        event.preventDefault();
        var formid = "#invite-friend-form";
        var status = sharewithfriendformvalidation(formid);
        if(status != "error")
            sharewithfriend();
        //event.preventDefault();
    });
    $("#invite-friend-form").on("click","#send-invite", function(){     
        var errMsgCont = $("#invite-friend-form").find("p.err-msg");
        if(errMsgCont.css("visibility") == "visible")
        {
            errMsgCont.css("visibility","hidden");
        } 
    });

});

function sharewithfriend()
{
    var fname = jQuery.trim(jQuery("#friendname").val());
    var email_id = jQuery.trim(jQuery("#friendemail").val());
    var id = "1";
    if(window.location.href.indexOf('https://') >= 0)
        _usesecureurl = true;
    else
        _usesecureurl = false;
    var url = homeUrl + 'mycatalog/myproduct/referfriend';
    if(_usesecureurl)
        url = securehomeUrl + 'mycatalog/myproduct/referfriend';

    jQuery.ajax({

        url     :   url,
        type    :   'POST',
        data    :   {'name':fname,'email':email_id,'id':id},
        beforeSend: function() {
            jQuery("#invite-friend-form .form-loader").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/new-loader.gif' style='width:16px;' />");
            jQuery("#send-invite").parent().hide();
            jQuery("#invite-friend-form .form-loader").show();
        },
        success :   function(data){

            data = eval('('+data + ')');
            var status = data.status;
            var message = data.message;
            if(status == "success")
            {
                jQuery(".invite-form").addClass("no-display");
                jQuery(".invite-message").removeClass("no-display");                
                setTimeout(function(){
                    jQuery("#invite_friends").dialog("close");
                    jQuery("#invite_friends").dialog({
                        close : function(event,ui){
                            jQuery(".invite-message").addClass("no-display");
                            jQuery(".invite-form").removeClass("no-display");
                            jQuery("#invite-friend-form .form-loader").hide();
                            jQuery("#send-invite").parent().show();
                            jQuery("#invite-friend-form input").val("").focus().blur();

                        }
                    });
                },2000);
            }
            else{
                jQuery("#invite-friend-form .err-msg").html(message).css("visibility","visible");
                jQuery("#send-invite").parent().show();
                jQuery("#invite-friend-form .form-loader").hide();
            }
        }
    });
}