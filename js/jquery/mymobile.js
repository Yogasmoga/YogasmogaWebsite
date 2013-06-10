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
    
    