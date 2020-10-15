$(document).ready(function() {
    var current = 1;
    widget = $(".step");
    btnnext = $(".next");
    btnback = $(".back");
    btnsubmit = $("#btnLivestreams");
    // Init buttons and UI
    widget.not(':eq(0)').hide();
    hideButtons(current);
    setProgress(current);
    // Next button click action
    btnnext.click(function() {
            if (current < widget.length) {
                // Check validation
                if ($(".form").valid()) {
                    widget.show();
                    widget.not(':eq(' + (current++) + ')').hide();
                    setProgress(current);
                }
            }
            hideButtons(current);
            window.scrollTo(0, 0);
        })
        // Back button click action
    btnback.click(function() {
        if (current > 1) {
            current = current - 2;
            if (current < widget.length) {
                widget.show();
                widget.not(':eq(' + (current++) + ')').hide();
                setProgress(current);
            }
        }
        hideButtons(current);
        window.scrollTo(0, 0);
    })
    $('.form').validate({ // initialize plugin
        ignore: ":not(:visible)",
        rules: {
            name: "required",
            description: "required",
            end_time: 'required',
            time_clock: "required",
        },
    });
});
// Change progress bar action
setProgress = function(currstep) {
        var percent = parseFloat(100 / widget.length) * currstep;
        percent = percent.toFixed();
        $(".progress-bar").css("width", percent + "%").html(percent + "%");
    }
    // Hide buttons according to the current step
hideButtons = function(current) {
        var limit = parseInt(widget.length);
        $(".action").hide();
        if (current < limit) btnnext.show();
        if (current > 1) btnback.show();
        if (current == limit) {
            // Show entered values
            $(".display label.lbl").each(function() {
                $(this).html($("#" + $(this).data("id")).val());
            });
            btnnext.hide();
            btnsubmit.show();
        }
        // console.log(limit);
        // console.log(current, 'adjdj');
    }
    // jquery
jQuery.extend(jQuery.expr[':'], {
    focusable: function(el, index, selector) {
        return $(el).is('a, button, :input, [tabindex]');
    }
});
$(document).on('keypress', 'input,select', function(e) {
    if (e.which == 13) {
        e.preventDefault();
        // Get all focusable elements on the page
        var $canfocus = $(':focusable');
        var index = $canfocus.index(this) + 1;
        if (index >= $canfocus.length) index = 0;
        $canfocus.eq(index).focus();
    }
});

