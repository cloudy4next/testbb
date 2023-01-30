    $('#terms').scroll(function () {
        if ($(this).scrollTop() + $(this).innerHeight() +2 >= $(this)[0].scrollHeight) {
            $('#div_code_of_ethics').removeClass('d-none');
        }
    });

    var lbApply = document.getElementById('apply_lable');
    var btnback = document.getElementById('btn_back_to_cover_letter');

    var texrArea = document.getElementById('cover_letter');
    var texrAreaError = document.getElementById('error_cover_letter');

    var btnApplyNow = document.getElementById('btn_apply_now');
    var btnConfirmApply = document.getElementById('btn_apply_confirm');
    var section1 = document.getElementById('section_1');
    var section2 = document.getElementById('section_2');

    var chConvicted = document.getElementById('ch_convicted');
    var txConvictedResoan = document.getElementById('convicted_resoan');
    var chTermination = document.getElementById('ch_termination');
    var txTerminationResoan = document.getElementById('termination_resoan');
    var chCodeOfEthics = document.getElementById('ch_code_of_ethics');
    var chAcauthenticity = document.getElementById('ch_authenticity');
    var btnApplyConfirm = document.getElementById('btn_apply_confirm');

    var defaultUnchecked3 = document.getElementById('defaultUnchecked3');
    var defaultUnchecked4 = document.getElementById('defaultUnchecked4');
    var defaultChecked3 = document.getElementById('defaultChecked3');
    var defaultChecked4 = document.getElementById('defaultChecked4');
    var defaultChecked = document.getElementById('defaultChecked');
    var defaultChecked2 = document.getElementById('defaultChecked2');
    var defaultChecked5 = document.getElementById('defaultChecked5');
    var defaultChecked7 = document.getElementById('defaultChecked7');

    btnApplyNow.addEventListener('click', function() {
    if(texrArea.value.length < 100 && texrArea.value.length > 0){
        texrAreaError.classList.remove("d-none");
        texrAreaError.textContent = "Too few characters to be submitted as a Cover Letter.";
    }
    else if(texrArea.value.length == 0){
        texrAreaError.classList.remove("d-none");
        texrAreaError.textContent = "Cover letter cannot be empty.";
    }else{
        texrAreaError.classList.add("d-none");
        btnback.classList.remove("d-none");
        lbApply.textContent="{{trans('base.apply_lable')}}";
        btnApplyNow.classList.add("d-none");
        section1.classList.add("d-none");
        btnConfirmApply.classList.remove("d-none");
        section2.classList.remove("d-none");
    }

    }, false);

    btnback.addEventListener('click', function() {
    btnback.classList.add("d-none");
    btnApplyNow.classList.remove("d-none");
    btnConfirmApply.classList.add("d-none");
    lbApply.textContent="{{trans('base.cover_letter')}}";
    section1.classList.remove("d-none");
    section2.classList.add("d-none");
    }, false);

    function showHideConvicted()
    {
    var chConvicted = document.getElementById('defaultChecked');
    var divAlert = document.getElementById('not_eligible_msg_div');
    //var txConvictedResoan = document.getElementById('convicted_resoan');
    //txConvictedResoan.disabled = chConvicted.checked;
    //var parentDiv = txConvictedResoan.parentNode;    

    if(chConvicted.checked){        
        divAlert.classList.add("d-none"); 
    }else{
        alert("You are not eligible for applying for any job with TIB");
        divAlert.classList.remove("d-none");
    }

    if((defaultUnchecked3.checked == true && defaultUnchecked4.checked == true) && (defaultUnchecked.checked == false && defaultUnchecked2.checked == false && defaultUnchecked5.checked == false && defaultUnchecked7.checked == false))      
    {
        btnApplyConfirm.disabled = false;
    }
    else
    {
        btnApplyConfirm.disabled = true;
    }
    }

    function showHideTermination()
    {
    var chTermination = document.getElementById('defaultChecked2');
    var divAlert = document.getElementById('not_eligible_msg_div2');
    //var txTerminationResoan = document.getElementById('termination_resoan');
    //txTerminationResoan.disabled = chTermination.checked;
    //var parentDiv = txTerminationResoan.parentNode;    

    if(chTermination.checked){
        divAlert.classList.add("d-none"); 
    }else{
        alert("You are not eligible for applying for any job with TIB");
        divAlert.classList.remove("d-none");
    }

    if((defaultUnchecked3.checked == true && defaultUnchecked4.checked == true) && (defaultUnchecked.checked == false && defaultUnchecked2.checked == false && defaultUnchecked5.checked == false && defaultUnchecked7.checked == false))      
    {
        btnApplyConfirm.disabled = false;
    }
    else
    {
        btnApplyConfirm.disabled = true;
    }
    }

    function showHideSexualHarassment()
    {
    var chSexualHarassment = document.getElementById('defaultChecked5');
    var divAlert = document.getElementById('not_eligible_msg_div5');
    //var txSexualHarassment = document.getElementById('sexual_harassment_reason');
    //txSexualHarassment.disabled = chSexualHarassment.checked;
    //var parentDiv = txSexualHarassment.parentNode;    

    if(chSexualHarassment.checked){
        divAlert.classList.add("d-none"); 
    }else{
        alert("You are not eligible for applying for any job with TIB");
        divAlert.classList.remove("d-none");
    }

    if((defaultUnchecked3.checked == true && defaultUnchecked4.checked == true) && (defaultUnchecked.checked == false && defaultUnchecked2.checked == false && defaultUnchecked5.checked == false && defaultUnchecked7.checked == false))      
    {
        btnApplyConfirm.disabled = false;
    }
    else
    {
        btnApplyConfirm.disabled = true;
    }
    }

    function showHideDisciplinaryAction()
    {
    var chDisciplinaryAction = document.getElementById('defaultChecked6');
    var selDisciplinaryAction = document.getElementById('ground_for_disciplinary_action');
    var selOutcomesAction = document.getElementById('outcomes_action');
    var txDisciplinaryAction = document.getElementById('disciplinary_action_reason');
    var txOutcomesAction = document.getElementById('outcomes_reason');
    
    selDisciplinaryAction.disabled = chDisciplinaryAction.checked;
    selOutcomesAction.disabled = chDisciplinaryAction.checked;
    
    var parentDiv = selDisciplinaryAction.parentNode;    
    var parentDiv2 = txDisciplinaryAction.parentNode; 
    var parentDiv3 = selOutcomesAction.parentNode;    
    var parentDiv4 = txOutcomesAction.parentNode;   

    if(chDisciplinaryAction.checked){        
        parentDiv.classList.add("d-none"); 
        parentDiv2.classList.add("d-none"); 
        parentDiv3.classList.add("d-none"); 
        parentDiv4.classList.add("d-none"); 
    }else{
        parentDiv.classList.remove("d-none");
        parentDiv3.classList.remove("d-none");
        var selValue = selDisciplinaryAction.value;
        var selValue2 = selOutcomesAction.value;

        if(selValue == "Others"){
        parentDiv2.classList.remove("d-none");
        txDisciplinaryAction.disabled = false;
        }else{
        parentDiv2.classList.add("d-none"); 
        txDisciplinaryAction.disabled = true;
        }

        if(selValue2 == "Others"){
        parentDiv4.classList.remove("d-none");
        txOutcomesAction.disabled = false;
        }else{
        parentDiv4.classList.add("d-none"); 
        txOutcomesAction.disabled = true;
        }
    }      
    }

    function showHideOutcomesTextarea()
    {
    var selOutcomesAction = document.getElementById('outcomes_action');
    var txOutcomesAction = document.getElementById('outcomes_reason');
    var selValue = selOutcomesAction.value;
    var parentDiv = txOutcomesAction.parentNode;
    console.log(selValue);
    if(selValue == "Others"){
        parentDiv.classList.remove("d-none");
        txOutcomesAction.disabled = false;
    }else{
        parentDiv.classList.add("d-none"); 
        txOutcomesAction.disabled = true;
    }
    }

    function showHideDisciplinaryGroundTextarea()
    {
    var selDisciplinaryAction = document.getElementById('ground_for_disciplinary_action');
    var txDisciplinaryAction = document.getElementById('disciplinary_action_reason');
    var selValue = selDisciplinaryAction.value;
    var parentDiv = txDisciplinaryAction.parentNode;
    
    if(selValue == "Others"){
        parentDiv.classList.remove("d-none");
        txDisciplinaryAction.disabled = false;
    }else{
        parentDiv.classList.add("d-none"); 
        txDisciplinaryAction.disabled = true;
    }
    }

    function showHideMisappropriationAction()
    {
    var chMisappropriationAction = document.getElementById('defaultChecked7');
    var divAlert = document.getElementById('not_eligible_msg_div7');      
    //var txMisappropriationAction = document.getElementById('misappropriation_action_reason');
    //txMisappropriationAction.disabled = chMisappropriationAction.checked;
    //var parentDiv = txMisappropriationAction.parentNode;    

    if(chMisappropriationAction.checked){
        divAlert.classList.add("d-none"); 
    }else{
        alert("You are not eligible for applying for any job with TIB");
        divAlert.classList.remove("d-none");
    }

    if((defaultUnchecked3.checked == true && defaultUnchecked4.checked == true) && (defaultUnchecked.checked == false && defaultUnchecked2.checked == false && defaultUnchecked5.checked == false && defaultUnchecked7.checked == false))      
    {
        btnApplyConfirm.disabled = false;
    }
    else
    {
        btnApplyConfirm.disabled = true;
    }
    }

    defaultUnchecked3.addEventListener('click', function() {
    //console.log(chCodeOfEthics.checked);
    if((defaultUnchecked3.checked == true && defaultUnchecked4.checked == true) && (defaultUnchecked.checked == false && defaultUnchecked2.checked == false && defaultUnchecked5.checked == false && defaultUnchecked7.checked == false))      
    {
        btnApplyConfirm.disabled = false;
    }
    else
    {
        btnApplyConfirm.disabled = true;
    }
    }, false);

    defaultUnchecked4.addEventListener('click', function() {
    if((defaultUnchecked3.checked == true && defaultUnchecked4.checked == true) && (defaultUnchecked.checked == false && defaultUnchecked2.checked == false && defaultUnchecked5.checked == false && defaultUnchecked7.checked == false))
    {
        btnApplyConfirm.disabled = false;
    }
    else
    {
        btnApplyConfirm.disabled = true;
    }
    }, false);    

    defaultChecked3.addEventListener('click', function() {
    if(defaultChecked3.checked == true)
    {
        btnApplyConfirm.disabled = true;
    }
    }, false);

    defaultChecked4.addEventListener('click', function() {
    if(defaultChecked4.checked == true)
    {
        btnApplyConfirm.disabled = true;
    }
    }, false);

    btnApplyConfirm.addEventListener('click', function() {
    if((defaultUnchecked3.checked == true && defaultUnchecked4.checked == true) && (defaultUnchecked.checked == false && defaultUnchecked2.checked == false && defaultUnchecked5.checked == false && defaultUnchecked7.checked == false))
    {
        var form = document.querySelector("form");
        window.onbeforeunload = null;
        // /form.submit();
        var result = confirm("Are you sure wants to continue?");

        if (result == true) {
        this.form.submit();
        }else {
            return false;
        }  

    }
    }, false);

    window.onbeforeunload = function ()
    {
        return "";
    };

    var maxLength = 2200;
    $('#cover_letter').keyup(function() {
    var length = $(this).val().length;
    var length = maxLength-length;
    $('#char_count').text(length);
    });