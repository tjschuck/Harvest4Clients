$(function () {
    // Datepickers
    var startDate = $('#startfield').val().toString();
    var endDate = $('#endfield').val().toString();

    $('#startdate').datepicker({
        altField:'#startfield',
        altFormat:'yymmdd',
        dateFormat:'yymmdd',
        firstDay:1
    });
    $('#startdate').datepicker("setDate", startDate);
    $('#enddate').datepicker({
        altField:'#endfield',
        altFormat:'yymmdd',
        dateFormat:'yymmdd',
        firstDay:1
    });
    $('#enddate').datepicker("setDate", endDate);
});