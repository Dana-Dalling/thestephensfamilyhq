jQuery( document ).ready(function($) {
    var msg_content_area = $('#message-area');

    function message_display(msgType, msg) {
        msg_content_area.removeClass('success');
        msg_content_area.removeClass('error');
        msg_content_area.addClass(msgType);
        $('.message-area--text').html(msg);
        msg_content_area.slideDown();
    }

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
            scrollTop: $("#"+region).offset().top-250
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
                message_display(response.type, response.message);
                var song_suggester_sel = $('#song_suggester_name');
                var song_title_sel = $('#song_title');
                var artist_sel = $('#artist');
                var rsvp_first_name_sel = $('#first_name');
                var rsvp_last_name_sel = $('#last_name');
                if(response.missing_song_title){
                    song_title_sel.addClass('input-required');
                }else{
                    song_title_sel.removeClass('input-required');
                }
                if(response.missing_artist){
                    artist_sel.addClass('input-required');
                }else{
                    artist_sel.removeClass('input-required');
                }
                if(response.missing_name){
                    song_suggester_sel.addClass('input-required');
                }else{
                    song_suggester_sel.removeClass('input-required');
                }
                if(response.missing_first_name){
                    rsvp_first_name_sel.addClass('input-required');
                }else{
                    rsvp_first_name_sel.removeClass('input-required');
                }
                if(response.missing_last_name){
                    rsvp_last_name_sel.addClass('input-required');
                }else{
                    rsvp_last_name_sel.removeClass('input-required');
                }
                if(!response.missing_song_title && !response.missing_artist && !response.missing_name){
                    //close any modal that was up
                    closeModal();
                }
                if(response.type == 'success'){
                    $('#'+response.clear_form_id)[0].reset();
                }
            });
    });

    $('#submit-rsvp-form').on('click', function(){
       $('#rsvp-form').submit();
    });


    function closeModal() {
        $('.close-reveal-modal').trigger('click');
    }
    $(document).on('click', '.message-area--dismiss-action', function () {
        $('#message-area').slideUp();
    });
});

