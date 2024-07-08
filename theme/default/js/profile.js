function readURL(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#userLogoBox').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function validatePhone(txtPhone) {
    //var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
    if (txtPhone == '') {
        return false;
    }else {
        return true;
    }
}

function addressCheck(){

    var errorCheck = 1;
    var fullname = $.trim($('input[name=fullname]').val());
    var firstname = $.trim($('input[name=firstname]').val());
    var lastname = $.trim($('input[name=lastname]').val());
    var telephone = $.trim($('input[name=telephone]').val());
    var country = $.trim($('select[name=country]').val());
    var address1 = $.trim($('input[name=address1]').val());
    var address2 = $.trim($('input[name=address2]').val());
    var city = $.trim($('input[name=city]').val());
    var postcode = $.trim($('input[name=postcode]').val());
    var state = $.trim($('select[name=state]').val());  
   
    if(fullname == ''){
        $('input[name=fullname]').parent().addClass('has-error');
        errorCheck = 0;
    }
    if(firstname == ''){
        $('input[name=firstname]').parent().addClass('has-error');
        errorCheck = 0;
    }
    if(lastname == ''){
        $('input[name=lastname]').parent().addClass('has-error');
        errorCheck = 0;
    }
    if(!validatePhone(telephone)){
        $('input[name=telephone]').parent().addClass('has-error');
        errorCheck = 0;
    }
    if(country == ''){
        $('select[name=country]').parent().addClass('has-error');
        errorCheck = 0;
    }
    if(address1 == ''){
        $('input[name=address1]').parent().addClass('has-error');
        errorCheck = 0;
    }
    if(city == ''){
        $('input[name=city]').parent().addClass('has-error');
        errorCheck = 0;
    }
    if(postcode == ''){
        $('input[name=postcode]').parent().addClass('has-error');
        errorCheck = 0;
    }
    if(state == ''){
        $('select[name=state]').parent().addClass('has-error');
        errorCheck = 0;
    }

    if(errorCheck == 1){
        $('input[name=firstname]').parent().removeClass('has-error');
        $('input[name=lastname]').parent().removeClass('has-error');
        $('select[name=country]').parent().removeClass('has-error');
        $('input[name=telephone]').parent().removeClass('has-error');
        $('input[name=address1]').parent().removeClass('has-error');
        $('input[name=city]').parent().removeClass('has-error');
        $('input[name=postcode]').parent().removeClass('has-error');
        $('select[name=state]').parent().removeClass('has-error');
        $('input[name=statestr]').val($("select[name=state] option:selected").text());       
        return true;
    } else{
        return false; 
    }                
}

function passCheck(){

    var errorCheck = 1;
    var old_pass = $.trim($('input[name=old_pass]').val());
    var new_pass = $.trim($('input[name=new_pass]').val());
    var retype_pass = $.trim($('input[name=retype_pass]').val());
   
    if(old_pass == ''){
        $('input[name=old_pass]').parent().addClass('has-error');
        errorCheck = 0;
    }else{
        $('input[name=old_pass]').parent().removeClass('has-error');
    }
    
    if(new_pass == ''){
        $('input[name=new_pass]').parent().addClass('has-error');
        errorCheck = 0;
    }else{
        $('input[name=new_pass]').parent().removeClass('has-error');
    }
    
    if(retype_pass == ''){
        $('input[name=retype_pass]').parent().addClass('has-error');
        errorCheck = 0;
    }else{
        $('select[name=retype_pass]').parent().removeClass('has-error');  
       
        if(retype_pass != new_pass){
            $('input[name=retype_pass]').parent().addClass('has-error');
            $('input[name=new_pass]').parent().addClass('has-error');
            errorCheck = 0;
        }else{
            $('input[name=new_pass]').parent().removeClass('has-error');
            $('select[name=retype_pass]').parent().removeClass('has-error'); 
        }
    }
    


    if(errorCheck == 1){
        $('input[name=old_pass]').parent().removeClass('has-error');
        $('input[name=new_pass]').parent().removeClass('has-error');
        $('select[name=retype_pass]').parent().removeClass('has-error');  
        return true;
    } else{
        return false; 
    }   
    return false;              
}

$("#logoUpload").change(function(){
    readURL(this);
});
