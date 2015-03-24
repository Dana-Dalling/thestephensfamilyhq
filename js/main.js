$( document ).ready(function() {
    function countdown_timer(timestamp){
        // set and convert the timestamp to milliseconds
        var ts = new Date(timestamp *1000);
        // variables for time units
        var days, hours, minutes, seconds;

        // get the difference in seconds from now and target date
        var current_date = new Date().getTime();
        var seconds_left = (ts - current_date) / 1000;

        // get the days
        days = parseInt(seconds_left / 86400);
        seconds_left = seconds_left % 86400;
        //get the hours
        hours = parseInt(seconds_left / 3600);
        seconds_left = seconds_left % 3600;
        //get the minutes
        minutes = parseInt(seconds_left / 60);
        seconds = parseInt(seconds_left % 60);

        //return an object to use as desired
        return {days: days, hours: hours, minutes: minutes, seconds: seconds };

    }

    //check if the countdown timestamp is present
    var getTimestamp = $('.dana-fabion-wedding-countdown').attr('id');
    if(getTimestamp > 0){
        setInterval(function () {
            var timeLeft = countdown_timer(getTimestamp);
            $('.time-left--seconds').html(timeLeft.seconds);
            $('.time-left--minutes').html(timeLeft.minutes);
            $('.time-left--hours').html(timeLeft.hours);
            $('.time-left--days').html(timeLeft.days);
        },1000);
    }

    //slide to content when button is clicked
    $(".m-header--menu-scroll-to").on('click',function() {
        var region = $(this).attr('rel');
        $('html, body').animate({
            scrollTop: $("#"+region).offset().top
        }, 1000);
    });
});