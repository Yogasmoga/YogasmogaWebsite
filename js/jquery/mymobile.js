$j(document).ready(function(){

$j("table.gfredeem input, table#redeem input").keyup(function(e){
        //console.log(e.keyCode);
        if(e.keyCode == 9 || e.keyCode == 13 || e.keyCode == 16 || e.keyCode == 17 || (e.keyCode >= 37 && e.keyCode <= 40))
            return;
        //console.log($j(this).val().length);
        if($j(this).val().length > 5)
        {
            $j(this).val($j(this).val().substr(0,5));
            $j(this).parent().next().next().find('input').focus().select();
        }
        if($j(this).val().length == 5)
        {
            $j(this).parent().next().next().find('input').focus().select();
    
        }
    });
    
    
    
    
        $j("#giftcard-form").submit(function(){
        
        return validateGiftCardForm($j("#giftcard-form table.gfredeem"));
        //return false;
    });

function validateGiftCardForm(tbl)
{
$j("input#giftcard_code").val($j("input#gf1").val() + "-" + $j("input#gf2").val() + "-" + $j("input#gf3").val());
return;
    //$j("table.gfredeem td.inputholder input").removeClass('error');
    //var tbl = $j("table.gfredeem");
    var flag = 0;
    tbl.find('input[type="text"]').each(function(){
        if($j(this).val() == '')
        {
            //console.log($j(this).val());
            flag = flag + 1;
        }
    });
    if(flag == 3)
    {
        tbl.find('td.errortext div').html('Gift of YS Code is required.').fadeIn('fast');
    }
    else if(flag > 0)
    {
        tbl.find('td.errortext div').html('Invalid Gift of YS Code.').fadeIn('fast');
    }
    if(flag == 0)
        flag = true;
    else
        flag = false;
    if(flag)
    {
        $j("input#giftcard_code").val($j("input#gf1").val() + "-" + $j("input#gf2").val() + "-" + $j("input#gf3").val());
        $j("input#cardno").val($j("input#gf1").val() + "-" + $j("input#gf2").val() + "-" + $j("input#gf3").val());
    }
    else
    {
        //$j("table.gfredeem td.inputholder input").addClass('error');
    }
    return flag;
    
    $j("#giftcardformmyaccount").find('table.inputtable td.errortext').html('<div></div>');
    unsetAllError($j("#giftcardformmyaccount"));
    var flag = validatefields($j("#giftcardformmyaccount"));
    return flag;
}

function validateGiftCardRedeemForm()
{
    var tbl = $j("table#redeem");
    tbl.find('td.errortext div').fadeOut('fast').removeAttr('class');
    var flag = 0;
    tbl.find('input[type="text"]').each(function(){
        if($j(this).val() == '')
        {
            //console.log($j(this).val());
            flag = flag + 1;
        }
    });
    if(flag == 3)
    {
        tbl.find('td.errortext div').html('Gift of YS Code is required.').fadeIn('fast');
    }
    else if(flag > 0)
    {
        tbl.find('td.errortext div').html('Invalid Gift of YS Code.').fadeIn('fast');
    }
    if(flag == 0)
        flag = true;
    else
        flag = false;
    if(flag)
    {
        $j("input#giftcard_code").val($j("input#gfr1").val() + "-" + $j("input#gfr2").val() + "-" + $j("input#gfr3").val());
    }
    return flag;
}


    
    });
    
	
function isNormalInteger(str) {
    var n = ~~Number(str);
    return String(n) === str && n > 0;
}			
    
$j(document).ready(function(){


$j("#giftcard-form table.gfredeem div.ershow").html($j("ul.messages li.error-msg span").html());


    
   
  
	    $j("#discountFormPoints2").submit(function(){
        return validateSmogibuckpoints();
    });
});
	
	
	
function validateSmogibuckpoints()
{
    $j("#points_error").html();
    $j("#points_to_be_used").removeClass('error');
    if($j("#discountFormPoints2 input[type='text']").length > 0)
    {
        var flag = true;
        if($j("#points_to_be_used").val().length == 0)
        {
            $j("#points_error").html('Amount is required.').fadeIn('fast');
            $j("#points_to_be_used").addClass('error');
            flag = false;
        }
        if($j("#points_to_be_used").val().length > 0)
        {
            if(!isNormalInteger($j("#points_to_be_used").val()))
            {
                $j("#points_error").html('Invalid Amount. Must be an integer.').fadeIn('fast');
                $j("#points_to_be_used").addClass('error');
                flag = false;
            }
            else
            {
                if(($j("#points_to_be_used").val() * 1) > ($j("span#tpoints").html() * 1))
                {
                    $j("#points_error").html('Insufficient Points. Maximum points is ' + $j("span#tpoints").html()).fadeIn('fast');
                    $j("#points_to_be_used").addClass('error');
                    //setOnError(jQuery("#card-amount"),"Maximum value of a Card is 1000");
                    flag = false;    
                }
            }
        }
        return flag;
    }
    else
        return true;
}


    