$("#vacancy").change(function (e) {
    var vacancyId = $(this).val()
    var target = e.target;

    $.ajax({
        method:'GET',
        url: target.dataset.url,
        data: {"vacancyId": vacancyId},
        success: function(result){
           $('#exam').empty().append(result)
        }
    });
})

// $("#submit").click(function (e) {
//     e.preventDefault();
//     var vacancyId = $("#vacancy").val()
//     var examId = $("#exam").val()
//
//     //get All email & names
//     var email_1 = $('#email_1').val();
//     var email_2 = $('#email_2').val();
//     var email_3 = $('#email_3').val();
//     var name_1 = $('#name_1').val();
//     var name_2 = $('#name_2').val();
//     var name_3 = $('#name_3').val();
//     var target = e.target;
//
//     $.ajax({
//         method:'GET',
//         url: target.dataset.url,
//         data: {"vacancyId": vacancyId, "examId": examId, "email_1": email_1, "email_2": email_2,
//             "email_3": email_3, "name_1": name_1, "name_2": name_2, "name_3": name_3,},
//         success: function(result){
//             new Noty({
//                 type: "success",
//                 text: 'Invitation successfully sent',
//             }).show();
//         }
//     });
// })
