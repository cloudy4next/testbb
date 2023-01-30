function shortlistAction(url) {
    $.ajax({
        type: 'POST',
        url: url,
        data: '_token = <?php echo csrf_token() ?>',
        success: function (responseAll) {
            var len = responseAll['data'].length;
            var response = responseAll['data'];
            //console.log(len);
            //console.log(response);

            $("#idTotalApplicant").text(responseAll['count'].total + " Applicant(s)");
            $("#idTotalShortlisted").text(responseAll['count'].num_shortlisted + " Applicant(s)");
            $("#idTotalRejected").text(responseAll['count'].num_rejected + " Applicant(s)");
            $("#shortlistTable tbody").append("");

            for (var i = 0; i < len; i++) {

                //console.log(response);
                var applicant_id = response[i].applicant_id;
                var job_id = response[i].job_id;
                var username = response[i].name;
                var email = response[i].email;
                var application_code = response[i].application_code;
                var total_score = response[i].total_score;
                //var status_text = response[i].status_text;
                var is_shortlisted = response[i].is_shortlisted;
                var keywords = response[i].keywords;
                var log_text = response[i].log_text;
                var processing_for = response[i].processing_for;

                if(is_shortlisted == 1){
                    var status_text = "<span class='badge badge-success'>Shortlisted</span>";
                }else{
                    var status_text = "<span class='badge badge-danger'>Rejected</span>";
                }

                if(keywords == ""){
                    keywords = "<center>NA</center>"
                }
                if(log_text == ""){
                    logCollapse = "<center>Not found</center>";
                }
                else{
                    var logCollapse = '<div class="text-center"><a data-toggle="collapse" href="#collapse-'+i+'" aria-expanded="false" role="bitton" aria-controls="collapse-'+i+'" class="btn btn-primary">' + 'Logs (Show/Hide)</a></div>';
                    logCollapse += '<div class="collapse" id="collapse-'+i+'" style="">' +
                    '<div class="card-body">' + log_text + '</div></div>';
                }

                var url2 = "/admin/applicant-details/applicant/"+ applicant_id +"/job/"+ job_id;

                var tr_str = '<tr>' +
                    "<td calss='left'>" + (i + 1) + "</td>" +
                    "<td class='left'><a href='" + url2 + "' target='_blank'><b>" + username + "</b></a><br>Apply Code:<b>" + application_code + "</b><br>Email: " + email + "</td>" +
                    "<td class='left'>Score:" + total_score + "<br>" + status_text + "</td>" +
                    "<td class='left'>" + keywords + "</td>" +
                    "<td class='left'>" + log_text + "</td>" +
                "</tr>";

                $("#shortlistTable tbody").append(tr_str);
            }

            //console.log(processing_for);
            $("#content_summary_shortlisting").show();
            $("#idProcessingFor").text(processing_for);
            $("#idConfirmSaveId").html('<input type="hidden" id="idProcessForText" value="'+ processing_for +'">');
            $("#idSaveListContent").removeClass('d-none');
        },
        complete: function(){
            setTimeout(function(){ $("#btnStartShorlistingNow").html('<i class="la la-search-plus mr-2"></i>  Start Shortlisting Now');     }, 10000);
            setTimeout(function(){ $("#btnStartShorlistingNow").attr("disabled", false); }, 10000);
        }
    });
}

function afterClickButtonBehavior(thisObj)
{
    $(thisObj).attr("disabled", true);
    $(thisObj).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="false"></span>  Processing...');
}

function confirmSaveShortlist(self, url)
{
    $.ajax({
        type: 'POST',
        url: url,
        data: '_token = <?php echo csrf_token() ?>',
        success: function (responseAll) {
           if(responseAll['data'] == true){
               $("#idSuccessMsg").html('<span style="color:green">Successfully saved this list applicants.</span>')
           }
           else{
                $("#idSuccessMsg").html('<span style="color:red">Cannot store again as you have previously stored this applicant list.</span>')
           }
        },
        complete: function(){
            setTimeout(function(){ $("#btnConfirmSave").html('<i class="la la-search-plus mr-2"></i>  Success');     }, 5000);
            setTimeout(function(){ $("#btnConfirmSave").attr("disabled", false); }, 5000);
        }
    });
}

function confirmSaveManualShortlist(self, url)
{
    $("input.applicantId").each(function(index, row){
        var applicant_id = $(this).val();
        var text = $("#idConfirmSaveId").text();
        var vacancy_id = $("#idVacancyId").text();
        var token = '<?php echo csrf_token() ?>';

        $.ajaxSetup({
            headers: {
              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: url,
            data: {type:text, applicant_id:applicant_id, vacancy_id:vacancy_id},
            success: function (responseAll) {
                if(responseAll == true){
                    $("#current_status_"+applicant_id).html(text.toUpperCase());
                    $("#action_status_"+applicant_id).html('<span class="badge badge-success"><i class="la la-check la-lg mr-2"></i>  Success</span>');
                }else{
                    $("#action_status_"+applicant_id).html('<span class="badge badge-warning"><i class="la la-close la-lg mr-2"></i>  Error'+responseAll+' </span>');
                }
            }
        });
    }).promise().done( function(){
        setTimeout(function(){ $("#btnConfirmSave").html('<i class="la la-search-plus mr-2"></i>  Confirm save');}, 2000);
        setTimeout(function(){ $("#btnConfirmSave").attr("disabled", false); }, 2000);
    } );


}
