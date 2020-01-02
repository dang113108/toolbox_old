$(document).ready(function () {
    var nowTime = new Date();
    var nowMTime = nowTime.getTime();
    kendo.culture('zh-TW');
    var time = $("#datetimepicker").kendoDateTimePicker({
        value: new Date(nowMTime+300000),
        format: "yyyy-MM-dd HH:mm:ss",
        interval: 1
    }).data("kendoDateTimePicker");

    time.min(time.value());
});