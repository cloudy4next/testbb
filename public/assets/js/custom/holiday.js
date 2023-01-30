$(document).ready(function(){
    $('.start-date, .end-date').on('change', function(){
        var startDate = $('.start-date').val();
        var endDate = $('.end-date').val();

        if (startDate == '' || endDate == '') {
            $('.duration').val('');
        } else if (startDate > endDate) {
            alert('Start date should not be after than end date.');
            $('.duration').val('');
        } else {
            var diffDays = (date, otherDate) => Math.ceil(Math.abs(date - otherDate) / (1000 * 60 * 60 * 24));

            var dateDiff = diffDays(new Date(startDate), new Date(endDate));
            var duration = dateDiff + 1;

            $('.duration').val(duration);
        }
    });
});