//Vui lòng điền Thời gian hẹn giờ phát nhỏ hơn thời gian hiển thị cộng với thời gian video endtime > timer_clock + duration
function validate() {
    var endTime = document.getElementById('dd').value;
    var timer_clock = document.getElementById('cc').value;
    var duration = document.getElementById('duration').value;
    //check validate theo địh dạng 
    //  var startdate = document.getElementById('pickupdate').value; //03-11-2015 15:49
    var someParts = endTime.split(" ");
    var theDate = someParts[0];
    var theTime = someParts[1];
    var dateParts = theDate.split("/");
    var timeParts = theTime.split(":");
    var theDay = dateParts[0];
    var theMonth = (parseInt(dateParts[1] - 1));
    var theYear = dateParts[2];
    var theHours = timeParts[0];
    var theMinutes = timeParts[1];
    var someDateTimeObject = new Date(theYear, theMonth, theDay, theHours, theMinutes, 0);
    var someDateTimeObjectMillis = someDateTimeObject.getTime();
    //var someDateTimeObjectMinutes = someDateTimeObjectMillis / (1000 * 60);
    var someDateTimeObjectMinutes = someDateTimeObjectMillis / (1000 * 60);
    if (theYear != someDateTimeObject.getFullYear() || theMonth != someDateTimeObject.getMonth() || theDay != someDateTimeObject.getDate() || theHours != someDateTimeObject.getHours() || theMinutes != someDateTimeObject.getMinutes()) {
        $('#error_dd').show();
        return false;
    } else {
        $('#error_dd').hide();
    }
    //  alert(someDateTimeObjectMinutes);

    var somePartsClock = timer_clock.split(" ");
    var theDateClock = somePartsClock[0];
    var theTimeClock = somePartsClock[1];
    var datePartsClock = theDateClock.split("/");
    var timePartsClock = theTimeClock.split(":");
    var theDayClock = datePartsClock[0];
    var theMonthClock = (parseInt(datePartsClock[1]) - 1);
    var theYearClock = datePartsClock[2];
    var theHoursClock = timePartsClock[0];
    var theMinutesClock1 = (timePartsClock[1]);
    var theMinutesClock2 = (parseInt(timePartsClock[1]) + parseInt(duration));
    var someDateTimeObject1 = new Date(theYearClock, theMonthClock, theDayClock, theHoursClock, theMinutesClock1, 0);
    var someDateTimeObject2 = new Date(theYearClock, theMonthClock, theDayClock, theHoursClock, theMinutesClock2, 0);
    //var someDateTimeObjectMinutes = someDateTimeObjectMillis / (1000 * 60);
    if (theYearClock != someDateTimeObject1.getFullYear() || theMonthClock != someDateTimeObject1.getMonth() || theDayClock != someDateTimeObject1.getDate() || theHoursClock != someDateTimeObject1.getHours() || theMinutesClock1 != someDateTimeObject1.getMinutes()) {
        $('#error_cc').show();
        return false;
    } else {
        $('#error_cc').hide();
        var newTime = new Date(someDateTimeObject2);
    }
    var someDateTimeObjectMillis1 = newTime.getTime();

    var someDateTimeObjectMinutes1 = someDateTimeObjectMillis1 / (1000 * 60);

    // end time Thời hạn hiển thị
    // var timeEnd = endTime,
    //     dateArgs1 = timeEnd.match(/\d{2,4}/g),
    //     year1 = dateArgs1[2],
    //     month1 = parseInt(dateArgs1[1]) - 1,
    //     day1 = dateArgs1[0],
    //     hour1 = dateArgs1[3],
    //     minutes1 = dateArgs1[4];
    // var timeEnds = new Date(year1, month1, day1, hour1, minutes1);
    // if (year1 != timeEnds.getFullYear() || month1 != timeEnds.getMonth() || day1 != timeEnds.getDate() || hour1 != timeEnds.getHours() || minutes1 != timeEnds.getMinutes()) {
    //     $('#error_dd').show();
    //     return false;
    // } else {
    //     $('#error_dd').hide();
    // }

    // dt.setMinutes( dt.getMinutes() + 30 );
    //console.log(dateTimeEnd, dateTimeClock, newTime);
    var datetime = moment(newTime).format("DD/MM/YYYY HH:mm");
    if (someDateTimeObjectMinutes < someDateTimeObjectMinutes1) {
        alert("Vui lòng điền Thời gian hiển thị lớn hơn " + datetime + " !!!");
        return false;
    }
    return true;

    // function validate() {
    //     var endTime = document.getElementById('dd').value;
    //     var timer_clock = document.getElementById('cc').value;
    //     var duration = document.getElementById('duration').value;
    //     //check validate theo địh dạng 
    //     var dateString = timer_clock,
    //         dateArgs = dateString.match(/\d{2,4}/g),
    //         year = dateArgs[2],
    //         month = parseInt(dateArgs[1]) - 1,
    //         day = dateArgs[0],
    //         hour = dateArgs[3],
    //         minutes = dateArgs[4],
    //         newminutes = dateArgs[4] + duration;
    //     var TimeClock = new Date(year, month, day, hour, minutes);

    //     if (year != TimeClock.getFullYear() || month != TimeClock.getMonth() || day != TimeClock.getDate() || hour != TimeClock.getHours() || minutes != TimeClock.getMinutes()) {
    //         $('#error_cc').show();
    //         return false;
    //     } else {
    //         $('#error_cc').hide();
    //         var newTime = new Date(year, month, day, hour, newminutes);
    //     }
    //     // end time Thời hạn hiển thị
    //     var timeEnd = endTime,
    //         dateArgs1 = timeEnd.match(/\d{2,4}/g),
    //         year1 = dateArgs1[2],
    //         month1 = parseInt(dateArgs1[1]) - 1,
    //         day1 = dateArgs1[0],
    //         hour1 = dateArgs1[3],
    //         minutes1 = dateArgs1[4];
    //     var timeEnds = new Date(year1, month1, day1, hour1, minutes1);
    //     if (year1 != timeEnds.getFullYear() || month1 != timeEnds.getMonth() || day1 != timeEnds.getDate() || hour1 != timeEnds.getHours() || minutes1 != timeEnds.getMinutes()) {
    //         $('#error_dd').show();
    //         return false;
    //     } else {
    //         $('#error_dd').hide();
    //     }

    //     // dt.setMinutes( dt.getMinutes() + 30 );
    //     //console.log(dateTimeEnd, dateTimeClock, newTime);
    //     var datetime = moment(newTime).format("DD/MM/YYYY HH:mm");
    //     if (timeEnds < newTime) {
    //         alert("Vui lòng điền Thời gian hiển thị lớn hơn " + datetime + " !!!");
    //         return false;
    //     }
    //     return true;
}
// update hình ảnh 
$(document).ready(function() {
    $('.upload').on('change', function() {

        readURL(input);

    });
    $('.upload1').on('change', function() {
        $("#image_big").remove();
        readURL1(input1);
    });
    $('.image_medium').on('change', function() {
        $("#image_medium1").remove();
        readURL1(input1);
    });
    //delete edit user 
    $('#avatarUpdate').on('change', function() {
        $("#avatar1").remove();
    });
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $("#image_small").remove();
            $('#imageResult')
                .attr('src', e.target.result);

        };
        reader.readAsDataURL(input.files[0]);
    }
}

function readURL1(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $("#image_big").remove();
            $('#imageResult1')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $("#image_medium1").remove();
            $('#imageResult2')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
/*  ==========================================
    SHOW UPLOADED IMAGE NAME
* ========================================== */

var input = document.getElementById('upload');
var infoArea = document.getElementById('upload-label');
var input = document.getElementById('upload1');
var infoArea1 = document.getElementById('upload-label1');
var input = document.getElementById('upload2');
var infoArea1 = document.getElementById('upload-label2');
input.addEventListener('change', showFileName);
input.addEventListener('change', showFileName1);
input.addEventListener('change', showFileName2);

function showFileName(event) {
    var input = event.srcElement;
    var fileName = input.files[0].name;
    infoArea.textContent = 'File name: ' + fileName;
}

function showFileName1(event) {
    var input1 = event.srcElement;
    var fileName1 = input1.file[0].name;
    infoArea1.textContent = 'File name: ' + fileName1;
}

function showFileName2(event) {
    var input2 = event.srcElement;
    var fileName2 = input2.file[0].name;
    infoArea1.textContent = 'File name: ' + fileName2;
}
$(document).ready(function() {
    $('.DateTimeTextBox').datetimepicker({
        mask: '39.19.9999 29:59',
        format: 'd.m.Y H:i'
    })
});
$(document).ready(function() {
    $('.multiselect-ui').multiselect({
        includeSelectAllOption: true
    });
});
