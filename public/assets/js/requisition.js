$('input[type="checkbox"]').click(function(){
    if($(this).prop("checked") == true){
       $('#grade').removeAttr('hidden')
    }
    else if($(this).prop("checked") == false){
        $('#grade').attr('hidden', true)
    }
});
