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

    $(".m-async-form").submit(function(event) {
        event.preventDefault();
        var operation = $(this).attr('action');
        var data = $(this).serializeArray();
        $.ajax({
            type: "POST",
            url: operation,
            data: data,
            dataType: 'json'
        }).done(function(response) {
                //set selectors for multi use
                var rsvp_code_field = $('#rsvp_code');
                var rsvp_label = $('#rsvp-response-msg');
                var rsvp_form = $('#rsvp-form');
                if(!response.success){
                    rsvp_code_field.addClass('highlight_field');
                    rsvp_label.addClass('error');
                    $('#rsvp-response-msg').html(response.message);
                }else{
                    rsvp_code_field.removeClass('highlight_field');
                    rsvp_label.removeClass('error');
                    rsvp_label.html('Please enter your RSVP Code');

                    //hide the rsvp form
                    rsvp_form.slideUp(500);

                    //show thank you note
                    $('#thank-you-note').html('<h3>Thank You So Much!</h3>')
                    //reset the form
                    rsvp_form.reset();
                }
                //close any modal that was up
                //$('.close-reveal-modal').trigger('click');
            });
    });

    $('#submit-rsvp-form').on('click', function(){
       $('#rsvp-form').submit();
    });

});