jQuery(document).ready(function($){

    $("#invite-friend-form").submit(function(event){

        var formid = "#invite-friend-form";
        var status = sharewithfriendformvalidation(formid);
        if(status != "error")
            sharewithfriend();
        event.preventDefault();
    });

});

function sharewithfriend()
{
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
        data    :   {'firstname':fname,'lastname':lname,'email':email_id,'password':pwd,'confirmation':cpassword,'is_subscribed':is_subscribed},
        beforeSend: function() {
            jQuery("#sign-up-form .form-loader").html("<img src='/skin/frontend/new-yogasmoga/yogasmoga-theme/images/loading1.gif' style='width:40px;' />");

        },
        success :   function(data){

            data = eval('('+data + ')');

        }
    });
}