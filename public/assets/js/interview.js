jQuery(document).ready(function () {
    $(".applicant").click(function (e) {
        e.preventDefault();
        var target = e.target;

        $.ajax({
            method: 'GET',
            url: target.dataset.url,
            beforeSend: function () {
                console.log("sending")
            },
            success: function (html) {
               $('#applicant_details').empty().append(html);
            }
        })
    })
})
